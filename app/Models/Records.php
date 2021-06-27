<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Curriculum;

class Records extends Model
{
    protected $fillable = [
        'student_id',
        'curriculum_id',
        'grade',
        'remarks',
        'credential_name',
    ];

    public function getStudent() {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function getCurriculum() {
        return $this->hasOne(Curriculum::class, 'id', 'curriculum_id');
    }
}
