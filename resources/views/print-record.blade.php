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
    <style>
        .select2-container {
            width: 98% !important;
            padding: 0;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center"><strong>Southern Philippines College</strong></h5>
                <h5 class="text-center">Julio Pacana St., Cagayan de Oro City</h5>
                <h5 class="text-center pt-4"><strong>PERMANENT RECORD</strong></h5>
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
                        <label for="">COURSE & YEAR LEVEL</label>
                    </div>
                    <div class="col-md-9">
                        <p>{{$view->getCourse->abbreviation}} {{$view->year_level}}</p>
                    </div>
                </div>
                <div class="row">
                    <h4>CURRICULUM FOLLOWED:</h4>
                </div>
                <!-- asdasdasdasdasdasdasdasdasd -->
                @if(count($evaluations) == 0)
                <div class="row d-flex justify-content-center">
                    <h4>No Evaluations yet...</h4>
                </div>
                @else
                @foreach($evaluations as $eval)
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4">
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
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td class="text-right"><strong>TOTAL UNITS</strong></td>
                                <td><strong>{{$eval->where('year_level', $eval[0]->year_level)->where('semester', $eval[0]->semester)->sum('getRecord.getCurriculum.getSubject.units')}}</strong></td>
                                <td><strong>{{round($eval->where('year_level', $eval[0]->year_level)->where('semester', $eval[0]->semester)->avg('grade'), 2)}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
                @endif
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
