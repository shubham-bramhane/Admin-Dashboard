<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users-view|users-create|users-edit|users-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }

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
                    'email' => 'required|unique:users,email',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'age' => "21",
                    'position' => "Developer",
                ];

                $UserEmail = User::where('email', $array['email'])->exists();
                if ($UserEmail) {
                    return redirect()->back()->withErrors(['User Email already exist.'])->withInput($request->all());
                }

                // dd(  $array );
                $response = User::UpdateOrCreate(['id' => null], $array);
                DB::commit();
                return redirect()->route('admin.users.index')->with('success', 'User created successfully.');

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }


    }

    public function status(string $id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->status = !$user->status;
                $user->save();
                return redirect()->back()->with('success', 'User status updated successfully.');
            }
            return redirect()->back()->with('error', 'User not found.');
        } catch (\Throwable $th) {
            //throw $th;
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
            $user = User::find($id);
            if ($user) {
                return view('admin.pages.user.edit', compact('data', 'user'));
            } else {
                return redirect()->route('users.index')->with('error', 'User not found.');
            }
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
                    'name' => 'required',
                    'email' => 'required|unique:users,email,' . $id,
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'age' => "21",
                    'position' => "Developer",
                ];

                $UserEmail = User::where('email', $array['email'])->where('id', '!=', $id)->exists();
                if ($UserEmail) {
                    return redirect()->back()->withErrors(['User Email already exist.'])->withInput($request->all());
                }

                // dd(  $array );
                $response = User::UpdateOrCreate(['id' => $id], $array);
                DB::commit();
                return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if ($id) {
                DB::beginTransaction();
                $user = User::find($id);
                if ($user) {
                    $user->delete();
                    DB::commit();
                    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
                } else {
                    return redirect()->route('users.index')->with('error', 'User not found.');
                }

            } else {
                return redirect()->route('users.index')->with('error', 'User not found.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function pageSetting($action, $dataArray = []){

        if($action == 'edit'){
            $data['page_title'] = 'Edit User';
            $data['page_description'] = 'Edit User';
            // dd($dataArray);
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
