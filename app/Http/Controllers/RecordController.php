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
     *  Index record
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $startDate = $request->input('startDate') ? Carbon::parse($request->input('startDate'))->startOfDay() : now()->startOfMonth();
        $endDate = $request->input('endDate') ? Carbon::parse($request->input('endDate'))->endOfDay() + 1 : now()->endOfMonth();
        $currentSession = session('app.user_session_type', 'personal');

        $records = Record::with('category', 'user')
            ->userScope($userId, $currentSession)
            ->dateRange($startDate, $endDate)
            ->orderByDesc('datetime')
            ->get();

        $categories = Category::all();
        $accounts = ($currentSession === 'personal') ? Account::where('user_id', $userId)->get() : collect();
        $totalBalance = $this->calculateTotalBalance($records);

        if ($request->ajax()) {
            return response()->json([
                'records' => $records,
                'categories' => $categories,
                'accounts' => $accounts,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'totalBalance' => $totalBalance
            ]);
        }

        // If it's a regular request, return the full view
        return view('record.index', compact('records', 'categories', 'accounts', 'totalBalance', 'startDate', 'endDate'));
    }

    /**
     *  search function
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $sort = $request->input('sort');
        $user = Auth::user();
        $currentSession = session('app.user_session_type', 'personal');

        $records = Record::search($searchTerm)
            ->with('category', 'account', 'user')
            ->userScope($user->id)
            ->sortedBy($sort)
            ->paginate(14);

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
        $currentSession = $request->input('userSessionType', 'personal');

        $records = Record::with('category', 'account', 'user')
            ->userScope($user->id, $currentSession)
            ->dateRange($startDate, $endDate)
            ->sortedBy($sort)
            ->paginate(14);

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
        $totalExpense = $records->where('type', 'Expense')->sum('amount');
        $totalIncome = $records->where('type', 'Income')->sum('amount');

        return $totalIncome - $totalExpense;
    }

    public function filter(Request $request)
    {
        $sort = $request->input('sort');
        $user = Auth::user();
        $currentSession = session('app.user_session_type', 'personal');

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
                'account_id' => 'nullable',
                'category_id' => 'required',
                'type' => 'required|string',
                'amount' => 'required|numeric',
                'datetime' => 'required',
                'description' => 'nullable|string',
                'expense_sharing_group_id' => 'nullable',
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
     *  View record
     */
    public function show($recordId)
    {
        $record = Record::with('account', 'category')->find($recordId);
        return response()->json($record);
    }

    /**
     *  Edit record
     */
    public function edit($recordId)
    {
        $record = Record::with('account')->find($recordId);

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
                'account_id' => 'nullable',
                'category_id' => 'required',
                'type' => 'required|string',
                'amount' => 'required|numeric',
                'datetime' => 'required',
                'description' => 'nullable|string',
                'expense_sharing_group_id' => 'nullable',
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
