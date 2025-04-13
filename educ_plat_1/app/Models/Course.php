<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'price',
        'level',
        'user_id'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'course_user')
                   ->withTimestamps();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function avgRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
