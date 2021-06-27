<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Print</title>
    @include('includes.link')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
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
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="pt-2">Curriculum Followed: <strong>{{$ref}}</strong></h5>
                                <!-- asdasdsdfasdasdasdasd -->
                                <div class="tab-content">
                                        @foreach($records->sortBy('getCurriculum.year_level')->groupBy('getCurriculum.year_level') as $year)
                                            @foreach($records->sortBy('getCurriculum.semester')->groupBy('getCurriculum.semester') as $sem)
                                                @if($sem[0]->getCurriculum->semester == 3)
                                                    @if(count($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', 3)->where('getCurriculum.reference', $ref)) > 0)
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
                                                                                <h4>@if($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref)->where('remarks', '!=', 'PASSED')->count() == 0) <span class="text-success"><i class="fa fa-check"></i> COMPLETE </span> @endif</h4>
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
                                                                        @endif
                                                                    </tr>
                                                                    @foreach($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref) as $row)
                                                                    <tr>
                                                                        <td>{{$row->getCurriculum->getSubject->course_code}}</td>
                                                                        <td>{{$row->getCurriculum->getSubject->title}}</td>
                                                                        <td>{{$row->getCurriculum->getSubject->units}}</td>
                                                                        <td align="center">
                                                                            @if($row->remarks == "PASSED")
                                                                                {{$row->grade}}
                                                                            @elseif($row->remarks == "FAILED")
                                                                                <strong style="color:red">{{$row->grade}}</strong>
                                                                            @elseif($row->remarks == "DROPPED")
                                                                                <strong style="color:red">DRP</strong>
                                                                            @elseif($row->remarks == "CREDIT")
                                                                                {{$row->grade}}
                                                                            @endif
                                                                        </td>
                                                                        @if($view->status == "TRANSFEREE")
                                                                        <td>{{$row->credential_name}}</td>
                                                                        @endif
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="text-right"><strong>TOTAL UNITS</strong></td>
                                                                        <td><strong>{{$records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref)->sum('getCurriculum.getSubject.units')}}</strong></td>
                                                                        <td><strong>{{round($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref)->avg('grade'), 2)}}<strong></td>
                                                                        @if($view->status == "TRANSFEREE")
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
                                                                            <h4>@if($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref)->where('remarks', '!=', 'PASSED')->count() == 0) <span class="text-success"><i class="fa fa-check"></i> COMPLETE </span> @endif</h4>
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
                                                                    @endif
                                                                </tr>
                                                                @foreach($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref) as $row)
                                                                <tr>
                                                                    <td>{{$row->getCurriculum->getSubject->course_code}}</td>
                                                                    <td>{{$row->getCurriculum->getSubject->title}}</td>
                                                                    <td>{{$row->getCurriculum->getSubject->units}}</td>
                                                                    <td align="center">
                                                                        @if($row->remarks == "PASSED")
                                                                            {{$row->grade}}
                                                                        @elseif($row->remarks == "FAILED")
                                                                            <strong style="color:red">{{$row->grade}}</strong>
                                                                        @elseif($row->remarks == "DROPPED")
                                                                            <strong style="color:red">DRP</strong>
                                                                        @elseif($row->remarks == "CREDITED")
                                                                            {{$row->grade}}
                                                                        @endif
                                                                    </td>
                                                                    @if($view->status == "TRANSFEREE")
                                                                    <td>{{$row->credential_name}}</td>
                                                                    @endif
                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td></td>
                                                                    <td class="text-right"><strong>TOTAL UNITS</strong></td>
                                                                    <td><strong>{{$records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref)->sum('getCurriculum.getSubject.units')}}</strong></td>
                                                                    <td><strong>{{round($records->where('getCurriculum.year_level', $year[0]->getCurriculum->year_level)->where('getCurriculum.semester', $sem[0]->getCurriculum->semester)->where('getCurriculum.reference', $ref)->avg('grade'), 2)}}<strong></td>
                                                                    @if($view->status == "TRANSFEREE")
                                                                    <td></td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                </div>
                            </div>
                </div>
            </div>
        </section>

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
