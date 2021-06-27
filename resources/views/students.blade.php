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
                        <h1 class="m-0">Students</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item">Students</li>
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
                        @if($msg = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>{{$msg}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="card-title">Student List</div>
                                    </div>
                                    <div>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#reg-student"><i class="fa fa-plus"></i> Register Student</button>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#bulk-reg"><i class="fa fa-upload"></i> Bulk Registration</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="student-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Student ID</th>
                                                <th>Year</th>
                                                <th>Reg Date</th>
                                                <th>Status</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $row)
                                            <tr>
                                                <td>{{$row->last_name}}, {{$row->first_name}} {{$row->middle_name}}</td>
                                                <td>{{$row->student_no}}</td>
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
                                                <td>{{$row->created_at->format('F j, Y')}}</td>
                                                <td>{{$row->status}}</td>
                                                <td align="center">
                                                    <div class="btn-group">
                                                        <a href="{{url('/students/student-record/'.$row->id)}}" class="btn btn-primary btn-outline btn-xs"><i class="fa fa-eye"></i> View</a>
                                                        <button class="btn btn-warning btn-outline btn-xs" data-toggle="modal" data-target="#edit-student"
                                                                data-id="{{$row->id}}"
                                                                data-studentno="{{$row->student_no}}"
                                                                data-fname="{{$row->first_name}}"
                                                                data-mname="{{$row->middle_name}}"
                                                                data-lname="{{$row->last_name}}"
                                                                data-gender="{{$row->gender}}"
                                                                data-contactno="{{$row->contact_no}}"
                                                                data-emerg-contact="{{$row->emerg_contact}}"
                                                                data-emerg-contactno="{{$row->emerg_contact_no}}"
                                                                data-bday="{{$row->birthdate}}"
                                                                data-bplace="{{$row->birthplace}}"><i class="fa fa-edit"></i> Edit</button>
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
                    <input type="number" name="studentno" class="form-control">
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
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Facebook Account</label>
                    <input type="text" name="facebook" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="">E-Mail Address</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Contact No.</label>
                    <input type="number" name="contactno" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Emergency Contact Name</label>
                    <input type="text" name="emerg_contact" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="">Emergency Contact No.</label>
                    <input type="number" name="emerg_contactno" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Birth Date</label>
                    <input type="date" name="bday" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Birth Place</label>
                    <input type="text" name="bplace" class="form-control">
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

<div class="modal fade" id="edit-student" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Student</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{url('/students/update-student')}}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit-id">
                <div class="form-group">
                    <label for="">STUDENT ID</label>
                    <input type="number" name="studentno" id="edit-studentno" class="form-control" maxlength="11">
                </div>
                <div class="form-group">
                    <label for="">First Name</label>
                    <input type="text" name="fname" id="edit-fname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Middle Name</label>
                    <input type="text" name="mname" id="edit-mname" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Last Name</label>
                    <input type="text" name="lname" id="edit-lname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Gender</label>
                    <select name="gender" id="edit-gender" class="form-control">
                        <option value="" selected disabled>Choose an option . . .</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Contact No.</label>
                    <input type="number" name="contactno" id="edit-contactno" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Emergency Contact</label>
                    <input type="text" name="emerg" id="edit-emerg" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Emergency Contact No.</label>
                    <input type="number" name="emerg_no" id="edit-emergno" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Birth Date</label>
                    <input type="date" name="bday" id="edit-bday" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Birth Place</label>
                    <input type="text" name="bplace" id="edit-bplace" class="form-control">
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

<div class="modal fade" id="bulk-reg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="display:none;" id="bulk-reg-overlay">
                <div class="overlay d-flex justify-content-center align-items-center">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
            </div>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Bulk Registration</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="bulk-reg-form" action="{{url('/students/bulk-registration')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Upload File</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                            <label class="custom-file-label" for="exampleInputFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">Choose file</label>
                        </div>
                    </div>
                    <small class="form-text text-muted">Only excel file will be accepted. Please make sure that the labels will be 'First Name' and 'Last Name' to make sure it will readable by the system. Make sure that it will be at the 1st row of the file.</small>
                </div>
                <div class="form-group">
                    <label for="">Curriculum Reference</label>
                    <select name="reference" class="form-control" required>
                        @foreach($reference as $row)
                            <option value="{{$row[0]->reference}}">{{$row[0]->reference}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>

@include('includes.script')
<script>
$(document).ready(function() {
    bsCustomFileInput.init();
    $('#student-table').DataTable();
    $('#status').on('change', function() {
        if($(this).is(':checked')) {
            $('#yearlevel').show();
        } else {
            $('#yearlevel').hide();
        }
    });
    $('#reg-student-form').on('submit', function() {
        $('#reg-student-overlay').show();
    });
    $('#bulk-reg-form').on('submit', function() {
        $('#bulk-reg-overlay').show(); 
    });
    $('#edit-student').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        $('#edit-id').val(button.data('id'));
        $('#edit-studentno').val(button.data('studentno'));
        $('#edit-fname').val(button.data('fname'));
        $('#edit-mname').val(button.data('mname'));
        $('#edit-lname').val(button.data('lname'));
        $('#edit-gender').val(button.data('gender'));
        $('#edit-contactno').val(button.data('contactno'));
        $('#edit-emerg').val(button.data('emerg-contact'));
        $('#edit-emergno').val(button.data('emerg-contactno'));
        $('#edit-bday').val(button.data('bday'));
        $('#edit-bplace').val(button.data('bplace'));
    });
})
</script>
</body>
</html>
