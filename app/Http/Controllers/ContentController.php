<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\ContentService;
use App\Services\QuestionService;

class ContentController extends Controller
{
    public function __construct(readonly private ContentService $contentService,
                                readonly private QuestionService $questionService
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
}
