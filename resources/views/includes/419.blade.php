<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blank</title>
    @include('includes.link')
</head>
<body>

<div class="error-page pt-5">
    <h2 class="headline text-danger"> 419</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page expired.</h3>
        <p>
            Page already expired. You may <a href="{{url('/')}}">return to login page</a>.
        </p>
    </div>
</div>

@include('includes.script')
</body>
</html>
