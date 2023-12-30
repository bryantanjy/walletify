<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\ExpenseSharingGroup;
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

        // Retrieve the user who is creating the group
        $user = auth()->user();

        // Assign the "Group Organizer" role within the context of this group
        $organizerRole = Role::where('name', 'Group Organizer')->first();
        $user->assignRole($organizerRole, $expenseSharing->id);

        // Create a new group member with the 'Group Organizer' role for the created group
        $groupMember = new GroupMember;
        $groupMember->user_id = auth()->id();
        $groupMember->expense_sharing_group_id = $expenseSharing->id;
        $groupMember->role_id = $organizerRole->id;
        $groupMember->save();

        return redirect()->route('expense-sharing.index')->with('success', 'Your Expense Sharing Group created successfully');
    }

    public function edit($groupId)
    {
        $group = ExpenseSharingGroup::find($groupId);

        if (!$group) {
            return response()->json(['error' => 'Group not found'], 404);
        }

        return response()->json($group);
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
