<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS - Laravel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ url('bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ url('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ url('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('bower_components/datatables.net-bs/css/responsive.bootstrap.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('bower_components/iCheck/all.css') }}">
  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <!-- jQuery 3 -->
      <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="{{ url('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

      <!-- InputMask -->
      <script src="{{ url('bower_components/input-mask/jquery.inputmask.js') }}"></script>
      <script src="{{ url('bower_components/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
      <script src="{{ url('bower_components/input-mask/jquery.inputmask.extensions.js') }}"></script>

  </head>
  <body class="hold-transition skin-blue sidebar-mini login-page">

    @if (Auth::user())
    <div class="content-wrapeer">

      @include('modules.users.header')
      
      @include('modules.users.menu')

      @yield('content')
    </div>
    @else
      @yield('login')
    @endif


    <!-- Content Wrapper. Contains page content -->
    {{-- <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
              <!-- Tabs within a box -->
              <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
                <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
              </ul>
              <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
              </div>
            </div>
            <!-- /.nav-tabs-custom -->

            <!-- Chat box -->
            <div class="box box-success">
              <div class="box-header">
                <i class="fa fa-comments-o"></i>

                <h3 class="box-title">Chat</h3>

                <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                  <div class="btn-group" data-toggle="btn-toggle">
                    <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                  </div>
                </div>
              </div>
              <div class="box-body chat" id="chat-box">
                <!-- chat item -->
                <div class="item">
                  <img src="dist/img/user4-128x128.jpg" alt="user image" class="online">

                  <p class="message">
                    <a href="#" class="name">
                      <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                      Mike Doe
                    </a>
                    I would like to meet you to discuss the latest news about
                    the arrival of the new theme. They say it is going to be one the
                    best themes on the market
                  </p>
                  <div class="attachment">
                    <h4>Attachments:</h4>

                    <p class="filename">
                      Theme-thumbnail-image.jpg
                    </p>

                    <div class="pull-right">
                      <button type="button" class="btn btn-primary btn-sm btn-flat">Open</button>
                    </div>
                  </div>
                  <!-- /.attachment -->
                </div>
                <!-- /.item -->
                <!-- chat item -->
                <div class="item">
                  <img src="dist/img/user3-128x128.jpg" alt="user image" class="offline">

                  <p class="message">
                    <a href="#" class="name">
                      <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>
                      Alexander Pierce
                    </a>
                    I would like to meet you to discuss the latest news about
                    the arrival of the new theme. They say it is going to be one the
                    best themes on the market
                  </p>
                </div>
                <!-- /.item -->
                <!-- chat item -->
                <div class="item">
                  <img src="dist/img/user2-160x160.jpg" alt="user image" class="offline">

                  <p class="message">
                    <a href="#" class="name">
                      <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                      Susan Doe
                    </a>
                    I would like to meet you to discuss the latest news about
                    the arrival of the new theme. They say it is going to be one the
                    best themes on the market
                  </p>
                </div>
                <!-- /.item -->
              </div>
              <!-- /.chat -->
              <div class="box-footer">
                <div class="input-group">
                  <input class="form-control" placeholder="Type message...">

                  <div class="input-group-btn">
                    <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box (chat box) -->

            <!-- TO DO List -->
            <div class="box box-primary">
              <div class="box-header">
                <i class="ion ion-clipboard"></i>

                <h3 class="box-title">To Do List</h3>

                <div class="box-tools pull-right">
                  <ul class="pagination pagination-sm inline">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="todo-list">
                  <li>
                    <!-- drag handle -->
                    <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                    <!-- checkbox -->
                    <input type="checkbox" value="">
                    <!-- todo text -->
                    <span class="text">Design a nice theme</span>
                    <!-- Emphasis label -->
                    <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <i class="fa fa-edit"></i>
                      <i class="fa fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                    <input type="checkbox" value="">
                    <span class="text">Make the theme responsive</span>
                    <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                    <div class="tools">
                      <i class="fa fa-edit"></i>
                      <i class="fa fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                    <input type="checkbox" value="">
                    <span class="text">Let theme shine like a star</span>
                    <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                    <div class="tools">
                      <i class="fa fa-edit"></i>
                      <i class="fa fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                    <input type="checkbox" value="">
                    <span class="text">Let theme shine like a star</span>
                    <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                    <div class="tools">
                      <i class="fa fa-edit"></i>
                      <i class="fa fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                    <input type="checkbox" value="">
                    <span class="text">Check your messages and notifications</span>
                    <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                    <div class="tools">
                      <i class="fa fa-edit"></i>
                      <i class="fa fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                    <input type="checkbox" value="">
                    <span class="text">Let theme shine like a star</span>
                    <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                    <div class="tools">
                      <i class="fa fa-edit"></i>
                      <i class="fa fa-trash-o"></i>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix no-border">
                <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
              </div>
            </div>
            <!-- /.box -->

            <!-- quick email widget -->
            <div class="box box-info">
              <div class="box-header">
                <i class="fa fa-envelope"></i>

                <h3 class="box-title">Quick Email</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                          title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
                <!-- /. tools -->
              </div>
              <div class="box-body">
                <form action="#" method="post">
                  <div class="form-group">
                    <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="subject" placeholder="Subject">
                  </div>
                  <div>
                    <textarea class="textarea" placeholder="Message"
                              style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  </div>
                </form>
              </div>
              <div class="box-footer clearfix">
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                  <i class="fa fa-arrow-circle-right"></i></button>
              </div>
            </div>

          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map box -->
            <div class="box box-solid bg-light-blue-gradient">
              <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"
                          title="Date range">
                    <i class="fa fa-calendar"></i></button>
                  <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                          data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                    <i class="fa fa-minus"></i></button>
                </div>
                <!-- /. tools -->

                <i class="fa fa-map-marker"></i>

                <h3 class="box-title">
                  Visitors
                </h3>
              </div>
              <div class="box-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.box-body-->
              <div class="box-footer no-border">
                <div class="row">
                  <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <div id="sparkline-1"></div>
                    <div class="knob-label">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <div id="sparkline-2"></div>
                    <div class="knob-label">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-xs-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="knob-label">Exists</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.box -->

            <!-- solid sales graph -->
            <div class="box box-solid bg-teal-gradient">
              <div class="box-header">
                <i class="fa fa-th"></i>

                <h3 class="box-title">Sales Graph</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="box-body border-radius-none">
                <div class="chart" id="line-chart" style="height: 250px;"></div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer no-border">
                <div class="row">
                  <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                    <div class="knob-label">Mail-Orders</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                    <div class="knob-label">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-xs-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                    <div class="knob-label">In-Store</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->

            <!-- Calendar -->
            <div class="box box-solid bg-green-gradient">
              <div class="box-header">
                <i class="fa fa-calendar"></i>

                <h3 class="box-title">Calendar</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bars"></i></button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="#">Add new event</a></li>
                      <li><a href="#">Clear events</a></li>
                      <li class="divider"></li>
                      <li><a href="#">View calendar</a></li>
                    </ul>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-black">
                <div class="row">
                  <div class="col-sm-6">
                    <!-- Progress bars -->
                    <div class="clearfix">
                      <span class="pull-left">Task #1</span>
                      <small class="pull-right">90%</small>
                    </div>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 90%;"></div>
                    </div>

                    <div class="clearfix">
                      <span class="pull-left">Task #2</span>
                      <small class="pull-right">70%</small>
                    </div>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 70%;"></div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                    <div class="clearfix">
                      <span class="pull-left">Task #3</span>
                      <small class="pull-right">60%</small>
                    </div>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 60%;"></div>
                    </div>

                    <div class="clearfix">
                      <span class="pull-left">Task #4</span>
                      <small class="pull-right">40%</small>
                    </div>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 40%;"></div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.box -->

          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->

      </section>
      <!-- /.content -->
    </div> --}}
    <!-- /.content-wrapper -->
    {{-- <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
      </div>
      <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
      reserved.
    </footer> --}}

    <!-- Control Sidebar -->
    {{-- <aside class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading">Recent Activity</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                  <p>Will be 23 on April 24th</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-user bg-yellow"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                  <p>New phone +1(800)555-1234</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                  <p>nora@example.com</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-file-code-o bg-green"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                  <p>Execution time 5 seconds</p>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

          <h3 class="control-sidebar-heading">Tasks Progress</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Custom Template Design
                  <span class="label label-danger pull-right">70%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Update Resume
                  <span class="label label-success pull-right">95%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Laravel Integration
                  <span class="label label-warning pull-right">50%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Back End Framework
                  <span class="label label-primary pull-right">68%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">General Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Report panel usage
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Some information about this general settings option
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Allow mail redirect
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Other sets of options are available
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Expose author name in posts
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Allow the user to show his name in blog posts
              </p>
            </div>
            <!-- /.form-group -->

            <h3 class="control-sidebar-heading">Chat Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Show me as online
                <input type="checkbox" class="pull-right" checked>
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Turn off notifications
                <input type="checkbox" class="pull-right">
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Delete chat history
                <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
              </label>
            </div>
            <!-- /.form-group -->
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
    </aside> --}}
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
    {{-- <div class="control-sidebar-bg"></div> --}}
    {{-- </div> --}}
    <!-- ./wrapper -->

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Morris.js charts -->
    <script src="{{ url('bower_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ url('bower_components/morris.js/morris.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ url('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ url('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('dist/js/demo.js') }}"></script>

    <!-- DaTables -->
    <script src="{{ url('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ url('bower_components/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <!-- iCheck -->
     <script src="{{ url('bower_components/iCheck/icheck.min.js') }}"></script>
    
    <script src="{{ url('js/plantilla.js') }}"></script>
    <script src="{{ url('js/users.js') }}"></script>
    <script src="{{ url('js/products.js') }}"></script>
    <script src="{{ url('js/clients.js') }}"></script>
    <script src="{{ url('js/sales.js') }}"></script>

    @if (session('success'))
      <script type="text/javascript">
        Swal.fire({
          title: "{{ session('success') }}",
          text: "",
          icon: "success",
          confirmButtonText: 'Aceptar'
        });
      </script>
    @endif
  </body>
</html>
