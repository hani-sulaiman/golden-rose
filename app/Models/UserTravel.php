<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class UserTravel extends Pivot
{
    use HasFactory;
    protected $table = 'user_travel';

    protected $fillable = [
        'user_id',
        'travel_id',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }
}
