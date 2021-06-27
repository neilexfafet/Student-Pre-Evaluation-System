<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class Subject extends Model
{
    protected $fillable = [
        'course_code',
        'title',
        'lec',
        'lab',
        'units',
        'pre_req_id',
        'course_id',
        'type',
        'special_pre_req',
        'is_active'
    ];

    public function getPrereq() {
        return $this->hasOne(Subject::class, 'id', 'pre_req_id');
    }
}
