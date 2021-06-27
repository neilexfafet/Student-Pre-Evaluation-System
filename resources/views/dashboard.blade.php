<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard</title>
    @include('includes.link')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

<div class="wrapper">
    @include('includes.navigation')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @if($msg = Session::get('alert'))
                <div class="alert alert-light alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-info"></i> 
                    Note! Check semester and school year first before evaluating students. 
                    <a href="javascript:void(0);" class="alert-link" data-toggle="modal" data-target="#set-semester">Click Here</a> 
                    for the semester and <a href="javascript:void(0);" class="alert-link" data-toggle="modal" data-target="#set-school-year">Click Here</a> for the school year or click the semester located at the top of the sidebar and click the school year located at the top header.</h5>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>&nbsp;</h3>
                                <p>Evaluate Students</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-tasks"></i>
                            </div>
                            <a href="{{url('/evaluation')}}" class="small-box-footer">Evaluation List <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$students}}</h3>
                                <p>Students</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="{{url('/students')}}" class="small-box-footer">View List <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$curriculum}}</h3>
                                <p>Curriculum</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <a href="{{url('/curriculum')}}" class="small-box-footer">View Curriculum(s) <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$evaluationscount}}</h3>
                                <p>Evaluations</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-person-booth"></i>
                            </div>
                            <a href="{{url('/reports')}}" class="small-box-footer">View Reports <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6" style="cursor:pointer" data-toggle="modal" data-target="#year-level" data-year="1">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">1st Year</span>
                                <span class="info-box-number">{{$year->where('getStudent.year_level', 1)->groupBy('student_id')->count()}} <span style="font-size:75%">currently evaluated</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6" style="cursor:pointer" data-toggle="modal" data-target="#year-level" data-year="2">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">2nd Year</span>
                                <span class="info-box-number">{{$year->where('getStudent.year_level', 2)->groupBy('student_id')->count()}} <span style="font-size:75%">currently evaluated</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6" style="cursor:pointer" data-toggle="modal" data-target="#year-level" data-year="3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">3rd Year</span>
                                <span class="info-box-number">{{$year->where('getStudent.year_level', 3)->groupBy('student_id')->count()}} <span style="font-size:75%">currently evaluated</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6" style="cursor:pointer" data-toggle="modal" data-target="#year-level" data-year="4">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">4th Year</span>
                                <span class="info-box-number">{{$year->where('getStudent.year_level', 4)->groupBy('student_id')->count()}} <span style="font-size:75%">currently evaluated</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Evaluations</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    @if(count($evaluations) > 0)
                                    @foreach($evaluations as $row)
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="{{asset('assets/img/user.jpg')}}" alt="Product Image" class="img-size-50">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{url('/reports/evaluation/'.$row[0]->student_id.'/'.$row[0]->evaluation_no)}}" class="product-title"> {{$row[0]->getStudent->first_name}} {{$row[0]->getStudent->last_name}} 
                                            <span class="badge badge-info float-right">{{$row[0]->created_at->diffForHumans()}}</span></a>
                                            <span class="product-description">
                                                @if($row[0]->year_level == 1)
                                                    1st Year
                                                @elseif($row[0]->year_level == 2)
                                                    2nd Year
                                                @elseif($row[0]->year_level == 3)
                                                    3rd Year
                                                @else
                                                    4th Year
                                                @endif

                                                @if($row[0]->semester == 1)
                                                    1st SEMESTER
                                                @elseif($row[0]->semester == 2)
                                                    2nd SEMESTER
                                                @else
                                                    SUMMER
                                                @endif
                                            </span>
                                        </div>
                                    </li>
                                    @endforeach
                                    @else
                                    <li class="item">
                                        <div class="d-flex justify-content-center">
                                            <span>No Evaluations Yet. . .</span>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{url('/reports')}}" class="uppercase">View All Evaluations</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <form id="search">
                                @csrf
                                <div class="row d-flex justify-content-between">
                                    <div>Search Evaluation by Date</div>
                                    <div class="row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="datepicker-search">
                                            <input type="hidden" name="from" id="search-from" required>
                                            <input type="hidden" name="to" id="search-to" required>
                                            <button type="submit" class="btn btn-block btn-outline-primary col-4"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body p-0" id="search-body" style="display:none;">
                                <div class="table-responsive">
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
        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
    @include('includes.footer')
</div>


<div class="modal fade" id="year-level" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Students</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/students-list')}}" method="POST">
                @csrf
                <input type="hidden" name="year" id="year-year-level">
                <div class="form-group">
                    <label for="">School Year Start</label>
                    <input type="text" name="school_year_from" id="school-year-id" class="form-control" placeholder="YYYY" value="{{Auth::guard('department')->user()->school_year_from}}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
            </form>
        </div>
    </div>
</div>


@include('includes.script')
<script>
$(document).ready(function() {
    $('#year-level').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        $('#year-year-level').val(button.data('year'));
    });
    $('#school-year-id').datepicker({
        autoclose: true,
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"
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
                    $('#search-body').show();
                }
                if(result.error) {
                    $('#search-result').html(result.error);
                    $('#search-body').show();
                }
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