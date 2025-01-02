<?php

namespace App\Http\Controllers;

use App\Models\ProductDiscovery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDiscoveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store_id = Auth::user()->store_id;

        $productDiscoveries = ProductDiscovery::where('store_id',$store_id)->get();

        return view('productdiscovery.index',compact( 'productDiscoveries'));
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
    public function show(Request $request,$id)
    {   
        $productDiscovery = ProductDiscovery::findOrFail($id);
        return view('productdiscovery.show', compact('productDiscovery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductDiscovery $productDiscovery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductDiscovery $productDiscovery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDiscovery $productDiscovery)
    {
        //
    }
}
