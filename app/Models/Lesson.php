<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\LessonProgress;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;


class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [

    'course_id',
    'title',
    'slug',
    'content',
    'video_url',
    'duration',
    'order',
    'is_free'

    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
   public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

}
