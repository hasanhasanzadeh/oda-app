<?php

namespace App\Helpers;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\User;

class DashboardPanel
{
    public static function dashboard()
    {
        $userCount = User::all()->count();
        $contactCount = Contact::all()->count();
        $blogsCount = Blog::all()->count();
        $paymentCount = Payment::where('status', 'done')->get()->count();

        $blogsTody = Blog::whereDate('created_at', today())->count();
        $userToday = User::whereDate('created_at', today())->count();
        $contactToday = Contact::whereDate('created_at', today())->count();
        $paymentToday = Payment::where('status', 'done')->whereDate('created_at', today())->count();

        $sumCount = $userToday + $contactToday + $paymentToday;


        return [
            'userCount' => $userCount,
            'contactCount' => $contactCount,
            'userToday' => $userToday,
            'contactToday' => $contactToday,
            'blogsCount' => $blogsCount,
            'blogsTody' => $blogsTody,
            'paymentCount' => $paymentCount,
            'paymentToday' => $paymentToday,
            'sumCount' => $sumCount,
        ];
    }

}
