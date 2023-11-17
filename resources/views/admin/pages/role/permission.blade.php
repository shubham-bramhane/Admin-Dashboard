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
                                <th scope="col">Module</th>
                                <th scope="col">
                                    <input type="checkbox" name="select" value="1" id="ckbCheckView" className="Checkbox1" class="Checkbox1">
                                    View
                                </th>
                                <th scope="col">
                                    <input type="checkbox" name="select" value="1" id="ckbCheckAddEdit" className="Checkbox1" class="Checkbox1">
                                    Create
                                </th>
                                <th scope="col">
                                    <input type="checkbox" name="select" value="1" id="ckbCheckAdd" className="Checkbox1" class="Checkbox1">
                                    Edit
                                </th>
                                <th scope="col">
                                    <input type="checkbox" name="select" value="1" id="ckbCheckEdit" className="Checkbox1" class="Checkbox1">
                                    Status
                                </th>
                                <th scope="col">
                                    <input type="checkbox" name="select" value="1" id="ckbCheckStatus" className="Checkbox1" class="Checkbox1">
                                    Delete
                                </th>
                                <th scope="col">
                                    <input type="checkbox" name="select" value="1" id="ckbCheckDelete" className="Checkbox1" class="Checkbox1">
                                    All
                                </th>
                            </tr>
                        </thead>


                        <tbody>
                            @php
                                $modules = modulesList();
                                $permission = json_decode($role->permissions, true);
                            @endphp

                              @foreach($modules as $key =>$module)

                                <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    {{$module['slug']}}
                                    <input type="hidden" value="{{$module['slug']}}" name="module_slug[{{$module['id']}}]">
                                </td>
                                <td>
                                    <input type="checkbox"  {{runTimeChecked(1, $permission)}} name="permissions[{{$module['id']}}]" id="Checkbox{{$module['id']}}" value="1" class="checkBoxView individual_checkbox">
                                </td>
                                <td>
                                    <input type="checkbox"  {{runTimeChecked(1, $permission)}} name="permissions[{{$module['id']}}]" id="Checkbox{{$module['id']}}" value="2" class="checkBoxViewEdit individual_checkbox">
                                </td>
                                <td>
                                    <input type="checkbox"  {{runTimeChecked(1, $permission)}} name="permissions[{{$module['id']}}]" id="Checkbox{{$module['id']}}" value="3" class="checkBoxViewAdd individual_checkbox">
                                </td>
                                <td>
                                    <input type="checkbox"  {{runTimeChecked(1, $permission)}} name="permissions[{{$module['id']}}]" id="Checkbox{{$module['id']}}" value="4" class="checkBoxViewAddEdit individual_checkbox">
                                </td>
                                <td>
                                    <input type="checkbox"  {{runTimeChecked(1, $permission)}} name="permissions[{{$module['id']}}]" id="Checkbox{{$module['id']}}" value="5" class="checkBoxViewAddEditStatus individual_checkbox">
                                </td>
                                <td>
                                    <input type="checkbox"  {{runTimeChecked(1, $permission)}} name="permissions[{{$module['id']}}]" id="Checkbox{{$module['id']}}" value="6" class="checkBoxViewAddEditDelete individual_checkbox">
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
    // select all checkbox of row if a last checkbox of row is selected

    // $('input[type="checkbox"]').click(function () {
    //     if ($(this).is(":checked")) {
    //         $(this).parents('tr').find('input[type="checkbox"]').prop('checked', true);
    //     } else {
    //         $(this).parents('tr').find('input[type="checkbox"]').prop('checked', false);
    //     }
    // });



</script>

<script>
    // select all checkbox if allselect checkbox
    $('#allselect').click(function () {
        $('input[type="checkbox"]').prop('checked', this.checked);
    });
</script>

<script>
    $(document).ready(function() {
        $("#ckbCheckView").click(function() {
            $(".Checkbox1").not(this).prop("checked", false);

            $(".checkBoxViewEdit").removeAttr("checked");
            $(".checkBoxViewAdd").removeAttr("checked");
            $(".checkBoxViewAddEdit").removeAttr("checked");
            $(".checkBoxViewAddEditDelete").removeAttr("checked");

            $(".checkBoxView").attr("checked", this.checked);
        });
        $("#ckbCheckAddEdit").click(function() {
            $(".Checkbox1").not(this).prop("checked", false);

            $(".checkBoxView").removeAttr("checked");
            $(".checkBoxViewAdd").removeAttr("checked");
            $(".checkBoxViewAddEdit").removeAttr("checked");
            $(".checkBoxViewAddEditDelete").removeAttr("checked");

            $(".checkBoxViewEdit").attr("checked", this.checked);
        });
        $("#ckbCheckAdd").click(function() {
            $(".Checkbox1").not(this).prop("checked", false);

            $(".checkBoxView").removeAttr("checked");
            $(".checkBoxViewEdit").removeAttr("checked");
            $(".checkBoxViewAddEdit").removeAttr("checked");
            $(".checkBoxViewAddEditDelete").removeAttr("checked");

            $(".checkBoxViewAdd").attr("checked", this.checked);
        });
        $("#ckbCheckEdit").click(function() {
            $(".Checkbox1").not(this).prop("checked", false);

            $(".checkBoxView").removeAttr("checked");
            $(".checkBoxViewEdit").removeAttr("checked");
            $(".checkBoxViewAdd").removeAttr("checked");
            $(".checkBoxViewAddEditDelete").removeAttr("checked");

            $(".checkBoxViewAddEdit").attr("checked", this.checked);
        });

        $("#ckbCheckStatus").click(function() {

            $(".Checkbox1").not(this).prop("checked", false);

            $(".checkBoxView").removeAttr("checked");
            $(".checkBoxViewEdit").removeAttr("checked");
            $(".checkBoxViewAdd").removeAttr("checked");
            $(".checkBoxViewAddEdit").removeAttr("checked");

            $(".checkBoxViewAddEditStatus").attr("checked", this.checked);
        });



        $("#ckbCheckDelete").click(function() {

            $(".Checkbox1").not(this).prop("checked", false);

            $(".checkBoxView").removeAttr("checked");
            $(".checkBoxViewEdit").removeAttr("checked");
            $(".checkBoxViewAdd").removeAttr("checked");
            $(".checkBoxViewAddEdit").removeAttr("checked");

            $(".checkBoxViewAddEditDelete").attr("checked", this.checked);
        });
        $(".individual_checkbox").click(function() {
            $(this).parents('tr').find("input[type=checkbox]").not(this).removeAttr("checked").prop("checked", false);
        });
    });
</script>

@endsection
