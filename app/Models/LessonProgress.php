<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

class LessonProgress extends Model
{
    use HasFactory;

    protected $fillable = [

    'user_id',
    'lesson_id',
    'completed',
    'completed_at'

    ];
    public function user()
    {
    return $this->belongsTo(User::class);
    }
    public function lesson()
    {
    return $this->belongsTo(Lesson::class);
    }
  
}
