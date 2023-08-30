<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class RecordController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = Auth::user();
            $records = Record::where('user_id', $user->id)->get();
            $categories = Category::all();
            $accounts = Account::where('user_id', $user->id)->get();
            return view('record.index', compact('records', 'categories', 'accounts'));
        } else {
            // Redirect to the login page if the user is not authenticated
            return redirect('/login');
        }
    }

    public function create()
    {
        $user = Auth::user();
        $account = Account::where('user_id', $user->id)->get();
        $categories = Category::all();

        return view('record.create', compact('accounts', 'categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required',
            'category_id' => 'required',
            'record_type' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required',
            'time' => 'required',
            'record_description' => 'nullable|string',
            'group_id' => 'nullable',
        ]);
        $validatedData['user_id'] = auth()->id();

        $record = new Record($validatedData);
        $record->save();
        return redirect()->route('record.index')->with('success', 'Record added successfully');
    }

    public function show(Record $record)
    {
        //
    }

    public function edit($recordId)
    {
        $record = Record::findOrFail($recordId);
        $categories = Category::all();
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();
        return view('record.edit', compact('record', 'accounts', 'categories'));
    }

    public function update(Request $request, $recordId)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|nullable',
            'record_type' => 'required|string',
            'category_id' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required',
            'time' => 'required',
            'record_description' => 'string|nullable',
            'group_id' => 'nullable',
        ]);

        $record = Record::findOrFail($recordId);
        $record->update($validatedData);

        return redirect()->route('record.index')->with('success', 'Record updated successfully');
    }

    public function delete(Record $record)
    {
        //
    }
}
