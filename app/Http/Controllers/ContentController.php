<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactCreateRequest;
use App\Models\Setting;
use App\Services\ContactService;
use App\Services\ContentService;
use App\Services\QuestionService;

class ContentController extends Controller
{
    public function __construct(readonly private ContentService $contentService,
                                readonly private QuestionService $questionService,
                                readonly private ContactService $contactService
    )
    {
    }

        public function about(){
            $about = $this->contentService->getByType('about-us');
            $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

            return view('pages.about', compact(['setting','about']));
        }
        public function contact(){
            $contact = $this->contentService->getByType('contact-us');
            $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

            return view('pages.contact', compact(['setting','contact']));
        }
        public function faq(){
            $questions = $this->questionService->all(['status'=>true]);
            $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

            return view('pages.faq', compact(['setting','questions']));
        }
        public function privacy(){
            $privacy = $this->contentService->getByType('privacy');
            $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

            return view('pages.privacy', compact(['setting','privacy']));
        }

        public function rules(){
            $rules = $this->contentService->getByType('rules');
            $setting= Setting::with(['logo','favicon','socialMedia','meta'])->first();

            return view('pages.rules', compact(['setting','rules']));
        }

    public function store(ContactCreateRequest $request)
    {
        $contact = $this->contactService->create($request->validated());
        if(!$contact){
            return redirect()->back('error','خطا در ارسال پیام، لطفا مجددا تلاش کنید');
        }
        return redirect()->back()->with('success', 'پیام شما با موفقیت ارسال شد');
    }
}
