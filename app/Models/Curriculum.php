<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class Curriculum extends Model
{
    protected $fillable = [
        'course_id',
        'subject_id',
        'year_level',
        'semester',
        'is_active',
    ];

    public function getSubject() {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
