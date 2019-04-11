@extends('layout.master')

@section('title', 'Approve Quote')

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
                            $creationDate = !empty($dataHeader['quote_date']) ? new \DateTime($dataHeader['quote_date']) : null;
                            ?>
                            <div class="panel-heading">
                                <h4 class="panel-title">{{ ucwords(strtolower($dataHeader['project_code_so'])) }} - {{ $dataHeader['quote_number'] }}</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                            <img src="{{ asset('images/male.png') }}" alt="user-img" class="img-circle user-img" height="60px">
                                    </div>
                                    <div class="col-xs-9">
                                        <h4 style="margin: 0px;">{{ $dataHeader['customer_name'] }}</h4>
                                        <h6 style="margin: 0px;">{{ $dataHeader['order_type'] }}</h6>
                                        <h6 style="margin: 0px;">{{ $dataHeader['sales_name'] }}</h6>
                                        <div class="clearfix"></div>
                                        <span class="label label-info pull-left">
                                            <i class="fa fa-calendar"></i>
                                            {{ !empty($creationDate) ? $creationDate->format('d-M-Y') : '' }}
                                        </span>
                                        <div class="clearfix"></div>
                                        <span class="label label-info pull-left" style="margin-top:2px;">
                                            <i class="fa fa-money"></i>
                                            {{ $dataHeader['transactional_curr_code'] }}
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <h5 style="margin: 0px;"><span class="fa fa-list-alt"></span> Detail Quote</h5>
                                    @foreach($dataLines as $line)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="card-box widget-box-two widget-two-primary" style="padding: 20px;">
                                            <!-- <i class="mdi mdi-cart widget-two-icon"></i> -->
                                            <div class="wigdet-two-content">
                                                <p class="m-0 text-uppercase font-600 font-secondary" title="Item Description">{{ $line['description'] }}</p>
                                                <h5><i class="fa fa-balance-scale" style="margin-right:10px;"></i><span title="Total Weight">Total weight {{ number_format($line['total_weight']) }} Kg</span></h5>
                                                <h5><i class="mdi mdi-cart" style="margin-right:10px;"></i><span title="Quantity">{{ $line['ordered_quantity'] }} {{ $line['order_quantity_uom'] }} </span> x <span title="Unit Selling Price">{{ $dataHeader['transactional_curr_code'] }} {{ number_format($line['unit_selling_price']) }}</span></h5>
                                                <h3><i class="fa fa-money" style="margin-right:10px;"></i><span title="Total">{{ $dataHeader['transactional_curr_code'] }} {{ number_format($line['subtotal']) }}</span></h3>
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    @endforeach
                                </div>
                                <br>
                                <div class="row">
                                    <h5 style="margin: 0px;"><span class="fa fa-list-alt"></span> Detail Quote</h5>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-info table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Num</th>
                                                    <th>Item <hr> Category</th>
                                                    <th>Description</th>
                                                    <th>Qty<hr> Uom</th>
                                                    <th>Price <hr> Weight</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dataLines as $line)
                                                <tr>
                                                    <th class="text-center" scope="row">{{ $line['line_number'] }}</th>
                                                    <td>{{ $line['ordered_item'] }} <hr> {{ $line['item_category'] }}</td>
                                                    <td>{{ $line['description'] }}</td>
                                                    <td class="text-right">{{ number_format($line['ordered_quantity']) }} <hr> {{ $line['order_quantity_uom'] }}</td>
                                                    <td class="text-right">{{ number_format($line['unit_selling_price']) }} <hr> {{ number_format($line['total_weight']) }}</td>
                                                    <td class="text-right">{{ number_format($line['subtotal']) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <form role="form" id="form-approve" action="{{ url('/approve-quote') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="buttonType" id="buttonType">
                                        <input type="hidden" name="keyId" id="keyId" value="{{ $keyId }}">
                                        <input type="hidden" name="noDocument" id="noDocument" value="{{ $dataHeader['quote_number'] }}">
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
