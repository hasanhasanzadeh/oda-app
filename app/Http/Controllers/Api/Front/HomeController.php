<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Requests\Contact\ContactCreateRequest;
use App\Models\Blog;
use App\Services\BlogService;
use App\Services\ContactService;
use App\Services\SettingService;
use Illuminate\Http\Request;

readonly class HomeController
{
    public function __construct(
        private SettingService $settingService,
        private BlogService $blogService,
        private ContactService $contactService,
    ) {}

    public function index(Request $request)
    {
        $blogs = $this->blogService->getTake(6);
        $setting = $this->settingService->first();
        return view('welcome', [
            'setting' => $setting,
            'blogs' => $blogs,
        ]);
    }

    public function contactSave(ContactCreateRequest $request)
    {
        $contact = $this->contactService->create($request->validated());
        if ($contact) {
            toast('انتقاد و پیشنهاد شما با موفقیت ثبت شد','success');
            return redirect()->route('home');
        }
        toast('انتقاد یا پیشنهاد شما ذخیره نشد لطفا دباره سعی کنید','error');
        return redirect()->route('home');
    }

    public function blogShow($slug)
    {

        $blog = $this->blogService->findBySlug($slug);
        $setting = $this->settingService->first();
        $relatedBlogs = Blog::where('slug', '!=', $slug)
            ->latest()
            ->take(3)
            ->get();
        return view('pages.blog', [
            'setting' => $setting,
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs,
        ]);
    }
}
