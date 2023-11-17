@extends('admin.layout.default')


@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $role->name }} :- Permission list</h5>

                        {{-- <div class="mb-12 row">
                            <label for="permissions"
                                class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                            <div class="col-md-6">
                                <select class="form-select @error('permissions') is-invalid @enderror" multiple
                                    aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
                                    @forelse ($permissions as $permission)
                                        <option value="{{ $permission->id }}"
                                            {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                            {{ $permission->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($errors->has('permissions'))
                                    <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                @endif
                            </div>
                        </div> --}}
                        <form method="POST" class="w-100" action="{{ route('admin.roles.permissionStore', $role->id) }}">
                            @csrf
                            <table class="table">
                                @include('admin.layout.partial.alert')
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Module</th>
                                        <th scope="col">
                                            <input type="checkbox" name="select" value="1" id="ckbCheckView"
                                                className="Checkbox1" class="Checkbox1">
                                            View
                                        </th>
                                        <th scope="col">
                                            <input type="checkbox" name="select" value="1" id="ckbCheckCreate"
                                                className="Checkbox1" class="Checkbox1">
                                            Create
                                        </th>
                                        <th scope="col">
                                            <input type="checkbox" name="select" value="1" id="ckbCheckEdit"
                                                className="Checkbox1" class="Checkbox1">
                                            Edit
                                        </th>
                                        <th scope="col">
                                            <input type="checkbox" name="select" value="1" id="ckbCheckDelete"
                                                className="Checkbox1" class="Checkbox1">
                                            Delete
                                        </th>
                                        <th scope="col">
                                            <input type="checkbox" name="select" value="1" id="ckbCheckStatus"
                                                className="Checkbox1" class="Checkbox1">
                                            Status
                                        </th>
                                        <th scope="col">
                                            <input type="checkbox" name="select" value="1" id="ckbCheckAll"
                                                className="Checkbox1" class="Checkbox1">
                                            All
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $modules = modulesList();
                                    @endphp
                                    @forelse ($modules as $module)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $module['slug'] }}</td>
                                            @forelse ($permissions as $permission)
                                                @if ($module['slug'] == explode('-', $permission->name)[0])
                                                    <td>
                                                        <input type="checkbox" name="permission[]"
                                                            value="{{ $permission->id }}"
                                                            class="checkBox{{ ucfirst(explode('-', $permission->name)[1]) }}"
                                                            {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>{{ $permission->name }}
                                                    </td>
                                                @endif
                                            @empty
                                            @endforelse

                                            <td>
                                                <input type="checkbox" class="checkBoxAll"
                                                    {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>All<br>
                                            </td>

                                        </tr>
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>



                            {{-- @forelse ($permissions as $permission)

                            <input type="checkbox" name="permission[]" value="{{$permission->id}}" class="checkBoxView" {{in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : ''}}>{{$permission->name}} <br>

                            @empty

                            @endforelse --}}

                            <div class="form-group col-md-12">
                                <center><button class="btn btn-success">Update</button></center>
                            </div>

                        </form>



                    </div>

                </div>
            </div>
    </section>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>

        // click all the checkboxes
        $('#ckbCheckAll').click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        // if i click checkBoxAll then select all checkbox of that row

        $('.checkBoxAll').click(function() {
            $(this).closest('tr').find('input[type="checkbox"]').prop('checked', this.checked);
        });



        $(document).ready(function() {
            $("#ckbCheckView").click(function() {
                $(".checkBoxView").prop('checked', $(this).prop('checked'));
            });

            $("#ckbCheckCreate").click(function() {
                $(".checkBoxCreate").prop('checked', $(this).prop('checked'));
            });

            $("#ckbCheckEdit").click(function() {
                $(".checkBoxEdit").prop('checked', $(this).prop('checked'));
            });

            $("#ckbCheckDelete").click(function() {
                $(".checkBoxDelete").prop('checked', $(this).prop('checked'));
            });

            $("#ckbCheckStatus").click(function() {
                $(".checkBoxStatus").prop('checked', $(this).prop('checked'));
            });

            $("#ckbCheckAll").click(function() {
                $(".checkBoxAll").prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endsection
