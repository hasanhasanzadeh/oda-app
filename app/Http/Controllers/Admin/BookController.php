<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookAllRequest;
use App\Http\Requests\Book\BookCreateFormRequest;
use App\Http\Requests\Book\BookCreateRequest;
use App\Http\Requests\Book\BookDeleteRequest;
use App\Http\Requests\Book\BookFindRequest;
use App\Http\Requests\Book\BookUpdateFormRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Services\BookService;
use App\Services\DepartmentService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private readonly BookService $bookService,private readonly DepartmentService $departmentService,private readonly ProductService $productService)
    {
    }

    public function index(BookAllRequest $request)
    {
        $title = __('message.books');
        $validated = $request->validated();
        $books = $this->bookService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.book.index', [
            'title' => $title,
            'books' => $books,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(BookCreateFormRequest $request)
    {
        $title = __('message.create');
        $departments = $this->departmentService->all($request->validated());
        $products = $this->productService->all($request->validated());
        return view('admin.book.create', compact([ 'title','departments','products' ]));
    }

    public function store(BookCreateRequest $request)
    {
        $book = $this->bookService->create($request->validated());
        if (!$book) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('books.index'));
    }


    public function show(BookFindRequest $request,Book $book)
    {
        $title = __('message.show');

        return view('admin.book.show', compact([ 'title', 'book']));
    }


    public function edit(BookUpdateFormRequest $request,Book $book)
    {
        $title = __('message.edit');
        $departments = $this->departmentService->all($request->validated());
        $products = $this->productService->all($request->validated());
        return view('admin.book.edit', compact(['title', 'book','departments','products']));
    }


    public function update(BookUpdateRequest $request, Book $book)
    {
        $book = $this->bookService->update($book->id,$request->validated());
        if (!$book) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('books.index'));
    }

    public function destroy(BookDeleteRequest $request,Book $book)
    {
        $book = $this->bookService->delete($book->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('books.index'));
    }

    public function search(Request $request)
    {
        $books = [];
        if ($request->has('q')) {
            $search = $request->q;
            $books = Book::select("id", "book_persian_name")
                ->where('book_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $books = collect($books);

        return response()->json($books);
    }
}
