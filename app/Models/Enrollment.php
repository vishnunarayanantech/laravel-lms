<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\LessonProgress;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;

class Enrollment extends Model
{
    //
    protected $fillable = [
        'user_id',
        'course_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
