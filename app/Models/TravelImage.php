<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TravelImage extends Model
{
    use HasFactory;

    protected $fillable = ['travel_id', 'image_path'];
    public function getImagePathAttribute($value)
    {
        return asset($value); 
    }
    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }
}
