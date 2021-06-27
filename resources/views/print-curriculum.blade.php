<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Print Curriculum</title>
    @include('includes.link')
</head>
<body>

<div class="text-center pb-4">
    <h1>Southern Philippines College</h1>
    <h4>Julio Pacana St., Licuan, Cagayan de Oro City</h4>
    <h6>TelNo.856-2609,856-2610,8555357</h6>
    <h3 style="text-transform: uppercase">{{Auth::guard('department')->user()->getCourse->name}}</h3>
    <h5><strong>Curriculum Reference: {{$reference}} </strong></h5>
</div>
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="7">
                    <div class="row justify-content-between">
                        <h4><strong>FIRST YEAR FIRST SEMESTER</strong></h4>
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
            </tr>
            @if(count($curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '1')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
            </tr>
            @if(count($curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '2')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@if(count($curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $reference)) > 0)
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="7">
                    <div class="row justify-content-between">
                        <h4><strong>FIRST YEAR SUMMER SEMESTER</strong></h4>
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
            </tr>
            @if(count($curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '1')->where('semester', '3')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
            </tr>
            @if(count($curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '1')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
            </tr>
            @if(count($curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '2')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@if(count($curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $reference)) > 0)
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="7">
                    <div class="row justify-content-between">
                        <h4><strong>SECOND YEAR SUMMER SEMESTER</strong></h4>
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
            </tr>
            @if(count($curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '2')->where('semester', '3')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
            </tr>
            @if(count($curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '1')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
            </tr>
            @if(count($curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '2')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@if(count($curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $reference)) > 0)
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="7">
                    <div class="row justify-content-between">
                        <h4><strong>THIRD YEAR SUMMER SEMESTER</strong></h4>
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
            </tr>
            @if(count($curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '3')->where('semester', '3')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
            </tr>
            @if(count($curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '1')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
            </tr>
            @if(count($curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $reference)) == 0)
            <tr><td colspan="7" align="center">No Subjects have been added.</td></tr>
            @else
            @foreach($curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $reference) as $row)
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
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
                <td><strong>{{$curriculum->where('year_level', '4')->where('semester', '2')->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
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
                <td class="text-center">{{$curriculum->where('getSubject.type', 'gen_ed')->where('reference', $reference)->sum('getSubject.units')}}</td>
                <td>Gen. Ed</td>
                <td class="text-center">{{$curriculum->where('getSubject.type', 'gen_ed')->where('reference', $reference)->sum('getSubject.lec')}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Major</td>
                <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('reference', $reference)->sum('getSubject.units')}}</td>
                <td>Major</td>
                <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('reference', $reference)->sum('getSubject.lec')}}</td>
                <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('getSubject.course_code', '!=', 'INTERNSHIP')->where('reference', $reference)->sum('getSubject.lab')}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>INTERNSHIP</td>
                <td></td>
                <td class="text-center">{{$curriculum->where('getSubject.type', 'major')->where('getSubject.course_code', 'INTERNSHIP')->where('reference', $reference)->sum('getSubject.lab')}}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td class="text-center"><strong>{{$curriculum->where('reference', $reference)->sum('getSubject.units')}}</strong></td>
                <td class="text-right"><strong>TOTAL</strong></td>
                <td class="text-center"><strong>{{$curriculum->where('reference', $reference)->sum('getSubject.lec')}}</strong></td>
                <td class="text-center"><strong>{{$curriculum->where('reference', $reference)->sum('getSubject.lab')}}</strong></td>
            </tr>
        </tbody>
    </table>
</div>

@include('includes.script')
<script>
$(document).ready(function() {
    function printpage() {
        window.print();
        window.close();
    }
    setInterval(printpage, 500);
})
</script>
</body>
</html>
