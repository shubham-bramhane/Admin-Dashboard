<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->pageSetting('index');
            $users = User::all();
            return view('admin.pages.user.index', compact('data', 'users'));
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
            return view('admin.pages.user.create', compact('data'));
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
                    'name' => 'required',
                    'email' => 'required|unique:users',
                    'password' => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ];
                $user = Role::where('name', $array['name'])->exists();
                if ($user) {
                    return redirect()->back()->with('error', 'User already exists');
                }

                $user = User::UpdateOrCreate(['id' => null], $array);
                $role = Role::where('id', $request->role_id)->first();
                if (!$role) {
                    return redirect()->back()->with('error', 'Role not found');
                }
                $user->assignRole($role->name);
                activity()->performedOn($user)->causedBy(auth()->user())->withProperties(['role' => $role->name])->log('User created with role');
                DB::commit();
                return redirect()->route('admin.users.index')->with('success', 'User created successfully');

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $data = $this->pageSetting('show', ['id' => $user->id]);
            return view('admin.pages.user.show', compact('data', 'user'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        try {
            $data = $this->pageSetting('edit', ['id' => $user->id]);
            return view('admin.pages.user.edit', compact('data', 'user'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|unique:users,email,' . $user->id,
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];
                $user = User::UpdateOrCreate(['id' => $user->id], $array);
                $role = Role::where('id', $request->role_id)->first();
                if (!$role) {
                    return redirect()->back()->with('error', 'Role not found');
                }
                $user->syncRoles($role->name);
                activity()->performedOn($user)->causedBy(auth()->user())->withProperties(['role' => $role->name])->log('User updated with role');
                DB::commit();
                return redirect()->route('admin.users.index')->with('success', 'User updated successfully');

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function status($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }
            $user->status = $user->status == 1 ? 0 : 1;
            activity()->performedOn($user)->causedBy(auth()->user())->withProperties(['status' => $user->status])->log('User status updated');
            $user->save();
            return redirect()->back()->with('success', 'User status updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            DB::beginTransaction();
            $user->delete();
            activity()->performedOn($user)->causedBy(auth()->user())->log('User deleted');
            DB::commit();
            return redirect()->back()->with('success', 'User deleted successfully');
        }
        catch(\Throwable $th){
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    public function pageSetting($action, $dataArray = []){

        if($action == 'edit'){
            $data['page_title'] = 'Edit User';
            $data['page_description'] = 'Edit User';
            $data['breadcrumbs'] = [
               [
                'title' => 'User',
                'url' => url('admin/users')
               ],
                [
                 'title' => 'Edit User',
                 'url' => url('admin/users/'.$dataArray['id'].'/edit')
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
            $data['page_title'] = 'Create User';
            $data['page_description'] = 'Create User';
            $data['breadcrumbs'] = [
               [
                'title' => 'User',
                'url' => url('admin/users')
               ],
                [
                 'title' => 'Create User',
                 'url' => url('admin/users/create')
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

        if($action == 'show'){
            $data['page_title'] = 'Show User';
            $data['page_description'] = 'Show User';
            $data['breadcrumbs'] = [
               [
                'title' => 'User',
                'url' => url('admin/users')
               ],
                [
                 'title' => 'Show User',
                 'url' => url('admin/users/'.$dataArray['id'])
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
            $data['page_title'] = 'User';
            $data['page_description'] = 'User';
            $data['breadcrumbs'] = [
               [
                'title' => 'User',
                'url' => url('admin/users')
               ],
               [
                'title' => 'User List',
                'url' => url('admin/users')
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
