@extends('admin.layout.default')


@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Customer</h5>

                        <!-- Floating Labels Form -->
                        <form class="row g-3" action="{{route('admin.customers.update', $customer->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingName" name='name' value="{{$customer->name}}"  placeholder="Enter Applicant Name">
                                    <label for="floatingName">Applicant Name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="floatingEmail" name='number' value="{{$customer->number}}" placeholder="Enter Application No.">
                                    <label for="floatingEmail">Application No.</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="floatingEmail" name='age' value="{{$customer->age}}" placeholder="Enter Age">
                                    <label for="floatingEmail">Age</label>
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
