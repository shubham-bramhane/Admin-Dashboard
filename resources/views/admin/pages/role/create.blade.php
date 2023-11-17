@extends('admin.layout.default')


@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Role</h5>
                        @include('admin.layout.partial.alert')
                        <!-- Floating Labels Form -->
                        <form class="row g-3" action="{{route('admin.roles.store')}}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingName" name='name' value="{{old('name')}}" placeholder="Role Name">
                                    <label for="floatingName">Role Name</label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
