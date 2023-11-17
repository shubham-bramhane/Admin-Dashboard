{{-- Message --}}
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
             <span aria-hidden="true">&times;</span>
        </button>
        <strong>Success !</strong> {{ session('success') }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
             <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error !</strong> {{ session('error') }}
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
             <span aria-hidden="true">&times;</span>
        </button>
        <strong>Warning !</strong> {{ session('warning') }}
    </div>
@endif

@if (Session::has('info'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
             <span aria-hidden="true">&times;</span>
        </button>
        <strong>Info !</strong> {{ session('info') }}
    </div>

@endif

{{-- any --}}

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
             <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error !</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
