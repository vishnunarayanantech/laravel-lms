<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\User;
use App\Models\LessonProgress;




class Course extends Model
{
    //
  use HasFactory;

    protected $fillable = [

    'title',
    'slug',
    'description',
    'thumbnail',
    'teacher_id',
    'price',
    'level',
    'status'

    ];

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class)
             ->orderBy('order');
    }
    public function students()
    {
        return $this->belongsToMany(
        User::class,
        'enrollments'
        );
    }
  
}
