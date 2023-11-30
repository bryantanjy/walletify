<?php

namespace App\Http\Controllers;

use App\Models\ExpenseSharingGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseSharingController extends Controller
{
    public function index()
    {   
        if(Auth::check()) {
            $user = auth()->user();
            $groups = ExpenseSharingGroup::where('user_id', $user->id)->get();

            return view('expense-sharing.index', compact('groups'));
        } else {
            redirect('/login');
        }
         
        
    }

    public function create()
    {
        return view('expense-sharing.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $expenseSharing = new ExpenseSharingGroup;
        $expenseSharing->name = $request->input('name');
        $expenseSharing->description = $request->input('description');
        $expenseSharing->save();

        return view('expense-sharing.index')->with('success', 'Your Expense Sharing Group created successfully');
    }

    public function edit()
    {
        return view('expense-sharing.edit');
    }

    public function update()
    {
        return view('expense-sharing.update');
    }

    public function delete()
    {
        return view('expense-sharing.delete');
    }
}
