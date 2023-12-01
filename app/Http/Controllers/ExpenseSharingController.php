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
        if (Auth::check()) {
            $user = auth()->user();
            $groups = ExpenseSharingGroup::where('user_id', $user->id)->get();

            return view('expense-sharing.index', compact('groups'));
        } else {
            return redirect('/login');
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
        $expenseSharing->user_id = auth()->id();
        $expenseSharing->name = $request->input('name');
        $expenseSharing->description = $request->input('description');
        $expenseSharing->save();

        return redirect()->route('expense-sharing.index')->with('success', 'Your Expense Sharing Group created successfully');
    }

    public function edit($groupId)
    {
        $group = ExpenseSharingGroup::find($groupId);

        return view('expense-sharing.edit', ['group' => $group]);
    }

    public function update(Request $request, $groupId)
    {
        $group = ExpenseSharingGroup::find($groupId);

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

        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        return redirect()->route('expense-sharing.index')->with('success', 'Group details are successfully updated');
    }

    public function delete(ExpenseSharingGroup $group)
    {

        $userId = Auth::id();
        if ($group->user_id === $userId) {
            $group->delete();
        }
        return redirect()->route('expense-sharing.index')->with('success', 'Group deleted successfully');
    }
}
