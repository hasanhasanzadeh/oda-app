<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiResponse;
use App\Http\ApiRequests\Auth\ActiveApiRequest;
use App\Http\ApiRequests\Auth\LoginApiRequest;
use App\Http\ApiRequests\User\UserUpdateApiRequest;
use App\Http\ApiRequests\User\UserUpdateAvatarApiRequest;
use App\Http\Controllers\Controller;
use App\Models\Resources\User\UserResource;
use App\Notifications\UserNotification;
use App\Services\ActivationCodeService;
use App\Services\AuthService;
use App\Services\NotificationService;
use App\Services\UserService;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class AuthController
{
    public function __construct(private AuthService $authService, private ActivationCodeService $activationCodeService, private UserService $userService,private NotificationService $notificationService)
    {
    }

    public function existsUser(LoginApiRequest $request): JsonResponse
    {
        $user = $this->authService->findByMobile($request->mobile);
        return ApiResponse::success(data: [], message: '', status: $user?200:201);
    }

    public function login(LoginApiRequest $request): JsonResponse
    {
        $user = $this->authService->findByMobile($request->mobile);

        if (!$user) {
            $user = $this->authService->create($request->validated());
            if (!$user) {
                return ApiResponse::error(message: 'مشکل در ارائه سرویس لطفا دوباره تلاش کنید', status: 500, errors: ['مشکل در ارائه سرویس لطفا دوباره تلاش کنید']);
            }
        }
        $existsCode=$this->activationCodeService->expiredCode($user->id);
        if ($existsCode) {
            return ApiResponse::error(message: '', status: 422, errors: [
                'کد فعال سازی قبلا برای شما ارسال شده است لطفا کمی صبر کنید و دوباره تلاش کنید'
            ]);
        }
        $this->activationCodeService->delete($user->id);
        $code = $this->activationCodeService->create($user);
        $user->notify(new UserNotification(message:$code,subject:'Verification Mobile',type:'sms',user: $user));
        return ApiResponse::success(data:[],message: 'کد فعال سازی با موفقیت برای شما ارسال شد');
    }

    public function activate(ActiveApiRequest $request): JsonResponse
    {
        $user = $this->authService->findByMobile($request->mobile);
        $activationCode = $this->activationCodeService->find($request->code,$user->id);

        if (!$activationCode) {
            return ApiResponse::error(message:'کد تایید اشتباه می باشد لطفا دباره تلاش کنید',status:422,errors:['کد تایید اشتباه می باشد لطفا دباره تلاش کنید']);
        }

        $this->activationCodeService->delete($user->id);

//        $this->notificationService->create([
//            'title'=>'اعلان ورود کاربر ',
//            'description'=>'شما در تاریخ و زمان '.Verta::now().' وارد سایت شدید.',
//            'user_id'=>$user->id
//        ]);

        return ApiResponse::success(
            data:[
            'user' => new UserResource($user),
            'token' => $user->createToken('AuthToken')->plainTextToken,
            ],
            message: 'موبایل شما با موفقیت تایید شد'
        );
    }

    public function logout(Request $request): JsonResponse
    {
//        $this->notificationService->create([
//            'title'=>'اعلان خروج کاربر ',
//            'description'=>'شما در تاریخ و زمان '.Verta::now().' از سایت خارج شدید.',
//            'user_id'=>auth()->user()->id
//        ]);

        $this->authService->logout();
        return ApiResponse::success(null, 'شما با موفقیت خارج شدید');
    }

    public function getProfile(Request $request): JsonResponse
    {
        $user = $this->authService->getProfile();
        return ApiResponse::success(
            data:new UserResource($user),
            message: 'پروفایل من'
        );
    }

    public function updateProfile(UserUpdateApiRequest $request): JsonResponse
    {
        $user = $this->authService->getProfile();
        $user_update =$this->userService->update($user->id, $request->validated());
        return ApiResponse::success(
            data:new UserResource($user_update),
            message: 'اطلاعات پروفایل با موفقیت بروز رسانی شد'
        );
    }

    public function updateRoleType(): JsonResponse
    {
        $user_update =$this->userService->updateRole();
        return ApiResponse::success(
            data:new UserResource($user_update),
            message: 'اطلاعات پروفایل با موفقیت بروز رسانی شد'
        );
    }

    public function updateAvatar(UserUpdateAvatarApiRequest $request): JsonResponse
    {
        $user = $this->userService->updateAvatar($request->validated());
        if (!$user) {
            return ApiResponse::error(message:'مشکل در آپلود عکس لطفا دوباره تلاش کنید', status:422,errors: ['مشکل در آپلود عکس لطفا دوباره تلاش کنید']);
        }
        return ApiResponse::success(
            data:new UserResource($user),
            message: 'عکس پروفایل شما موفقیت آپلود شد'
        );
    }
}
