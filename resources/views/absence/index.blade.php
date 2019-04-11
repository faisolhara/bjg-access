@extends('layout.master')

@section('title', 'Absence')

@section('css')
<style type="text/css">
    #table-notification tbody tr{
        cursor: pointer;
    }
    .span-date{
        cursor: pointer;
    }
</style>
@endsection

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
                    <!-- <div class="card-box"> -->
                        <div class="row">
                            <form class="form-horizontal" role="form" action="{{ url('/absence') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Start Date</label>
                                    <div class="col-xs-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-date" name="startDate" id="startDate" placeholder="dd-mm-yyyy" value="{{ !empty($filters['startDate']) ? $filters['startDate'] : '' }}" readonly>
                                            <span class="input-group-addon span-date bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">End Date</label>
                                    <div class="col-xs-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-date" name="endDate" id="endDate" placeholder="dd-mm-yyyy" value="{{ !empty($filters['endDate']) ? $filters['endDate'] : '' }}" readonly>
                                            <span class="input-group-addon span-date bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-purple waves-effect waves-light" style="margin-left: 20px;">Search</button>
                            </form>
                        </div>
                        <br>
                        <div class="row">
                            <?php $count = 0; ?>

                            @foreach($datas as $data)
                            <?php 
                            $count++;
                            $date = !empty($data['dt_joind_date']) ? new \DateTime($data['dt_joind_date']) : null;
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-border panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{ $data['vc_emp_name'] }} ({{ $data['vc_initial_name'] }})</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <span class="label label-info pull-left">
                                                <i class="fa fa-calendar"></i>
                                                Join Date {{ !empty($date) ? $date->format('d-M-Y') : '' }}
                                            </span>
                                            <div class="clearfix"></div>
                                            <div class="col-xs-6">
                                                <a href="{{ url('absence/detail/'.'?category=T&empCode='.$data['vc_emp_code'].'&startDate='.$filters['startDate'].'&endDate='.$filters['endDate']) }}">
                                                    <h5><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i> Late <span class="badge up bg-danger" title="Total Case">{{ $data['terlambat'] }}</span></h5>
                                                        
                                                    </a>
                                                <a href="{{ url('absence/detail/'.'?category=PA&empCode='.$data['vc_emp_code'].'&startDate='.$filters['startDate'].'&endDate='.$filters['endDate']) }}">
                                                    <h5><i class="mdi mdi-walk" style="margin-right:10px;"></i> Home Early <span class="badge up bg-info" title="Total Case">{{ $data['pulang_awal'] }}</span></h5>
                                                </a>
                                            </div>
                                            <div class="col-xs-6">
                                                <a href="{{ url('absence/detail/'.'?category=IJIN&empCode='.$data['vc_emp_code'].'&startDate='.$filters['startDate'].'&endDate='.$filters['endDate']) }}">
                                                    <h5><i class="mdi mdi-car" style="margin-right:10px;"></i> Leave <span class="badge up bg-primary" title="Total Case">{{ $data['ijin'] }}</span></h5>
                                                </a>
                                                <a href="{{ url('absence/detail/'.'?category=S&empCode='.$data['vc_emp_code'].'&startDate='.$filters['startDate'].'&endDate='.$filters['endDate']) }}">
                                                    <h5><i class="fa fa-bed" style="margin-right:10px;"></i> Sick Leave <span class="badge up bg-warning" title="Total Case">{{ $data['sakit'] }}</span></h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($count % 2 == 0)
                            <div class="clearfix"></div>
                            @endif
                            @endforeach
                        </div>
                    <!-- </div> -->
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
        jQuery('.input-date').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true
        });

        $('.span-date').on('click', function(){
            $(this).parent().find('input[type="text"]').focus();
        });
    });
 </script>
@endsection

@section('modal')
<div id="modal-confirmation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-detail-itemLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <form role="form" id="form-approve" action="{{ url('/approve-notification') }}" method="POST">
                {{ csrf_field() }}  
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="modal-detail-itemLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <h4>Are you sure?</h4>
                        <input type="hidden" name="buttonType" id="buttonType">
                        <input type="hidden" name="approveType" id="approveType" value="">
                        <input type="hidden" name="noDocument" id="noDocument" value="">
                        <div class="form-group">
                            <label class="control-label">Note <span class="text-danger"></span></label>
                            <textarea class="form-control" name="note" id="note" rows="5" maxlength="255"></textarea>
                            <span class="help-block"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-confirmation" class="btn btn-primary waves-effect">Yes</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection



