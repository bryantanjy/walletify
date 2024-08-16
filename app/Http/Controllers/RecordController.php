<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
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
    // public function search(Request $request)
    // {
    //     $searchTerm = $request->input('search');
    //     $sort = $request->input('sort');
    //     $user = Auth::user();
    //     $currentSession = session('app.user_session_type', 'personal');

    //     $records = Record::search($searchTerm)
    //         ->with('category', 'account', 'user')
    //         ->userScope($user->id, $currentSession)
    //         ->sortedBy($sort)
    //         ->get();

    //     $categories = Category::all(); // Retrieve all categories
    //     $accounts = Account::where('user_id', Auth::user()->id)->get(); // Retrieve all accounts for the current user
    //     $totalBalance = $this->calculateTotalBalance($records);

    //     return view('record.record_list', compact('records', 'categories', 'accounts', 'totalBalance'))->render();
    // }

    /**
     *  fetch the date from datepicker and show the ranged record
     */
    // public function fetchByDate(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = Carbon::parse($request->input('endDate'))->endOfDay();
    //     $sort = $request->input('sort');
    //     $user = Auth::user();
    //     $currentSession = session('app.user_session_type', 'personal');

    //     $records = Record::with('category', 'account', 'user')
    //         ->userScope($user->id, $currentSession)
    //         ->dateRange($startDate, $endDate)
    //         ->sortedBy($sort)
    //         ->get();

    //     $categories = Category::all(); // Retrieve all categories
    //     $accounts = Account::where('user_id', Auth::user()->id)->get(); // Retrieve all accounts for the current user
    //     $totalBalance = $this->calculateTotalBalance($records);

    //     return view('record.record_list', compact('records', 'categories', 'accounts', 'totalBalance'))->render();
    // }

    /**
     *  calculate total balance function
     */
    private function calculateTotalBalance($records)
    {
        $totalExpense = $records->where('type', 'Expense')->sum('amount');
        $totalIncome = $records->where('type', 'Income')->sum('amount');

        return $totalIncome - $totalExpense;
    }

    // public function filter(Request $request)
    // {
    //     $user = Auth::user();
    //     $currentSession = session('app.user_session_type', 'personal');

    //     $records = Record::with('category', 'account', 'user');

    //     if ($currentSession === 'personal') {
    //         $records->where('user_id', $user->id);
    //     } else {
    //         $activeGroupId = session('active_group_id');
    //         $records->where('expense_sharing_group_id', $activeGroupId);
    //     }

    //     if ($request->has('categories')) {
    //         $records->whereIn('category_id', $request->categories);
    //     }

    //     if ($request->has('types')) {
    //         $records->whereIn('type', $request->types);
    //     }

    //     $sort = $request->input('sort', 'latest');
    //     $records->orderBy('datetime', $sort == 'oldest' ? 'asc' : 'desc');
    //     $records = $records->get();

    //     $categories = Category::all();
    //     $accounts = Account::where('user_id', Auth::user()->id)->get();
    //     $totalBalance = $this->calculateTotalBalance($records);

    //     return view('record.record_list', compact('records', 'categories', 'accounts', 'totalBalance'));
    // }

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
                'account' => 'numeric|exists:accounts,id|nullable',
                'category' => 'required|exists:categories,id',
                'type' => 'required|string',
                'amount' => 'required|numeric|min:0.01|max:9999999.99',
                'datetime' => 'required|date_format:Y-m-d\TH:i',
                'description' => 'string|max:255|nullable',
                'expense_sharing_group_id' => 'numeric|exists:expense_sharing_groups,id|nullable',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userId = auth()->user()->id;
        $groupId = $request->input('group_id');

        if ($groupId != null) {
            $groupMember = DB::table('group_members')->where('user_id', $userId)
                ->where('expense_sharing_group_id', $groupId)
                ->first();

            $requiredPermission = Permission::where('name', 'create record')->first();
            $permissionsArray = json_decode($groupMember->permissions, true);
            if (!$permissionsArray || !in_array($requiredPermission->id, $permissionsArray)) {
                return redirect()->route('record.index')->with('error', 'You do not have permission to create a record in this group.');
            }
        }

        Record::create([
            'user_id' => $userId,
            'account_id' => $request->input('account'),
            'category_id' => $request->input('category'),
            'expense_sharing_group_id' => $groupId,
            'type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'datetime' => $request->input('datetime'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('record.index')->with('success', 'Financial record added successfully');
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
            return redirect()->route('record.edit')->withErrors($validator);
        }

        $userId = auth()->user()->id;
        $groupId = $request->input('group_id');

        if ($groupId != null) {
            $groupMember = DB::table('group_members')->where('user_id', $userId)
                ->where('expense_sharing_group_id', $groupId)
                ->first();

            $requiredPermission = Permission::where('name', 'edit record')->first();
            $permissionsArray = json_decode($groupMember->permissions, true);
            if (!$permissionsArray || !in_array($requiredPermission->id, $permissionsArray)) {
                return redirect()->route('record.index')->with('error', 'You do not have permission to create a record in this group.');
            }
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

        if ($record->user_id === $userId && is_null($record->expense_sharing_group_id)) {
            $record->delete();
            return redirect()->route('record.index')->with('success', 'Record deleted successfully');
        }

        // If it's not the personal budget, check for group permission
        $activeGroupId = session('active_group_id');
        $groupMember = DB::table('group_members')->where('user_id', $userId)
            ->where('expense_sharing_group_id', $activeGroupId)
            ->first();

        if ($groupMember) {
            // Check if the user has the necessary permission to delete budgets within the group
            $requiredPermission = Permission::where('name', 'delete record')->first();

            $permissionsArray = json_decode($groupMember->permissions, true);

            if ($permissionsArray && in_array($requiredPermission->id, $permissionsArray)) {
                // The user has permission, delete the budget
                $record->delete();
                return redirect()->route('record.index')->with('success', 'Record deleted successfully');
            }
        }

        // Permission denied
        return redirect()->route('record.index')->with('error', 'You do not have permission to delete this record.');
    }
}
