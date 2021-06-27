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
    <style>
        .note{margin-top: -10px; margin-left:50px;}
        .note1{margin-top: 10px; margin-left:80px;}
        .note2{margin-top: 10px; margin-left: 78px;}
        .note3{margin-top: 10px; margin-left: 78px;}
        .approved{margin-top: -45px; margin-left: 700px;}
        .registrar{margin-top: -5px; margin-left: 820px;}
        .spc{margin-top: 30px;}
        .approved1{margin-right:70px;}       
        .registrar1{margin-right: 120px;}  
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

<div class="wrapper">
    @include('includes.navigation')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 style="text-align:center;">Southern Philippines College</h3>
                        <h5 class="address" style="text-align:center;">Julio Pacana St. Licuan</h5>
                        <h5 class="address1" style="text-align:center;">Cagayan de Oro City</h5>
                        <h6 class="address2" style="text-align:center;">SPC-ACA-001</h6>
                        <h5 class="address3" style="text-align:left;"><b><i><u>ENROLLMENT FORM - COLLEGE</u></i></b></h5>
                        <h6 class="address4" style="text-align:left;"><b><i>Registrar's Copy</b></i></h6>
                        <dl class="row pt-4">
                            <dd class="col-sm-1">Name</dd>
                            <dt class="col-sm-4" style="border-bottom:1px solid black">{{$student->last_name}}</dt>
                            <dt class="col-sm-5" style="border-bottom:1px solid black">{{$student->first_name}}</dt>
                            <dt class="col-sm-2" style="border-bottom:1px solid black">{{$student->middle_name}}</dt>
                        </dl>
                        <dl class="row" style="margin-top:-15px">
                            <dd class="col-sm-1"></dd>
                            <dd class="col-sm-4">(Last Name)</dd>
                            <dd class="col-sm-5">(First Name)</dd>
                            <dd class="col-sm-2">(Middle Name)</dd>
                        </dl>
                        <dl class="row">
                            <dd class="col-sm-2">Birth Place</dd>
                            <dt class="col-sm-3" style="border-bottom:1px solid black">{{$student->birthplace}}</dt>
                            <dd class="col-sm-1">Birth Date</dd>
                            <dt class="col-sm-2" style="border-bottom:1px solid black">{{$student->birthdate}}</dt>
                            <dd class="col-sm-2 text-right">Course & Yr.</dd>
                            <dt class="col-sm-2" style="border-bottom:1px solid black">{{$student->getCourse->abbreviation}} {{$student->year_level}}</dt>
                        </dl>
                        <dl class="row">
                            <dd class="col-sm-1">Address</dd>
                            <dt class="col-sm-7" style="border-bottom:1px solid black">{{$student->address}}</dt>
                            <dd class="col-sm-2 text-right">Semester</dd>
                            <dt class="col-sm-2" style="border-bottom:1px solid black">
                                @if($evalinfo->semester == 1)
                                    1st Semester
                                @elseif($evalinfo->semester == 2)
                                    2nd Semester
                                @else
                                    Summer
                                @endif
                            </dt>
                        </dl>
                        <dl class="row">
                            <dd class="col-sm-2">Contact Number</dd>
                            <dt class="col-sm-6" style="border-bottom:1px solid black">{{$student->contact_no}}</dt>
                            <dd class="col-sm-2 text-right">School Year</dd>
                            <dt class="col-sm-2" style="border-bottom:1px solid black">{{$evalinfo->school_year_from}} - {{$evalinfo->school_year_to}}</dt>
                        </dl>
                        <dl class="row">
                            <dd class="col-sm-3">Faceboook Messenger Account</dd>
                            <dt class="col-sm-5" style="border-bottom:1px solid black">{{$student->facebook_account}}</dt>
                            <dd class="col-sm-1">Email Ad</dd>
                            <dt class="col-sm-3" style="border-bottom:1px solid black">{{$student->email}}</dt>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-1"></dt>
                            <dt class="col-sm-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" @if($student->status == "NEW") checked @else disabled @endif >
                                    <label class="custom-control-label">New Student</label>
                                </div>
                            </dt>
                            <dt class="col-sm-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" @if($student->status == "TRANSFEREE") checked @else disabled @endif>
                                    <label class="custom-control-label">Transferee Student</label>
                                </div>
                            </dt>
                            <dt class="col-sm-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" @if($student->status == "OLD") checked @else disabled @endif>
                                    <label class="custom-control-label">Old Student</label>
                                </div>
                            </dt>
                            <dt class="col-sm-2"></dt>
                            <dt class="col-sm-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" @if($student->gender == "Male") checked @else disabled @endif>
                                    <label class="custom-control-label">Male</label>
                                </div>
                            </dt>
                            <dt class="col-sm-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" @if($student->gender == "Female") checked @else disabled @endif>
                                    <label class="custom-control-label">Female</label>
                                </div>
                            </dt>
                            <dt class="col-sm-1"></dt>
                        </dl>
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="10%">DCODE</th>
                                        <th width="10%">SECCODE</th>
                                        <th width="35%">DESCRIPTIVE TITLE</th>
                                        <th width="5%">UNITS</th>
                                        <th width="10%">TIME</th>
                                        <th width="10%">DAY</th>
                                        <th width="10%">ROOM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eval as $row)
                                    <tr>
                                        <td>{{$row->getRecord->getCurriculum->getSubject->course_code}}</td>
                                        <td></td>
                                        <td>{{$row->getRecord->getCurriculum->getSubject->title}}</td>
                                        <td>{{$row->getRecord->getCurriculum->getSubject->units}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h6 class="note" style="text-align:left;"><i>Note: INC must be completed within one (1) year and cannot</i></h6>
                        <h6 class="note1" style="text-align:left;"><i>be enrolled simultaneously with another subject if the</i></h6>
                        <h6 class="note2" style="text-align:left;"><i>INC subject is a pre-requisite subject. After 1 year, INC</i></h6>
                        <h6 class="note3" style="text-align:left;"><i>subject must be re-enrolled.</i></h6>
                        <h6 class="approved" style="text-align:left;">Approved by:________________________</h6>
                        <h6 class="registrar" style="text-align:left;"><b><i>Registrar</i></b></h6>
                        <hr class="separator">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <h5 class="spc" style="text-align:center;"><b>Southern Philippines College</b></h5>
                                <h6 class="julio" style="text-align:center;">Julio Pacana St., Licuan, Cagayan de Oro City</h6>
                                <h5 class="address3 pt-4" style="text-align:left;"><b><i><u>ENROLLMENT FORM - COLLEGE</u></i></b></h5>
                                <h6 class="note" style="text-align:left;"><i><b>Student's Copy.</b></i></h6>
                                <dl class="row pt-2">
                                    <dd class="col-sm-1">NAME</dd>
                                    <dt class="col-sm-4" style="border-bottom:1px solid black">{{$student->last_name}}</dt>
                                    <dt class="col-sm-5" style="border-bottom:1px solid black">{{$student->first_name}}</dt>
                                    <dt class="col-sm-2" style="border-bottom:1px solid black">{{$student->middle_name}}</dt>
                                </dl>
                                <dl class="row" style="margin-top:-15px">
                                    <dd class="col-sm-1"></dd>
                                    <dd class="col-sm-4">(Last Name)</dd>
                                    <dd class="col-sm-5">(First Name)</dd>
                                    <dd class="col-sm-2">(Middle Name)</dd>
                                </dl>
                                <dl class="row">
                                    <dd class="col-sm-2">Course</dd>
                                    <dt class="col-sm-10" style="border-bottom:1px solid black">{{$student->getCourse->name}}</dt>
                                </dl>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DCODE</th>
                                            <th>SECCODE</th>
                                            <th>UNITS</th>
                                            <th>TIME</th>
                                            <th>DAY</th>
                                            <th>ROOM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($eval as $row)
                                        <tr>
                                            <td>{{$row->getRecord->getCurriculum->getSubject->course_code}}</td>
                                            <td></td>
                                            <td>{{$row->getRecord->getCurriculum->getSubject->units}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <h6><i>I certify that I verified and evaluated the record of the said student and that he/she has no</i></h6>
                                    <h6><i>back subjects in his/her preceding year. If he/she has back subjects, the same are included in</i></h6>
                                    <h6><i>this enrollment</i></h6>
                                </div>
                            </div>
                        </div>
                        <h6 class="note6" style="text-align:left;padding-top:20px"><i><b>Note:</b>INC must be completed within one (1) year & cannot</i></h6>
                        <h6 class="" style="text-align:left;"><i>be enrolled simultaneously with another subject if the</i></h6>
                        <h6 class="" style="text-align:left;"><i>INC subjects is a pre-requisite subject. After 1 year, INC</i></h6>
                        <h6 class="" style="text-align:left;"><i>subject must be re-enrolled.</i></h6>
                        <h6 class="approved1" style="text-align:right;">Approved by:______________________</h6>
                        <h6 class="registrar1" style="text-align:right;"><i><b>Registrar</b></i></h6>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <a href="{{url('/print/evaluation/'.$student->id.'/'.$evalinfo->evaluation_no)}}" target="_blank" class="btn btn-default btn-lg"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
</div>

@include('includes.script')
</body>
</html>
