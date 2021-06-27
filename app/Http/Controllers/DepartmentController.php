<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Imports\StudentsImport;
use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Curriculum;
use App\Models\Student;
use App\Models\Records;
use App\Models\Evaluation;
use Auth;

class DepartmentController extends Controller
{
    function dashboard() {
        $students = Student::all()->where('course_id', Auth::guard('department')->user()->course_id)->count();
        $curriculum = Curriculum::all()->where('course_id', Auth::guard('department')->user()->course_id)->where('is_active', '1')->groupBy('reference')->count();
        $evaluationscount = Evaluation::all()->where('course_id', Auth::guard('department')->user()->course_id)->groupBy('evaluation_no')->count();
        $evaluations = Evaluation::with('getRecord.getCurriculum.getSubject', 'getStudent')->where('course_id', Auth::guard('department')->user()->course_id)->get()->sortByDesc('created_at')->groupBy('evaluation_no')->take(10);
        $year = Evaluation::with('getStudent')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('semester', Auth::guard('department')->user()->set_semester)
            ->where('school_year_from', Auth::guard('department')->user()->school_year_from)
            ->where('school_year_to', Auth::guard('department')->user()->school_year_to)
            ->get();
        /* $year1 = DB::table('evaluations')
            ->select('*')
            ->join('students', 'evaluations.student_id', '=', 'students.id')
            ->where('evaluations.semester', Auth::guard('department')->user()->set_semester)
            ->where('evaluations.school_year_from', Auth::guard('department')->user()->school_year_from)
            ->where('evaluations.school_year_to', Auth::guard('department')->user()->school_year_to)
            ->get()
            ->groupBy('evaluations.evaluation_no')
            ->count(); */
        return view('dashboard')
            ->with('students', $students)
            ->with('curriculum', $curriculum)
            ->with('evaluationscount', $evaluationscount)
            ->with('evaluations', $evaluations)
            ->with('year', $year);
    }

    function students_list(Request $req) {
        $year = $req->input('year');
        $syf = $req->input('school_year_from');
        $syt = $syf + 1;
        return redirect('students/'.$year.'/'.$syf.'-'.$syt);
    }

    function students_list_view($year, $syf, $syt) {
        /* $year = Evaluation::with('getStudent')
            ->where('semester', Auth::guard('department')->user()->set_semester)
            ->where('school_year_from', $syf)
            ->where('school_year_to', $syt)
            ->get(); */
        $students = Evaluation::with('getStudent')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('semester', Auth::guard('department')->user()->set_semester)
            ->where('school_year_from', $syf)
            ->where('school_year_to', $syt)
            ->get();
        return view('students-list')
            ->with('students', $students)
            ->with('year', $year)
            ->with('syf', $syf)
            ->with('syt', $syt);
    }

    function confirm_password(Request $req) {
        if(Hash::check($req->input('password'), Auth::guard('department')->user()->password)) {
            return response()->json(['success'=>'Password Correct!']);
        } else {
            return response()->json(['error'=>'Password invalid.']);
        }
    }

    function set_semester(Request $req) {
        $update = Department::all()->find(Auth::guard('department')->user()->id);
        $update->set_semester = $req->input('semester');
        $update->save();
        return back();
    }

    function set_school_year(Request $req) {
        $update = Department::all()->find(Auth::guard('department')->user()->id);
        $update->school_year_from = $req->input('year');
        $update->school_year_to = $req->input('year') + 1;
        $update->save();
        return back();
    }

    function profile() {
        return view('profile');
    }

    function profile_update_dept(Request $req) {
        $update = Course::all()->find(Auth::guard('department')->user()->course_id);
        $update->name = $req->input('course');
        $update->abbreviation = $req->input('abbreviation');
        $update->save();
        $update2 = Department::all()->find(Auth::guard('department')->user()->id);
        $update2->name = $req->input('name');
        $update2->dept_head = $req->input('dept_head');
        $update2->save();
        return back()->with('success', 'Department Information Updated Successfully!');
    }

    function profile_update_username(Request $req) {
        if(Department::all()->where('username', $req->input('username'))->first() != null) {
            return back()->with('error', 'Username already exists or the Username is currently used by this account. Please try again.');
        } else {
            $update = Department::all()->find(Auth::guard('department')->user()->id);
            $update->username = $req->input('username');
            $update->save();
            return back()->with('success', 'Username Changed Successfully!');
        }
    }

    function profile_update_password(Request $req) {
        $update = Department::all()->find(Auth::guard('department')->user()->id);
        if(Hash::check($req->input('current_password'), $update->password)) {
            $update->password = Hash::make($req->input('new_password'));
            $update->save();
            return back()->with('success', 'Password Changed Successfully!');
        } else {
            return back()->with('error', 'Invalid Password. Please try again.');
        }
    }

    function curriculum() {
        $curriculum = Curriculum::with('getSubject.getPrereq')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', '1')
            ->get();
        $subjects = Subject::all()
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', '1')
            ->sortBy('course_code');
        $reference = Curriculum::with('getSubject.getPrereq')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', '1')
            ->get()
            ->sortByDesc('reference')
            ->groupBy('reference');
        return view('curriculum')
            ->with('curriculum', $curriculum)
            ->with('subjects', $subjects)
            ->with('reference', $reference);
    }

    function option_pre_req($ref) {
        $view = Curriculum::with('getSubject')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('reference', $ref)
            ->where('is_active', '1')
            ->get();
        if(count($view) == 0) {
            $select = '<option value="" selected>NO SUBJECTS</option>';
        } else {
            foreach($view->sortBy('getSubject.course_code') as $row) {
                $select[] = '<option value='.$row->getSubject->id.'>'.$row->getSubject->course_code.' - '.$row->getSubject->title.'</option>';
            }
        }
        return response()->json(['select'=>$select]);
    }

    function create_curriculum(Request $req) {
        $add = new Subject;
        $add->course_code = $req->input('code');
        $add->title = $req->input('title');
        $add->lec = $req->input('lec');
        $add->lab = $req->input('lab');
        $add->units = $req->input('units');
        if($req->input('pre_req') == "3rd") {
            $add->special_pre_req = "3rd";
        } else if($req->input('pre_req') == "4th") {
            $add->special_pre_req = "4th";
        } else if($req->input('pre_req') == "Complete") {
            $add->special_pre_req = "Complete";
        } else {
            $add->pre_req_id = $req->input('pre_req');
        }
        $add->course_id = Auth::guard('department')->user()->course_id;
        $add->type = $req->input('type');
        $add->save();
        $add2 = new Curriculum;
        $add2->course_id = Auth::guard('department')->user()->course_id;
        $add2->subject_id = $add->id;
        $add2->year_level = $req->input('year');
        $add2->semester = $req->input('semester');
        $add2->reference = $req->input('reference');
        $add2->save();
        return redirect('/curriculum')->with('success', 'Subject Added Successfully!');
    }

    function edit_reference(Request $req) {
        $curr = Curriculum::all()
            ->where('reference', $req->input('old-reference'))
            ->where('course_id', Auth::guard('department')->user()->course_id);
        foreach($curr as $row) {
            $update = Curriculum::all()->find($row->id);
            $update->reference = $req->input('new-reference');
            $update->save();
        }
        return back()->with('success', 'Curriculum Reference Updated!');
    }

    function edit_subject(Request $req) {
        $id = $req->input('id');
        $update = Subject::find($id);
        $update->title = $req->input('title');
        $update->course_code = $req->input('code');
        if($req->input('pre_req') == "3rd") {
            $update->pre_req_id = null;
            $update->special_pre_req = "3rd";
        } else if($req->input('pre_req') == "4th") {
            $update->pre_req_id = null;
            $update->special_pre_req = "4th";
        } else if($req->input('pre_req') == "Complete") {
            $update->pre_req_id = null;
            $update->special_pre_req = "Complete";
        } else {
            $update->special_pre_req = null;
            $update->pre_req_id = $req->input('pre_req');
        }
        $update->type = $req->input('type');
        $update->lec = $req->input('lec');
        $update->lab = $req->input('lab');
        $update->units = $req->input('units');
        $update->save();
        return redirect('/curriculum')->with('success', 'Subject Updated Successfully!');
    }

    function remove_subject(Request $req) {
        $id = $req->input('id');
        $remove = Curriculum::find($id);
        $remove->is_active = '0';
        $remove->save();
        $remove2 = Subject::find($remove->subject_id);
        $remove2->is_active = '0';
        $remove2->save();
        return redirect('/curriculum')->with('remove', 'Subject Removed.');
    }

    function students() {
        $students = Student::all()->where('course_id', Auth::guard('department')->user()->course_id);
        $reference = Curriculum::with('getSubject.getPrereq')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', '1')
            ->get()
            ->sortByDesc('reference')
            ->groupBy('reference');
        return view('students')
            ->with('students', $students)
            ->with('reference', $reference);
    }

    function reg_student(Request $req) {
        $add = new Student;
        $add->student_no = $req->input('studentno');
        $add->first_name = $req->input('fname');
        $add->middle_name = $req->input('mname');
        $add->last_name = $req->input('lname');
        $add->gender = $req->input('gender');
        $add->address = $req->input('address');
        $add->facebook_account = $req->input('facebook');
        $add->email = $req->input('email');
        $add->course_id = Auth::guard('department')->user()->course_id;
        $add->contact_no = $req->input('contactno');
        $add->emerg_contact = $req->input('emerg_contact');
        $add->emerg_contact_no = $req->input('emerg_contactno');
        $add->birthdate = $req->input('bday');
        $add->birthplace = $req->input('bplace');
        if($req->input('status') == "TRANSFEREE") {
            $add->status = "TRANSFEREE";
            $add->save();
            $curriculum = Curriculum::where('is_active', '1')
                ->where('course_id', Auth::guard('department')->user()->course_id)
                ->where('reference', $req->input('reference'))
                ->get();
            foreach($curriculum as $row) {
                $add2 = new Records;
                $add2->student_id = $add->id;
                $add2->curriculum_id = $row->id;
                $add2->save();
            }
            return redirect('/students/student-record/'.$add->id)->with('transferee', 'Registered Student Successfully!');
        } else {
            $add->status = "NEW";
            $add->save();
            $rand = rand(11111, 99999);
            $date = date('dmy');
            $eval_id = "EVL-".$date."-".$add->id."-".$rand;
            $curriculum = Curriculum::where('is_active', '1')
                ->where('course_id', Auth::guard('department')->user()->course_id)
                ->where('reference', $req->input('reference'))
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
                ->where('curricula.reference', $req->input('reference'))
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
            return redirect('/evaluation/student-evaluation/'.$add->id.'/'.$eval_id)->with('success', 'Registered Student Successfully!');
        }
    }

    function bulk_registration(Request $req) {
        $reference = $req->input('reference');
        Excel::import(new StudentsImport($reference), request()->file('file'));
        return back();
    }

    function student_record($id) {
        $view = Student::with('getCourse')->find($id);
        $records = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->get();
        $complete = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->whereNotNull('grade')
            ->get();
        $inc = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->whereNull('grade')
            ->get();
        $ref = Curriculum::with('getSubject.getPrereq')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', '1')
            ->get()
            ->sortByDesc('reference')
            ->groupBy('reference');
        $reference = Records::with('getCurriculum')
            ->where('student_id', $id)
            ->get()
            ->sortByDesc('getCurriculum.reference')
            ->groupBy('getCurriculum.reference');
        return view('students-record')
            ->with('view', $view)
            ->with('records', $records)
            ->with('complete', $complete)
            ->with('inc', $inc)
            ->with('reference', $reference)
            ->with('ref', $ref);
    }

    function student_new_curr(Request $req) {
        $curriculum = Curriculum::where('is_active', '1')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('reference', $req->input('reference'))
            ->get();
        foreach($curriculum as $row) {
            $add = new Records;
            $add->student_id = $req->input('id');
            $add->curriculum_id = $row->id;
            $add->save();
        }
        return redirect('/evaluation/student-record/'.$req->input('id'));
    }

    function update_student(Request $req) {
        $id = $req->input('id');
        $update = Student::all()->find($id);
        $update->student_no = $req->input('studentno');
        $update->first_name = $req->input('fname');
        $update->middle_name = $req->input('mname');
        $update->last_name = $req->input('lname');
        $update->gender = $req->input('gender');
        $update->contact_no = $req->input('contactno');
        $update->emerg_contact = $req->input('emerg');
        $update->emerg_contact_no = $req->input('emerg_no');
        $update->birthdate = $req->input('bday');
        $update->birthplace = $req->input('bplace');
        $update->save();
        return back()->with('success', 'Student Updated Successfully!');
    }

    function student_evaluation_records($id) {
        $student = Student::with('getCourse')->find($id);
        $eval = Evaluation::with('getRecord.getCurriculum.getSubject')
            ->where('student_id', $id)
            ->get()
            ->sortByDesc('created_at')
            ->groupBy('evaluation_no');
        return view('students-evaluation')->with('student', $student)->with('eval', $eval);
    }

    function evaluation() {
        $students = Student::all()->where('course_id', Auth::guard('department')->user()->course_id);
        $reference = Curriculum::with('getSubject.getPrereq')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', '1')
            ->get()
            ->sortByDesc('reference')
            ->groupBy('reference');
        return view('evaluation')->with('students', $students)->with('reference', $reference);
    }

    function evaluation_record($id) {
        $view = Student::with('getCourse')->find($id);
        $records = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->get();
        $complete = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->whereNotNull('grade')
            ->get();
        $inc = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->whereNull('grade')
            ->get();
        $ref = Curriculum::with('getSubject.getPrereq')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', '1')
            ->get()
            ->sortByDesc('reference')
            ->groupBy('reference');
        $reference = Records::with('getCurriculum')
            ->where('student_id', $id)
            ->get()
            ->sortByDesc('getCurriculum.reference')
            ->groupBy('getCurriculum.reference');
        $evaluations = Evaluation::with('getRecord.getCurriculum.getSubject')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('student_id', $id)
            ->get();
        return view('evaluation-record')
            ->with('view', $view)
            ->with('records', $records)
            ->with('complete', $complete)
            ->with('inc', $inc)
            ->with('reference', $reference)
            ->with('ref', $ref)
            ->with('evaluations', $evaluations);
    }

    function edit_year_level(Request $req) {
        $update = Student::find($req->input('id'));
        $update->year_level = $req->input('year');
        $update->save();
        return back()->with('successyear', 'Student Updated Successfully!');
    }

    function edit_status(Request $req) {
        $update = Student::find($req->input('id'));
        $update->status = $req->input('status');
        $update->save();
        return back()->with('successyear', 'Student Updated Successfully!');
    }

    function add_grade(Request $req) {
        $id = $req->input('id');
        $update = Evaluation::with('getRecord.getCurriculum.getSubject')->find($id);
        if($req->input('grade') > 3) {
            $update->grade = 5;
            $update->remarks = 'FAILED';
            $update->save();
            $records = Records::with('getCurriculum.getSubject')->find($update->record_id);
            $records->grade = null;
            $records->remarks = 'FAILED';
            $records->save();
            return back()->with('success', $update->getRecord->getCurriculum->getSubject->course_code.' - '.$update->getRecord->getCurriculum->getSubject->title);
        } else if($req->has('dropped')) {
            $update->grade = null;
            $update->remarks = 'DROPPED';
            $update->save();
            $records = Records::with('getCurriculum.getSubject')->find($update->record_id);
            $records->grade = null;
            $records->remarks = 'DROPPED';
            $records->save();
            return back()->with('success', $update->getRecord->getCurriculum->getSubject->course_code.' - '.$update->getRecord->getCurriculum->getSubject->title);
        } else if($req->input('grade') == null) {
            return back()->with('error', 'It seems like you did not put any grade. Please try again.');
        } else {
            $update->grade = $req->input('grade');
            $update->remarks = 'PASSED';
            $update->save();
            $records = Records::with('getCurriculum.getSubject')->find($update->record_id);
            $records->grade = $req->input('grade');
            $records->remarks = 'PASSED';
            $records->save();
            return back()->with('success', $update->getRecord->getCurriculum->getSubject->course_code.' - '.$update->getRecord->getCurriculum->getSubject->title);
        }
    }

    function update_grade(Request $req) {
        $id = $req->input('id');
        $update = Evaluation::with('getRecord.getCurriculum.getSubject')->find($id);
        if($req->input('grade') > 3) {
            $update->grade = 5;
            $update->remarks = 'FAILED';
            $update->save();
            $records = Records::with('getCurriculum.getSubject')->find($update->record_id);
            $records->grade = null;
            $records->remarks = 'FAILED';
            $records->save();
            return back()->with('successupdate', $update->getRecord->getCurriculum->getSubject->course_code.' - '.$update->getRecord->getCurriculum->getSubject->title);
        } else if($req->has('dropped')) {
            $update->grade = null;
            $update->remarks = 'DROPPED';
            $update->save();
            $records = Records::with('getCurriculum.getSubject')->find($update->record_id);
            $records->grade = null;
            $records->remarks = 'DROPPED';
            $records->save();
            return back()->with('successupdate', $update->getRecord->getCurriculum->getSubject->course_code.' - '.$update->getRecord->getCurriculum->getSubject->title);
        } else if($req->input('grade') == null) {
            $update->grade = null;
            $update->remarks = null;
            $update->save();
            $records = Records::with('getCurriculum.getSubject')->find($update->record_id);
            $records->grade = null;
            $records->remarks = null;
            $records->save();
            return back()->with('successupdate', $update->getRecord->getCurriculum->getSubject->course_code.' - '.$update->getRecord->getCurriculum->getSubject->title);
        } else {
            $update->grade = $req->input('grade');
            $update->remarks = 'PASSED';
            $update->save();
            $records = Records::with('getCurriculum.getSubject')->find($update->record_id);
            $records->grade = $req->input('grade');
            $records->remarks = 'PASSED';
            $records->save();
            return back()->with('successupdate', $update->getRecord->getCurriculum->getSubject->course_code.' - '.$update->getRecord->getCurriculum->getSubject->title);
        }
    }

    function credit_grade(Request $req) {
        $id = $req->input('id');
        $credit = Records::with('getCurriculum.getSubject')->find($id);
        if($req->input('grade') == null || $req->input('credential') == null) {
            $credit->grade = null;
            $credit->remarks = null;
            $credit->credential_name = null;
            $credit->save();
            return back()->with('credit', 'Updated Subject: '.$credit->getCurriculum->getSubject->course_code.' - '.$credit->getCurriculum->getSubject->title);
        } else if($req->input('grade') > 3) {
            $credit->grade = null;
            $credit->remarks = null;
            $credit->credential_name = null;
            $credit->save();return back()->with('credit', 'Updated Subject: '.$credit->getCurriculum->getSubject->course_code.' - '.$credit->getCurriculum->getSubject->title);
        } else {
            $credit->grade = $req->input('grade');
            $credit->remarks = 'CREDITED';
            $credit->credential_name = $req->input('credential');
            $credit->save();
        }
        return back()->with('credit', 'Subject: '.$credit->getCurriculum->getSubject->course_code.' - '.$credit->getCurriculum->getSubject->title.' Credited Successfully.');
    }

    function pre_evaluate(Request $req) {
        $id = $req->input('id');
        $year = $req->input('year');
        $sem = $req->input('semester');
        $reference = $req->input('reference');
        $student = Student::with('getCourse')->get()->find($id);
        $r = DB::table('records')
            ->select('*')
            ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
            ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
            ->where('records.student_id', $id)
            ->where('curricula.year_level', $year)
            ->where('curricula.semester', $sem)
            ->where('curricula.reference', $reference)
            ->where('records.remarks', 'PASSED')
            ->count();

        if($r > 3) {
            if($year < 4) {
                $year = $year + 1; 
            }
        } 

        $max = DB::table('curricula')
            ->select('*')
            ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
            ->where('year_level', $year)
            ->where('semester', $sem)
            ->where('reference', $reference)
            ->where('curricula.course_id', Auth::guard('department')->user()->course_id)
            ->where('curricula.is_active', '1')
            ->sum('units');

        $records = DB::table('records')
            ->select('*', 'records.id AS idrecord')
            ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
            ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
            ->where('curricula.year_level', $year)
            ->where('curricula.semester', $sem)
            ->where('curricula.reference', $reference)
            ->where('records.student_id', $id)
            ->whereNull('records.remarks')
            ->whereNull('records.grade')
            ->get();
    
        
        if(count($records) == 0) {
            $records2 = DB::table('records')
                ->select('*', 'records.id AS idrecord')
                ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
                ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                ->where('records.student_id', $id)
                ->whereNull('records.grade')
                ->where('curricula.semester', $sem)
                ->where('curricula.reference', $reference)
                ->orderBy('course_code')
                ->get();
            
            if(count($records2) == 0) {
                $additional = '<tr align="center"><td colspan="4">No Subjects. Either Semester is already completed or No subjects are offered.</td></tr>';
            } else {
                foreach($records2 as $row) {
                    $prereq2 = DB::table('curricula')
                        ->select('*')
                        ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                        ->where('subjects.id', $row->subject_id)
                        ->first();
                    if($prereq2->pre_req_id == null) {
                        if($prereq2->special_pre_req == "3rd" && $year >= 3) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                        if($prereq2->special_pre_req == "4th" && $year == 4) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                        if($prereq2->special_pre_req == "Complete" && $year == 4) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                        if($prereq2->special_pre_req == null) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                    } else {
                        $findprereq2 = DB::table('records')
                            ->select('*')
                            ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
                            ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                            ->where('subjects.id',  $prereq2->pre_req_id)
                            ->first();
                        if($findprereq2->grade != null) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                    }
                }
            }
            return response()->json(['norecord'=>'<tr align="center"><td colspan="3">No Subjects. Either Semester is already completed or No subjects are offered.</td></tr>',
                                    'additional'=>$additional,
                                    'student'=>$student, 
                                    'max'=>$max,
                                    'sem'=>$sem,
                                    'year'=>$year]);
        } else {
            foreach($records as $key => $row) {
                $prereq = DB::table('curricula')
                    ->select('*')
                    ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                    ->where('curricula.reference', $reference)
                    ->where('subjects.id', $row->subject_id)
                    ->first();
                if($prereq->pre_req_id == null) {
                    if($prereq->special_pre_req == "3rd" && $year >= 3) {
                        $record[] = '<tr>
                                        <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.'></td>
                                        <td>'.$row->title.'</td>
                                        <td>'.$row->units.'<input type="hidden" class="subjects-input-value" value='.$row->units.'></td>
                                        <td><button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i></button></td>
                                    </tr>';
                        $curr[] = $row->idrecord;
                    } else if($prereq->special_pre_req == "4th" && $year == 4) {
                        $record[] = '<tr>
                                        <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.'></td>
                                        <td>'.$row->title.'</td>
                                        <td>'.$row->units.'<input type="hidden" class="subjects-input-value" value='.$row->units.'></td>
                                        <td><button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i></button></td>
                                    </tr>';
                        $curr[] = $row->idrecord;
                    } else {
                        $record[] = '<tr>
                                        <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.'></td>
                                        <td>'.$row->title.'</td>
                                        <td>'.$row->units.'<input type="hidden" class="subjects-input-value" value='.$row->units.'></td>
                                        <td><button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i></button></td>
                                    </tr>';
                        $curr[] = $row->idrecord;
                    }
                } else {
                    $findprereq = DB::table('records')
                        ->select('*')
                        ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
                        ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                        ->where('records.student_id', $id)
                        ->where('curricula.reference', $reference)
                        ->where('subjects.id',  $prereq->pre_req_id)
                        ->first();
                    if($findprereq->grade != null) {
                        $record[] = '<tr>
                                        <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.'></td>
                                        <td>'.$row->title.'</td>
                                        <td>'.$row->units.'<input type="hidden" class="subjects-input-value" value='.$row->units.'></td>
                                        <td><button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i></button></td>
                                    </tr>';
                        $curr[] = $row->idrecord;
                    }
                }
            }
            $records2 = DB::table('records')
                ->select('*', 'records.id AS idrecord')
                ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
                ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                ->whereNotIn('records.id', $curr)
                ->where('records.student_id', $id)
                ->whereNull('records.grade')
                ->where('curricula.semester', $sem)
                ->where('curricula.reference', $reference)
                ->orderBy('course_code')
                ->get();

            if(count($records2) == 0) {
                $additional = '<tr align="center"><td colspan="4">No Subjects. Either Semester is already completed or No subjects are offered.</td></tr>';
            } else {
                foreach($records2 as $key => $row) {
                    $prereq2 = DB::table('curricula')
                        ->select('*')
                        ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                        ->where('curricula.reference', $reference)
                        ->where('subjects.id', $row->subject_id)
                        ->first();
                    if($prereq2->pre_req_id == null) {
                        if($prereq2->special_pre_req == "3rd" && $year >= 3) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                        if($prereq2->special_pre_req == "4th" && $year == 4) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                        if($prereq2->special_pre_req == "Complete" && $year == 4) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                        if($prereq2->special_pre_req == null) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                    } else {
                        $findprereq2 = DB::table('records')
                            ->select('*')
                            ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
                            ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
                            ->where('records.student_id', $id)
                            ->where('curricula.reference', $reference)
                            ->where('subjects.id',  $prereq2->pre_req_id)
                            ->first();
                        if($findprereq2->grade != null) {
                            $additional[] = '<tr>
                                                <td>'.$row->course_code.'<input type="hidden" name="id[]" class="subjects-input-id" value='.$row->idrecord.' disabled></td>
                                                <td>'.$row->title.'</td>
                                                <td>'.$row->units.'<input type="hidden" class="subjects-add-value" value='.$row->units.' required></td>
                                                <td><button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></button></td>
                                            </tr>';
                        }
                    }
                }
                if(empty($additional)) {
                    $additional = '<tr align="center"><td colspan="4">No Subjects are offered.</td></tr>';
                }
            }
            return response()->json(['record'=>$record, 
                                    'student'=>$student,
                                    'max'=>$max,
                                    'additional'=>$additional,
                                    'sem'=>$sem,
                                    'year'=>$year,
                                    'records2'=>$records2]);
        }
    }

    function evaluate_student(Request $req) {
        if($req->input('id') != null) {
            $rand = rand(11111, 99999);
            $date = date('dmy');
            $eval_id = "EVL-".$date."-".$req->input('student')."-".$rand;
            $curr_id = $req->input('id');
            $curriculum = Records::with('getCurriculum.getSubject')
                ->where('student_id', $req->input('student'))
                ->whereIn('id', $curr_id)->get();
            if($req->input('max') == 0) {
                $student = Student::all()->find($req->input('student'));
                $student->year_level = $req->input('year');
                if($student->status == "NEW") {
                    $student->status = "OLD";
                }
                $student->save();
                foreach($curr_id as $curr) {
                    $add = new Evaluation;
                    $add->evaluation_no = $eval_id;
                    $add->course_id = Auth::guard('department')->user()->course_id;
                    $add->student_id = $req->input('student');
                    $add->record_id = $curr;
                    $add->year_level = $req->input('year');
                    $add->semester = $req->input('sem');
                    $add->school_year_from = Auth::guard('department')->user()->school_year_from;
                    $add->school_year_to = Auth::guard('department')->user()->school_year_to;
                    $add->save();
                }
            } else if($curriculum->sum('getCurriculum.getSubject.units') > $req->input('max')) {
                return response()->json(['error'=>'Maximum units is: '.$req->input('max').'. Please remove additional subjects.']);
            } else {
                $student = Student::all()->find($req->input('student'));
                $student->year_level = $req->input('year');
                if($student->status == "NEW") {
                    $student->status = "OLD";
                }
                $student->save();
                foreach($curr_id as $curr) {
                    $add = new Evaluation;
                    $add->evaluation_no = $eval_id;
                    $add->course_id = Auth::guard('department')->user()->course_id;
                    $add->student_id = $req->input('student');
                    $add->record_id = $curr;
                    $add->year_level = $req->input('year');
                    $add->semester = $req->input('sem');
                    $add->school_year_from = Auth::guard('department')->user()->school_year_from;
                    $add->school_year_to = Auth::guard('department')->user()->school_year_to;
                    $add->save();
                }
            }
            return response()->json(['success'=>'/evaluation/student-evaluation/'.$req->input('student').'/'.$eval_id]);
        } else {
            return response()->json(['error'=>'No Subjects on entry.']);
        }
        /* return redirect('/evaluation/student-evaluation/'.$req->input('student').'/'.$eval_id); */
    }

    function evaluation_info($id, $evl) {
        $student = Student::all()->find($id);
        $eval = Evaluation::with('getRecord.getCurriculum.getSubject')->where('evaluation_no', $evl)->get();
        $evalinfo = Evaluation::with('getRecord.getCurriculum.getSubject')->where('evaluation_no', $evl)->first();
        return view('evaluation-evaluate')->with('student', $student)->with('eval', $eval)->with('evalinfo', $evalinfo);
    }

    function reports() {
        $eval = Evaluation::with('getRecord.getCurriculum.getSubject', 'getStudent')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->get()
            ->groupBy('evaluation_no');
        return view('reports')->with('eval', $eval);
    }

    function reports_evaluation_info($id, $evl) {
        $student = Student::all()->find($id);
        $eval = Evaluation::with('getRecord.getCurriculum.getSubject')->where('evaluation_no', $evl)->get();
        $evalinfo = Evaluation::with('getRecord.getCurriculum.getSubject')->where('evaluation_no', $evl)->first();
        return view('reports-info')->with('student', $student)->with('eval', $eval)->with('evalinfo', $evalinfo);
    }

    function search(Request $req) {
        $from = $req->input('from');
        $to = $req->input('to');
        $eval = Evaluation::with('getRecord.getCurriculum.getSubject', 'getStudent')
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()
            ->groupBy('evaluation_no');
        if(count($eval) == 0) {
            $error = '<tr align="center"><td colspan="6">No Evaluations.</td></tr>';
            return response()->json(['error'=>$error]);
        } else {
            foreach($eval as $row) {
                if($row[0]->semester == 1) {
                    $evaluation[] = '<tr>
                                        <td>'.$row[0]->created_at->format('Y-m-d').'</td>
                                        <td>'.$row[0]->evaluation_no.'</td>
                                        <td>'.$row[0]->getStudent->first_name.' '.$row[0]->getStudent->last_name.'</td>
                                        <td>'.$row[0]->year_level.'</td>
                                        <td>1st SEMESTER</td>
                                        <td>'.$row[0]->school_year_from.' - '.$row[0]->school_year_to.'</td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <a href='.url("/reports/evaluation/".$row[0]->student_id."/".$row[0]->evaluation_no).' target="_blank" class="btn btn-primary btn-outline btn-xs"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </td>
                                    </tr>';
                } else if($row[0]->semester == 2) {
                    $evaluation[] = '<tr>
                                        <td>'.$row[0]->created_at->format('Y-m-d').'</td>
                                        <td>'.$row[0]->evaluation_no.'</td>
                                        <td>'.$row[0]->getStudent->first_name.' '.$row[0]->getStudent->last_name.'</td>
                                        <td>'.$row[0]->year_level.'</td>
                                        <td>2nd SEMESTER</td>
                                        <td>'.$row[0]->school_year_from.' - '.$row[0]->school_year_to.'</td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <a href='.url("/reports/evaluation/".$row[0]->student_id."/".$row[0]->evaluation_no).' target="_blank" class="btn btn-primary btn-outline btn-xs"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </td>
                                    </tr>';
                } else {
                    $evaluation[] = '<tr>
                                        <td>'.$row[0]->created_at->format('Y-m-d').'</td>
                                        <td>'.$row[0]->evaluation_no.'</td>
                                        <td>'.$row[0]->getStudent->first_name.' '.$row[0]->getStudent->last_name.'</td>
                                        <td>'.$row[0]->year_level.'</td>
                                        <td>SUMMER</td>
                                        <td>'.$row[0]->school_year_from.' - '.$row[0]->school_year_to.'</td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <a href='.url("/reports/evaluation/".$row[0]->student_id."/".$row[0]->evaluation_no).' target="_blank" class="btn btn-primary btn-outline btn-xs"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </td>
                                    </tr>';
                }
            }
            return response()->json(['evaluation'=>$evaluation]);
        }
    }

    function print($id, $evl) {
        $student = Student::all()->find($id);
        $eval = Evaluation::with('getRecord.getCurriculum.getSubject')->where('evaluation_no', $evl)->get();
        $evalinfo = Evaluation::with('getRecord.getCurriculum.getSubject')->where('evaluation_no', $evl)->first();
        return view('print')->with('student', $student)->with('eval', $eval)->with('evalinfo', $evalinfo);
    }

    function print_curr($reference) {
        $curriculum = Curriculum::with('getSubject.getPrereq')
            ->where('reference', $reference)
            ->where('course_id', Auth::guard('department')->user()->course_id)
            ->where('is_active', 1)
            ->get();
        return view('print-curriculum')->with('curriculum', $curriculum)->with('reference', $reference);
    }

    function print_record($id) {
        $view = Student::find($id);
        $evaluations = Evaluation::with('getRecord.getCurriculum.getSubject')
            ->where('student_id', $id)
            ->get()
            ->groupBy('evaluation_no');
        return view('print-record')->with('view', $view)->with('evaluations', $evaluations);
    }

    function print_student_record($id, $ref) {
        $view = Student::with('getCourse')->find($id);
        $records = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->get();
        $complete = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->whereNotNull('grade')
            ->get();
        $inc = Records::with('getCurriculum.getSubject')
            ->where('student_id', $id)
            ->whereNull('grade')
            ->get();
        $reference = Records::with('getCurriculum')
            ->where('student_id', $id)
            ->get();
        return view('print-student-record')
            ->with('view', $view)
            ->with('records', $records)
            ->with('complete', $complete)
            ->with('inc', $inc)
            ->with('reference', $reference)
            ->with('ref', $ref);
    }

    function blank() {
        /* $complete = DB::table('records')
            ->select('*', 'records.id AS recordid')
            ->join('curricula', 'records.curriculum_id', '=', 'curricula.id')
            ->join('subjects', 'curricula.subject_id', '=', 'subjects.id')
            ->where('records.student_id', 6)
            ->where('subjects.special_pre_req', 'Complete')
            ->get();
        $completerecords = Records::all()->where('student_id', 6)
            ->where('grade', null)
            ->where('id', '!=', $complete[0]->recordid)
            ->count(); */
        $records = Records::with('getCurriculum.getSubject')
            ->where('student_id', 6)
            ->get();
        $complete = Records::with('getCurriculum.getSubject')
            ->where('student_id', 6)
            ->whereNotNull('grade')
            ->get();
        $inc = Records::with('getCurriculum.getSubject')
            ->where('student_id', 6)
            ->whereNull('grade')
            ->get();
        $reference = Records::with('getCurriculum')
            ->where('student_id', 6)
            ->get()
            ->groupBy('getCurriculum.reference');
        return view('blank')
            ->with('records', $records)
            ->with('complete', $complete)
            ->with('inc', $inc)
            ->with('reference', $reference); 
    }
}
