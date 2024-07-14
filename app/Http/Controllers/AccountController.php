<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     *  Index account
     */
    public function index(Request $request)
    {
        if (session('active_group_id')) {
            return redirect('/dashboard')
                ->with('error', 'You are not authorized to access this resource in a group session.');
        }

        $user = auth()->user();
        $accountsQuery = Account::where('user_id', $user->id);

        if ($request->has('type')) {
            $types = $request->input('type');
            $accountsQuery->whereIn('type', $types);
        }

        $accounts = $accountsQuery->oldest()->get();
        $balances = [];

        foreach ($accounts as $account) {
            $records = Record::where('user_id', $user->id)
                ->where('account_id', $account->id)
                ->whereNull('expense_sharing_group_id')
                ->get();

            $totalExpense = 0;
            $totalIncome = 0;

            if (isset($records)) {
                foreach ($records as $record) {
                    if ($record->type == 'Expense') {
                        $totalExpense += $record->amount;
                    } else {
                        $totalIncome += $record->amount;
                    }
                }
            }
            $balances[$account->id] = $totalIncome - $totalExpense;
        }

        $sort = $request->input('sort', 'default');
        switch ($sort) {
            case 'newest':
                $accounts = $accounts->sortByDesc('created_at');
                break;
            case 'balance_low':
                $accounts = $accounts->sortBy(function ($account) use ($balances) {
                    return $balances[$account->id];
                });
                break;
            case 'balance_high':
                $accounts = $accounts->sortByDesc(function ($account) use ($balances) {
                    return $balances[$account->id];
                });
                break;
            default:
                $accounts = $accounts->sortBy('created_at');
                break;
        }

        return view('account.index', compact('accounts', 'balances'));
    }

    /**
     *  Create account
     */
    public function create()
    {
        return view('account.create');
    }


    /**
     *  Store account
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required|string|max:255',
                'name' => 'required|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            Account::create([
                'name' => $request->name,
                'type' => $request->type,
                'user_id' => Auth::user()->id,
            ]);
        }

        return redirect()->route('account.index')->with('success', 'Account created successfully');
    }

    /**
     *  Show account
     */
    public function show($accountId)
    {
        $account = Account::find($accountId);
        $records = Record::where('account_id', $account->id)->get();
        $totalExpense = 0;
        $totalIncome = 0;
        $totalBalance = [];
        $dates = [];

        if (isset($records)) {
            foreach ($records as $record) {
                if ($record->type == 'Expense') {
                    $totalExpense += $record->amount;
                } else {
                    $totalIncome += $record->amount;
                }
                $totalBalance[] = $totalIncome - $totalExpense;
                $dates[] = Carbon::parse($record->datetime)->format('d M Y');
            }
        }
        $balance = $totalIncome - $totalExpense;


        return view('account.view', compact('account', 'balance', 'totalBalance', 'dates'));
    }

    /**
     *  Edit account
     */
    public function edit($accountId)
    {
        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }

        return response()->json($account);
    }


    /**
     *  Update account
     */
    public function update(Request $request, $accountId)
    {
        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }

        $request->validate([
            'account_type' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
        ]);

        $account->type = $request->input('account_type');
        $account->name = $request->input('account_name');
        $account->save();

        return response()->json(['success' => 'Account updated successfully'], 200);
    }

    /**
     *  Delete account
     */
    public function delete(Account $account)
    {
        $userId = Auth::id();
        if ($account->user_id === $userId) {
            $account->delete();
        }

        return redirect()->route('account.index')->with('success', 'Account deleted successfully');
    }
}
