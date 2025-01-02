<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {    
        $Customers = Customer::orderByDesc('id')->paginate(15);
        return view('customers.index',compact( 'Customers'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchCustomer');
        $query = Customer::query();

        $query->where('name', 'like', '%'.$searchTerm.'%')
            ->orWhere('phone_number', 'like', '%'.$searchTerm.'%');

        $Customers = $query->paginate(15);
        
        return view('customers.index', compact('Customers'));
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
    $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
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
}
