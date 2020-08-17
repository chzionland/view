@if (session('status'))
    <div class="alert alert-success alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fas fa-times"></i></button>
        {{ session('status') }}
    </div>
@endif
@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fas fa-times"></i></button>
        {{ session('message') }}
    </div>
@endif
@if(Session::has('danger-message'))
    <div class="alert alert-danger alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fas fa-times"></i></button>
        {{ session('danger-message') }}
    </div>
@endif
@if(Session::has('warning-message'))
    <div class="alert alert-warning alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fas fa-times"></i></button>
        {{ session('warning-message') }}
    </div>
@endif
