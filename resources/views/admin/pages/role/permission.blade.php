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
                        <form method="POST" class="w-100" action="{{route('admin.roles.permissionStore', $role->id)}}">
                            @csrf
                            <table class="table">
                                @include('admin.layout.partial.alert')
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Module</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $modules= modulesList();
                                    @endphp
                                    @forelse ($modules as $module)
                                    <tr>
                                        <td>{{$module['slug']}}</td>
                                        <td>
                                            {{-- @forelse ($module->permissions as $permission)
                                            <input type="checkbox" name="permission[]" value="{{$permission->id}}" class="checkBoxView" {{in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : ''}}>{{$permission->name}} <br>
                                            @empty

                                            @endforelse --}}
                                        </td>
                                    </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>

                            <input type="checkbox" id="selectAll" {{count($permissions) == count($role->permissions) ? 'checked' : ''}}
                            >Select All <br>

                            @forelse ($permissions as $permission)

                            {{-- checkboxes --}}
                            <input type="checkbox" name="permission[]" value="{{$permission->id}}" class="checkBoxView" {{in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : ''}}>{{$permission->name}} <br>

                            @empty

                            @endforelse

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

    $("#selectAll").click(function(){
        $(".checkBoxView").prop('checked', $(this).prop('checked'));
    });

</script>

@endsection
