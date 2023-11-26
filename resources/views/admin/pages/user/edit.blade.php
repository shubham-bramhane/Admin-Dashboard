@extends('admin.layout.default')


@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit User</h5>
                        @include('admin.layout.partial.alert')
                        <!-- Floating Labels Form -->
                        <form class="row g-3" action="{{route('admin.users.update', $user->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingName" name='name' value="{{old('name', $user->name)}}"
                                     placeholder="User Name">
                                    <label for="floatingName">User Name</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingEmail" name='email' value="{{old('email', $user->email)}}"
                                    placeholder="User Email">
                                    <label for="floatingEmail">User Email</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword" name='password' value="{{old('password')}}"
                                    placeholder="User password">
                                    <label for="floatingPassword">User password</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                  <select class="form-select" id="floatingSelect" name="role_id" aria-label="Role">
                                    @foreach(getRoles() as $role)
                                    <option value="{{$role->id}}" {{old('role_id', getRoleByName($user->getRoleNames()[0])->id) == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                                    @endforeach
                                  </select>
                                  <label for="floatingSelect">Select Role</label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
