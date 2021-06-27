<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Curriculum</title>
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
                        <h1 class="m-0">Curriculum</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Curriculum</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if($msg = Session::get('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>{{$msg}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if($msg = Session::get('remove'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>{{$msg}}</strong><!--  To restore removed Subject, go to <a href="javascript:void(0);" class="alert-link">Archived Subjects</a> -->
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs">
                                    @foreach($reference as $row)
                                    <li class="nav-item"><a href="#ref_{{$row[0]->reference}}" class="nav-link @if($loop->first) active @endif" data-toggle="tab">{{$row[0]->reference}}</a></li>
                                    @endforeach
                                    <li class="nav-item"><a href="#new-ref" class="nav-link" data-toggle="tab"><i class="fa fa-plus"></i> New Curriculum</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    @foreach($reference as $refs)
                                    <div class="tab-pane fade @if($loop->first) active show @endif" id="ref_{{$refs[0]->reference}}">
                                        <div class="text-center pb-4">
                                            <h1>Southern Philippines College</h1>
                                            <h4>Julio Pacana St., Licuan, Cagayan de Oro City</h4>
                                            <h6>TelNo.856-2609,856-2610,8555357</h6>
                                            <h3 style="text-transform: uppercase">{{Auth::guard('department')->user()->getCourse->name}}</h3>
                                            <h5><strong>Curriculum Reference: {{$refs[0]->reference}} </strong></h5>
                                            <a href="javascript:void(0);" style="font-size:80%" data-toggle="modal" data-target="#edit-reference" data-reference="{{$refs[0]->reference}}"><i class="fa fa-edit"></i> Edit Reference</a>
                                        </div>
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>FIRST YEAR FIRST SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="1" data-sem="1" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>FIRST YEAR SECOND SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="1" data-sem="2" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @if(count($curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $refs[0]->reference)) == 0)
                                        <div class="row pb-3">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="1" data-sem="3" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add FIRST YEAR SUMMER SEMESTER Subject(s)</button>
                                        </div>
                                        @else
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>FIRST YEAR SUMMER SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="1" data-sem="3" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>SECOND YEAR FIRST SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="2" data-sem="1" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>SECOND YEAR SECOND SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="2" data-sem="2" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @if(count($curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $refs[0]->reference)) == 0)
                                        <div class="row pb-3">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="2" data-sem="3" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add SECOND YEAR SUMMER SEMESTER Subject(s)</button>
                                        </div>
                                        @else
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>SECOND YEAR SUMMER SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="2" data-sem="3" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>THIRD YEAR FIRST SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="3" data-sem="1" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>THIRD YEAR SECOND SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="3" data-sem="2" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @if(count($curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $refs[0]->reference)) == 0)
                                        <div class="row pb-3">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="3" data-sem="3" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add THIRD YEAR SUMMER SEMESTER Subject(s)</button>
                                        </div>
                                        @else
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>THIRD YEAR SUMMER SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="3" data-sem="3" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>FOURTH YEAR FIRST SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="4" data-sem="1" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">
                                                            <div class="row justify-content-between">
                                                                <h4><strong>FOURTH YEAR SECOND SEMESTER</strong></h4>
                                                                <button class="btn btn-success" data-toggle="modal" data-target="#create" data-year="4" data-sem="2" data-ref="{{$refs[0]->reference}}"><i class="fa fa-plus"></i> Add Subject(s)</button>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center bg-info">
                                                        <td>COURSE CODE</td>
                                                        <td>DESCRIPTIVE TITLE</td>
                                                        <td>LEC</td>
                                                        <td>LAB</td>
                                                        <td>UNITS</td>
                                                        <td>PREREQ</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    @if(count($curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $refs[0]->reference)) == 0)
                                                    <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
                                                    @else
                                                    @foreach($curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $refs[0]->reference) as $row)
                                                    <tr>
                                                        <td>{{$row->getSubject->course_code}}</td>
                                                        <td>{{$row->getSubject->title}}</td>
                                                        <td>{{$row->getSubject->lec}}</td>
                                                        <td>{{$row->getSubject->lab}}</td>
                                                        <td>{{$row->getSubject->units}}</td>
                                                        <td>
                                                            @if($row->getSubject->pre_req_id != null) 
                                                                {{$row->getSubject->getPrereq->course_code}} 
                                                            @elseif($row->getSubject->pre_req_id == null && $row->getSubject->special_pre_req != null)
                                                                @if($row->getSubject->special_pre_req == "Complete")
                                                                    Complete Academic Year
                                                                @else
                                                                    {{$row->getSubject->special_pre_req}} Year
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-subject"
                                                                        data-id="{{$row->getSubject->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"
                                                                        data-pre_req="{{$row->getSubject->pre_req_id}}"
                                                                        data-special-prereq="{{$row->getSubject->special_pre_req}}"
                                                                        data-lec="{{$row->getSubject->lec}}"
                                                                        data-lab="{{$row->getSubject->lab}}"
                                                                        data-units="{{$row->getSubject->units}}"
                                                                        data-type="{{$row->getSubject->type}}"
                                                                        data-ref="{{$refs[0]->reference}}"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger btn-outline btn-xs" data-toggle="modal" data-target="#remove-subject"
                                                                        data-id="{{$row->id}}"
                                                                        data-code="{{$row->getSubject->course_code}}"
                                                                        data-title="{{$row->getSubject->title}}"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                        <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row pt-4">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="text-center bg-info">
                                                        <th>Subjects</th>
                                                        <th>Unit (Total)</th>
                                                        <th>Subjects</th>
                                                        <th>Lec Hours</th>
                                                        <th>Lab Hours</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Gen. Ed</td>
                                                        <td class="text-center">{{$curriculum->where('getSubject.type', 'gen_ed')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</td>
                                                        <td>Gen. Ed</td>
                                                        <td class="text-center">{{$curriculum->where('getSubject.type', 'gen_ed')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Major</td>
                                                        <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</td>
                                                        <td>Major</td>
                                                        <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</td>
                                                        <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('getSubject.course_code', '!=', 'INTERNSHIP')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>INTERNSHIP</td>
                                                        <td></td>
                                                        <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('getSubject.course_code', 'INTERNSHIP')->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td class="text-center"><strong>{{$curriculum->where('reference', $refs[0]->reference)->sum('getSubject.units')}}</strong></td>
                                                        <td class="text-right"><strong>TOTAL</strong></td>
                                                        <td class="text-center"><strong>{{$curriculum->where('reference', $refs[0]->reference)->sum('getSubject.lec')}}</strong></td>
                                                        <td class="text-center"><strong>{{$curriculum->where('reference', $refs[0]->reference)->sum('getSubject.lab')}}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <a href="{{url('/print/curriculum/'.$refs[0]->reference)}}" target="_blank" class="btn btn-secondary btn-lg"><i class="fa fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="tab-pane fade" id="new-ref">
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new-curriculum"><i class="fa fa-plus"></i> Create New Curriculum</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
    @include('includes.footer')
</div>

<div class="modal fade" id="edit-reference" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Edit Reference</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{url('/curriculum/edit-reference')}}" method="POST">
            @csrf
                <input type="hidden" name="old-reference" id="edit-old-ref">
                <div class="form-group">
                    <label for="">Reference</label>
                    <input type="text" name="new-reference" id="edit-new-ref" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy" data-mask>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Subject Information</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{url('/curriculum/create-curriculum')}}" id="create-form" method="POST">
            @csrf
                <input type="hidden" name="year" id="create-year" required>
                <input type="hidden" name="semester" id="create-sem" required>
                <input type="hidden" name="reference" id="create-ref" required>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Descriptive Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Title" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Course Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Code" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Pre-Requisite</label>
                            <select name="pre_req" id="create-pre-req" class="form-control">
                                
                                <!-- asdasd -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Lecture</label>
                            <input type="number" name="lec" class="form-control" placeholder="Hours">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Laboratory</label>
                            <input type="number" name="lab" class="form-control" placeholder="Hours">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Units</label>
                            <input type="number" name="units" class="form-control" placeholder="Units" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Type of Subject</label>
                            <select name="type" class="form-control">
                                <option value="gen_ed">General Education</option>
                                <option value="major">Major</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="create-submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Subject</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-subject" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Update Subject</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{url('/curriculum/edit-subject')}}" method="POST">
            @csrf
                <input type="hidden" name="id" id="edit-id" required>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Descriptive Title</label>
                            <input type="text" name="title" id="edit-title" class="form-control" placeholder="Title" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Course Code</label>
                            <input type="text" name="code" id="edit-code" class="form-control" placeholder="Code" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Pre-Requisite</label>
                            <select name="pre_req" id="edit-pre_req" class="form-control"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Lecture (hours)</label>
                            <input type="number" name="lec" id="edit-lec" class="form-control" placeholder="Lec">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Laboratory (hours)</label>
                            <input type="number" name="lab" id="edit-lab" class="form-control" placeholder="Lab">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Units</label>
                            <input type="number" name="units" id="edit-units" class="form-control" placeholder="Units" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Type of Subject</label>
                            <select name="type" id="edit-type" class="form-control">
                                <option value="gen_ed">General Education</option>
                                <option value="major">Major</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update Subject</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="remove-subject" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Remove Subject</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{url('/curriculum/remove-subject')}}" method="POST">
            @csrf
                <input type="hidden" name="id" id="remove-id" required>
                <p>Are you sure you want to remove <strong id="remove-desc"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i> Remove Subject</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="new-curriculum" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">New Curriculum</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{url('/curriculum/create-curriculum')}}" method="POST">
            @csrf
                <input type="hidden" name="year" id="create-year" value="1" required>
                <input type="hidden" name="semester" id="create-sem" value="1" required>
                <div class="form-group">
                    <label for="">Curriculum Reference (year)</label>
                    <input type="text" name="reference" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy" data-mask>
                </div>
                <hr class="separator">
                <h4 class="text-center pb-4">Initialize First Year First Semester Subject</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Descriptive Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Title" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Course Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Code" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Pre-Requisite</label>
                            <select name="pre_req" class="form-control">
                                <option value="" selected>None</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Lecture</label>
                            <input type="number" name="lec" class="form-control" placeholder="Hours">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Laboratory</label>
                            <input type="number" name="lab" class="form-control" placeholder="Hours">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Units</label>
                            <input type="number" name="units" class="form-control" placeholder="Units" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Type of Subject</label>
                            <select name="type" class="form-control">
                                <option value="gen_ed">General Education</option>
                                <option value="major">Major</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Subject</button>
            </div>
            </form>
        </div>
    </div>
</div>


@include('includes.script')
<script>
$(document).ready(function() {
    $('input[type=text]').keyup(function () {
        $(this).val($(this).val().toUpperCase());  
    });
    $('[data-mask]').inputmask();
    $('#create').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        $('#create-year').val(button.data('year'));
        $('#create-sem').val(button.data('sem'));
        $('#create-ref').val(button.data('ref'));

        $('#create-pre-req').find('option').remove().end().append('<option value="">LOADING...</option>');
        $.ajax({
            type: "GET",
            enctype: "multipart/form-data",
            url: "{{ url('/curriculum/option-pre-req') }}"+"/"+button.data('ref'),
            dataType: "JSON",
            success: function(result) {
                $('#create-pre-req').find('option').remove().end().append("<option value='' selected>None</option><option value='3rd'>3rd Year</option><option value='4th'>4th Year</option><option value='Complete'>Complete Academic Requirements</option>"+result.select);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    $('#create-form').on('submit', function() {
        $('#create-submit').prop('disabled', true);
        /* function timeout() {
            $('#create-submit').prop('disabled', false);
        }
        setTimeout(timeout, 5000); */
    });
    $('#edit-subject').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        $('#edit-id').val(button.data('id'));
        $('#edit-title').val(button.data('title'));
        $('#edit-code').val(button.data('code'));
        $('#edit-lec').val(button.data('lec'));
        $('#edit-lab').val(button.data('lab'));
        $('#edit-units').val(button.data('units'));
        $('#edit-type').val(button.data('type'));
        if(button.data('pre_req') == false) {
            $.ajax({
                type: "GET",
                enctype: "multipart/form-data",
                url: "{{ url('/curriculum/option-pre-req') }}"+"/"+button.data('ref'),
                dataType: "JSON",
                success: function(result) {
                    $('#edit-pre_req').find('option').remove().end().append("<option value='' selected>None</option><option value='3rd'>3rd Year</option><option value='4th'>4th Year</option><option value='Complete'>Complete Academic Requirements</option>"+result.select).val(button.data('special-prereq'));
                },
                error: function(error) {
                    console.log(error);
                }
            });
        } else {
            $.ajax({
                type: "GET",
                enctype: "multipart/form-data",
                url: "{{ url('/curriculum/option-pre-req') }}"+"/"+button.data('ref'),
                dataType: "JSON",
                success: function(result) {
                    $('#edit-pre_req').find('option').remove().end().append("<option value='' selected>None</option><option value='3rd'>3rd Year</option><option value='4th'>4th Year</option><option value='Complete'>Complete Academic Requirements</option>"+result.select).val(button.data('pre_req'));
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        $('#edit-pre_req').find('option').remove().end().append('<option value="">LOADING...</option>');
    });
    $('#remove-subject').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        $('#remove-id').val(button.data('id'));
        $('#remove-desc').html(button.data('code')+" "+button.data('title'));
    });
    $('#edit-reference').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        $('#edit-old-ref').val(button.data('reference'));
        $('#edit-new-ref').val(button.data('reference'));
    });
});
</script>
</body>
</html>