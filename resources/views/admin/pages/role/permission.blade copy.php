@extends('admin.layout.default')


@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$role->name}} :- Permission List</h5>

                    <!-- Table with stripped rows -->

                    <h6>Select all permissions <input type="checkbox" name="all" id="allselect" value="1"></h6>

                    <form action="{{route('admin.roles.permissionStore' , $role->id)}}" method="POST">
                        @csrf

                    <table class="table">
                        @include('admin.layout.partial.alert')
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Module Name</th>
                                <th scope="col">View</th>
                                <th scope="col">Create</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                                <th scope="col">All</th>
                            </tr>
                        </thead>
                        @php
                            $permissions=[
                               [
                                      'module_name'=>'User',
                                      'view'=>0,
                                      'create'=>1,
                                      'edit'=>1,
                                      'delete'=>1,
                                      'all'=>1,
                                 ],
                                 [
                                  'module_name'=>'Customer',
                                  'view'=>1,
                                  'create'=>0,
                                  'edit'=>1,
                                  'delete'=>1,
                                  'all'=>1,
                               ]
                    ];

                        @endphp

                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <input type="hidden" name='module' value="{{ $permission['module_name'] }}">
                                        {{ $permission['module_name'] }}</td>
                                    <td>
                                        <input type="checkbox" name="view" id="view" value="1"
                                            {{ $permission['view'] == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="create" id="create" value="1"
                                            {{ $permission['create'] == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="edit" id="edit" value="1"
                                            {{ $permission['edit'] == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="delete" id="delete" value="1"
                                            {{ $permission['delete'] == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="all" id="all" value="1"
                                            {{ $permission['all'] == 1 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach

                    </table>
                    <!-- End Table with stripped rows -->

                    {{-- submit button --}}

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    // select all checkbox if that row
    $('input[name="all"]').click(function () {
        $(this).closest('tr').find('input[type="checkbox"]').prop('checked', this.checked);
    });
</script>

<script>
    // select all checkbox if allselect checkbox
    $('#allselect').click(function () {
        $('input[type="checkbox"]').prop('checked', this.checked);
    });
</script>

@endsection
