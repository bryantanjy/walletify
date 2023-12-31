<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\ExpenseSharingGroup;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class ExpenseSharingController extends Controller
{
    public function index()
    {
        if (session('active_group_id')) {
            return redirect('/dashboard')
                ->with('error', 'You are not authorized to access this resource in a group session.');
        }

        $user = auth()->user();
        $groups = ExpenseSharingGroup::where('user_id', $user->id)->get();

        return view('expense-sharing.index', compact('groups'));
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

        // Check if the user has already created a group
        $existingGroup = ExpenseSharingGroup::where('user_id', auth()->id())->first();

        if ($existingGroup) {
            return redirect()->back()->withErrors('You have already created a group.');
        }

        $expenseSharing = new ExpenseSharingGroup;
        $expenseSharing->user_id = auth()->id();
        $expenseSharing->name = $request->input('name');
        $expenseSharing->description = $request->input('description');
        $expenseSharing->save();


        // Get the 'organizer' role id
        $organizerRoleId = Role::where('name', 'Group Organizer')->first()->id;
        // Fetch permission IDs by name
        $permissions = Permission::whereIn('name', ['create record', 'view record', 'edit record', 'delete record', 'create budget', 'view budget', 'edit budget', 'delete budget', 'send group invitation', 'view participant', 'edit participant', 'remove participant'])->pluck('id')->toArray();
        // Attach the user to the group_members pivot table with the 'organizer' role
        $expenseSharing->members()->attach(auth()->user()->id, [
            'role_id' => $organizerRoleId,
            'permissions' => json_encode($permissions),
        ]);

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
            // Use a transaction to ensure consistency
            DB::transaction(function () use ($group) {
                // Detach all group members
                $group->members()->detach();

                // Delete the group
                $group->delete();
            });

            return redirect()->route('expense-sharing.index')->with('success', 'Group deleted successfully');
        }
    }
}
