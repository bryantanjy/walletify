<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Termwind\render;

class RecordController extends Controller
{
    /**
     *  Index record
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->startOfMonth();
            $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() + 1 : now()->endOfMonth();

            $records = Record::with('category', 'account', 'user')
                ->where('user_id', $user->id)
                ->whereBetween('datetime', [$startDate, $endDate])
                ->orderBy('datetime', 'desc')
                ->paginate(14);

            $totalBalance = $this->calculateTotalBalance($records);

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
     *  search function
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $sort = $request->input('sort');
        $user = Auth::user();

        $records = Record::search($searchTerm)
            ->with('category', 'account', 'user')
            ->where('user_id', $user->id);

        if ($sort == 'oldest') {
            $records = $records->orderBy('datetime', 'asc');
        } else {
            $records = $records->orderBy('datetime', 'desc');
        }

        $records = $records->paginate(14);

        $categories = Category::all(); // Retrieve all categories
        $accounts = Account::where('user_id', Auth::user()->id)->get(); // Retrieve all accounts for the current user
        $totalBalance = $this->calculateTotalBalance($records);

        return view('record.record_list', compact('records', 'categories', 'accounts', 'totalBalance'))->render();
    }

    /**
     *  fetch the date from datepicker and show the ranged record
     */
    public function fetchByDate(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = Carbon::parse($request->input('endDate'))->endOfDay();
        $sort = $request->input('sort');
        $user = Auth::user();

        $records = Record::with('category', 'account', 'user')
            ->where('user_id', $user->id)
            ->whereBetween('datetime', [$startDate, $endDate]);

        if ($sort == 'oldest') {
            $records = $records->orderBy('datetime', 'asc');
        } else {
            $records = $records->orderBy('datetime', 'desc');
        }

        $records = $records->paginate(14);

        $categories = Category::all(); // Retrieve all categories
        $accounts = Account::where('user_id', Auth::user()->id)->get(); // Retrieve all accounts for the current user
        $totalBalance = $this->calculateTotalBalance($records);

        return view('record.record_list', compact('records', 'categories', 'accounts', 'totalBalance'))->render();
    }

    /**
     *  calculate total balance function
     */
    private function calculateTotalBalance($records)
    {
        $totalExpense = 0;
        $totalIncome = 0;

        foreach ($records as $record) {
            if ($record->type === 'Expense') {
                $totalExpense += $record->amount;
            } else {
                $totalIncome += $record->amount;
            }
        }

        return $totalIncome - $totalExpense;
    }

    public function filter(Request $request)
    {
        $sort = $request->input('sort');
        $user = Auth::user();

        $records = Record::with('category', 'account', 'user')
            ->where('user_id', $user->id);

            if ($request->has('categories')) {
                $records->whereIn('category_id', $request->categories);
            }
            if ($request->has('types')) {
                $records->whereIn('type', $request->types);
            }
        
            $records->orderBy('datetime', $sort == 'oldest' ? 'asc' : 'desc');
        
            $records = $records->paginate(14);

            $records->appends(['categories' => $request->categories, 'types' => $request->types]);

        $categories = Category::all(); // Retrieve all categories
        $accounts = Account::where('user_id', Auth::user()->id)->get(); // Retrieve all accounts for the current user
        $totalBalance = $this->calculateTotalBalance($records);

        return view('record.record_list', compact('records', 'categories', 'accounts', 'totalBalance'));
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
            $record->expense_sharing_group_id = $request->input('group_id');
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
            'expense_sharing_group_id' => $request->input('group_id'),
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
