<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="developer_name" content="Faisol Andi Sefihara"/>
        <meta name="developer_website" content="faisolhara.com"/>
        <meta name="developer_email" content="sfaisolandi@gmail.com"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- App title -->
        <title>BJG Access - @yield('title')</title>

        <!-- Table Responsive css -->
        <link href="{{ asset('plugins/responsive-table/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">

        <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

        <!-- Notification css (Toastr) -->
        <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Nestable css -->
        <link href="{{ asset('plugins/nestable/jquery.nestable.css') }}" rel="stylesheet" />

        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('plugins/switchery/switchery.min.css') }}">
        <style type="text/css">
            hr{
                margin-top: 2px !important;
                margin-bottom: 2px !important;
            }
            .topbar .topbar-left {
                background: #f4f3f3;
            }
            .navbar-default {
                background-color: #af3232;
            }
            .button-menu-mobile {
                color: #f3f3f3;
            }
            .card-box {
                padding: 1px;
            }

            .panel-heading {
                padding: 10px;
            }
            
            .panel {
                margin-bottom: 5px;
            }

            .widget-box-two .widget-two-icon {
                bottom: 72px;
                height: 60px;
                width: 60px;
                line-height: 60px;
            }

            .vertical-center{
                vertical-align: middle !important;
            }

            .panel-border .panel-heading {
            padding: 15px 10px 0;
            }
        </style>

        @section('css')
    
        @show

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="{{ url('/home') }}" class="logo"><i><img src="{{ asset('images/logo.png') }}" alt="" height="50"></i></a>
                    <!-- Image logo -->
                    <a href="{{ url('/home') }}" class="logo">
                        <span>
                            <img src="{{ asset('images/logo.png') }}" alt="" height="50">
                        </span>
                    </a>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <!-- Left navbar -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                        </ul>

                        <!-- Right(Notification) -->
                        <ul class="nav navbar-nav navbar-right">
                        
                            <li>
                                <h5 style="float: center; color:white; margin-top:27px;">{{ \Session::get('user')['full_name'] }}</h5>
                            </li>

                            <li class="dropdown user-box">
                                <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                    <img src="{{ asset('images/male.png') }}" alt="user-img" class="img-circle user-img">
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Settings</a></li>
                                    <li><a href="{{ url('/logout') }}"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                </ul>
                            </li>

                        </ul> <!-- end navbar-right -->

                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Navigation</li>
                            <li>
                                <a href="{{ url('/home') }}" class="waves-effect"><i class="mdi mdi-home"></i><span> Home </span></a>
                            </li>
                            @foreach($navigationOneLevel as $navigation)
                            <li>
                                <a href="{{ url($navigation['route']) }}" class="waves-effect"><i class="{{ $navigation['icon'] }}"></i><span> {{ $navigation['label'] }} </span></a>
                            </li>
                            @endforeach
                            @foreach($navigationTwoLevel as $navigations)
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="{{ $navigations['icon'] }}"></i><span class="menu-arrow"></span> <span> {{ $navigations['label'] }} </span> </a>
                                <ul class="list-unstyled">
                                @foreach($navigations['children'] as $navigation)
                                    <li><a href="{{ url($navigation['route']) }}">{{ $navigation['label'] }}</a></li>
                                @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                    <div class="help-box">
                        <h5 class="text-muted m-t-0">For Help ?</h5>
                        <p class=""><span class="text-custom">Email:</span> <br/> se.care@dckconsulting.com</p>
                        <p class="m-b-0"><span class="text-custom">Call:</span> <br/> 1504</p>
                    </div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            
            @yield('content')

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="mdi mdi-close-circle-outline"></i>
                </a>
                <h4 class="">Settings</h4>
                <div class="setting-list nicescroll">
                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Notifications</h5>
                            <p class="text-muted m-b-0"><small>Do you need them?</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">API Access</h5>
                            <p class="m-b-0 text-muted"><small>Enable/Disable access</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Auto Updates</h5>
                            <p class="m-b-0 text-muted"><small>Keep up to date</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-xs-8">
                            <h5 class="m-0">Online Status</h5>
                            <p class="m-b-0 text-muted"><small>Show your status to all</small></p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <input type="checkbox" checked data-plugin="switchery" data-color="#7fc1fc" data-size="small"/>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/detect.js') }}"></script>
        <script src="{{ asset('assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
        <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>

        <!-- Toastr js -->
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
        <!-- Toastr init js (Demo)-->
        <script src="{{ asset('assets/pages/jquery.toastr.js') }}"></script>

        <!-- responsive-table-->
        <script src="{{ asset('plugins/responsive-table/js/rwd-table.min.js') }}" type="text/javascript"></script>

        <!-- jQuery  -->
        <script src="{{ asset('plugins/waypoints/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>

        <!--script for this page only-->
        <script src="{{ asset('plugins/nestable/jquery.nestable.js') }}"></script>
        <script src="{{ asset('assets/pages/jquery.nestable.init.js') }}"></script>

        <!-- jQuery  -->

        <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>


        <script src="{{ asset('plugins/moment/moment.js') }}"></script>

        <!-- Todojs  -->
        <script src="{{ asset('assets/pages/jquery.todo.js') }}"></script>

        <!-- chatjs  -->
        <script src="{{ asset('assets/pages/jquery.chat.js') }}"></script>


        <!-- App js -->
        <script src="{{ asset('assets/js/jquery.core.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.app.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                if('{{Session::has("successMessage") }}'){
                    Command: toastr["success"]('{{ Session::get("successMessage") }}');
                }
                if('{{Session::has("errorMessage") }}'){
                    Command: toastr["error"]('{{ Session::get("errorMessage") }}')
                }
            });
         </script>

        @section('script')

        @show

        @section('modal')
            <div id="modal-alert" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center text-danger">
                                <span class="icon-attention-1" aria-hidden="true"></span>
                                <span id="title-modal-line-unit">Alert !</span>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="alert-message">Alert Message</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @show
    </body>
</html>