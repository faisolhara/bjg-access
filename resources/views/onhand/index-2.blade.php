@extends('layout.master')

@section('title', 'Onhand Quantity 2')

@section('css')
	<style type="text/css">
		hr{
			margin-top 		: 0px !important; 
			margin-bottom   : 2px !important;
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
                        <h4 class="page-title">@yield('title') </h4>
                        <div class="clearfix"></div>
                    </div>
				</div>
			</div>
            <!-- end row -->


            <div class="row">
				<div class="col-sm-12">
					<div class="card-box">
						<div class="row">
							<form class="form-horizontal" role="form" action="{{ url('/onhand2') }}" method="POST">
	                    		{{ csrf_field() }}
	                            <div class="form-group">
	                                <label class="col-md-2 control-label">Organitation Id</label>
	                                <div class="col-md-10">
	                                    <input type="text" name="p_organization_id" id="p_organization_id" class="form-control" value="{{ !empty($filters['p_organization_id']) ? $filters['p_organization_id'] : '' }}">
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label class="col-md-2 control-label">Project Code</label>
	                                <div class="col-md-10">
	                                    <input type="text" name="p_project_code" id="p_project_code" class="form-control" value="{{ !empty($filters['p_project_code']) ? $filters['p_project_code'] : '' }}">
	                                </div>
	                            </div>
	                            <button type="submit" class="btn btn-purple waves-effect waves-light">Search</button>
	                        </form>
						</div>
						<br>
						<div class="row">
							<div class="table-rep-plugin">
								<div class="table-responsive" data-pattern="priority-columns">
									<table id="tech-companies-1" class="table  table-striped table-hover table-bordered">
										<thead>
											<tr>
												<th>Action</th>
												<th data-priority="1" rowspan="3">Org & Item</th>
												<th data-priority="1">Onhand</th>
											</tr>
										</thead>
										<tbody>
											@foreach($data as $value)
											<tr>
												<td class="text-center">
													<button data-toggle="tooltip" data-placement="top" title="" data-original-title=" Detail Item" class="btn btn-icon waves-effect waves-light btn-primary m-b-5 btn-sm btn-detail-item" data-org="{{ $value['organization_id'] }}" data-inv="{{ $value['inventory_item_id'] }}"><i class="fa fa-search"></i> </button>
												</td>
												<td>{{ $value['org_name'] }}<hr/>
													{{ $value['item_code'] }}<hr/>
													{{ substr($value['description'],0,20).'...' }}</td>
												<td class="text-right">{{ number_format($value['onhand']) }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
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
		$('.btn-detail-item').on('click', function(){
			var organization_id   = $(this).attr('data-org');
			var inventory_item_id = $(this).attr('data-inv');
			// alert(organization_id+' '+inventory_item_id)
      		$.ajax({
		    	url: '{{ url('/onhand/get-detail-item') }}', 
		        type: "POST",
		    	data: { p_organization_id : organization_id, p_inventory_item_id : inventory_item_id, "_token": "{{ csrf_token() }}" }, 
		    	success: function(result){
				    $('#table-detail-item tbody').html('');
				    result.forEach(function(value) {
				    	$('#table-detail-item tbody').append(
			                '<tr>\
							<td width="50%">\
								<div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Organitation Name</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_org_name">'+ value.org_name +'</label>\
				                </div>\
								<div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Item Code</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_item_code">'+ value.item_code +'</label>\
				                </div>\
				                <div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Description</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_description">'+ value.description +'</label>\
				                </div>\
				                <div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Item Cat.</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_item_category">'+ value.item_category +'</label>\
				                </div>\
				                <div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Subinventory</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_subinventory_code">'+ value.subinventory_code +'</label>\
				                </div>\
								<div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Locator Name</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_locator_name">'+ value.locator_name +'</label>\
				                </div>\
								<div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Project Code</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_project_code">'+ value.project_code +'</label>\
				                </div>\
				                <div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Project Name</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_project_name">'+ value.project_name +'</label>\
				                </div>\
				                <div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">Lot Number</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_lot_number">'+ value.lot_number +'</label>\
				                </div>\
				                <div class="form-group">\
				                    <label class="col-md-2 col-xs-6 control-label">On Hand</label>\
				                    <label class="col-md-10 col-xs-6 control-label" id="dt_onhand">'+ value.onhand +'</label>\
				                </div>\
							</td>\
						</tr>'
			            );
				    });
		    	},
			});

      		$('#modal-detail-item').modal('show');
		});
	});
 </script>
@endsection

@section('modal')
<div id="modal-detail-item" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-detail-itemLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal-detail-itemLabel">Detail Item</h4>
            </div>
            <div class="modal-body">
            	<table class="table table-striped m-0 table-bordered table-hover" id="table-detail-item">
					<tbody>
					</tbody>
				</table>
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
