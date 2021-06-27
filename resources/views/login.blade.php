<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('assets/login/css/style.css')}}">
    <link href="{{asset('assets/login/images/SPC.png')}}" rel="shortcut icon"/>
	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
                        <center><img src="{{asset('assets/login/images/SPC.png')}}" width="140"; height="130"; ></center>
		      	        <h3 class="text-center mb-4">ACCOUNT LOGIN</h3>
                        @if($msg = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{$msg}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="alert alert-success alert-dismissible fade show" id="register-alert" style="display:none;" role="alert">
                            <strong>Registered Successfully!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{url('/login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="username" class="form-control @if(Session::get('error')) is-invalid @endif" placeholder="Username" required>
                            @if($msg = Session::get('error'))
                                <div class="invalid-feedback">{{$msg}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control @if(Session::get('error')) is-invalid @endif" placeholder="Password" required>
                        </div>
                        <div class="form-group d-flex justify-content-center">
                                <a style="color: #800000;" type="button" data-toggle="modal" data-target="#exampleModal">Register Here !</a>
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary rounded submit p-3 px-5">LOGIN</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Registration</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form id="register-form">
        @csrf
            <div class="container">
                <p>Please fill in this form to create an account.</p>
                <div class="form-group">
                    <input type="text" name="course" id="course-name" class="form-control" oninput="$(this).removeClass('is-invalid')" placeholder="Course" required>
                    <div class="invalid-feedback"><span id="course-name-feedback"></span></div>
                </div>
                <div class="form-group">
                    <input type="text" name="abbreviation" id="course-abb" class="form-control" oninput="$(this).removeClass('is-invalid')" placeholder="Course Abbreviation" required>
                    <div class="invalid-feedback"><span id="course-abb-feedback"></span></div>
                </div>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Name of Department" required>
                </div>
                <div class="form-group">
                    <input type="text" name="dept_head" class="form-control" placeholder="Name of Department Head" required>
                </div>
                <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control" oninput="$(this).removeClass('is-invalid')" placeholder="Username" required>
                    <div class="invalid-feedback"><span id="username-feedback"></span></div>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="repeat_password" placeholder="Confirm Password" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Close</button>
            <button type="submit" id="register-button" class="btn btn-primary rounded">Register</button>
        </div>
        </form>
    </div>
</div>

<script src="{{asset('assets/login/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/login/js/popper.js')}}"></script>
<script src="{{asset('assets/login/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/login/js/main.js')}}"></script>
<script>
$(document).ready(function() {
    if(localStorage.getItem("success")) {
        $('#register-alert').show();
        localStorage.clear();
    }
    $('input').on('input', function(){
        $(this).removeClass('is-invalid');
    });
    $('#register-form').on('submit', function(event) {
        event.preventDefault();
        $('#register-button').prop('disabled', true);

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{url('/register')}}",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                if(result.course) {
                    $('#course-name').addClass('is-invalid');
                    $('#course-name-feedback').html(result.course);
                    $('#course-abb').addClass('is-invalid');
                    $('#course-abb-feedback').html(result.course);
                }
                if(result.username) {
                    $('#username').addClass('is-invalid');
                    $('#username-feedback').html(result.username);
                }
                if(result.success) {
                    localStorage.setItem("success", result.success);
                    window.location = result.success;
                }
            },
            complete: function() {
                $('#register-button').prop('disabled', false);   
            },
            error: function(error) {
                console.log(error);
            }
        })
    })
})
</script>
<script>
$(document).ready(function() {
    var password = document.getElementById('password');
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

