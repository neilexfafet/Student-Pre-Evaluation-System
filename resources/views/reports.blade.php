<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reports</title>
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
                        <h1 class="m-0">Evaluation Records</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Evaluation Records</li>
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
                                <div class="row d-flex justify-content-between">
                                    <div class="card-title">Evaluation List</div>
                                    <div class="row">
                                        <form id="search">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            @csrf
                                            <input type="text" class="form-control" id="datepicker-search">
                                            <input type="hidden" name="from" id="search-from" required>
                                            <input type="hidden" name="to" id="search-to" required>
                                            <button type="submit" class="btn btn-block btn-outline-primary col-4"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                        </form>
                                        <button type="button" class="btn btn-outline-info" id="view-all-btn"><i class="fa fa-list"></i>View All</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="evaluation-body">
                                    <table class="table table-striped table-bordered table-hover" id="evaluation-table">
                                        <thead>
                                            <tr>
                                                <th>Evaluation Date</th>
                                                <th>Student</th>
                                                <th>Year Level</th>
                                                <th>Semester</th>
                                                <th>School Year</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($eval as $row)
                                            <tr>
                                                <td>{{$row[0]->created_at}}</td>
                                                <td><a href="{{url('/students/student-record/'.$row[0]->getStudent->id)}}" target="_blank">{{$row[0]->getStudent->first_name}} {{$row[0]->getStudent->last_name}}</a></td>
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
                                                        <a href="{{url('/reports/evaluation/'.$row[0]->student_id.'/'.$row[0]->evaluation_no)}}" class="btn btn-primary btn-outline btn-xs"><i class="fa fa-eye"></i> View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive" id="search-body" style="display:none;">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Evaluation Date</th>
                                                <th>Evaluation #</th>
                                                <th>Student</th>
                                                <th>Year</th>
                                                <th>Semester</th>
                                                <th>School Year</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="search-result"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('includes.script')
<script>
$(document).ready(function() {
    $('#evaluation-table').DataTable({
        order: [[0, 'desc']],
    });
    $('#view-all-btn').on('click', function() {
        $('#search-body').hide();
        $('#evaluation-body').show();
    });
    $('#search').on('submit', function(event) {
        event.preventDefault();
        $('#search-body').hide();
        
        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ url('/reports/search') }}",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                if(result.evaluation) {
                    $('#search-result').html(result.evaluation);
                }
                if(result.error) {
                    $('#search-result').html(result.error);
                }
            },
            complete: function() {
                $('#evaluation-body').hide();
                $('#search-body').show();
            },
            error: function(error) {
                console.log(error);
            },
        })
    });
    $('#search-from').val(moment().format('YYYY-MM-DD'));
    $('#search-to').val(moment().format('YYYY-MM-DD'));
    $('#datepicker-search').daterangepicker({
        maxDate: moment(),
        startDate: moment(),
        endDate: moment(),
    },function(start, end, label) {
        $('#search-from').val(start.format('YYYY-MM-DD'));
        $('#search-to').val(end.format('YYYY-MM-DD'));
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });
})
</script>
</body>
</html>
