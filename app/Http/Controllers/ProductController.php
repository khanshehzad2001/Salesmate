<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\AlgoliaService;


class ProductController extends Controller
{   
    protected $algoliaService;

    public function __construct(AlgoliaService $algoliaService)
    {
        $this->algoliaService = $algoliaService;
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $results = $this->algoliaService->searchProducts($search);

        return view("products.search", compact("results","request"));
    }


    public function index(Request $request)
    {
        $products=Product::paginate(15);
        return view( "products.index",compact("products"));
    }

    public function create()
    {
        //
    }

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
}