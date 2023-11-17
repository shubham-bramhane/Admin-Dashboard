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
                                        <input type="checkbox" name="select" value="1" id="ckbCheckStatus"
                                            className="Checkbox1" class="Checkbox1">
                                        Status
                                    </th>
                                    <th scope="col">
                                        <input type="checkbox" name="select" value="1" id="ckbCheckDelete"
                                            className="Checkbox1" class="Checkbox1">
                                        Delete
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
                                    $permissions = $permissions->pluck('name', 'id')->toArray();
                                @endphp

                                @foreach ($modules as $key => $module)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            {{ $module['slug'] }}
                                            <input type="hidden" value="{{ $module['slug'] }}"
                                                name="module_slug[{{ $module['id'] }}]">
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[{{ $module['id'] }}][view]"
                                                value="1" id="ckbCheckView" class="checkBoxView individual_checkbox"
                                                {{ isset($permissions[$module['id']]['view']) ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[{{ $module['id'] }}][create]"
                                                value="1" id="ckbCheckCreate" class="checkBoxCreate individual_checkbox"
                                                {{ isset($permissions[$module['id']]['create']) ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[{{ $module['id'] }}][edit]"
                                                value="1" id="ckbCheckEdit" class="checkBoxEdit individual_checkbox"
                                                {{ isset($permissions[$module['id']]['edit']) ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[{{ $module['id'] }}][status]"
                                                value="1" id="ckbCheckStatus" class="checkBoxStatus individual_checkbox"
                                                {{ isset($permissions[$module['id']]['status']) ? 'checked' : '' }}>

                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[{{ $module['id'] }}][delete]"
                                                value="1" id="ckbCheckDelete" class="checkBoxDelete individual_checkbox"
                                                {{ isset($permissions[$module['id']]['delete']) ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="permissions[{{ $module['id'] }}][all]"
                                                value="1" id="ckbCheckAll" class="checkBoxAll individual_checkbox"
                                                {{ isset($permissions[$module['id']]['all']) ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>




                    </div>

                </div>
            </div>
    </section>
@endsection

@section('script')

<script>
    $("#ckbCheckView").click(function() {
            $(".Checkbox1").not(this).prop("checked", false);

            $(".ckbCheckCreate").removeAttr("checked");
            $(".ckbCheckEdit").removeAttr("checked");
            $(".ckbCheckStatus").removeAttr("checked");
            $(".ckbCheckDelete").removeAttr("checked");
            $(".ckbCheckAll").removeAttr("checked");

            $(".checkBoxView").attr("checked", this.checked);
        });
</script>


@endsection
