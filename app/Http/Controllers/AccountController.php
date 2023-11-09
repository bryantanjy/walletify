<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $accounts = Account::where('user_id', $user->id)->oldest()->get();

            return view('account.index', compact('accounts'));
        } else {
            return redirect()->route('login');
        }
    }

    public function create()
    {
        return view('account.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required|string|max:255',
                'name' => 'required|string|max:255',
            ]
        );

        Account::create([
            "name" => $request->name,
            "type" => $request->type,
            "user_id" => Auth::user()->id,
        ]);

        return redirect()->route('account.index')->with('success', 'Account created successfully');
    }

    public function show(Account $accounts)
    {
        //
    }

    public function edit($accountId)
    {
        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }
    
        return response()->json($account);
    }

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

        return response()->json(['message' => 'Account updated successfully'], 200);
    }

    public function delete(Account $account)
    {
        $userId = Auth::id();
        if ($account->user_id === $userId) {
            $account->delete();
        }
        return redirect()->route('account.index')->with('success', 'Account deleted successfully');
    }
}
