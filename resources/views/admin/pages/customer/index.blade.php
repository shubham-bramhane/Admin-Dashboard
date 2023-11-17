@extends('admin.layout.default')


@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer List</h5>
                        @include('admin.layout.partial.alert')
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Applicant Name</th>
                                    <th scope="col">Application Number</th>
                                    <th scope="col">Applicant Age</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status </th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->number }}</td>
                                        <td>{{ $customer->age }}</td>
                                        <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($customer->status == 1)
                                            <a href="{{ route('admin.customers.status', $customer->id) }}"
                                                class="btn btn-success btn-sm">Active</a>

                                            @else
                                            <a href="{{ route('admin.customers.status', $customer->id) }}"
                                                class="btn btn-danger btn-sm">Inactive</a>

                                            @endif

                                        </td>

                                        <td>
                                            <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                class="btn btn-primary btn-sm"> <i class="ri-edit-2-line"></i></a>
                                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?')"> <i class="ri-delete-bin-2-line"></i></button>
                                            </form>
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
