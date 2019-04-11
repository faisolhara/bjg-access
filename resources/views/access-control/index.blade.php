@extends('layout.master')

@section('title', 'Access Control')

<?php 
use App\Service\AccessControlService;
?>

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
                            <form class="form-horizontal" role="form" action="{{ url('/access-control') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-xs-4 col-sm-2 control-label">Username</label>
                                    <div class="col-xs-8 col-sm-4">
                                        <input type="text" class="form-control" name="username" id="username" value="{{ !empty($filters['username']) ? $filters['username'] : '' }}" style="text-transform:uppercase">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 col-sm-2 control-label">Name</label>
                                    <div class="col-xs-8 col-sm-4">
                                        <input type="text" class="form-control" name="name" id="name" value="{{ !empty($filters['name']) ? $filters['name'] : '' }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light" style="margin-left: 20px;"><i class="fa fa-search"></i> Search</button>
                            </form>
                        </div>
                        <br>
                        <div class="row">
                            @foreach($accessControls as $data)
                            <?php 
                            $canAccess = AccessControlService::canAccess(\Session::get('user')['user_name'], $resource, 'edit');
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-border panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a href="{{ $canAccess ? url($url.'/edit/'.$data['user_name']) : '#' }}">{{ $data['full_name'] }}</a></h3>
                                    </div>
                                </div>
                            </div>
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



