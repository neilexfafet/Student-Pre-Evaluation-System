<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_no',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'address',
        'facebook_account',
        'email',
        'year_level',
        'course_id',
        'contact_no',
        'emerg_contact',
        'emerg_contact_no',
        'birthdate',
        'birthplace',
        'status',
        'is_active'
    ];
    
    public function getCourse() {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
}
