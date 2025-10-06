<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DashboardRequest;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
    }

    public function index(DashboardRequest $request)
    {

        $contactsCount       = Contact::count();
        $usersCount          = User::count();
        $paymentsCount       = Payment::count();


        $contacts       = Contact::with(['user'])->latest()->take(10)->get();
        $customers          = User::latest()->take(10)->get();
        $payments       = Payment::with(['user','paymentable'])->latest()->take(10)->get();

        $title = __('message.dashboard');
        session(['previous_url' => url()->full()]);

        return view('admin.dashboard.index', compact([
            'title','contactsCount','usersCount','paymentsCount',
            'contacts','customers','payments',
            ]));
    }

    public function tagSearch(Request $request)
    {
        $tags = [];
        if ($request->has('q')) {
            $search = $request->q;
            $tagNames = Tag::where('name', 'LIKE', "%{$search}%")
                ->pluck('name')
                ->unique()
                ->values()
                ->all();

            $tags = collect($tagNames)->map(function ($tagName) {
                return (object)['id' => null, 'name' => $tagName];
            });
        }

        $tags = collect($tags);

        return response()->json($tags);
    }

    public function makeSlug(Request $request): string
    {
        $slug = $request->title;
        $string = str_replace(['/', "\\", '%', '#', '!', '@', '$', '^', '&', '*', '(', ')', '_', '=', "'", '"','|'], '', $slug);
        return preg_replace('/\s+/u', '-', trim($string));
    }
}
