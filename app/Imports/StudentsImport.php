<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Records;
use App\Models\Evaluation;
use App\Models\Curriculum;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Auth;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    public function __construct($reference) {
        $this->reference = $reference;
    }

    public function model(array $row)
    {
        if(empty($row['Last Name']) || empty($row['First Name'])) {
           Session::flash('error', 'No Last Name and First Name rows detected. Please make sure to put data on first row on the file');
        } else {
            $add = new Student;
            $add->last_name = $row['Last Name'];
            $add->first_name = $row['First Name'];
            $add->course_id = Auth::guard('department')->user()->course_id;
            $add->status = 'NEW';
            $add->save();
            $rand = rand(11111, 99999);
            $date = date('dmy');
            $eval_id = "EVL-".$date."-".$add->id."-".$rand;
            
            $curriculum = Curriculum::where('is_active', '1')
                ->where('course_id', Auth::guard('department')->user()->course_id)
                ->where('reference', $this->reference)
                ->get();
            foreach($curriculum as $row) {
                $add2 = new Records;
                $add2->student_id = $add->id;
                $add2->curriculum_id = $row->id;
                $add2->save();
            }
            $evaluation = DB::table('records')
                ->select('*', 'records.id AS idrecord')
                ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
                ->where('records.student_id', $add->id)
                ->where('curricula.reference', $this->reference)
                ->where('curricula.year_level', '1')
                ->where('curricula.semester', '1')
                ->get();
            foreach($evaluation as $row) {
                $add3 = new Evaluation;
                $add3->evaluation_no = $eval_id;
                $add3->course_id = Auth::guard('department')->user()->course_id;
                $add3->student_id = $add->id;
                $add3->record_id = $row->idrecord;
                $add3->year_level = '1';
                $add3->semester = '1';
                $add3->school_year_from = Auth::guard('department')->user()->school_year_from;
                $add3->school_year_to = Auth::guard('department')->user()->school_year_to;
                $add3->save();
            }
            Session::flash('success', 'Students Registered Successfully!');
        }
        /* return new Student([
            'last_name'    => $row['last_name'], 
            'first_name'     => $row['first_name'],
            'course_id' => Auth::guard('department')->user()->course_id,
        ]); */
    }
}
