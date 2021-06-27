<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="studentport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Student Evaluations</title>
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
                        <h1 class="m-0">Student Evaluations</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/students')}}">Students</a></li>
                            <li class="breadcrumb-item">Evaluation Records</li>
                            <li class="breadcrumb-item active">{{$student->student_no}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="row pb-4">
                                    <a href="{{url('/students/student-record/'.$student->id)}}" class="btn btn-primary mr-2"><i class="fa fa-eye"></i> Records</a>
                                    <a href="{{url('/evaluation/student-record/'.$student->id)}}" class="btn btn-warning mr-2"><i class="fa fa-columns fa-fw"></i> Evaluate Student</a>
                                    <a href="{{url('/students/student-record/evaluations/'.$student->id)}}" class="btn btn-success disabled"><i class="fa fa-tasks"></i> Evaluation Records</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">ID NUMBER</label>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{$student->student_no}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">FULL NAME</label>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">COURSE</label>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{$student->getCourse->abbreviation}} ({{$student->getCourse->name}})</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">YEAR LEVEL</label>
                                    </div>
                                    <div class="col-md-9">
                                        <p>
                                            @if($student->year_level == 1) 
                                                1st Year
                                            @elseif($student->year_level == 2)
                                                2nd Year
                                            @elseif($student->year_level == 3)
                                                3rd Year
                                            @elseif($student->year_level == 4)
                                                4th year
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">GENDER</label>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{$student->gender}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">STATUS</label>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{$student->status}} STUDENT</p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="evaluations-table">
                                        <thead>
                                            <tr>
                                                <th>Evaluation Date</th>
                                                <th>Reference</th>
                                                <th>Year Level</th>
                                                <th>Semester</th>
                                                <th>School Year</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eval as $row)
                                            <tr>
                                                <td>{{$row[0]->created_at->format('F j, Y')}} at {{$row[0]->created_at->format('h:i A')}}</td>
                                                <td>{{$row[0]->getRecord->getCurriculum->reference}}</td>
                                                <td>
                                                    @if($row[0]->year_level == 1)
                                                        1st Year
                                                    @elseif($row[0]->year_level == 2)
                                                        2nd Year
                                                    @elseif($row[0]->year_level == 3)
                                                        3rd Year
                                                    @else
                                                        4th Year
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row[0]->semester == 1)
                                                        1st SEMESTER
                                                    @elseif($row[0]->semester == 2)
                                                        2nd SEMESTER
                                                    @else
                                                        SUMMER
                                                    @endif
                                                </td>
                                                <td>{{$row[0]->school_year_from}} - {{$row[0]->school_year_to}}</td>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <a href="{{url('/evaluation/student-evaluation/'.$student->id.'/'.$row[0]->evaluation_no)}}" class="btn btn-primary btn-outline btn-xs"><i class="fa fa-eye"></i> View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>  
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('includes.footer')
</div>

@include('includes.script')
<script>
$(document).ready(function() {
    $('#evaluations-table').DataTable({
        ordering: false,
    });
})
</script>
</body>
</html>
