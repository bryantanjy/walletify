<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ExpenseSharingGroup;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $activeGroupId = session('active_group_id');
        $groups = ExpenseSharingGroup::where('user_id', $userId)->get();

        // Determine the current session type
        $currentSession = session('app.user_session_type', 'personal');

        if ($activeGroupId) {
            $group = ExpenseSharingGroup::findOrFail($activeGroupId);

            $monthExpenses = Record::where('expense_sharing_group_id', $group->id)
                ->where('type', 'Expense')
                ->whereMonth('datetime', now()->month)
                ->whereYear('datetime', now()->year)
                ->groupBy('category_id')
                ->selectRaw('category_id, sum(amount) as total_amount')
                ->with('category')
                ->get();

            $recentRecords = Record::where('expense_sharing_group_id', $group->id)
                ->orderBy('datetime', 'desc')
                ->take(10)
                ->get();

            $records = Record::where('expense_sharing_group_id', $group->id)
                ->whereMonth('datetime', now()->month)
                ->whereYear('datetime', now()->year)
                ->get();
        } else {
            $monthExpenses = Record::where('user_id', $userId)
                ->where('expense_sharing_group_id', null)
                ->where('type', 'Expense')
                ->whereMonth('datetime', now()->month)
                ->whereYear('datetime', now()->year)
                ->groupBy('category_id')->selectRaw('category_id, sum(amount) as total_amount')
                ->with('category')
                ->get();

            $recentRecords = Record::where('user_id', $userId)
                ->where('expense_sharing_group_id', null)
                ->orderBy('datetime', 'desc')
                ->take(10)
                ->get();

            $records = Record::where('user_id', $userId)
                ->where('expense_sharing_group_id', null)
                ->whereMonth('datetime', now()->month)
                ->whereYear('datetime', now()->year)
                ->get();
        }

        return view('dashboard', compact('groups', 'monthExpenses', 'recentRecords', 'records', 'currentSession'));
    }
}
