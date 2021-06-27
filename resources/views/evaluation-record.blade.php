<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Evaluation</title>
    @include('includes.link')
    <style>
        .select2-container {
            width: 98% !important;
            padding: 0;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

<div class="wrapper">
    @include('includes.navigation')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Student Record</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/students')}}">Students</a></li>
                            <li class="breadcrumb-item">Evaluate Students</li>
                            <li class="breadcrumb-item active">{{$view->student_no}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            @if($msg = Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>Added Grade to {{$msg}} Successfully!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if($msg = Session::get('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong>{{$msg}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if($msg = Session::get('successupdate'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>Grade to {{$msg}} Updated Successfully!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if($msg = Session::get('successyear'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>{{$msg}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="row pb-4">
                                    <a href="{{url('/students/student-record/'.$view->id)}}" class="btn btn-primary mr-2"><i class="fa fa-eye"></i> Records</a>
                                    <a href="{{url('/evaluation/student-record/'.$view->id)}}" class="btn btn-warning disabled mr-2"><i class="fa fa-columns fa-fw"></i> Evaluate Student</a>
                                    <a href="{{url('/students/student-record/evaluations/'.$view->id)}}" class="btn btn-success"><i class="fa fa-tasks"></i> Evaluation Records</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">ID NUMBER</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>{{$view->student_no}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">FULL NAME</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>{{$view->first_name}} {{$view->middle_name}} {{$view->last_name}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">COURSE</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>{{$view->getCourse->abbreviation}} ({{$view->getCourse->name}})</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">YEAR LEVEL</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>
                                                    @if($view->year_level == 1) 
                                                        1st Year
                                                    @elseif($view->year_level == 2)
                                                        2nd Year
                                                    @elseif($view->year_level == 3)
                                                        3rd Year
                                                    @elseif($view->year_level == 4)
                                                        4th year
                                                    @endif
                                                    &nbsp; &nbsp; &nbsp;<a href="javascript:void(0);" style="font-size:75%" data-toggle="modal" data-target="#edit-year-level" data-id="{{$view->id}}" data-year="{{$view->year_level}}"><i class="fa fa-edit"></i> Edit Year Level</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">GENDER</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>{{$view->gender}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">STATUS</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>
                                                    {{$view->status}} STUDENT
                                                    &nbsp; &nbsp; &nbsp;<a href="javascript:void(0);" style="font-size:75%" data-toggle="modal" data-target="#edit-status" data-id="{{$view->id}}" data-status="{{$view->status}}"><i class="fa fa-edit"></i> Edit Status</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="nav nav-pills">
                                            @foreach($reference as $row)
                                            <li class="nav-item"><a href="#chart_{{$row[0]->getCurriculum->reference}}" class="nav-link @if($loop->first) active @endif" data-toggle="tab"><strong>{{$row[0]->getCurriculum->reference}}</strong></a></li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($reference as $row)
                                            <div class="tab-pane fade @if($loop->first) active show @endif" id="chart_{{$row[0]->getCurriculum->reference}}">
                                                <canvas id="donutChart_{{$loop->index}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>CURRICULUM FOLLOWED:</h5>
                                    </div>
                                </div>
                                <div class="pb-4">
                                    <ul class="nav nav-tabs">
                                        @foreach($reference as $row)
                                        <li class="nav-item"><a href="#ref_{{$row[0]->getCurriculum->reference}}" class="nav-link @if($loop->first) active @endif" data-toggle="tab"><strong>{{$row[0]->getCurriculum->reference}}</strong></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- asdasdasdasdasdasdasdasdasd -->
                                <div class="tab-content">
                                    @foreach($reference as $refs)
                                    <div class="tab-pane fade @if($loop->first) active show @endif" id="ref_{{$refs[0]->getCurriculum->reference}}">
                                        @if(count($records->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)->whereNull('grade')) > 0)
                                        <div class="row pb-4">
                                            <div class="col-md-12">
                                                <form id="evaluate-form-{{$refs[0]->getCurriculum->reference}}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$view->id}}">
                                                    <input type="hidden" name="year" value="{{$view->year_level}}">
                                                    <input type="hidden" name="semester" value="{{Auth::guard('department')->user()->set_semester}}">
                                                    <input type="hidden" name="reference" value="{{$refs[0]->getCurriculum->reference}}">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-list"></i> EVALUATE</button>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                        @if(count($evaluations->where('getRecord.getCurriculum.reference', $refs[0]->getCurriculum->reference)) == 0)
                                        <div class="row d-flex justify-content-center">
                                            <h4>No Evaluations yet...</h4>
                                        </div>
                                        @else
                                        @foreach($evaluations->where('getRecord.getCurriculum.reference', $refs[0]->getCurriculum->reference)->groupBy('evaluation_no') as $eval)
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row d-flex justify-content-between">
                                                                <h4>
                                                                    <strong>
                                                                        @if($eval[0]->year_level == 1)
                                                                            1st    
                                                                        @elseif($eval[0]->year_level == 2)
                                                                            2nd
                                                                        @elseif($eval[0]->year_level == 3)
                                                                            3rd
                                                                        @elseif($eval[0]->year_level == 4)
                                                                            4th
                                                                        @endif Year
                                                                        @if($eval[0]->semester == 1)
                                                                            1st
                                                                        @elseif($eval[0]->semester == 2)
                                                                            2nd
                                                                        @elseif($eval[0]->semester == 3)
                                                                            Summer
                                                                        @endif Semester
                                                                    </strong>
                                                                </h4>
                                                                <h4><strong>S.Y. {{$eval[0]->school_year_from}} - {{$eval[0]->school_year_to}}</strong></h4>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>UNITS</td>
                                                        <td width="5%">GRADE</td>
                                                        @if($loop->last)
                                                        <td>Action</td>
                                                        @endif
                                                    </tr>
                                                    @foreach($eval as $row)
                                                        <tr>
                                                            <td>{{$row->getRecord->getCurriculum->getSubject->course_code}}</td>
                                                            <td>{{$row->getRecord->getCurriculum->getSubject->title}}</td>
                                                            <td>{{$row->getRecord->getCurriculum->getSubject->units}}</td>
                                                            <td class="text-center">
                                                                @if($row->remarks == "PASSED")
                                                                    {{$row->getRecord->grade}}
                                                                @elseif($row->remarks == "FAILED")
                                                                    <strong style="color:red">{{$row->grade}}</strong>
                                                                @elseif($row->remarks == "DROPPED")
                                                                    <strong style="color:red">DRP</strong>
                                                                @endif
                                                            </td>
                                                            @if($loop->parent->last)
                                                            <td class="text-center">
                                                                @if($row->grade == null && $row->remarks == null)
                                                                    <button class="btn btn-success btn-outline btn-xs" data-toggle="modal" data-target="#add-grade"
                                                                        data-id="{{$row->id}}"
                                                                        data-curr-id="{{$row->getRecord->getCurriculum->id}}"
                                                                        data-code="{{$row->getRecord->getCurriculum->getSubject->course_code}}"
                                                                        data-title="{{$row->getRecord->getCurriculum->getSubject->title}}"
                                                                        data-lec="{{$row->getRecord->getCurriculum->getSubject->lec}}"
                                                                        data-lab="{{$row->getRecord->getCurriculum->getSubject->lab}}"
                                                                        data-units="{{$row->getRecord->getCurriculum->getSubject->units}}"><i class="fa fa-plus"></i> Add Grade</button>
                                                                @else
                                                                    <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-grade"
                                                                        data-id="{{$row->id}}"
                                                                        data-curr-id="{{$row->getRecord->getCurriculum->id}}"
                                                                        data-code="{{$row->getRecord->getCurriculum->getSubject->course_code}}"
                                                                        data-title="{{$row->getRecord->getCurriculum->getSubject->title}}"
                                                                        data-lec="{{$row->getRecord->getCurriculum->getSubject->lec}}"
                                                                        data-lab="{{$row->getRecord->getCurriculum->getSubject->lab}}"
                                                                        data-units="{{$row->getRecord->getCurriculum->getSubject->units}}"
                                                                        data-remarks="{{$row->getRecord->remarks}}"
                                                                        data-grade="{{$row->getRecord->grade}}"><i class="fa fa-edit"></i> Edit Grade</button>
                                                                @endif
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL UNITS</strong></td>
                                                        <td><strong>{{$eval->where('year_level', $eval[0]->year_level)->where('semester', $eval[0]->semester)->where('getRecord.getCurriculum.reference', $refs[0]->getCurriculum->reference)->sum('getRecord.getCurriculum.getSubject.units')}}</strong></td>
                                                        <td><strong>{{round($eval->where('year_level', $eval[0]->year_level)->where('semester', $eval[0]->semester)->where('getRecord.getCurriculum.reference', $refs[0]->getCurriculum->reference)->avg('grade'), 2)}}</strong></td>
                                                        @if($loop->last)
                                                        <td></td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                <!-- asdasdasdasdas -->
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="{{url('/print/record/'.$view->id)}}" target="_blank" class="btn btn-default btn-lg"><i class="fa fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
    @include('includes.footer')
</div>

<div class="modal fade" id="add-grade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Grade</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/evaluation/student-record/add-grade')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id" id="add-id" required>
                    <input type="hidden" name="curr_id" id="add-curr-id" required>
                    <input type="hidden" name="student_id" value="{{$view->id}}" required>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">COURSE CODE</label>
                            <p id="add-code"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="">DESCRIPTIVE TITLE</label>
                            <p id="add-title"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Lecture</label>
                            <p id="add-lec"></p>
                        </div>
                        <div class="col-md-4">
                            <label for="">Laboratory</label>
                            <p id="add-lab"></p>
                        </div>
                        <div class="col-md-4">
                            <label for="">Units</label>
                            <p id="add-units"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Input Grade</label>
                        <input type="number" id="grade-input" name="grade" class="form-control" min="1" max="5" step="0.1" placeholder="Grade" required>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input name="dropped" id="add-dropped" type="checkbox"><strong>&nbsp;&nbsp;&nbsp;DROPPED</strong></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-grade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Grade</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/evaluation/student-record/update-grade')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id" id="edit-id" required>
                    <input type="hidden" name="curr_id" id="edit-curr-id" required>
                    <input type="hidden" name="student_id" value="{{$view->id}}" required>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">COURSE CODE</label>
                            <p id="edit-code"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="">DESCRIPTIVE TITLE</label>
                            <p id="edit-title"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Lecture</label>
                            <p id="edit-lec"></p>
                        </div>
                        <div class="col-md-4">
                            <label for="">Laboratory</label>
                            <p id="edit-lab"></p>
                        </div>
                        <div class="col-md-4">
                            <label for="">Units</label>
                            <p id="edit-units"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Input Grade</label>
                        <input type="number" id="edit-grade-input" name="grade" class="form-control" min="1" max="5" step="0.1" placeholder="Grade">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input name="dropped" id="edit-dropped" type="checkbox"><strong>&nbsp;&nbsp;&nbsp;DROPPED</strong></label>
                        </div>
                    </div>
                </div>
                @if($view->status == "TRANSFEREE")
                <div class="form-group">
                    <div class="checkbox">
                        <label><input name="credit" id="edit-credit-checkbox" type="checkbox" name="credit"><strong> CREDIT SUBJECT</strong></label>
                    </div>
                </div>
                <div class="form-group" id="edit-credential-view" style="display:none;">
                    <label for="">Name of Subject from Previous School</label>
                    <input type="text" name="credential" id="edit-credential" class="form-control">
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="evaluate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="evaluate-modal-dialog" role="document">
        <form id="evaluate-form-success" style="display:none;">
        <div class="modal-content">
            <div style="display:none;" id="evaluate-overlay">
                <div class="overlay d-flex justify-content-center align-items-center">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">Evaluate Student</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="student" value="{{$view->id}}">
                <input type="hidden" name="sem" id="evaluate-input-sem">
                <input type="hidden" name="max" id="evaluate-input-max">
                <input type="hidden" name="year" id="evaluate-input-year">
                <div id="error-alert" class="alert alert-danger" role="alert" style="display:none;">
                    <strong id="error-msg"></strong>
                </div>
                <div class="row pb-4">
                    <div class="col-md-3">
                        <label for="">Student Name</label>
                        <p id="evaluate-form-success-name"></p>
                    </div>
                    <div class="col-md-3">
                        <label for="">Student ID</label>
                        <p id="evaluate-form-success-studentno"></p>
                    </div>
                    <div class="col-md-3">
                        <label for="">Year Level</label>
                        <p id="evaluate-form-success-year-span"></p>
                    </div>
                    <div class="col-md-3">
                        <label for="">MAXIMUM UNITS</label>
                        <p id="maximum-units"></p>
                    </div>
                </div>
                <h5>Subjects to be Enrolled</h5>
                <div class="table-responsive">
                    <table class="table" id="subjects-table">
                        <thead>
                            <tr>
                                <th>DCODE</th>
                                <th>TITLE</th>
                                <th>UNITS</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="evaluate-form-success-tbody"></tbody>
                        <tr>
                            <td colspan='2' class='text-right'><strong>TOTAL</strong></td>
                            <td><strong id='subjectsum-id'></strong></td>
                            <td></td>
                        </tr>
                        <tr id="evaluate-form-alert" style="display:none;">
                            <td colspan='4' class='text-right'><span style="color:red">Maximum Total of units exceeded. Please remove subjects.</span></td>
                        </tr>
                    </table>
                </div>
                <div id="additional-view">
                    <h5>Select Additional Subject(s)</h5>
                    <div class="table-responsive">
                        <table class="table" id="additional-table">
                            <thead>
                                <tr>
                                    <th>DCODE</th>
                                    <th>TITLE</th>
                                    <th>UNITS</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="evaluate-form-additional-tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Evaluate</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit-year-level" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/evaluation/edit-year-level')}}" method="POST">
                @csrf 
                <input type="hidden" name="id" id="edit-year-id" required>
                <div class="form-group">
                    <label for="">Year Level</label>
                    <select name="year" id="edit-year-select" class="form-control" required>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/evaluation/edit-status')}}" method="POST">
                @csrf 
                <input type="hidden" name="id" id="edit-status-id" required>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" id="edit-status-select" class="form-control" required>
                        <option value="TRANSFEREE">Transferee/Returnee Student</option>
                        <option value="NEW">New Student</option>
                        <option value="OLD">Old Student</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


@include('includes.script')
<script>
$(document).ready(function() {
    $('#edit-year-level').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        $('#edit-year-id').val(button.data('id'));
        $('#edit-year-select').val(button.data('year'));
    });
    $('#edit-status').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        $('#edit-status-id').val(button.data('id'));
        $('#edit-status-select').val(button.data('status'));
    });
    $('#add-grade').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        $('#add-id').val(button.data('id'));
        $('#add-curr-id').val(button.data('curr-id'));
        $('#add-code').html(button.data('code'));
        $('#add-title').html(button.data('title'));
        $('#add-lec').html(button.data('lec'));
        $('#add-lab').html(button.data('lab'));
        $('#add-units').html(button.data('units'));
    });
    $('#edit-grade').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        $('#edit-id').val(button.data('id'));
        $('#edit-curr-id').val(button.data('curr-id'));
        $('#edit-code').html(button.data('code'));
        $('#edit-title').html(button.data('title'));
        $('#edit-lec').html(button.data('lec'));
        $('#edit-lab').html(button.data('lab'));
        $('#edit-units').html(button.data('units'));
        $('#edit-grade-input').val(button.data('grade'));
        if(button.data('remarks') == "FAILED") {
            $('#edit-grade-input').val('5');
        }
        if(button.data('remarks') == "DROPPED") {
            $('#edit-dropped').prop('checked', true);
            $('#edit-grade-input').prop('disabled', true);
        }
    });
    $('#add-dropped').change(function() {
        if($(this).is(':checked')) {
            $('#grade-input').val("").prop('disabled', true);
        } else {
            $('#grade-input').prop('disabled', false);
        }
    });
    $('#edit-dropped').change(function() {
        if($(this).is(':checked')) {
            $('#edit-grade-input').val("").prop('disabled', true);
        } else {
            $('#edit-grade-input').prop('disabled', false);
        }
    });
    $('#credit-checkbox').change(function() {
        if($(this).is(':checked')) {
            $('#credential').val("").prop('disabled', false).prop('required', true);
            $('#credential-view').show();
        } else {
            $('#credential').prop('disabled', true).prop('required', false);
            $('#credential-view').hide();
        }
    });
    $('#edit-credit-checkbox').change(function() {
        if($(this).is(':checked')) {
            $('#edit-credential').val("").prop('disabled', false).prop('required', true);
            $('#edit-credential-view').show();
        } else {
            $('#edit-credential').prop('disabled', true).prop('required', false);
            $('#edit-credential-view').hide();
        }
    });
    $('#evaluate-form-success').on('submit', function(event) {
        event.preventDefault();
        $('#evaluate-overlay').show();

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ url('/evaluation/student-record/evaluate') }}",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                if(result.error) {
                    $('#evaluate').animate({ scrollTop: 0 }, 'slow');
                    $('#error-alert').show();
                    $('#error-msg').html(result.error);
                    $('#evaluate-overlay').hide();
                }
                if(result.success) {
                    window.location = result.success;
                }
            },
            error: function(error) {
                console.log(error);
            },
        })
    });
})
</script>
@foreach($reference as $row)
<script>
$(document).ready(function() {
    var count = "{{$records->where('getCurriculum.reference', $row[0]->getCurriculum->reference)->count()}}";
    var complete = "{{$complete->where('getCurriculum.reference', $row[0]->getCurriculum->reference)->count()}}";
    var incomplete = "{{$inc->where('getCurriculum.reference', $row[0]->getCurriculum->reference)->count()}}";
    var com = Math.round((complete / count) * 100);
    var inc = Math.round((incomplete / count) * 100);
    var donutChartCanvas = $('#donutChart_{{$loop->index}}').get(0).getContext('2d');
    var donutData        = {
        labels: [
            'Complete',
            'No Grade / Failed / Dropped',
        ],
        datasets: [
            {
                data: [com, inc],
                backgroundColor : ['#00c0ef', '#d2d6de'],
            }
        ]
    }
    var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
        tooltips: {
            callbacks: {
                title: function (tooltipItem, data) {
                    return data["labels"][tooltipItem[0]["index"]];
                },
                label: function(tooltipItem, data) {
                    return (
                        data["datasets"][0]["data"][tooltipItem["index"]] + "%"
                    );
                }
            }
        }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
    })
})
</script>
@endforeach

@foreach($reference as $row)
<script>
$(document).ready(function() {
    $('#evaluate-form-{{$row[0]->getCurriculum->reference}}').on('submit', function(event) {
        event.preventDefault();
        $('#evaluate-modal-dialog').hide();

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ url('/evaluation/student-record/pre-evaluate') }}",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                if(result.norecord) {
                    $('#evaluate-form-success-studentno').html(result.student.student_no);
                    $('#evaluate-form-success-name').html(result.student.first_name+" "+result.student.last_name);
                    $('#evaluate-input-sem').val(result.sem);
                    $('#evaluate-input-max').val(result.max);
                    $('#evaluate-input-year').val(result.year);
                    $('#maximum-units').html(result.max);
                    $('#evaluate-form-success-tbody').html(result.norecord);
                    $('#evaluate-form-additional-tbody').html(result.additional);
                    $('#select-multiple-div').show();
                    /* $('#select-multiple').html(result.select2); */
                    if(result.student.year_level == "1") {
                        $('#evaluate-form-success-year-span').html("1st Year");
                    } else if(result.student.year_level == "2") {
                        $('#evaluate-form-success-year-span').html("2nd Year");
                    } else if(result.student.year_level == "3") {
                        $('#evaluate-form-success-year-span').html("3rd Year");
                    } else {
                        $('#evaluate-form-success-year-span').html("4th Year");
                    }
                    $('#evaluate-form-success').show();
                } else {
                    /* var sum2 = sum(result.count2); */
                    /* $.each(result.curr, function(i, item) {
                        $('#evaluate-input-curr').append("<input name='id[]' type='hidden' value="+item+"><br>");
                    }); */
                    $('#evaluate-form-success-studentno').html(result.student.student_no);
                    $('#evaluate-form-success-name').html(result.student.first_name+" "+result.student.last_name);
                    $('#evaluate-input-sem').val(result.sem);
                    $('#evaluate-input-max').val(result.max);
                    $('#evaluate-input-year').val(result.year);
                    $('#maximum-units').html(result.max);
                    if(result.student.year_level == "1") {
                        $('#evaluate-form-success-year-span').html("1st Year");
                    } else if(result.student.year_level == "2") {
                        $('#evaluate-form-success-year-span').html("2nd Year");
                    } else if(result.student.year_level == "3") {
                        $('#evaluate-form-success-year-span').html("3rd Year");
                    } else {
                        $('#evaluate-form-success-year-span').html("4th Year");
                    }
                    $('#evaluate-form-success-tbody').html(result.record);
                    var subjectsum = 0;
                    $('.subjects-input-value').each(function() {
                        subjectsum += +$(this).val();
                    });
                    $('#subjectsum-id').html(subjectsum);
                    if(subjectsum == result.max) {
                        $('#additional-view').hide();
                    }
                    $('#evaluate-form-additional-tbody').html(result.additional);
                    $('#evaluate-form-success').show();
                }
                console.log(result.records2);
            },
            complete: function() {
                $('#evaluate').modal('show');
                $('#evaluate-modal-dialog').show();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
})
</script>
@endforeach
<script>
$(document).ready(function() {
    var subjectsum = 0;
    function SubjectsSum() {
        var subjectsum = 0;
        $('.subjects-input-value').each(function() {
            subjectsum += +$(this).val();
        });
        $('#subjectsum-id').html(subjectsum);
    }
    $('table').on('click', '.btn.btn-outline-success.btn-sm, .btn.btn-outline-danger.btn-sm', function() {
        if($(this).hasClass('btn btn-outline-danger btn-sm')) {
            $('#additional-view').show();
            var newTd = 'btn btn-outline-success btn-sm';
            $(this).removeClass().addClass(newTd);
            $(this).find('i').removeClass().addClass("fa fa-plus");
            $(this).closest('tr').find('input[class="subjects-input-id"]').prop('disabled', true);
            $(this).closest('tr').find('input[class="subjects-input-value"]').removeClass().addClass("subjects-add-value");
            var tr = $(this).closest('tr');
            $('#evaluate-form-additional-tbody').append(tr.clone());
        } else {
            $('#additional-view').show();
            var newTd = 'btn btn-outline-danger btn-sm';
            $(this).removeClass().addClass(newTd);
            $(this).find('i').removeClass().addClass("fa fa-times");
            $(this).closest('tr').find('input[class="subjects-input-id"]').prop('disabled', false);
            $(this).closest('tr').find('input[class="subjects-add-value"]').removeClass().addClass("subjects-input-value");
            var tr = $(this).closest('tr');
            $('#evaluate-form-success-tbody').append(tr.clone());
        }
        tr.remove();
        SubjectsSum();
        if(parseInt($('#maximum-units').text()) != 0) {
            if(parseInt($('#subjectsum-id').text()) > parseInt($('#maximum-units').text())) {
                $('#evaluate-form-alert').show();
            } else {
                $('#evaluate-form-alert').hide();
            }
        }
    })
})
</script>
</body>
</html>
