<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionAllRequest;
use App\Http\Requests\Question\QuestionCreateFormRequest;
use App\Http\Requests\Question\QuestionCreateRequest;
use App\Http\Requests\Question\QuestionDeleteRequest;
use App\Http\Requests\Question\QuestionFindRequest;
use App\Http\Requests\Question\QuestionUpdateFormRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Models\Qaq;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    public function __construct(readonly private QuestionService $questionService)
    {
    }

    public function index(QuestionAllRequest $request)
    {
        $title = __('message.questions');
        $validated = $request->validated();
        $questions = $this->questionService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.question.index', [
            'title' => $title,
            'questions' => $questions,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(QuestionCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.question.create', compact(['title']));
    }

    public function store(QuestionCreateRequest $request)
    {
        $question = new Qaq();
        $question->title = $request->title;
        $question->description = $request->description;
        $question->status = $request->status;
        $question->save();

        toast(__('message.created'), 'success');

        return redirect(session('previous_url')??route('questions.index'));
    }


    public function show(QuestionFindRequest $request, Qaq $question)
    {
        $title = __('message.show');

        return view('admin.question.show', compact(['title', 'question']));
    }


    public function edit(QuestionUpdateFormRequest $request, Qaq $question)
    {
        $title = __('message.edit');

        return view('admin.question.edit', compact(['title', 'question']));
    }


    public function update(QuestionUpdateRequest $request, Qaq $question)
    {
        $question->title = $request->title;
        $question->description = $request->description;
        $question->status = $request->status;
        $question->save();

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('questions.index'));
    }

    public function destroy(QuestionDeleteRequest $request, Qaq $question)
    {
        $question->delete();

        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('questions.index'));
    }

}
