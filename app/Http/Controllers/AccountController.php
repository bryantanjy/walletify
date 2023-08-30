<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            // The user is authenticated, fetch the finance accounts
            $user = Auth::user();
            $accounts = Account::where('user_id', $user->id)->oldest()->get();
            if ($request->ajax()) {
                return response()->json($accounts); // Return accounts data as JSON for AJAX request
            }
        
            return view('account.index', compact('accounts'));
        } else {
            // Redirect to the login page or take appropriate action
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $incomingDatas = $request->validate([
            'account_type' => 'required|string',
            'account_name' => 'required|string|max:50',
        ]);

        $incomingDatas['account_type'] = strip_tags($incomingDatas['account_type']);
        $incomingDatas['account_name'] = strip_tags($incomingDatas['account_name']);
        $incomingDatas['user_id'] = auth()->id();
        Account::create($incomingDatas);

        return redirect()->route('account.index')->with('success', 'Account created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $accounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($accountId)
    {
        // $user = Auth::user();
        // if ($account->user_id !== $user->id) {
        //     return redirect('/login');
        // }
        //return view('account.edit', compact('account'));
        $account = Account::find($accountId);
        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }
        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $accountId)
    {
        $account = Account::find($accountId);

        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }

        // Validate the request data
        $request->validate([
            'account_type' => 'required|string',
            'account_name' => 'required|string|max:50',
        ]);

        // Update the account details
        $account->account_type = $request->input('account_type');
        $account->account_name = $request->input('account_name');
        $account->save();

        return response()->json(['message' => 'Account updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
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
