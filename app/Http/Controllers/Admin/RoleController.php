<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:roles-view|roles-create|roles-edit|roles-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:roles-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:roles-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->pageSetting('index');
            $roles = Role::all();
            return view('admin.pages.role.index', compact('data', 'roles'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $data = $this->pageSetting('create');
            return view('admin.pages.role.create', compact('data'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required | unique:roles,name',
                ],[
                    'name.required' => 'Role Name is required.',
                    'name.unique' => 'Role Name already exist.',
                ]
                );

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'guard_name' => 'web',
                ];

                $role = Role::where('name', $array['name'])->exists();
                if ($role) {
                    return redirect()->back()->withErrors(['Role Name already exist.'])->withInput($request->all());
                }

                $response = Role::UpdateOrCreate(['id' => null], $array);
                activity()->performedOn($response)->causedBy(auth()->user()->id)->withProperties(['name' => $response->name])->log('Role created successfully.');
                DB::commit();
                return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = $this->pageSetting('edit', ['id' => $id]);
            $role = Role::find($id);
            if ($role) {
                return view('admin.pages.role.edit', compact('data', 'role'));
            }
            return redirect()->back()->with('error', 'Role not found.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if ($request->isMethod('put')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required | unique:roles,name,'.$id,
                ],[
                    'name.required' => 'Role Name is required.',
                    'name.unique' => 'Role Name already exist.',
                ]
                );

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'guard_name' => 'web',
                ];

                $role = Role::where('name', $array['name'])->where('id', '!=', $id)->exists();
                if ($role) {
                    return redirect()->back()->withErrors(['Role Name already exist.'])->withInput($request->all());
                }

                $response = Role::UpdateOrCreate(['id' => $id], $array);
                activity()->performedOn($response)->causedBy(auth()->user()->id)->withProperties(['name' => $response->name])->log('Role updated successfully.');
                DB::commit();
                return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function status(string $id)
    {
        try {
            $role = Role::find($id);
            if ($role) {
                $role->status = !$role->status;
                activity()->performedOn($role)->causedBy(auth()->user()->id)->withProperties(['status' => $role->status])->log('Role status updated successfully.');
                $role->save();
                return redirect()->back()->with('success', 'Role status updated successfully.');
            }
            return redirect()->back()->with('error', 'Role not found.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::find($id);
            if ($role) {
                $role->delete();
                activity()->performedOn($role)->causedBy(auth()->user()->id)->log('Role deleted successfully.');
                return redirect()->back()->with('success', 'Role deleted successfully.');
            }
            return redirect()->back()->with('error', 'Role not found.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function permission(string $id){
        try {
            $role = Role::find($id);
            if ($role) {
                $data = $this->pageSetting('edit', ['id' => $id]);
                $permissions = Permission::all();
                $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();
                return view('admin.pages.role.permission', compact('data', 'role', 'permissions', 'rolePermissions'));
            }
        }
        catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function permissionStore(Request $request, string $id){
        try {
            if ($request->isMethod('post')) {
                $role = Role::find($id);
                if ($role) {
                    if(!empty($request->permission)){
                    $permission= Permission::whereIn('id', $request->permission)->get()->pluck('name')->toArray();
                    $role->syncPermissions($permission);
                    activity()->performedOn($role)->causedBy(auth()->user()->id)->withProperties(['permission' => $permission])->log('Role permission updated successfully.');
                    }
                    else{
                        $role->syncPermissions(null);
                    }
                    return redirect()->route('admin.roles.index')->with('success', 'Role permission updated successfully.');
                }
                return redirect()->back()->with('error', 'Role not found.');
            }
        }
        catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function pageSetting($action, $dataArray = []){

        if($action == 'edit'){
            $data['page_title'] = 'Edit Role';
            $data['page_description'] = 'Edit Role';
            // dd($dataArray);
            $data['breadcrumbs'] = [
               [
                'title' => 'Role',
                'url' => url('admin/roles')
               ],
                [
                 'title' => 'Edit Role',
                 'url' => url('admin/roles/'.$dataArray['id'].'/edit')
                ]
            ];
            if(isset($dataArray['title']) && !empty($dataArray['title'])){

                $data['breadcrumbs'][] = [
                    'title' => $dataArray['title'],
                    'url' => ''
                ];
            }

            return $data;
        }

        if($action == 'create'){
            $data['page_title'] = 'Create Role';
            $data['page_description'] = 'Create Role';
            $data['breadcrumbs'] = [
               [
                'title' => 'Role',
                'url' => url('admin/roles')
               ],
                [
                 'title' => 'Create Role',
                 'url' => url('admin/roles/create')
                ]
            ];
            if(isset($dataArray['title']) && !empty($dataArray['title'])){

                $data['breadcrumbs'][] = [
                    'title' => $dataArray['title'],
                    'url' => ''
                ];
            }

            return $data;
        }

        if($action == 'index'){
            $data['page_title'] = 'Role';
            $data['page_description'] = 'Role';
            $data['breadcrumbs'] = [
               [
                'title' => 'Role',
                'url' => url('admin/roles')
               ],
               [
                'title' => 'Role List',
                'url' => url('admin/roles')
               ]
            ];
            if(isset($dataArray['title']) && !empty($dataArray['title'])){

                $data['breadcrumbs'][] = [
                    'title' => $dataArray['title'],
                    'url' => ''
                ];
            }
            return $data;
        }
    }
}
