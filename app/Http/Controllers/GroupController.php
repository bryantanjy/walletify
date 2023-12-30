<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GroupMember;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\GroupInvitation;
use App\Models\ExpenseSharingGroup;
use Illuminate\Support\Facades\Mail;

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

        $members = GroupMember::with('user', 'roles')->where('expense_sharing_group_id', $group->id)->get();
        
        return view('groups.index', compact('members', 'group'));
    }

    public function sendInvitation(Request $request, $groupId)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the user can invite to the group
        $group = ExpenseSharingGroup::findOrFail($groupId);
        $this->authorize('sendInvitation', $group);

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

        // Add the user to the group & assign role
        $user->assignRole('Group Collaborator');

        // Delete the invitation
        $invitation->delete();

        return redirect()->route('groups.index')->with('success', 'Invitation accepted. You are now a member of the group.');
    }
}
