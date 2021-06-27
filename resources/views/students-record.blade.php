<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Students</title>
    @include('includes.link')
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
                            <li class="breadcrumb-item">Records</li>
                            <li class="breadcrumb-item active">{{$view->student_no}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            @if($msg = Session::get('transferee'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>{{$msg}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if($msg = Session::get('credit'))
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
                                    <a href="{{url('/students/student-record/'.$view->id)}}" class="btn btn-primary disabled mr-2"><i class="fa fa-eye"></i> Records</a>
                                    <a href="{{url('/evaluation/student-record/'.$view->id)}}" class="btn btn-warning mr-2"><i class="fa fa-columns fa-fw"></i> Evaluate Student</a>
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
                                                </p>
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
                                <h5>Curriculum Followed:</h5>
                                <div class="pb-4">
                                    <ul class="nav nav-tabs">
                                        @foreach($reference as $row)
                                        <li class="nav-item"><a href="#ref_{{$row[0]->getCurriculum->reference}}" class="nav-link @if($loop->first) active @endif" data-toggle="tab"><strong>{{$row[0]->getCurriculum->reference}}</strong></a></li>
                                        @endforeach
                                        <li class="nav-item"><a href="#new-ref" class="nav-link" data-toggle="tab"><i class="fa fa-plus"></i> New Curriculum</a></li>
                                    </ul>
                                </div>
                                <!-- asdasdsdfasdasdasdasd -->
                                <div class="tab-content">
                                    @foreach($reference as $refs)
                                    <div class="tab-pane fade @if($loop->first) active show @endif" id="ref_{{$refs[0]->getCurriculum->reference}}">
                                        @foreach($records->sortBy('getCurriculum.year_level')->groupBy('getCurriculum.year_level') as $year)
                                            @foreach($records->sortBy('getCurriculum.semester')->groupBy('getCurriculum.semester') as $sem)
                                                @if($sem[0]->getCurriculum->semester == 3)
                                                    @if(count($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', 3)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)) > 0)
                                                        <div class="row">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="7">
                                                                            <div class="row d-flex justify-content-between">
                                                                                <h4>
                                                                                    <strong>
                                                                                        @if($year[0]->getCurriculum->year_level == 1)
                                                                                            1st
                                                                                        @elseif($year[0]->getCurriculum->year_level == 2)
                                                                                            2nd
                                                                                        @elseif($year[0]->getCurriculum->year_level == 3)
                                                                                            3rd
                                                                                        @elseif($year[0]->getCurriculum->year_level == 4)
                                                                                            4th
                                                                                        @endif Year
                                                                                        @if($sem[0]->getCurriculum->semester == 1)
                                                                                            1st
                                                                                        @elseif($sem[0]->getCurriculum->semester == 2)
                                                                                            2nd
                                                                                        @elseif($sem[0]->getCurriculum->semester == 3)
                                                                                            Summer
                                                                                        @endif Semester
                                                                                    </strong>
                                                                                </h4>
                                                                                <h4>@if($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)->whereNotIn('remarks', ['PASSED', 'CREDITED'])->count() == 0) <span class="text-success"><i class="fa fa-check"></i> COMPLETE </span> @endif</h4>
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
                                                                        @if($view->status == "TRANSFEREE")
                                                                        <td>CREDIT NAME</td>
                                                                        <td></td>
                                                                        @endif
                                                                    </tr>
                                                                    @foreach($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference) as $row)
                                                                    <tr>
                                                                        <td>{{$row->getCurriculum->getSubject->course_code}}</td>
                                                                        <td>{{$row->getCurriculum->getSubject->title}}</td>
                                                                        <td>{{$row->getCurriculum->getSubject->units}}</td>
                                                                        <td align="center">
                                                                            @if($row->remarks == "PASSED")
                                                                                {{$row->grade}}
                                                                            @elseif($row->remarks == "FAILED")
                                                                                <strong style="color:red">5</strong>
                                                                            @elseif($row->remarks == "DROPPED")
                                                                                <strong style="color:red">DRP</strong>
                                                                            @elseif($row->remarks == "CREDITED")
                                                                                {{$row->grade}}
                                                                            @endif
                                                                        </td>
                                                                        @if($view->status == "TRANSFEREE")
                                                                        <td>{{$row->credential_name}}</td>
                                                                        <td align="center">
                                                                            <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#credit"
                                                                                data-id="{{$row->id}}"
                                                                                data-curr-id="{{$row->getCurriculum->id}}"
                                                                                data-code="{{$row->getCurriculum->getSubject->course_code}}"
                                                                                data-title="{{$row->getCurriculum->getSubject->title}}"
                                                                                data-lec="{{$row->getCurriculum->getSubject->lec}}"
                                                                                data-lab="{{$row->getCurriculum->getSubject->lab}}"
                                                                                data-units="{{$row->getCurriculum->getSubject->units}}"
                                                                                data-grade="{{$row->grade}}"
                                                                                data-credential="{{$row->credential_name}}"><i class="fa fa-check"></i> CREDIT</button>
                                                                        </td>
                                                                        @endif
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="text-right"><strong>TOTAL UNITS</strong></td>
                                                                        <td><strong>{{$records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)->sum('getCurriculum.getSubject.units')}}</strong></td>
                                                                        <td><strong>{{round($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)->avg('grade'), 2)}}<strong></td>
                                                                        @if($view->status == "TRANSFEREE")
                                                                        <td></td>
                                                                        <td></td>
                                                                        @endif
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="row">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="7">
                                                                        <div class="row d-flex justify-content-between">
                                                                            <h4>
                                                                                <strong>
                                                                                    @if($year[0]->getCurriculum->year_level == 1)
                                                                                        1st
                                                                                    @elseif($year[0]->getCurriculum->year_level == 2)
                                                                                        2nd
                                                                                    @elseif($year[0]->getCurriculum->year_level == 3)
                                                                                        3rd
                                                                                    @elseif($year[0]->getCurriculum->year_level == 4)
                                                                                        4th
                                                                                    @endif Year
                                                                                    @if($sem[0]->getCurriculum->semester == 1)
                                                                                        1st
                                                                                    @elseif($sem[0]->getCurriculum->semester == 2)
                                                                                        2nd
                                                                                    @elseif($sem[0]->getCurriculum->semester == 3)
                                                                                        Summer
                                                                                    @endif Semester
                                                                                </strong>
                                                                            </h4>
                                                                                <h4>@if($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)->whereNotIn('remarks', ['PASSED', 'CREDITED'])->count() == 0) <span class="text-success"><i class="fa fa-check"></i> COMPLETE </span> @endif</h4>
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
                                                                    @if($view->status == "TRANSFEREE")
                                                                    <td>CREDIT NAME</td>
                                                                    <td></td>
                                                                    @endif
                                                                </tr>
                                                                @foreach($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference) as $row)
                                                                <tr>
                                                                    <td>{{$row->getCurriculum->getSubject->course_code}}</td>
                                                                    <td>{{$row->getCurriculum->getSubject->title}}</td>
                                                                    <td>{{$row->getCurriculum->getSubject->units}}</td>
                                                                    <td align="center">
                                                                        @if($row->remarks == "PASSED")
                                                                            {{$row->grade}}
                                                                        @elseif($row->remarks == "FAILED")
                                                                            <strong style="color:red">5</strong>
                                                                        @elseif($row->remarks == "DROPPED")
                                                                            <strong style="color:red">DRP</strong>
                                                                        @elseif($row->remarks == "CREDITED")
                                                                            {{$row->grade}}
                                                                        @endif
                                                                    </td>
                                                                    @if($view->status == "TRANSFEREE")
                                                                    <td>{{$row->credential_name}}</td>
                                                                    <td align="center">
                                                                        <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#credit"
                                                                            data-id="{{$row->id}}"
                                                                            data-curr-id="{{$row->getCurriculum->id}}"
                                                                            data-code="{{$row->getCurriculum->getSubject->course_code}}"
                                                                            data-title="{{$row->getCurriculum->getSubject->title}}"
                                                                            data-lec="{{$row->getCurriculum->getSubject->lec}}"
                                                                            data-lab="{{$row->getCurriculum->getSubject->lab}}"
                                                                            data-units="{{$row->getCurriculum->getSubject->units}}"
                                                                            data-grade="{{$row->grade}}"
                                                                            data-credential="{{$row->credential_name}}"><i class="fa fa-check"></i> CREDIT</button>
                                                                    </td>
                                                                    @endif
                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td></td>
                                                                    <td class="text-right"><strong>TOTAL UNITS</strong></td>
                                                                    <td><strong>{{$records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)->sum('getCurriculum.getSubject.units')}}</strong></td>
                                                                    <td><strong>{{round($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $refs[0]->getCurriculum->reference)->avg('grade'), 2)}}<strong></td>
                                                                    @if($view->status == "TRANSFEREE")
                                                                    <td></td>
                                                                    <td></td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <div class="row d-flex justify-content-end">
                                            <a href="{{url('/print/student-record/'.$view->id.'/'.$refs[0]->getCurriculum->reference)}}" target="_blank" class="btn btn-default btn-lg"><i class="fa fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="tab-pane fade" id="new-ref">
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new-curriculum"><i class="fa fa-plus"></i> Create New Curriculum</button>
                                        </div>
                                    </div>
                                    <!-- asdasdasdasdasdasd -->
                                </div>
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

<div class="modal fade" id="new-curriculum" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="display:none;" id="new-curriculum-overlay">
                <div class="overlay d-flex justify-content-center align-items-center">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
            </div>
            <div class="modal-header">
                <span class="modal-title">New Curriculum</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="confirm-password-form">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" name="password" id="password-form" class="form-control" oninput="$(this).removeClass('is-invalid')" required>
                        <div class="invalid-feedback">Password invalid. Please try again.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
            <form action="{{url('/students/student-new-curriculum')}}" id="new-curr-form" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="id" value="{{$view->id}}" required>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Curriculum</label>
                        <select name="reference" class="form-control" required>
                            @foreach($ref as $row)
                                <option value="{{$row[0]->reference}}">{{$row[0]->reference}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="new-curr-submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="credit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Credit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/evaluation/student-record/credit-grade')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id" id="credit-id" required>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">COURSE CODE</label>
                            <p id="credit-code"></p>
                        </div>
                        <div class="col-md-6">
                            <label for="">DESCRIPTIVE TITLE</label>
                            <p id="credit-title"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Lecture</label>
                            <p id="credit-lec"></p>
                        </div>
                        <div class="col-md-4">
                            <label for="">Laboratory</label>
                            <p id="credit-lab"></p>
                        </div>
                        <div class="col-md-4">
                            <label for="">Units</label>
                            <p id="credit-units"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Input Grade</label>
                        <input type="number" id="credit-grade" name="grade" class="form-control" min="1" max="5" step="0.1" placeholder="Grade">
                    </div>
                    <div class="form-group">
                        <label for="">Name of Subject from Previous School</label>
                        <input type="text" name="credential" id="credit-credential" class="form-control" placeholder="Name">
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
    $('#new-curr-form').on('submit', function() {
        $('#new-curr-submit').prop('disabled', true);
    });
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
    $('#credit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        $('#credit-id').val(button.data('id'));
        $('#credit-curr-id').val(button.data('curr-id'));
        $('#credit-code').html(button.data('code'));
        $('#credit-title').html(button.data('title'));
        $('#credit-lec').html(button.data('lec'));
        $('#credit-lab').html(button.data('lab'));
        $('#credit-units').html(button.data('units'));
        $('#credit-grade').val(button.data('grade'));
        $('#credit-credential').val(button.data('credential'));
    });
    $('#confirm-password-form').on('submit', function(event) {
        event.preventDefault();
        $('#new-curriculum-overlay').show();

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ url('/confirm-password') }}",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                if(result.success) {
                    $('#confirm-password-form').hide();
                    $('#new-curr-form').show();
                    $('#new-curriculum-overlay').hide();
                }
                if(result.error) {
                    $('#password-form').addClass('is-invalid').val("");
                    $('#new-curriculum-overlay').hide();
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
</body>
</html>
