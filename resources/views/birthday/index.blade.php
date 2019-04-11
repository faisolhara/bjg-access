@extends('layout.master')

@section('title', 'Birth Day')

@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@yield('title')</h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            @include('layout.alert')
            <!-- end row -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="row">
                            <?php $count = 0; ?>

                            @foreach($datas as $data)
                            <?php 
                            $count++;
                            $date = !empty($data['dt_birthday']) ? new \DateTime($data['dt_birthday']) : null;
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-border panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{ $data['vc_emp_name'] }} ({{ $data['vc_initial_name'] }})</h3>
                                    </div>
                                    <div class="panel-body" style="padding-top:4px; padding-bottom:4px;">
                                        <div class="row">
                                            <span class="label label-info pull-left">
                                                <i class="fa fa-calendar"></i>
                                                Birth Date {{ !empty($date) ? $date->format('d-M-Y') : '' }}
                                            </span>
                                            <div class="clearfix"></div>
                                            <label class="pull-left">
                                                Age <span class="badge up bg-primary">{{  $data['umur'] }}</span> years<br>
                                                Day counter <span class="badge up bg-info">{{  $data['hari'] }}</span> day(s)
                                            </label>
                                            <div class="clearfix"></div>
                                            <label class="pull-left">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->



        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer text-right">
        2017 © DCK.
    </footer>

</div>


<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){

    });
 </script>
@endsection
