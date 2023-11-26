@extends('admin.layout.default')


@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User List</h5>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            @include('admin.layout.partial.alert')
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td>{{ $user->created_at->format('d-m-Y') }}</td>

                                        <td>
                                            @can('users-status')
                                            @if ($user->status == 1)
                                                <a href="{{ route('admin.users.status', $user->id) }}"
                                                    class="btn btn-success btn-sm">Active</a>

                                            @else
                                                <a href="{{ route('admin.users.status', $user->id) }}"
                                                    class="btn btn-danger btn-sm">Inactive</a>

                                            @endif
                                            @endcan
                                        </td>

                                        <td>
                                            @can('users-edit')

                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="ri-edit-2-line"></i></a>

                                            @endcan
                                            @can('users-delete')
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?')"> <i class="ri-delete-bin-2-line"></i></button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
