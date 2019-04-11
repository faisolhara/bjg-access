@extends('layout.master')

@section('title', 'Approve SPKL')

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
                            $creationDate = !empty($dataHeader['spkl_date']) ? new \DateTime($dataHeader['spkl_date']) : null;
                            ?>
                            <div class="panel-heading">
                                <h4 class="panel-title">{{ ucwords(strtolower($dataHeader['approval_type'])) }} - {{ $dataHeader['no_spkl'] }}</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                            <img src="{{ asset('images'.'/'.strtolower(trim($dataHeader['ch_sex'])).'.png') }}" alt="user-img" class="img-circle user-img" height="60px">
                                    </div>
                                    <div class="col-xs-9">
                                        <h4 style="margin: 0px;">{{ $dataHeader['vc_emp_name'] }}</h4>
                                        <h6 style="margin: 0px;">{{ $dataHeader['vc_emp_code'] }}</h6>
                                        <h6 style="margin: 0px;">{{ $dataHeader['vc_dept_name'] }}</h6>
                                        <div class="clearfix"></div>
                                        <span class="label label-info pull-left">
                                            <i class="fa fa-calendar"></i>
                                            {{ !empty($creationDate) ? $creationDate->format('d-M-Y') : '' }}
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <h5 style="margin: 0px;"><span class="fa fa-list-alt"></span> Detail SPKL</h5>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-info table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Num</th>
                                                    <th>Emp Code <hr> Emp Name</th>
                                                    <th>Description</th>
                                                    <th>Plan Start <hr> Plan End</th>
                                                    <th>Actual Start <hr> Actual End</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; ?>
                                                @foreach($dataLines as $line)
                                                <tr>
                                                    <th class="text-center" scope="row">{{ $no++ }}</th>
                                                    <td>{{ $line['vc_emp_code'] }} <hr> {{ $line['vc_emp_name'] }}</td>
                                                    <td>{{ $line['description'] }}</td>
                                                    <td>{{ $line['plan_start'] }} <hr> {{ $line['plan_end'] }}</td>
                                                    <td>{{ $line['actual_start'] }} <hr> {{ $line['actual_end'] }}</td>
                                                    <td>{{ $line['result_note'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <form role="form" id="form-approve" action="{{ url('/approve-spkl') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="buttonType" id="buttonType">
                                        <input type="hidden" name="approveType" id="approveType" value="{{ $dataHeader['approval_type'] }}">
                                        <input type="hidden" name="keyId" id="keyId" value="{{ $keyId }}">
                                        <input type="hidden" name="noDocument" id="noDocument" value="{{ $dataHeader['no_spkl'] }}">
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
