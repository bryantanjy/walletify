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
            $records = Record::where('user_id', $user->id)->oldest()->get();
            $categories = Category::all();
            $accounts = Account::where('user_id', $user->id)->get();
            return view('record.index', compact('records', 'categories', 'accounts'));
        } else {
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
        $accounts = Account::where('user_id', Auth::user()->id)->get();
        // return response()->json([
        //     'record' => $record,
        //     'accounts' => $accounts,
        //     'categories' => $categories,
        // ]);
        return view('record.edit', compact('record', 'accounts', 'categories'));
    }


    public function update(Request $request, Record $record)
    {
        $recordId = $request->input('record_id');

        $validatedData = $request->validate([
            'account_id' => 'required',
            'category_id' => 'required',
            'record_type' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'record_description' => 'nullable|string',
            'group_id' => 'nullable',
        ]);
        $validatedData['user_id'] = auth()->id();

        $record = Record::findOrFail($recordId);
        $record->update($validatedData);

        return redirect()->route('record.index');
    }

    public function delete(Record $record)
    {
        $userId = Auth::id();
        if ($record->user_id === $userId) {
            $record->delete();
        }
        return redirect()->route('record.index')->with('success', 'Record deleted successfully');
    }
}
