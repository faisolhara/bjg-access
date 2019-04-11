@extends('layout.master')

@section('title', 'Requisition Detail')

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
                        <div class="panel panel-color panel-danger" style="border-color: #f56f79;">
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
		                           <!--  <span class="label label-info pull-left">
		                            	<i class="fa fa-calendar"></i>
		                            	Created at {{ !empty($creationDate) ? $creationDate->format('d-M-Y H:i') : '' }}
		                            </span>
	                                <div class="clearfix"></div><br> -->
	                                <div class="alert alert-icon alert-info alert-dismissible fade in" role="alert" style="color: #0084ff;">
	                                    <i class="mdi mdi-information"></i>
	                                    {{ !empty($dataHeader['description']) ? $dataHeader['description'] : 'No description' }}
	                                </div>
                                </div>
	                            <div class="row">
		                            <h5><span class="fa fa-database"></span> Detail Item</h5>
                                    <?php $count = 0; ?>
                                    @foreach($dataItem as $item)
                                	<?php 
                                    $count++;
                                    $needDate = !empty($item['need_by_date']) ? new \DateTime($item['need_by_date']) : null; 
                                    ?>
		                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		                                <div class="card-box widget-box-two widget-two-primary" style="padding: 20px;">
                                            <!-- <i class="mdi mdi-cart widget-two-icon"></i> -->
		                                    <div class="wigdet-two-content">
                                                <p class="m-0 text-uppercase font-600 font-secondary" title="Item Description">{{ $item['item_description'] }}</p>
                                                <h2><i class="mdi mdi-cart" style="margin-right:10px;"></i><span title="Quantity">{{ $item['quantity'] }}</span> <small title="Unit">{{ $item['unit_meas_lookup_code'] }}</small></h2>
		                                        <span class="fa fa-calendar" title="Action Date"> {{ !empty($needDate) ? $needDate->format('d-M-Y') : '' }}</span> 
		                                        <p title="Note to Agent"><span class="fa fa-commenting"></span> {{ $item['note_to_agent'] }}</p>
		                                    </div>
		                                </div>
		                            </div><!-- end col -->
                                    @if($count % 2 == 0)
                                    <div class="clearfix"></div>
                                    @endif
                                    @endforeach
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
	});
 </script>
@endsection
