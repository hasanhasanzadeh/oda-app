<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\ExamAllRequest;
use App\Http\Requests\Exam\ExamCreateFormRequest;
use App\Http\Requests\Exam\ExamCreateRequest;
use App\Http\Requests\Exam\ExamDeleteRequest;
use App\Http\Requests\Exam\ExamFindRequest;
use App\Http\Requests\Exam\ExamUpdateFormRequest;
use App\Http\Requests\Exam\ExamUpdateRequest;
use App\Models\Exam;
use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(private readonly ExamService $examService)
    {
    }

    public function index(ExamAllRequest $request)
    {
        $title = __('message.exams');
        $validated = $request->validated();
        $exams = $this->examService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.exam.index', [
            'title' => $title,
            'exams' => $exams,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(ExamCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.exam.create', compact([ 'title']));
    }

    public function store(ExamCreateRequest $request)
    {
        $exam = $this->examService->create($request->validated());
        if (!$exam) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('exams.index'));
    }


    public function show(ExamFindRequest $request,Exam $exam)
    {
        $title = __('message.show');

        return view('admin.exam.show', compact([ 'title', 'exam']));
    }


    public function edit(ExamUpdateFormRequest $request,Exam $exam)
    {
        $title = __('message.edit');

        return view('admin.exam.edit', compact(['title', 'exam']));
    }


    public function update(ExamUpdateRequest $request, Exam $exam)
    {
        $exam = $this->examService->update($exam->id,$request->validated());
        if (!$exam) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('exams.index'));
    }

    public function destroy(ExamDeleteRequest $request,Exam $exam)
    {

        $exam = $this->examService->delete($exam->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('exams.index'));
    }

    public function search(Request $request)
    {
        $exams = [];
        if ($request->has('q')) {
            $search = $request->q;
            $exams = Exam::select("id", "exam_persian_name")
                ->where('exam_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $exams = collect($exams);

        return response()->json($exams);
    }
}
