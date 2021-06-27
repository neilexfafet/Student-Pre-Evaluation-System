<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Curriculum;

class Evaluation extends Model
{
    protected $fillabled = [
        'evaluation_no',
        'course_id',
        'student_id',
        'record_id',
        'grade',
        'remarks',
        'year_level',
        'semester',
        'school_year_from',
        'school_year_to',
    ];

    public function getCourse() {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
    
    public function getStudent() {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function getRecord() {
        return $this->hasOne(Records::class, 'id', 'record_id');
    }
}
