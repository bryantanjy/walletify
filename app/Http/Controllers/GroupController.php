<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GroupMember;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\GroupInvitation;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\ExpenseSharingGroup;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class GroupController extends Controller
{
    public function index()
    {
        $currentSession = session('app.user_session_type', 'personal');
        $activeGroupId = session('active_group_id');
        // Check if the user is in a group session
        if (!session('active_group_id')) {
            return redirect('/dashboard')
                ->with('error', 'You are not authorized to access this resource in a group session.');
        }

        $group = ExpenseSharingGroup::find($activeGroupId);
        $roles = Role::all();
        $permissions = Permission::all();
        $members = $group->members()->with('roles')->get();

        return view('groups.index', compact('group', 'members', 'roles', 'permissions', 'activeGroupId'));
    }

    public function sendInvitation(Request $request, $groupId)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        $group = ExpenseSharingGroup::findOrFail($groupId);
        $user = auth()->user();
        $groupMember = DB::table('group_members')
            ->where('user_id', $user->id)
            ->where('expense_sharing_group_id', $group->id)
            ->first();

        $requiredPermission = Permission::where('name', 'send group invitation')->first();

        // Check if the user can invite to the group
        if ($groupMember && in_array($requiredPermission->id, json_decode($groupMember->permissions, true))) {

            // Check if the user is already a member
            $user = User::where('email', $request->input('email'))->first();
            if ($user && $group->members->contains($user)) {
                return redirect()->back()->with('error', 'User is already a member of the group.');
            }

            // Send an invitation email
            $invitationToken = Str::random(64);

            // Create an invitation record in the database
            $invitation = $group->invitations()->create([
                'email' => $request->input('email'),
                'token' => $invitationToken,
            ]);

            // Ensure that the email address is valid before attempting to send the email
            if (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
                // Build the URL for accepting the invitation
                $acceptUrl = route('groups.accept-invitation', ['groupId' => $group->id, 'token' => $invitation->token]);

                // Send an invitation email
                Mail::to($request->input('email'))->send(new GroupInvitation($group, $invitationToken, $acceptUrl));

                return redirect()->back()->with('success', 'Invitation sent successfully.');
            } else {
                return redirect()->back()->with('error', 'Invalid email address.');
            }
        } else {
            return redirect()->back()->with('error', 'You do not have the required permission to access this.');
        }
    }

    public function acceptInvitation($groupId, $token)
    {
        // Find the group 
        $group = ExpenseSharingGroup::findOrFail($groupId);

        // Find the invitation
        $invitation = $group->invitations()->where('token', $token)->first();

        if (!$invitation) {
            abort(404, 'Invitation not found.');
        }

        // Find the user
        $user = User::where('email', $invitation->email)->first();

        if (!$user) {
            // Handle the case where the user doesn't exist
            return redirect()->route('/register')->with('info', 'Please register before accepting the invitation.');
        }

        $collaboratorRoleId = Role::where('name', 'Group Collaborator')->first()->id;

        // Attach the user to the group_members pivot table with the 'organizer' role
        $group->members()->attach(auth()->user()->id, ['role_id' => $collaboratorRoleId]);

        // Delete the invitation
        $invitation->delete();

        return redirect()->route('dashboard')->with('success', 'Invitation accepted. You are now a member of the group.');
    }

    public function edit($groupId, $userId)
    {
        $group = ExpenseSharingGroup::findOrFail($groupId);
        $currentUser = auth()->user();
        // Fetch the group member record for the current user
        $currentUserRecord = GroupMember::where('user_id', $currentUser->id)
            ->where('expense_sharing_group_id', $group->id)
            ->first();

        // Fetch the group member record for the selected participant
        $groupMember = GroupMember::where('user_id', $userId)
            ->where('expense_sharing_group_id', $group->id)
            ->first();

        // Find the permission ID based on the name
        $requiredPermission = Permission::where('name', 'edit participant')->first();

        // Check if the user has the required permission
        if ($currentUserRecord && $requiredPermission) {
            $permissionsArray = json_decode($currentUserRecord->permissions, true);

            // Check if permissionsArray is not null before using in_array
            if ($permissionsArray && in_array($requiredPermission->id, $permissionsArray)) {
                // User has permission, proceed with the logic
                return response()->json($groupMember);
            }
        }

        // Permission denied or other conditions not met
        return response()->json(['error' => 'Unauthorized action.'], 403);
    }


    public function update(Request $request, $groupId, $userId)
    {
        // Validate the request and update the participant's role
        $request->validate([
            'role' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Fetch the current user
        $currentUser = auth()->user();

        // Fetch the group member record for the current user
        $currentUserRecord = GroupMember::where('user_id', $currentUser->id)
            ->where('expense_sharing_group_id', $groupId)
            ->first();

        // Check if the current user has the required permission to update participants
        $requiredPermission = Permission::where('name', 'edit participant')->first();

        if ($currentUserRecord && $requiredPermission) {
            $permissionsArray = json_decode($currentUserRecord->permissions, true);

            // Check if permissionsArray is not null before using in_array
            if ($permissionsArray && in_array($requiredPermission->id, $permissionsArray)) {
                // Update the user's role and permissions in the group_members table
                GroupMember::where('expense_sharing_group_id', $groupId)
                    ->where('user_id', $userId)
                    ->update([
                        'role_id' => $request->input('role'),
                        'permissions' => $request->input('permissions', []),
                    ]);

                return redirect()->route('groups.index')->with('success', 'Participant details updated successfully');
            }
        }

        return redirect()->route('groups.index')->with('error', 'You cannot perform this action');
    }

    public function delete($groupId, $userId)
    {
        // Fetch the current user
        $currentUser = auth()->user();

        // Fetch the group member record for the current user
        $currentUserRecord = GroupMember::where('user_id', $currentUser->id)
            ->where('expense_sharing_group_id', $groupId)
            ->first();

        // Check if the current user has the required permission to update participants
        $requiredPermission = Permission::where('name', 'remove participant')->first();

        if ($currentUserRecord && $requiredPermission) {
            $permissionsArray = json_decode($currentUserRecord->permissions, true);

            // Check if permissionsArray is not null before using in_array
            if ($permissionsArray && in_array($requiredPermission->id, $permissionsArray)) {
                $group = GroupMember::where('expense_sharing_group_id', $groupId)->where('user_id', $userId);
                $group->delete();

                return redirect()->route('groups.index')->with('success', 'Group Participant removed');
            }
        }
        return redirect()->route('groups.index')->with('error', 'You cannot perform this action');
    }

    public function leaveGroup($groupId, $userId)
    {
        // Find the group member record and remove
        GroupMember::where('expense_sharing_group_id', $groupId)
            ->where('user_id', $userId)
            ->delete();

        // Clear any group-related session variables
        Session::forget('active_group_id');
        session(['user_session_type' => 'personal']);

        return redirect()->route('dashboard')->with('success', 'You have left the group successfully.');
    }
}
