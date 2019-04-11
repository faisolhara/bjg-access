@extends('layout.master')

@section('title', 'My Requisition')

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
                            <?php $count = 0;?>
                            @foreach($requisitions as $requisition)
                            <?php 

                            $date = !empty($requisition['pr_date']) ? new \DateTime($requisition['pr_date']) : null;
                            $count++;
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-color panel-danger" style="border-color: #f56f79;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">PR Number {{ $requisition['pr_no'] }}</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h5 style="margin: 0px;">{{ $requisition['approver'] }}</h5>
                                                <div class="clearfix"></div>
                                                <span class="label label-info pull-left">
                                                    <i class="fa fa-envelope"></i>
                                                    {{ $requisition['approver_email'] }}
                                                </span>
                                                <div class="clearfix"></div>
                                                <span class="label label-info pull-left" style="margin-top:4px;">
                                                    <i class="fa fa-calendar"></i>
                                                    Created at {{ !empty($date) ? $date->format('d-M-Y H:i') : '' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12" style="margin-top:7px; margin-bottom:5px;">
                                                <p>{{ $requisition['description'] }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ url($url.'/detail/?requisitionHeaderId='.$requisition['requisition_header_id']) }}" class="btn btn-sm btn-info waves-effect waves-light pull-left"><span class="fa fa-search"></span> Detail</a>
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



