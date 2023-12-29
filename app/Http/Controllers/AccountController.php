<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Account;
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
        $user = auth()->user();
        $accounts = Account::where('user_id', $user->id)->oldest()->get();
        $balance = [];

        foreach ($accounts as $account) {
            $records = Record::where('user_id', $user->id)->where('account_id', $account->id)->get();

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
            $balance = $totalIncome - $totalExpense;
            $balances[$account->id] = $balance;
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
                "name" => $request->name,
                "type" => $request->type,
                "user_id" => Auth::user()->id,
            ]);
        }

        return redirect()->route('account.index')->with('success', 'Account created successfully');
    }

    /**
     *  Show account
     */
    public function show(Account $accounts)
    {
        //
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
