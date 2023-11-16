<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\CategoryPartAllocation;
use Illuminate\Http\Request;
use App\Models\PartAllocation;
use Illuminate\Support\Facades\Auth;
use App\Models\PartAllocationCategory;
use App\Models\Record;

class BudgetController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = auth()->user();
            $categories = Category::all();
            $budgets = Budget::where('user_id', $user->id)->get();
    
            foreach ($budgets as $budget) {
                $totalAllocationAmount = 0;
    
                foreach ($budget->partAllocations as $partAllocation) {
                    $totalExpense = 0;
                    $totalIncome = 0;
    
                    foreach ($partAllocation->categories as $category) {
    
                        $records = Record::where('user_id', $user->id)
                            ->where('category_id', $category->id)
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
        } else {
            return redirect()->route('login');
        }
    }

    public function createUserTemplate()
    {
        $categories = Category::all();

        return view('budget.createUserTemplate', compact('categories'));
    }

    public function createDefaultTemplate()
    {
        $categories = Category::all();

        return view('budget.createDefaultTemplate', compact('categories'));
    }

    public function storeDefaultTemplate(Request $request)
    {

        // Create a new budget record
        $budget = Budget::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'group_id' => null,
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
            $partAllocation->categories()->attach($categoryIds);

            // Store the part allocation in the array
            $partAllocations[] = $partAllocation;
        }

        return redirect()->route('budget.index')->with('success', 'Default template created successfully');
    }

    public function storeUserTemplate(Request $request)
    {
        $userTemplateRules = [
            'type' => 'required|string|max:50',
            'part_name.*' => 'required|string|max:50',
            'allocation_amount.*' => 'required|numeric|min:0.01',
            'category_id.*.*' => 'required|string',
        ];

        // Validate the request for default template
        $validatedUserTemplateData = $request->validate($userTemplateRules);

        try {
            // Create a new budget record
            $budget = Budget::create([
                'type' => $request->input('type'),
                'user_id' => auth()->id(),
                'group_id' => null,
            ]);

            // Create a new budget template part record and part allocation record for each part
            foreach ($request->input('part_name') as $key => $name) {
                // Create a new budget template part record
                $partAllocation = PartAllocation::create([
                    'budget_id' => $budget->budget_id,
                    'part_name' => $name,
                    'allocation_amount' => $request->input('allocation_amount')[$key],
                ]);

                // Create a new part allocation category record for each category selected for this part
                foreach ($request->input('category_id.' . $key) as $categoryId) {
                    CategoryPartAllocation::create([
                        'part_allocation_id' => $partAllocation->part_allocation_id,
                        'category_id' => $categoryId,
                    ]);
                }
            }

            return redirect()->route('budget.index')->with('success', 'User template created successfully');
        } catch (\Exception $e) {
            // Handle the error as needed, e.g., log it or return an error response
            return redirect()->route('budget.index')->with('error', 'Error creating user template');
        }
    }

    public function editDefaultTemplate($budgetId)
    {
        $budget = Budget::find($budgetId);
        $categories = Category::all();

        if (!$budget) {
            return redirect()->back()->with('error', 'Budget not found');
        }

        $partAllocations = PartAllocation::where('budget_id', $budgetId)->get();

        return view('budget.editDefaultTemplate', compact('budget', 'categories', 'partAllocations'));
    }

    public function editUserTemplate($budgetId)
    {
        $budget = Budget::find($budgetId);
        $categories = Category::all();

        return view('budget.editUserTemplate', compact('budget', 'categories'));
    }

    public function updateDefaultTemplate(Request $request, $budgetId)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'part_name.*' => 'required|string|max:255',
            'allocation_amount.*' => 'required|numeric|min:0',
            'category_id.*.*' => 'required|string',
        ]);
        // dd($request->input());
        $budget = Budget::find($budgetId);

        if (!$budget) {
            return redirect()->back()->with('error', 'Budget not found');
        }

        $budget->update([
            'type' => $request->input('type'),
        ]);

        $partNames = $request->input('part_name');
        $allocationAmounts = $request->input('allocation_amount');
        $categoryIds = $request->input('category_id');

        // Loop through the part allocations and update them
        foreach ($partNames as $index => $partName) {
            $partAllocation = PartAllocation::find($request->input('part_allocation_id')[$index]);

            if ($partAllocation) {
                $partAllocation->update([
                    'part_name' => $partName,
                    'allocation_amount' => $allocationAmounts[$index],
                ]);

                $partAllocation->partAllocationCategories($categoryIds[$index]);
            }
        }


        return redirect()->route('budget.index')->with('success', 'Budget updated successfully');
    }

    public function updateUserTemplate()
    {
        //
    }

    public function delete(Budget $budget)
    {
        $user = Auth::id();
        if ($budget->user_id === $user) {
            $budget->delete();
        }
        return redirect()->route('budget.index')->with('success', 'Budget deleted successfully');
    }
}
