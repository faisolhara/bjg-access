@extends('layout.master')
<?php 
$categoryString = '';
if($category == 'T'){
    $categoryString = 'Late';
}elseif($category == 'PA'){
    $categoryString = 'Leave Early';
}elseif($category == 'IJIN'){
    $categoryString = 'Leave';
}elseif($category == 'S'){
    $categoryString = 'Sick Early';
}
?>

@section('title', 'Absence Detail ('.$categoryString.')')

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
                        <div class="panel panel-border panel-primary">
							<?php 
                            $joinDate = !empty($header['dt_joind_date']) ? new \DateTime($header['dt_joind_date']) : null;
							$birthDate = !empty($header['dt_birthday']) ? new \DateTime($header['dt_birthday']) : null;
							?>
                            <div class="panel-heading">
                                <h4 class="panel-title">{{ $header['vc_emp_name'] }} ({{ $header['initial_name'] }})</h4>
                            </div>
                            <div class="panel-body">
                            	<div class="row">
                                    <div class="clearfix"></div>
                                    <label class="">
                                        <i class="fa fa-calendar"></i>
                                        Join at {{ !empty($joinDate) ? $joinDate->format('d-M-Y') : '' }}
                                    </label>
                                    <div class="clearfix"></div>
                                    <label class="">
                                        <i class="fa fa-envelope"></i>
                                        {{ $header['vc_email'] }}
                                    </label>
                                </div>
                                <br>
                            	<div class="row">
                            		<div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-info table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center vertical-center">Num</th>
                                                    <th>Date <hr>
                                                        Day</th>
                                                    <th>Start <hr>
                                                        End</th>
                                                    <th>Checkin <hr>
                                                        Checkout</th>
                                                    <th class="vertical-center">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num = 0; ?>
                                            	@foreach($lines as $line)
                                            	<?php 
                                                $date       = !empty($line['tanggal']) ? new \DateTime($line['tanggal']) : null; 
                                                $checkin    = !empty($line['checkin']) ? new \DateTime($line['checkin']) : null; 
                                                $checkout   = !empty($line['checkout']) ? new \DateTime($line['checkout']) : null; 
                                                $num++;
                                                ?>
                                                <tr>
                                                    <th class="text-center vertical-center" scope="row">{{ $num }}</th>
                                                    <td>{{ !empty($date) ? $date->format('d-M-Y') : '' }} <hr>
                                                        {{ $line['hari'] }}</td>
                                                    <td>{{ $line['shift_start'] }} <hr>
                                                        {{ $line['shift_end'] }}</td>
                                                    <td>{{ !empty($checkin) ? $checkin->format('H:i') : '' }} <hr>
                                                        {{ !empty($checkout) ? $checkout->format('H:i') : '' }}</td>
                                                    <td class="vertical-center">{{ $line['note'] }}</td>
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

