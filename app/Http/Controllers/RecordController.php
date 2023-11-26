<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    /**
     *  Index record @ record list render
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();

            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->startOfMonth();
            $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfMonth();

            $records = Record::with('category', 'account', 'user')->where('user_id', $user->id)
                ->whereBetween('datetime', [$startDate, $endDate])->get();

            $totalExpesne = 0;
            $totalIncome = 0;

            foreach ($records as $record) {
                if ($record->type === 'Expense') {
                    $totalExpesne += $record->amount;
                } else {
                    $totalIncome += $record->amount;
                }
            }

            $totalBalance = $totalIncome - $totalExpesne;

            $categories = Category::all();
            $accounts = Account::where('user_id', $user->id)->get();

            if ($request->ajax()) {
                return response()->json([
                    'records' => $records,
                    'categories' => $categories,
                    'accounts' => $accounts,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'totalBalance' => $totalBalance
                ]);
            } else {
                // If it's a regular request, return the full view
                return view('record.index', compact('records', 'categories', 'accounts', 'totalBalance', 'startDate', 'endDate'));
            }
        } else {
            return redirect('/login');
        }
    }

    /**
     *  Create record
     */
    public function create()
    {
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();
        $categories = Category::all();

        return view('record.create', compact('accounts', 'categories'));
    }


    /**
     *  Store record
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'account_id' => 'required',
                'category_id' => 'required',
                'type' => 'required|string',
                'amount' => 'required|numeric',
                'datetime' => 'required',
                'description' => 'nullable|string',
                'group_id' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $record = new Record;
            $record->account_id = $request->input('account_id');
            $record->category_id = $request->input('category_id');
            $record->user_id = auth()->id();
            $record->type = $request->input('type');
            $record->amount = $request->input('amount');
            $record->datetime = $request->input('datetime');
            $record->description = $request->input('description');
            $record->group_id = $request->input('group_id');
            $record->save();
        }

        return redirect()->route('record.index')->with('success', 'Record added successfully');
    }


    /**
     *  Edit record
     */
    public function edit($recordId)
    {
        $record = Record::find($recordId);
        $categories = Category::all();
        $accounts = Account::all();

        // return view('record.edit', compact('record', 'categories', 'accounts'));
        return response()->json($record);
    }

    /**
     *  Update record
     */
    public function update(Request $request, $recordId)
    {
        $record = Record::find($recordId);
        $validator = Validator::make(
            $request->all(),
            [
                'account_id' => 'required',
                'category_id' => 'required',
                'type' => 'required|string',
                'amount' => 'required|numeric',
                'datetime' => 'required',
                'description' => 'nullable|string',
                'group_id' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('record.edit')
                ->withErrors($validator);
        }

        $record->update([
            'account_id' => $request->input('account_id'),
            'category_id' => $request->input('category_id'),
            'type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'datetime' => $request->input('datetime'),
            'description' => $request->input('description'),
            'group_id' => $request->input('group_id'),
        ]);

        return redirect()->route('record.index')->with('success', 'Record updated successfully');
    }

    /**
     *  Delete record
     */
    public function delete(Record $record)
    {
        $userId = Auth::id();
        if ($record->user_id === $userId) {
            $record->delete();
        }

        return redirect()->route('record.index')->with('success', 'Record deleted successfully');
    }
}
