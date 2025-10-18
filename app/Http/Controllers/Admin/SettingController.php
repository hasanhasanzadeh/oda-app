<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingAllRequest;
use App\Http\Requests\Setting\SettingCreateFormRequest;
use App\Http\Requests\Setting\SettingCreateRequest;
use App\Http\Requests\Setting\SettingDeleteRequest;
use App\Http\Requests\Setting\SettingEditFormRequest;
use App\Http\Requests\Setting\SettingFindRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Models\Setting;

use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __construct(readonly private SettingService $settingService)
    {
    }

    public function index(SettingAllRequest $request)
    {
        $title = __('message.settings');
        $validated = $request->validated();
        $panels = $this->settingService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.setting.index', [
            'title' => $title,
            'panels' => $panels,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function show(SettingFindRequest $request, $id)
    {
        $title = __('message.show');

        $panel = Setting::findOrFail($id);

        return view('admin.setting.show', compact(['title', 'panel']));
    }

    public function create(SettingCreateFormRequest $request)
    {
        $title = __('message.show');

        return view('admin.setting.create', compact(['title']));
    }


    public function store(SettingCreateRequest $request)
    {
        $setting = new Setting();
        $setting->title = $request->title;
        $setting->url = $request->url;
        $setting->short_text = $request->short_text;
        $setting->copy_right = $request->copy_right;
        $setting->address = $request->address;
        $setting->phone = $request->phone;
        $setting->description = $request->description;
        $setting->script_text = $request->script_text;
        $setting->tel = $request->tel;
        $setting->email = $request->email;
        if ($request->file('favicon')) {
            $setting->favicon_id = Helper::uploadImage($request->file('favicon'));
        }
        if ($request->file('logo')) {
            $setting->logo_id = Helper::uploadImage($request->file('logo'));
        }
        $setting->save();

        $setting->meta()->create([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);

        $setting->socialMedia()->create([
            'telegram' => $request->telegram,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'whatsapp' => $request->whatsapp,
            'x_link' => $request->x_link,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'github' => $request->github,
            'dribble' => $request->dribble,
        ]);

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('settings.index'));
    }

    public function edit(SettingEditFormRequest $request, $id)
    {
        $title = __('message.edit');

        $panel = Setting::findOrFail($id);

        return view('admin.setting.edit', compact(['title', 'panel']));
    }

    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $setting->title = $request->title;
        $setting->url = $request->url;
        $setting->short_text = $request->short_text;
        $setting->copy_right = $request->copy_right;
        $setting->address = $request->address;
        $setting->description = $request->description;
        $setting->script_text = $request->script_text;
        $setting->phone = $request->phone;
        $setting->tel = $request->tel;
        $setting->email = $request->email;
        $setting->support_text = $request->support_text;
        if ($request->file('favicon')) {
            if ($setting->favicon_id) {
                Helper::deleteFile($setting->favicon->url);
                $setting->favicon()->delete();
            }
            $setting->favicon_id = Helper::uploadImage($request->file('favicon'));
        }
        if ($request->file('logo')) {
            if ($setting->logo_id) {
                Helper::deleteFile($setting->logo->url);
                $setting->logo()->delete();
            }
            $setting->logo_id = Helper::uploadImage($request->file('logo'));
        }
        $setting->save();
        if ($setting->meta) {
            $setting->meta()->update([
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description
            ]);
        } else {
            $setting->meta()->create([
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description
            ]);
        }
        if ($setting->socialMedia) {
            $setting->socialMedia()->update([
                'telegram' => $request->telegram,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'whatsapp' => $request->whatsapp,
                'x_link' => $request->x_link,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'github' => $request->github,
                'dribble' => $request->dribble,
            ]);
        } else {
            $setting->socialMedia()->create([
                'telegram' => $request->telegram,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'whatsapp' => $request->whatsapp,
                'x_link' => $request->x_link,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'github' => $request->github,
                'dribble' => $request->dribble,
            ]);
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('settings.index'));
    }


    public function destroy(SettingDeleteRequest $request, Setting $setting)
    {
        $count = Setting::all()->count();

        if ($count <= 1) {
            toast('تنظیمات نمی تواند حذف شود', 'error');
            return redirect(session('previous_url')??route('settings.index'));
        }

        $setting->delete();

        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('settings.index'));
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $settings = [];
        if ($request->has('q')) {
            $search = $request->q;
            $settings = Setting::select("id", "title")
                ->where('title', 'LIKE', "%$search%")
                ->get();
        }
        $settings = collect($settings);

        return response()->json($settings);
    }
}
