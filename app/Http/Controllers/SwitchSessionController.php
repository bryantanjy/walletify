<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwitchSessionController extends Controller
{
    public function switchSession(Request $request)
    {
        // Get the group id from the form data
        $groupId = $request->input('group_id');

        if ($groupId) {
            // If a group id is provided, switch to group session
            session(['active_group_id' => $groupId]);
            session(['user_session_type' => 'group']);
        } else {
            // Toggle to personal session
            session()->forget('active_group_id');
            session(['user_session_type' => 'personal']);
        }

        return back()->with('success', 'Session switched successfully');
    }
}
