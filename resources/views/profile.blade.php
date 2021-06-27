@if(Auth::guard('department')->check())

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Profile</title>
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
                        <h1 class="m-0">Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Profile</li>
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
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#course" class="nav-link active" data-toggle="tab">Department Information</a></li>
                                    <li class="nav-item"><a href="#account" class="nav-link" data-toggle="tab">Account Information</a></li>
                                    <li class="nav-item"><a href="#password" class="nav-link" data-toggle="tab">Change Password</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="course">
                                        <form action="{{url('/profile/department-information')}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Course Name</label>
                                                <input type="text" name="course" class="form-control" value="{{Auth::guard('department')->user()->getCourse->name}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Course Abbreviation</label>
                                                <input type="text" name="abbreviation" class="form-control" value="{{Auth::guard('department')->user()->getCourse->abbreviation}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Department Name</label>
                                                <input type="text" name="name" class="form-control" value="{{Auth::guard('department')->user()->name}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Department Head</label>
                                                <input type="text" name="dept_head" class="form-control" value="{{Auth::guard('department')->user()->dept_head}}" required>
                                            </div>
                                            <div class="text-right" style="margin-top:20px">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update Information</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="account">
                                        <form action="{{url('/profile/account-information')}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" name="username" class="form-control" value="{{Auth::guard('department')->user()->username}}" required>
                                            </div>
                                            <div class="text-right" style="margin-top:20px">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Change Username</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="password">
                                        <form action="{{url('/profile/change-password')}}" method="POST">
                                        @csrf
                                            <div class="form-group">
                                                <label for="">Current Password</label>
                                                <input type="password" name="current_password" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">New Password</label>
                                                <input type="password" name="new_password" class="form-control" id="new_password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Repeat New Password</label>
                                                <input type="password" name="repeat_password" class="form-control" id="repeat_password" required>
                                            </div>
                                            <div class="text-right" style="margin-top:20px">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Change Password</button>
                                            </div>
                                        </form>
                                    </div>
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
    var password = document.getElementById('new_password');
    var password_repeat = document.getElementById('repeat_password');

    function validatePassword(){
        if(password.value != password_repeat.value) {
            password_repeat.setCustomValidity("Passwords Don't Match");
        } else {
            password_repeat.setCustomValidity('');
        }
    }
    password.onchange = validatePassword;
    password_repeat.onkeyup = validatePassword;
})
</script>
</body>
</html>

@else
    @include('includes.419')
@endif