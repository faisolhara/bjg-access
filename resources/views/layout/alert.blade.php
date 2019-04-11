@if(Session::has('successMessage'))
    <div class="alert alert-icon alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="mdi mdi-check-all"></i>
         {{ Session::get('successMessage') }}
    </div>
@endif

@if(Session::has('errorMessage'))
    <div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="mdi mdi-block-helper"></i>
         {{ Session::get('errorMessage') }}
    </div>
@endif