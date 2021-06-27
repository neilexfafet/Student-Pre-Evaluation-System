<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Course;

class Department extends Authenticatable
{
    use Notifiable;

    protected $guard = 'department';

    protected $fillable = [
        'name',
        'dept_head',
        'course_id',
        'username',
        'password',
        'set_semester',
    ];

    protected $hidden = [
        'password',
    ];

    public function getCourse() {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
}
