<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerJourney;
use App\Models\Option;
use App\Models\Product;
use App\Models\User;
use App\Models\CJProduct;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Services\AlgoliaService;
use Illuminate\Support\Facades\Validator;

class CustomerJourneyController extends Controller
{
    protected $algoliaService;

    public function __construct(AlgoliaService $algoliaService)
    {
        $this->algoliaService = $algoliaService;
    }

    
    public function searchProducts(Request $request)
    {   
        $search = $request->input('query');

        $results = $this->algoliaService->searchProducts($search);

        return response()->json([
            'hits' => array_map(function ($hit) {
                return ['id' => $hit['id'], 'title' => $hit['title']];
            }, $results)
        ]);
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $CustomerJourneys = CustomerJourney::with(['customer','outcome','products'])->where('user_id', $userId)->orderByDesc('id')->paginate(10);
        return view('customerjourney.index', compact('CustomerJourneys'));
    }

    public function searchJourneys(Request $request)
    {
        $userId = Auth::id();
        $query = CustomerJourney::with(['customer','outcome','products'])->where('user_id', $userId);

        if ($request->has('searchJourneys')) {
            $searchTerm = $request->input('searchJourneys');
            $query->where(function ($subquery) use ($searchTerm) {
                $subquery->where('customer_name', 'like', '%'.$searchTerm.'%')
                        ->orWhere('phone_number', 'like', '%'.$searchTerm.'%');
            });
        }

        $CustomerJourneys = $query->paginate(10);
        return view('customerjourney.index', compact('CustomerJourneys'));
    }

    public function create()
    {
        $customers = Customer::paginate(15);
        $users= User::paginate(15);
        $outcomes = Option::paginate(15);
        $products = Product::paginate(15);
        $stores = Store::paginate(15);
        return view('customerjourney.create', compact('customers','users','outcomes', 'products', 'stores'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'phone_number' => 'required|regex:/^[0-9]{12}$/',
        'customer_name' => 'required|string|max:255',
        'email' => 'required|email',
        'outcome_id' => 'required|integer|exists:options,id',
        'products' => 'required|array',
        'products.*' => 'integer|exists:products,id',
    ]);

    
    $existingCustomer = Customer::where('phone_number', $request->phone_number)->first();

    if (!$existingCustomer) {
        $customer = Customer::create([
            'phone_number' => $request->phone_number,
            'name' => $request->customer_name,
            'email' => $request->email,
        ]);
    } else {
        $customer = $existingCustomer;
    }

    $journey = new CustomerJourney([
        'customer_id' => $customer->id,
        'customer_name' => $request->customer_name,
        'phone_number' => $request->phone_number, 
        'email'=> $request->email,
        'reason'=> $request->reason,
        'remark'=> $request->remark,
        'outcome_id' => $request->outcome_id,
        'store_id'=>Auth::user()->store_id,
        'user_id' => Auth::id(), 
    ]);

    $journey->save();
    $journey->products()->sync($request->products);

    
    return redirect()->route('customerjourney.index')->with('success', 'Customer Journey created successfully.');
    }

    public function searchPhoneNumber(Request $request)
    {
        $term = $request->get('term');
        $customer = Customer::where('phone_number', 'LIKE', "%{$term}%")->first();

        if ($customer) {
            return response()->json([
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'email' => $customer->email,
            ]);
        }

        return response()->json([]);
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