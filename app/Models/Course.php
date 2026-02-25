<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\User;
use App\Models\LessonProgress;




use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //
    use HasFactory, SoftDeletes;

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function progressForUser($userId)
    {

    $totalLessons = $this->lessons()->count();

    $completedLessons = LessonProgress::where('user_id',$userId)
    ->whereIn('lesson_id',$this->lessons->pluck('id'))
    ->where('completed', true)
    ->count();

    if($totalLessons == 0)
    return 0;

    return round(($completedLessons/$totalLessons)*100);

    }
  
}
