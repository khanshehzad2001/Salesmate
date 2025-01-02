<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerJourney;
use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        
        $startMonthDate = Carbon::now()->startOfMonth();
        $startYearDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now();

        $todayCustomerJourneys = CustomerJourney::where('user_id', $userId)->whereDate('created_at',Carbon::today())->count();
        
        $mtdCustomerJourneys = CustomerJourney::where('user_id', $userId)->whereBetween('created_at', [$startMonthDate, $endDate])->count();

        $ytdCustomerJourneys = CustomerJourney::where('user_id', $userId)->whereBetween('created_at', [$startYearDate, $endDate])->count();

        $lastTenCustomerJourneys = CustomerJourney::where('user_id', $userId)->orderBy('created_at', 'desc')->take(10)->get();
        
        $tasks = auth()->user()->tasks ?? collect([]);
        $tasks = $tasks->sortByDesc('id');

        return view('dashboard.index',compact('todayCustomerJourneys','mtdCustomerJourneys','ytdCustomerJourneys','lastTenCustomerJourneys','tasks') );
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
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Check if the checkbox is checked, set to 1 if checked, else 0
        $completed = $request->input('completed') ? 1 : 0;
        
        $task->completed = $completed;
        $task->save();

        $message = $completed ? 'Task completed successfully' : 'Task updated successfully but not completed';
    
        return redirect()->route('dashboard.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
