<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
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

    public function create()
    {
        $user = Auth::user();
        $categories = Category::all();

        return view('record.create', compact('categories'));
    }

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

    public function show(Record $record)
    {
        //
    }

    public function edit(Record $record)
    {
        //
    }

    public function update(Request $request, Record $record)
    {
        //
    }

    public function delete(Record $record)
    {
        //
    }
}
