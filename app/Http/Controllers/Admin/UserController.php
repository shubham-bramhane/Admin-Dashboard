<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Route;


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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function pageSetting($action, $dataArray = []){

        if($action == 'edit'){
            $data['page_title'] = 'Edit User';
            $data['page_description'] = 'Edit User';
            $data['breadcrumbs'] = [
               [
                'title' => 'User',
                'url' => route('admin.dashboard')
               ],
                [
                 'title' => 'Edit User',
                 'url' => route('admin.users.edit', $dataArray['id'])
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
                'url' => url('users')
               ],
                [
                 'title' => 'Create User',
                 'url' => url('users/create')
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
            // dd ($action);
            $data['page_title'] = 'User';
            $data['page_description'] = 'User';
            // dd ($data);
            $data['breadcrumbs'] = [
               [
                'title' => 'User',
                'url' => url('users')
               ],
               [
                'title' => 'User List',
                'url' => url('users')
               ]
            ];
            // dd ($data);
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
