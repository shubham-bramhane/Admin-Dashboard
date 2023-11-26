@extends('admin.layout.default')


@section('content')

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">User Details:</h5>
            <p>Name: {{$user->name}}</p>
            <p>Email: {{$user->email}}</p>
            <p>Role: {{$user->getRoleNames()[0]}}</p>
            <p>Created At: {{$user->created_at}}</p>
            <p>Updated At: {{$user->updated_at}}</p>
            <p>Status :
                @if($user->status == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
                </p>

            <a href="{{route('admin.users.index')}}" class="btn btn-primary">Back</a>

          </div>
        </div>

      </div>
    </div>
  </section>

@endsection
