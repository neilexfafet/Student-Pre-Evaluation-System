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
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

<div class="wrapper">
    @include('includes.navigation')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Students</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item">Students</li>
                            <li class="breadcrumb-item active">Evaluate Students</li>
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
                                    <div class="d-flex justify-content-between">
                                        <div class="card-title">Student List</div>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#reg-student"><i class="fa fa-plus"></i> Register Student</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-hover" id="students-table">
                                        <thead>
                                            <tr>
                                                <th>Reg Date</th>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th>Year</th>
                                                <th>Gender</th>
                                                <th>Status</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $row)
                                            <tr>   
                                                <td>{{$row->created_at}}</td>
                                                <td>{{$row->student_no}}</td>
                                                <td>{{$row->last_name}}, {{$row->first_name}} {{$row->middle_name}}</td>
                                                <td>
                                                    @if($row->year_level == 1)
                                                        1st Year
                                                    @elseif($row->year_level == 2)
                                                        2nd Year
                                                    @elseif($row->year_level == 3)
                                                        3rd Year
                                                    @elseif($row->year_level == 4)
                                                        4th Year
                                                    @endif
                                                </td>
                                                <td>{{$row->gender}}</td>
                                                <td>{{$row->status}}</td>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <a href="{{url('/evaluation/student-record/'.$row->id)}}" class="btn btn-warning btn-outline btn-xs"><i class="fa fa-edit"></i> Evaluate</a>
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

<div class="modal fade" id="reg-student" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div style="display:none;" id="reg-student-overlay">
                <div class="overlay d-flex justify-content-center align-items-center">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
            </div>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Register Student</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/students/register-student')}}" id="reg-student-form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">STUDENT ID</label>
                    <input type="number" name="studentno" class="form-control" max="99999999999" required>
                </div>
                <div class="form-group">
                    <label for="">First Name</label>
                    <input type="text" name="fname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Middle Name</label>
                    <input type="text" name="mname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Last Name</label>
                    <input type="text" name="lname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="" selected disabled>Choose an option . . .</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Facebook Account</label>
                    <input type="text" name="facebook" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">E-Mail Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Contact No.</label>
                    <input type="number" name="contactno" class="form-control" max="99999999999" required>
                </div>
                <div class="form-group">
                    <label for="">Emergency Contact Name</label>
                    <input type="text" name="emerg_contact" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Emergency Contact No.</label>
                    <input type="number" name="emerg_contactno" class="form-control" max="99999999999" required>
                </div>
                <div class="form-group">
                    <label for="">Birth Date</label>
                    <input type="date" name="bday" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Birth Place</label>
                    <input type="text" name="bplace" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="NEW" selected>New Student</option>
                        <option value="TRANSFEREE">Transferee Student</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Curriculum Reference</label>
                    <select name="reference" class="form-control" required>
                        @foreach($reference as $row)
                            <option value="{{$row[0]->reference}}">{{$row[0]->reference}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox" name="status"> <strong>Transferee</strong></label>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="reg-student-submit" class="btn btn-primary">Register Student</button>
            </div>
            </form>
        </div>
    </div>
</div>

@include('includes.script')
<script>
$(document).ready(function() {
    $('#students-table').DataTable({
        responsive: true,
        order: [[0, 'desc']],
    });
    $('#reg-student-form').on('submit', function() {
        $('#reg-student-overlay').show();
    });
})
</script>
</body>
</html>
