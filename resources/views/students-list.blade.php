<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>List of @if($year == 1) 1st @elseif($year == 2) 2nd @elseif($year == 3) 3rd @elseif($year == 4) 4th @endif Year Students, School Year {{$syf}} - {{$syt}}</title>
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
                        <h1 class="m-0">Students List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Students List</li>
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
                            <div class="card-header">
                                <div class="card-title">List of @if($year == 1) 1st @elseif($year == 2) 2nd @elseif($year == 3) 3rd @elseif($year == 4) 4th @endif Year Students, School Year {{$syf}} - {{$syt}}</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="students-table">
                                        <thead>
                                            <tr>
                                                <th style="width:2%">#</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Gender</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students->where('getStudent.year_level', $year)->groupBy('student_id') as $row)
                                            <tr class="clickable-row" data-href="{{url('/students/student-record/'.$row[0]->getStudent->id)}}" style="cursor:pointer">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$row[0]->getStudent->last_name}}</td>
                                                <td>{{$row[0]->getStudent->first_name}}</td>
                                                <td>{{$row[0]->getStudent->gender}}</td>
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
        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
    @include('includes.footer')
</div>

@include('includes.script')
<script>
$(document).ready(function() {
    $('#students-table').DataTable({
        order: false,
        paging: false,
        lengthChange: false,
        buttons: ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#students-table_wrapper .col-md-6:eq(0)');
    $('.clickable-row').on('click', function() {
        window.open($(this).data('href'), '_blank');
    })
})
</script>
</body>
</html>