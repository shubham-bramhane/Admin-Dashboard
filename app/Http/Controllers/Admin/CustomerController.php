<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:customers-view|customers-create|customers-edit|customers-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:customers-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customers-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:customers-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->pageSetting('index');
            $customers = Customer::all();
            return view('admin.pages.customer.index', compact('data', 'customers'));
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
            return view('admin.pages.customer.create', compact('data'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    public function status(string $id){
        try {
            $customer = Customer::find($id);
            if($customer){
                $customer->status = !$customer->status;
                $customer->save();
                return redirect()->back()->with('success', 'Customer status updated successfully.');
            }
            return redirect()->back()->with('error', 'Customer not found.');
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
                    'number' => 'required|unique:customers,number',
                    'age' => 'required|numeric',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'number' => $request->number,
                    'age' => $request->age,
                ];


                $customer = Customer::where('number', $array['number'])->exists();

                if ($customer) {
                    return redirect()->back()->withErrors(['Customer Number already exist.'])->withInput($request->all());
                }

                $response = Customer::UpdateOrCreate(['id' => null], $array);
                DB::commit();
                return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
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
            $data = $this->pageSetting('edit' , ['id' => $id]);
            $customer = Customer::find($id);
            if($customer){
                return view('admin.pages.customer.edit', compact('data', 'customer'));
            }
            return redirect()->back()->with('error', 'Customer not found.');
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
                    'number' => 'required|unique:customers,number,'.$id,
                    'age' => 'required|numeric',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->name,
                    'number' => $request->number,
                    'age' => $request->age,
                ];

                $customer = Customer::find($id);

                if(!$customer){
                    return redirect()->back()->withErrors(['Customer not found.'])->withInput($request->all());
                }

                $response = Customer::UpdateOrCreate(['id' => $id], $array);

                DB::commit();
                return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
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
            $customer = Customer::find($id);
            if($customer){
                $customer->delete();
                return redirect()->back()->with('success', 'Customer deleted successfully.');
            }
            return redirect()->back()->with('error', 'Customer not found.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function pageSetting($action, $dataArray = []){

        if($action == 'edit'){
            $data['page_title'] = 'Edit Customer';
            $data['page_description'] = 'Edit Customer';
            // dd($dataArray);
            $data['breadcrumbs'] = [
               [
                'title' => 'Customer',
                'url' => url('admin/customers')
               ],
                [
                 'title' => 'Edit Customer',
                 'url' => url('admin/customers/'.$dataArray['id'].'/edit')
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
            $data['page_title'] = 'Create Customer';
            $data['page_description'] = 'Create Customer';
            $data['breadcrumbs'] = [
               [
                'title' => 'Customer',
                'url' => url('admin/customers')
               ],
                [
                 'title' => 'Create Customer',
                 'url' => url('admin/customers/create')
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
            $data['page_title'] = 'Customer';
            $data['page_description'] = 'Customer';
            $data['breadcrumbs'] = [
               [
                'title' => 'Customer',
                'url' => url('admin/customers')
               ],
               [
                'title' => 'Customer List',
                'url' => url('admin/customers')
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
