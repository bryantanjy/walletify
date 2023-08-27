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
    public function index()
    {
        if (auth()->check()) {
            $userId = Auth::id();
            $records = Record::all();
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
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();
        $categories = Category::all();
        //dd($accounts);
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
            'category_id' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'record_description' => 'nullable|max:50',
            'group_id' => 'nullable',
        ]);
        $validatedData['user_id'] = auth()->id();
        Record::create($validatedData);

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
    public function delete(Record $record)
    {
        //
    }
}
