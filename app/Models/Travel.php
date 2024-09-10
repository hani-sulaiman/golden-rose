<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;
    protected $table="travels";
    protected $fillable = [
        'name',
        'restaurant_id',
        'hotel_id',
        'cost',
        'is_group',
        'start_date',
        'end_date',
        'category_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_travel')
            ->using(UserTravel::class)
            ->withPivot('is_paid')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function images()
    {
        return $this->hasMany(TravelImage::class);
    }
}
