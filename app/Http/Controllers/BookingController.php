<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        return view('bookings.index', [
            'bookings' => $request->user()->bookings()->latest()->paginate(8),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_name' => ['required', 'string', 'max:180'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->user()->bookings()->create($validated);

        return back()->with('status', 'Booking berhasil dikirim.');
    }

    public function manage()
    {
        return view('admin.bookings.index', [
            'bookings' => Booking::with('user')->latest()->paginate(12),
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,finished,canceled'],
        ]);

        $booking->update($validated);

        return back()->with('status', 'Status booking berhasil diperbarui.');
    }
}
