<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'project_name', 'booking_date', 'phone', 'address', 'notes', 'status'])]
class Booking extends Model
{
    protected function casts(): array
    {
        return ['booking_date' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
