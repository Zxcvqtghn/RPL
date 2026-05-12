<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Booking;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('dashboard.index', [
            'user' => $user,
            'metrics' => [
                'articles' => $user->canManageContent()
                    ? ($user->isAdmin() ? Article::count() : $user->articles()->count())
                    : null,
                'testimonials' => $user->isAdmin() ? Testimonial::count() : null,
                'staff' => $user->isAdmin() ? User::whereIn('role', ['admin', 'writer'])->count() : null,
                'bookings' => $user->isAdmin() ? Booking::count() : $user->bookings()->count(),
            ],
            'latestBookings' => $user->isAdmin()
                ? Booking::with('user')->latest()->take(5)->get()
                : $user->bookings()->latest()->take(5)->get(),
        ]);
    }
}
