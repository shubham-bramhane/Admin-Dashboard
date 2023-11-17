<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
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



    public function store(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $array = [
                    'name' => $request->name,
                    'guard_name' => 'web',
                ];

                DB::beginTransaction();

                $role = Role::where('name',$array['name'])->exists();
                if($role){
                    return redirect()->back()->with('error', 'Role already exists.');
                }
                $role = Role::UpdateOrCreate(['id' => null], $array);
                DB::commit();

                $role->syncPermissions($request->permission);

                return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $data = $this->pageSetting('edit');
            $role = Role::find($id);
            $permissions = $role->permissions()->pluck('name', 'name')->all();
            return view('admin.pages.role.edit', compact('data', 'role', 'permissions'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->isMethod('put')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|unique:roles,name,' . $id,
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $role = Role::find($id);
                $role->name = $request->name;
                $role->save();
                $role->syncPermissions($request->permission);

                return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function status(string $id)
    {
        try {
            $role = Role::find($id);
            if ($role) {
                $role->status = !$role->status;
                $role->save();
                return redirect()->back()->with('success', 'Role status updated successfully.');
            }
            return redirect()->back()->with('error', 'Role not found.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function show(string $id)
    {
        //
    }



    public function pageSetting($action, $dataArray = []){
// dd ($action);
        if($action == 'edit'){
            $data['page_title'] = 'Edit role';
            $data['page_description'] = 'Edit role';
            // dd($dataArray);
            $data['breadcrumbs'] = [
               [
                'title' => 'role',
                'url' => url('admin/roles')
               ],
                [
                 'title' => 'Edit role',
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
            $data['page_title'] = 'Create role';
            $data['page_description'] = 'Create role';
            $data['breadcrumbs'] = [
               [
                'title' => 'role',
                'url' => url('admin/roles')
               ],
                [
                 'title' => 'Create role',
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
            $data['page_title'] = 'role';
            $data['page_description'] = 'role';
            $data['breadcrumbs'] = [
               [
                'title' => 'role',
                'url' => url('admin/roles')
               ],
               [
                'title' => 'role List',
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
