@extends('layout.master')

@section('title', 'Approve Requisition')

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
            <!-- end row -->
            <div class="row">
				<div class="col-sm-12">
					<div class="row">
                        <div class="panel panel-color panel-danger">
							<?php 
							$creationDate = !empty($dataHeader['creation_date']) ? new \DateTime($dataHeader['creation_date']) : null;
							?>
                            <div class="panel-heading">
                                <h4 class="panel-title">Requisition {{ $dataHeader['pr_no'] }}</h4>
                            </div>
                            <div class="panel-body">
                            	<div class="row">
		                            <h3 style="margin: 0px;">{{ $dataHeader['org_name'] }}</h3>
		                            <div class="clearfix"></div>
		                            <span class="label label-info pull-left">
		                            	<i class="fa fa-calendar"></i>
		                            	Created at {{ !empty($creationDate) ? $creationDate->format('d-M-Y H:i') : '' }}
		                            </span>
	                                <div class="clearfix"></div><br>
	                                <div class="alert alert-icon alert-info alert-dismissible fade in" role="alert" style="color: #0084ff;">
	                                    <i class="mdi mdi-information"></i>
	                                    {{ !empty($dataHeader['description']) ? $dataHeader['description'] : 'No description' }}
	                                </div>
                                </div>
	                            <div class="row">
		                            <h5><span class="fa fa-database"></span> Detail Item</h5>
                                    @foreach($dataItem as $item)
                                	<?php $needDate = !empty($item['need_by_date']) ? new \DateTime($item['need_by_date']) : null; ?>
		                            <div class="col-lg-3 col-md-6 col-xs-12">
		                                <div class="card-box widget-box-two widget-two-primary" style="padding: 20px;">
		                                    <i class="mdi mdi-cart widget-two-icon"></i>
		                                    <div class="wigdet-two-content">
		                                        <p class="m-0 text-uppercase font-600 font-secondary" title="Item Description">{{ $item['item_description'] }}</p>
		                                        <h2><span data-plugin="counterup" title="Quantity">{{ $item['quantity'] }}</span> <small title="Unit">{{ $item['unit_meas_lookup_code'] }}</small></h2>
		                                        <span class="fa fa-calendar" title="Action Date"> {{ !empty($needDate) ? $needDate->format('d-M-Y') : '' }}</span> 
		                                        <p title="Note to Agent"><span class="fa fa-commenting"></span> {{ $item['note_to_agent'] }}</p>
		                                    </div>
		                                </div>
		                            </div><!-- end col -->
                                    @endforeach
		                        </div>
                            	<div class="row">
		                            <h5 style="margin: 0px;"><span class="fa fa-database"></span> Detail Item</h5>
                            		<div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-info">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="5%">Num</th>
                                                    <th width="30%">Description</th>
                                                    <th width="5%">Quantity</th>
                                                    <th width="15%">Unit</th>
                                                    <th width="20%">Need By Date</th>
                                                    <th width="25%">Note To Agent</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	@foreach($dataItem as $item)
                                            	<?php $needDate = !empty($item['need_by_date']) ? new \DateTime($item['need_by_date']) : null; ?>
                                                <tr>
                                                    <th scope="row" class="text-center">{{ $item['line_num'] }}</th>
                                                    <td>{{ $item['item_description'] }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ $item['unit_meas_lookup_code'] }}</td>
                                                    <td>{{ !empty($needDate) ? $needDate->format('d-M-Y') : '' }}</td>
                                                    <td>{{ $item['note_to_agent'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            	</div>
                            	<div class="row">
		                            <h5 style="margin: 0px;"><span class="fa fa-legal"></span> Detail History Approval</h5>
                            		<div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-info table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Num</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                    <th>Date</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	@foreach($dataHistory as $history)
                                            	<?php $actionDate = !empty($history['action_date']) ? new \DateTime($history['action_date']) : null; ?>
                                                <tr>
                                                    <th class="text-center" scope="row">{{ $history['sequence_num'] }}</th>
                                                    <td>{{ $history['full_name'] }}</td>
                                                    <td>{{ $history['action_code'] }}</td>
                                                    <td>{{ !empty($actionDate) ? $actionDate->format('d-M-Y') : '' }}</td>
                                                    <td>{{ $history['note'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            	</div>
                            	<div class="row">
									<form role="form" id="form-approve" action="{{ url('/approve-requisition') }}" method="POST">
			                    		{{ csrf_field() }}
			                    		<input type="hidden" name="buttonType" id="buttonType">
			                    		<input type="hidden" name="requitionHeaderId" id="requitionHeaderId" value="{{ $dataHeader['requisition_header_id'] }}">
			                            <div class="form-group">
			                                <label class="control-label">Note <span class="text-danger">*</span></label>
			                                <textarea class="form-control" name="note" id="note" rows="5" maxlength="255"></textarea>
		                                    <span class="help-block"></span>
			                            </div>
			                            <div class="text-center">
				                            <a  class="btn btn-sm btn-warning waves-effect waves-light" href="{{ \URL::previous() }}"><span class="fa fa-undo"></span> Back</a>
				                            <button type="submit" data-type="approve" class="btn btn-sm btn-primary waves-effect waves-light btn-submit"><span class="fa fa-check"></span> Approve</button>
				                            <button type="submit" data-type="reject" class="btn btn-sm btn-danger waves-effect waves-light btn-submit"><span class="fa fa-remove"></span> Reject</button>
			                            </div>
			                        </form>
		                        </div>
                            </div>
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
			event.preventDefault();
			if($(this).data('type') == 'reject' && $('#note').val() == ''){
				$('#note').parent().addClass('has-error');
            	$('#note').find('span.help-block').html('Note required');
            	return;
			}else{
				$('#note').parent().removeClass('has-error');
       			$('#note').find('span.help-block').html('');
			}

			$('#buttonType').val($(this).data('type'));
			$('#modal-confirmation').modal('show');
		});

		$('#btn-confirmation').on('click', function(event){
			$('#form-approve').submit();
		});
	});
 </script>
@endsection

@section('modal')
<div id="modal-confirmation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-detail-itemLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal-detail-itemLabel">Confirmation</h4>
            </div>
            <div class="modal-body">
				<h4>Are you sure?</h4>				
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-confirmation" class="btn btn-sm btn-primary waves-effect">Yes</button>
                <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
