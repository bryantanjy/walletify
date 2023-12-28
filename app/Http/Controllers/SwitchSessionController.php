<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwitchSessionController extends Controller
{
    public function switchSession(Request $request)
    {
        $userSessionType = session('user_session_type', 'personal');

        if ($userSessionType === 'personal') {
            // Toggle to group session
            $groupId = $request->input('group_id'); // Replace with the logic to determine the group ID
            session(['active_group_id' => $groupId]);
            session(['user_session_type' => 'group']);
        } else {
            // Toggle to personal session
            session()->forget('active_group_id');
            session(['user_session_type' => 'personal']);
        }

        return back(); // Redirect back to the previous page
    }
}
