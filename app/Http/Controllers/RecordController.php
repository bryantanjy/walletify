<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $query = Record::where('user_id', $user->id);

            if ($request->has('sort')) {
                $sortOption = $request->input('sort');
                if ($sortOption == 'oldest') {
                    $query->orderBy('date', 'asc')->orderBy('time', 'asc');
                } else {
                    $query->orderBy('date', 'desc')->orderBy('time', 'desc');
                }
            } else {
                $query->orderBy('date', 'desc')->orderBy('time', 'desc');
            }

            $records = $query->get();
            $totalExpesne = 0;
            $totalIncome = 0;

            foreach ($records as $record) {
                if ($record->record_type === 'Expense') {
                    $totalExpesne += $record->amount;
                } else {
                    $totalIncome += $record->amount;
                }
            }

            $totalBalance = $totalIncome - $totalExpesne;

            $categories = Category::all();
            $accounts = Account::where('user_id', $user->id)->get();
            return view('record.index', compact('records', 'categories', 'accounts', 'totalBalance'));
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
            'category_id' => 'required|string',
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
