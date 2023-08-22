<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $account_id = $request->input('account_id');

            // Check if account_id is provided, retrieve records for the single user
            if ($account_id) {
                $records = Record::where('account_id', $account_id)->get();
            } else {
                // If account_id is not provided, return all records for the authenticated user
                $records = $user->records;
            }
            $categories = Category::all();

            return view('record.index', compact('records', 'categories'));
        } else {
            // Redirect to the login page if the user is not authenticated
            return redirect('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())->get();
        $categories = Category::all();
        return view('record.create', compact('accounts', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'record_type' => 'required',
            'category_name' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'record_description' => 'nullable|max:50',
        ]);

        // Create a new Record instance and fill it with the validated data
        $record = new Record($validatedData);

        // Save the record to the database
        $record->save();

        // Redirect back to the index page with a success message
        return redirect()->route('record.index')->with('success', 'Record added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        //
    }
}
