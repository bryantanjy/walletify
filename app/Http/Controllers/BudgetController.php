<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
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

            $budgetData = [];

            foreach ($budgets as $budget) {
                $totalAllocationAmount = 0;
                $partData = [];

                foreach ($budget->partAllocations as $part) {
                    $totalExpense = 0;
                    $totalIncome = 0;
                    $categoryIds = [];

                    foreach ($part->partAllocationCategories as $pac) {
                        $records = Record::where('user_id', $user->id)->where('category_id', $pac->category_id)->get();
                        $category = Category::find($pac->category_id);
                        $categoryIds[] = $category->category_id;


                        foreach ($records as $record) {
                            if ($record->record_type == 'Expense') {
                                $totalExpense += $record->amount;
                            } else {
                                $totalIncome += $record->amount;
                            }
                        }
                    }

                    $currentBudget = $totalExpense - $totalIncome;
                    $percentage = ($currentBudget / $part->allocation_amount) * 100;
                    $percentageWidth = min(max($percentage, 0), 100);

                    $partData[] = [
                        'part_name' => $part->part_name,
                        'current_budget' => $currentBudget,
                        'allocation_amount' => $part->allocation_amount,
                        'percentage' => $percentage,
                        'percentage_for_width' => $percentageWidth,
                        'category_ids' => $categoryIds,
                    ];

                    $totalAllocationAmount += $part->allocation_amount;
                }

                $budgetData[] = [
                    'budget' => $budget,
                    'total_allocation_amount' => $totalAllocationAmount,
                    'parts' => $partData,
                ];
            }

            return view('budget.index', compact('categories', 'budgetData'));
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

        try {
            // Create a new budget record
            $budget = Budget::create([
                'template_name' => $request->template_name,
                'user_id' => auth()->id(),
                'group_id' => null,
            ]);

            // Loop through the form data
            for ($i = 0; $i < count($request->input('part_name')); $i++) {
                // Create a new budget template part record
                $partAllocation = PartAllocation::create([
                    'budget_id' => $budget->budget_id,
                    'part_name' => $request->input('part_name')[$i],
                    'allocation_amount' => $request->input('allocation_amount')[$i],
                ]);

                // Create a new part allocation category record for each category selected for this part
                foreach ($request->input('category_id.' . ($i + 1)) as $categoryId) {
                    PartAllocationCategory::create([
                        'part_allocation_id' => $partAllocation->part_allocation_id,
                        'category_id' => $categoryId,
                    ]);
                }
            }

            return redirect()->route('budget.index')->with('success', 'Default template created successfully');
        } catch (\Exception $e) {
            // Handle the error as needed, e.g., log it or return an error response
            return redirect()->route('budget.index')->with('error', 'Error creating default template');
        }
    }

    public function storeUserTemplate(Request $request)
    {
        $userTemplateRules = [
            'template_name' => 'required|string|max:50',
            'part_name.*' => 'required|string|max:50',
            'allocation_amount.*' => 'required|numeric|min:0.01',
            'category_id.*.*' => 'required|string',
        ];

        // Validate the request for default template
        $validatedUserTemplateData = $request->validate($userTemplateRules);

        try {
            // Create a new budget record
            $budget = Budget::create([
                'template_name' => $request->input('template_name'),
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
                    PartAllocationCategory::create([
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

        $budgetData = [];

        foreach ($budget->partAllocations as $part) {
            $categoryIds = [];

            foreach ($part->partAllocationCategories as $pac) {
                $category = Category::find($pac->category_id);
                $categoryIds[] = $category->category_id;
            }

            $partData[] = [
                'part_id' => $part->part_allocation_id,
                'part_name' => $part->part_name,
                'allocation_amount' => $part->allocation_amount,
                'category_ids' => $categoryIds,
            ];
        }

        return view('budget.editDefaultTemplate', compact('budget', 'partData', 'categories'));
    }

    public function editUserTemplate($budgetId)
    {
        $budget = Budget::find($budgetId);
        $categories = Category::all();

        return view('budget.editUserTemplate', compact('budget', 'categories'));
    }

    public function update()
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
