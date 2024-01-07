<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Budget;
use App\Models\Record;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PartAllocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    /**
     *  Index for budget
     */
    public function index()
    {

        $user = auth()->user();
        $categories = Category::all();
        $currentSession = session('app.user_session_type', 'personal');
        $budgets = Budget::userScope($user->id, $currentSession)->get();

        foreach ($budgets as $budget) {
            $totalAllocationAmount = 0;

            foreach ($budget->partAllocations as $partAllocation) {
                $totalExpense = 0;
                $totalIncome = 0;

                foreach ($partAllocation->partCategories as $category) {
                    $now = Carbon::now();
                    $records = Record::userScope($user->id, $currentSession)
                        ->where('category_id', $category->id)
                        ->whereYear('datetime', $now->year)
                        ->whereMonth('datetime', $now->month)
                        ->get();

                    foreach ($records as $record) {
                        if ($record->type == 'Expense') {
                            $totalExpense += $record->amount;
                        } else {
                            $totalIncome += $record->amount;
                        }
                    }
                }

                $currentBudget = $totalExpense - $totalIncome;
                $percentage = ($currentBudget / $partAllocation->amount) * 100;
                $percentageWidth = min(max($percentage, 0), 100);

                $partAllocation->currentBudget = $currentBudget;
                $partAllocation->percentage = $percentage;
                $partAllocation->percentageWidth = $percentageWidth;
                $totalAllocationAmount += $partAllocation->amount;
            }
        }

        if ($budgets->count() > 0) {
            return view('budget.index', compact('categories', 'budgets', 'totalAllocationAmount'));
        } else {
            return view('budget.index', compact('categories', 'budgets'));
        }
    }

    /**
     *  Create user budget template
     */
    public function createUserTemplate()
    {
        $categories = Category::all();

        return view('budget.createUserTemplate', compact('categories'));
    }

    /**
     *  Create default budget template
     */
    public function createDefaultTemplate()
    {
        $categories = Category::all();

        return view('budget.createDefaultTemplate', compact('categories'));
    }

    /**
     *  Store default budget template
     */
    public function storeDefaultTemplate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount.*' => 'required|numeric|min:0.01',
            ]
        );

        $userId = auth()->id();
        $currentSession = session('app.user_session_type', 'personal');
        $activeGroupId = session('active_group_id');

        // Check if it's a personal session or a group session
        if ($currentSession === 'personal') {
            // Check if a personal budget already exists for the user
            $existingPersonalBudget = Budget::userScope($userId, $currentSession)->first();

            if ($existingPersonalBudget) {
                return redirect()->route('budget.index')->with('error', 'You already have a personal budget. Only one personal budget is allowed per user account.');
            }

            if ($validator->fails()) {
                return redirect()->back()->withErrors('Amount should not be empty');
            }

            // Create a new personal budget record
            $budget = Budget::create([
                'user_id' => $userId,
                'type' => $request->type,
                'expense_sharing_group_id' => null, // Set expense_sharing_group_id to null for personal budgets
            ]);

            foreach ($request->input('part_name') as $key => $partName) {
                $partAllocation = new PartAllocation([
                    'budget_id' => $budget->id,
                    'name' => $partName,
                    'amount' => $request->input('allocation_amount')[$key],
                ]);
                // Save the part allocation
                $partAllocation->save();

                // Attach categories to the part allocation
                $categoryIds = $request->input('category_id')[$key];
                $partAllocation->partCategories()->attach($categoryIds);

                // Store the part allocation in the array
                $partAllocations[] = $partAllocation;
            }
        } elseif ($currentSession === 'group') {
            // Check if the logged-in user is a member of the active group
            $groupMember = DB::table('group_members')->where('user_id', $userId)
                ->where('expense_sharing_group_id', $activeGroupId)
                ->first();

            if (!$groupMember) {
                return redirect()->route('budget.index')->with('error', 'You are not a member of this group.');
            }

            // Check if the user has the necessary permission to create a budget within the group
            $requiredPermission = Permission::where('name', 'create budget')->first();

            $permissionsArray = json_decode($groupMember->permissions, true);

            if (!$permissionsArray || !in_array($requiredPermission->id, $permissionsArray)) {
                return redirect()->route('budget.index')->with('error', 'You do not have permission to create a budget in this group.');
            }

            // Check if a budget already exists for the user in the current group
            $existingGroupBudget = Budget::userScope($userId, $currentSession)->where('expense_sharing_group_id', $activeGroupId)->first();

            if ($existingGroupBudget) {
                return redirect()->route('budget.index')->with('error', 'Your group already has a budget. Only one budget is allowed per group.');
            }

            if ($validator->fails()) {
                return redirect()->back()->withErrors('Amount should not be empty');
            }

            // Create a new group budget record
            $budget = Budget::create([
                'user_id' => $userId,
                'type' => $request->type,
                'expense_sharing_group_id' => $activeGroupId,
            ]);

            foreach ($request->input('part_name') as $key => $partName) {
                $partAllocation = new PartAllocation([
                    'budget_id' => $budget->id,
                    'name' => $partName,
                    'amount' => $request->input('allocation_amount')[$key],
                ]);
                // Save the part allocation
                $partAllocation->save();

                // Attach categories to the part allocation
                $categoryIds = $request->input('category_id')[$key];
                $partAllocation->partCategories()->attach($categoryIds);

                // Store the part allocation in the array
                $partAllocations[] = $partAllocation;
            }
        }

        return redirect()->route('budget.index')->with('success', 'Default template created successfully');
    }

    /**
     *  Store user budget template
     */
    public function storeUserTemplate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required|string|in:User Template',
                'part_name.*' => 'required|string|max:255',
                'amount.*' => 'required|numeric|min:0.01',
                'categoryId.*.*' => 'exists:categories,id',
                'group_id' => 'nullable',
            ]
        );

        $userId = auth()->id();
        $currentSession = session('app.user_session_type', 'personal');
        $activeGroupId = session('active_group_id');

        // Check if it's a personal session or a group session
        if ($currentSession === 'personal') {
            // Check if a personal budget already exists for the user
            $existingPersonalBudget = Budget::userScope($userId, $currentSession)->first();

            if ($existingPersonalBudget) {
                return redirect()->route('budget.index')->with('error', 'You already have a personal budget. Only one personal budget is allowed per user account.');
            }

            // Create a new budget record
            $budget = Budget::create([
                'type' => $request->input('type'),
                'user_id' => auth()->id(),
                'expense_sharing_group_id' => $request->input('group_id'),
            ]);

            // Create a new budget template part record and part allocation record for each part
            foreach ($request->input('part_name') as $key => $partName) {
                $partAllocation = PartAllocation::create([
                    'budget_id' => $budget->id,
                    'name' => $partName,
                    'amount' => $request->input('amount')[$key],
                ]);

                $categoryIds = $request->input('categoryId')[$key];
                $partAllocation->partCategories()->attach($categoryIds);

                // Store the part allocation in the array
                $partAllocations[] = $partAllocation;
            }
        } elseif ($currentSession === 'group') {
            // Check if the logged-in user is a member of the active group
            $groupMember = DB::table('group_members')->where('user_id', $userId)
                ->where('expense_sharing_group_id', $activeGroupId)
                ->first();

            if (!$groupMember) {
                return redirect()->route('budget.index')->with('error', 'You are not a member of this group.');
            }

            // Check if the user has the necessary permission to create a budget within the group
            $requiredPermission = Permission::where('name', 'create budget')->first();

            $permissionsArray = json_decode($groupMember->permissions, true);

            if (!$permissionsArray || !in_array($requiredPermission->id, $permissionsArray)) {
                return redirect()->route('budget.index')->with('error', 'You do not have permission to create a budget in this group.');
            }

            // Check if a budget already exists for the user in the current group
            $existingGroupBudget = Budget::userScope($userId, $currentSession)->where('expense_sharing_group_id', $activeGroupId)->first();

            if ($existingGroupBudget) {
                return redirect()->route('budget.index')->with('error', 'Your group already has a budget. Only one budget is allowed per group.');
            }

            // Create a new budget record
            $budget = Budget::create([
                'type' => $request->input('type'),
                'user_id' => auth()->id(),
                'expense_sharing_group_id' => $request->input('group_id'),
            ]);

            // Create a new budget template part record and part allocation record for each part
            foreach ($request->input('part_name') as $key => $partName) {
                $partAllocation = PartAllocation::create([
                    'budget_id' => $budget->id,
                    'name' => $partName,
                    'amount' => $request->input('amount')[$key],
                ]);

                $categoryIds = $request->input('categoryId')[$key];
                $partAllocation->partCategories()->attach($categoryIds);

                // Store the part allocation in the array
                $partAllocations[] = $partAllocation;
            }
        }

        return redirect()->route('budget.index')->with('success', 'User template created successfully');
    }

    /**
     *  show budget details
     */
    public function show($budgetId)
    {
        $budget = Budget::find($budgetId);
        $currentSession = session('app.user_session_type', 'personal');
        $activeGroupId = session('active_group_id');
        $partAllocations = $budget->partAllocations;
        $user = auth()->user();

        if (!$budget) {
            return redirect()->back()->with('error', 'Budget not found');
        }

        // Check if the logged-in user is a member of the group (for group budgets)
        if ($budget->expense_sharing_group_id !== null) {
            $groupMember = DB::table('group_members')->where('user_id', $user->id)
                ->where('expense_sharing_group_id', $budget->expense_sharing_group_id)
                ->first();

            if (!$groupMember) {
                return redirect()->route('budget.index')->with('error', 'You are not a member of this group.');
            }

            // Check if the user has the necessary permission to view a budget within the group
            $requiredPermission = Permission::where('name', 'view budget')->first();
            $permissionsArray = json_decode($groupMember->permissions, true);

            if (!$requiredPermission || !$permissionsArray || !in_array($requiredPermission->id, $permissionsArray)) {
                return redirect()->route('budget.index')->with('error', 'You do not have permission to view this budget in this group.');
            }
        } elseif ($budget->user_id !== $user->id) {
            // Check if the logged-in user is the owner of the budget (for personal budgets)
            return redirect()->route('budget.index')->with('error', 'You do not have permission to view this budget.');
        }

        // Generate date range for the current month
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = [];

        // Populate dates array with dates for the current month
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }

        $chartData = [];

        // Process data for each part allocation
        foreach ($partAllocations as $partAllocation) {
            $categories = $partAllocation->partCategories;

            $startDate = Carbon::now()->startOfMonth();
            $records = Record::userScope($budget->user_id, $currentSession)
                ->whereIn('category_id', $categories->pluck('id'))
                ->whereBetween('datetime', [$startDate, $endDate])
                ->get();


            // Calculate the total amount used for this part allocation
            $totalUsed = $records->reduce(function ($carry, $record) {
                $amount = ($record->type === 'Expense') ? $record->amount : -$record->amount;
                return $carry + $amount;
            }, 0);

            // Add the total used to the part allocation
            $partAllocation->totalUsed = $totalUsed;

            // Process records and organize data for Chart.js
            $data = $this->processChartData($records, $dates);

            // Add the processed data to the chartData array
            $chartData[] = [
                'label' => $partAllocation->name,
                'data' => $data,
            ];
        }

        return view('budget.show', compact('budget', 'chartData', 'dates', 'totalUsed'));
    }

    private function processChartData($records, $dates)
    {
        $data = array_fill_keys($dates, 0);
        $cumulativeAmount = 0;

        foreach ($dates as $date) {
            $recordsOnDate = $records->filter(function ($record) use ($date) {
                return $record->datetime->toDateString() === $date;
            });

            foreach ($recordsOnDate as $record) {
                $amount = ($record->type === 'Expense') ? $record->amount : -$record->amount;
                $cumulativeAmount += $amount;

                // Set the cumulative amount for the current date
                $data[$date] = $cumulativeAmount;
            }
        }

        // Fill remaining dates with the last cumulative amount
        $prevDate = null;
        foreach ($dates as $date) {
            if ($data[$date] === 0 && isset($prevDate) && $data[$prevDate] !== 0) {
                $data[$date] = $data[$prevDate];
            }
            $prevDate = $date;
        }

        // dd($records, $dates, $data);
        return array_values($data);
    }

    /**
     *  edit default budget template
     */
    public function editDefaultTemplate($budgetId)
    {
        $budget = Budget::find($budgetId);
        $categories = Category::all();

        if (!$budget) {
            return redirect()->back()->with('error', 'Budget not found');
        }

        return view('budget.editDefaultTemplate', compact('budget', 'categories'));
        // return response()->json(['budget' => $budget]);
    }

    /**
     *  edit user budget template
     */
    public function editUserTemplate($budgetId)
    {
        $budget = Budget::find($budgetId);
        $categories = Category::all();

        return view('budget.editUserTemplate', compact('budget', 'categories'));
    }

    /**
     *  update default budget template
     */
    public function updateDefaultTemplate(Request $request, $budgetId)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'part_name.*' => 'required|string|max:255',
                'allocation_amount.*' => 'required|numeric|min:0',
                'categories.*.*' => 'exists:categories,id',
                'type' => 'required|string|in:Default Template',
            ]
        );

        $budget = Budget::find($budgetId);
        $user = auth()->user();

        if (!$budget) {
            return redirect()->back()->with('error', 'Budget not found');
        }

        // Check if the logged-in user is the owner of the budget (for personal budgets)
        if ($budget->expense_sharing_group_id === null && $budget->user_id !== $user->id) {
            return redirect()->route('budget.index')->with('error', 'You do not have permission to edit this budget.');
        }

        // Check if the logged-in user is a member of the group (for group budgets)
        if ($budget->expense_sharing_group_id !== null) {
            $groupMember = DB::table('group_members')->where('user_id', $user->id)
                ->where('expense_sharing_group_id', $budget->expense_sharing_group_id)
                ->first();

            if (!$groupMember) {
                return redirect()->route('budget.index')->with('error', 'You are not a member of this group.');
            }

            // Check if the user has the necessary permission to edit a budget within the group
            $requiredPermission = Permission::where('name', 'edit budget')->first();
            $permissionsArray = json_decode($groupMember->permissions, true);

            if (!$permissionsArray || !in_array($requiredPermission->id, $permissionsArray)) {
                return redirect()->route('budget.index')->with('error', 'You do not have permission to edit this budget in this group.');
            }
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $budget->update(['type' => $request->input('type')]);

        // Loop through the part allocations and update them
        foreach ($request->input('part_name') as $index => $partName) {
            $partAllocation = $budget->partAllocations()->find($request->input('part_allocation_id')[$index]);

            $partAllocation->update([
                'name' => $partName,
                'amount' => $request->input('allocation_amount')[$index],
            ]);

            $partAllocation->partCategories()->sync($request->input('categories.' . $index), false);
        }

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully');
    }

    /**
     *  update user budget template
     */
    public function updateUserTemplate(Request $request, $budgetId)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'part_name.*' => 'required|string|max:255',
                'amount.*' => 'required|numeric|min:0',
                'partCategory.*.*' => 'exists:categories,id',
                'type' => 'required|string|in:User Template',
            ]
        );

        $budget = Budget::find($budgetId);
        $user = auth()->user();

        if (!$budget) {
            return redirect()->back()->with('error', 'Budget not found');
        }

        // Check if the logged-in user is the owner of the budget (for personal budgets)
        if ($budget->expense_sharing_group_id === null && $budget->user_id !== $user->id) {
            return redirect()->route('budget.index')->with('error', 'You do not have permission to edit this budget.');
        }

        // Check if the logged-in user is a member of the group (for group budgets)
        if ($budget->expense_sharing_group_id !== null) {
            $groupMember = DB::table('group_members')->where('user_id', $user->id)
                ->where('expense_sharing_group_id', $budget->expense_sharing_group_id)
                ->first();

            if (!$groupMember) {
                return redirect()->route('budget.index')->with('error', 'You are not a member of this group.');
            }

            // Check if the user has the necessary permission to edit a budget within the group
            $requiredPermission = Permission::where('name', 'edit budget')->first();
            $permissionsArray = json_decode($groupMember->permissions, true);

            if (!$permissionsArray || !in_array($requiredPermission->id, $permissionsArray)) {
                return redirect()->route('budget.index')->with('error', 'You do not have permission to edit this budget in this group.');
            }
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $budget->update([
            'type' => $request->input('type'),
        ]);

        // Loop through the part allocations and update them
        foreach ($request->input('part_name') as $index => $partName) {
            $partAllocation = $budget->partAllocations()->find($request->input('part_allocation_id')[$index]);

            $partAllocation->update([
                'name' => $partName,
                'amount' => $request->input('amount')[$index],
            ]);

            $partAllocation->partCategories()->sync($request->input('partCategory.' . $index), true);
        }

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully');
    }

    /**
     *  delete budget
     */
    public function delete(Budget $budget)
    {
        $user = Auth::id();
        if ($budget->user_id === $user && is_null($budget->expense_sharing_group_id)) {
            $budget->delete();
            return redirect()->route('budget.index')->with('success', 'Budget deleted successfully');
        }

        // If it's not the personal budget, check for group permission
        $activeGroupId = session('active_group_id');
        $groupMember = DB::table('group_members')->where('user_id', $user)
            ->where('expense_sharing_group_id', $activeGroupId)
            ->first();

        if ($groupMember) {
            // Check if the user has the necessary permission to delete budgets within the group
            $requiredPermission = Permission::where('name', 'delete budget')->first();

            $permissionsArray = json_decode($groupMember->permissions, true);

            if ($permissionsArray && in_array($requiredPermission->id, $permissionsArray)) {
                // The user has permission, delete the budget
                $budget->delete();
                return redirect()->route('budget.index')->with('success', 'Budget deleted successfully');
            }
        }

        // Permission denied
        return redirect()->route('budget.index')->with('error', 'You do not have permission to delete this budget.');
    }
}
