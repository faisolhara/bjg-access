@extends('layout.master')

@section('title', 'Edit Access Control')

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
    .accordion-header{
        background-color: aliceblue;
        padding: 0px 5px 0px 2px;
        margin-left: 20px;
        border:1px solid #cfcfcf;
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
                            <form class="form-horizontal" role="form" action="{{ url($url.'/save') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-xs-4 col-sm-2 control-label" style="text-align:left; padding-left:30px;">User</label>
                                    <div class="col-xs-8 col-sm-4">

                                        <input type="hidden" class="form-control" name="username" id="username" value="{{ $username }}" readonly>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $user['full_name'] }}" readonly>
                                    </div>
                                </div>
                                <div id="accordion" role="tablist">
                                @foreach($resources as $resource)
                                  <div class="card accordion-header">
                                    <div class="card-header" role="tab" id="headingTwo" style="padding-left:10px;">
                                      <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#{{ $resource['id'] }}" aria-expanded="false" aria-controls="{{ $resource['id'] }}" >
                                          <i class="fa fa-circle"></i> {{ $resource['label'] }}
                                        </a>
                                      </h5>
                                    </div>
                                    <div id="{{ $resource['id'] }}" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" style="padding-left:25px;">
                                      <div class="card-body">
                                        @foreach($resource['privilege'] as $privilege)
                                        <?php
                                        $access = !empty(old('privileges')) ? !empty(old('privileges')[$resource['resources']][$privilege]) : AccessControlService::canAccess($username, $resource['resources'], $privilege);
                                        ?>
                                        <div class="checkbox checkbox-primary" style="padding-bottom:10px;">
                                            <input type="checkbox" name="privileges[{{ $resource['resources'] }}][{{ $privilege }}]" id="privileges[{{ $resource['resources'] }}][{{ $privilege }}]" value="1" {{ $access ? 'checked' : '' }}>
                                            <label for="privileges[{{ $resource['resources'] }}][{{ $privilege }}]">
                                                {{ ucfirst($privilege) }}
                                            </label>
                                        </div>
                                        @endforeach
                                      </div>
                                    </div>
                                  </div>
                                @endforeach
                                <br>
                                <a href="{{ url($url) }}" class="btn btn-warning waves-effect waves-light pull-left" style="margin-left: 20px;"><i class="fa fa-undo"></i> Back</a>
                                <button type="submit" class="btn btn-purple waves-effect waves-light pull-right" style="margin-left: 20px;"><i class="fa fa-save"></i> Save</button>
                            </form>
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
        $('.dd-item').on('click', function(){
            console.log('asdasd');
            $(this).find('input[type="checkbox"]').attr('checked', 'checked');
            console.log(input[type="checkbox"].val());
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



