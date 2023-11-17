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
                            <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th>Guard</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td>{{ $permission->created_at }}</td>
                                        <td>{{ $permission->updated_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No permissions found.</td>
                                    </tr>
                                @endforelse

                            </tbody>




                    </div>

                </div>
            </div>
    </section>
@endsection
