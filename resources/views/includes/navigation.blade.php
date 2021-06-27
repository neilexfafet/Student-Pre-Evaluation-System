<!-- HEADER -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="javascript:void(0);" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <h4><a href="javascript:void(0);" class="nav-link" data-toggle="modal" data-target="#set-school-year">S.Y.&nbsp;&nbsp;&nbsp;<strong>{{Auth::guard('department')->user()->school_year_from}} - {{Auth::guard('department')->user()->school_year_to}}</strong></a></h4>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user user-menu">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{asset('assets/login/images/SPC.png')}}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="hidden-xs">{{Auth::guard('department')->user()->name}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- User image -->
                <li class="user-header" style="background-color: rgba(90,8,8,0.8)">
                    <img src="{{asset('assets/login/images/SPC.png')}}" class="img-circle" alt="User Image">
                    <p style="color: #ffffff">{{Auth::guard('department')->user()->getCourse->name}}</p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                    <div class="col-6 text-center">
                        <a href="{{url('profile')}}"><i class="fas fa-user"></i> Profile</a>
                    </div>
                    <div class="col-6 text-center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.HEADER -->

<!-- SIDEBAR -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:void(0);" class="brand-link">
        <img src="{{asset('assets/login/images/SPC.png')}}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{Auth::guard('department')->user()->getCourse->abbreviation}}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-2 mb-2 d-flex justify-content-center">
            <!-- <div class="image">
                <img src="{{asset('assets/login/images/SPC.png')}}" class="img-circle elevation-2" alt="User Image">
            </div> -->
            <div class="info">
                <a href="javascript:void(0);" class="d-block" data-toggle="modal" data-target="#set-semester">
                    <h4 data-toggle="popover" data-placement="top" data-content="Set Semester for Evaluations">
                    @if(Auth::guard('department')->user()->set_semester == 1)
                        1st Semester
                    @elseif(Auth::guard('department')->user()->set_semester == 2)
                        2nd Semester
                    @else
                        SUMMER
                    @endif
                    </h4>
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('dashboard')}}" class="nav-link @if(Request::is('dashboard')) active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('curriculum')}}" class="nav-link @if(Request::is('curriculum')) active @endif">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>Curriculum</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="{{url('evaluation')}}" class="nav-link @if(Request::is('evaluation')) active @endif">
                        <i class="nav-icon fa fa-columns fa-fw"></i> <p>Evaluate Students</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="{{url('students')}}" class="nav-link @if(Request::is('students')) active @endif">
                        <i class="nav-icon fa fa-users fa-fw"></i> <p>Students</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('reports')}}" class="nav-link @if(Request::is('reports')) active @endif">
                        <i class="nav-icon fa fa-tasks fa-fw"></i> <p>Evaluation Reports</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>
<!-- SIDEBAR -->

<!-- SET SEMESTER -->
<div class="modal fade" id="set-semester" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <span class="modal-title">Set Semester</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/set-semester') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="1">1st Semester</option>
                    <option value="2">2nd Semester</option>
                    <option value="3">SUMMER</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- END SET SEMESTER -->

<!-- SET SCHOOL YEAR -->
<div class="modal fade" id="set-school-year" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <span class="modal-title">Update School Year</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/set-school-year') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="">School Year Start:</label>
                <input type="text" name="year" id="set-school-year-start" class="form-control" value="{{Auth::guard('department')->user()->school_year_from}}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- END SET SCHOOL YEAR -->

<!-- LOGOUT MODAL -->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <span class="modal-title">Logout</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <span class="text-dark font-size-15">Are you sure you want to Logout?</span>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Logout</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- END LOGOUT MODAL -->
