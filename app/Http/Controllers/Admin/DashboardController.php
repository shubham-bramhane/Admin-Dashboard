<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:dashboard-view|dashboard-create|dashboard-edit|dashboard-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:dashboard-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:dashboard-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:dashboard-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->pageSetting('index');
            return view('admin.pages.dashboard.index', compact('data'));
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
        //
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
            $data['page_title'] = 'Edit Dashboard';
            $data['page_description'] = 'Edit Dashboard';
            $data['breadcrumbs'] = [
               [
                'title' => 'Dashboard',
                'url' => route('admin.dashboard')
               ],
                [
                 'title' => 'Edit Dashboard',
                 'url' => route('admin.Dashboards.edit', $dataArray['id'])
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
            $data['page_title'] = 'Create Dashboard';
            $data['page_description'] = 'Create Dashboard';
            $data['breadcrumbs'] = [
               [
                'title' => 'Dashboard',
                'url' => url('Dashboard')
               ],
                [
                 'title' => 'Create Dashboard',
                 'url' => url('Dashboard/create')
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
            $data['page_title'] = 'Dashboard';
            $data['page_description'] = 'Dashboard';
            $data['breadcrumbs'] = [
               [
                'title' => 'Dashboard',
                'url' => url('admin/dashboard')
               ],
            //    [
            //     'title' => 'Dashboard List',
            //     'url' => url('admin/dashboard')
            //    ]
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
