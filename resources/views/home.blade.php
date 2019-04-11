@extends('layout.master')

@section('title', 'Home')

@section('css')
<style type="text/css">
    #table-notification tbody tr{
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
            <!-- @include('layout.alert') -->
            <!-- end row -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="row">
                            <?php $count = 0; ?>
                            @foreach($notifications as $notification)
                            <?php 
                            $date = !empty($notification['document_date']) ? new \DateTime($notification['document_date']) : null;
                            $count++;
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-color panel-danger" style="border-color: #f56f79;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">{{ $notification['subject1'] }}</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <img src="{{ asset('images'.'/'.strtolower(trim($notification['ch_sex'])).'.png') }}" alt="user-img" class="img-circle user-img" height="35px">
                                            </div>
                                            <div class="col-xs-9">
                                                <h5 style="margin: 0px;">{{ $notification['vc_emp_name'] }}</h5>
                                                <div class="clearfix"></div>
                                                <span class="label label-info pull-left">
                                                    <i class="fa fa-calendar"></i>
                                                    Created at {{ !empty($date) ? $date->format('d-M-Y H:i') : '' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12" style="margin-top:10px; margin-bottom:5px;">
                                                <p>{{ $notification['subject2'] }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ url('notification-detail/?documentId='.$notification['document_id'].'&keyId='.$notification['key_id'].'&approveType='.$notification['notify_type']) }}" data-type="approve" class="btn btn-sm btn-info waves-effect waves-light pull-left"><span class="fa fa-search"></span> Detail</a>
                                        <a type="submit" data-type="approve" data-json="{{ json_encode($notification) }}" class="btn btn-sm btn-primary waves-effect waves-light btn-submit pull-right"><span class="fa fa-check"></span> Approve</a>
                                    </div>
                                </div>
                            </div>
                            @if($count % 2 == 0)
                            <div class="clearfix"></div>
                            @endif
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
        $('.btn-submit').on('click', function(event){
            $item =  $(this).data('json');
            $('#buttonType').val($(this).data('type'));
            $('#approveType').val($item.notify_type);
            
            $keyId = $item.key_id;
            $('#keyId').val($item.key_id);

            $('#note').val('');
            $colPanel = $(this).parent().parent().parent();

            $.ajax({
                method: "POST",
                url: "{{ url('/approve-notification') }}",
                data: { buttonType: $(this).data('type'), approveType: $item.notify_type, keyId : $keyId, note : '', "_token": "{{ csrf_token() }}" }
            })
            .done(function( msg ) {
                if(msg == 'S'){
                    $colPanel.css("display", "none");
                    Command: toastr["success"]($item.subject1 + ' has been approved');
                }else{
                    Command: toastr["error"]($item.subject1 + ' cannot to approve')
                }
            });
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



