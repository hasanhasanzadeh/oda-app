<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Term\TermAllRequest;
use App\Http\Requests\Term\TermCreateFormRequest;
use App\Http\Requests\Term\TermCreateRequest;
use App\Http\Requests\Term\TermDeleteRequest;
use App\Http\Requests\Term\TermFindRequest;
use App\Http\Requests\Term\TermUpdateFormRequest;
use App\Http\Requests\Term\TermUpdateRequest;
use App\Models\Term;
use App\Services\TermService;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function __construct(private readonly TermService $termService)
    {
    }

    public function index(TermAllRequest $request)
    {
        $title = __('message.terms');
        $validated = $request->validated();
        $terms = $this->termService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.term.index', [
            'title' => $title,
            'terms' => $terms,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(TermCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.term.create', compact([ 'title']));
    }

    public function store(TermCreateRequest $request)
    {
        $term = $this->termService->create($request->validated());
        if (!$term) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('terms.index'));
    }


    public function show(TermFindRequest $request,Term $term)
    {
        $title = __('message.show');

        return view('admin.term.show', compact([ 'title', 'term']));
    }


    public function edit(TermUpdateFormRequest $request,Term $term)
    {
        $title = __('message.edit');

        return view('admin.term.edit', compact(['title', 'term']));
    }


    public function update(TermUpdateRequest $request, Term $term)
    {
        $term = $this->termService->update($term->id,$request->validated());
        if (!$term) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('terms.index'));
    }

    public function destroy(TermDeleteRequest $request,Term $term)
    {
        $term = $this->termService->delete($term->id);

        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('terms.index'));
    }

    public function search(Request $request)
    {
        $terms = [];
        if ($request->has('q')) {
            $search = $request->q;
            $terms = Term::select("id", "term_persian_name")
                ->where('term_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $terms = collect($terms);

        return response()->json($terms);
    }
}
