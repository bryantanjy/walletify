<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Record;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PartAllocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

                    foreach ($partAllocation->partCategories as $category) {

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
            $partAllocation->partCategories()->attach($categoryIds);

            // Store the part allocation in the array
            $partAllocations[] = $partAllocation;
        }

        return redirect()->route('budget.index')->with('success', 'Default template created successfully');
    }

    public function storeUserTemplate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required|string|in:User Template',
                'part_name.*' => 'required|string|max:255',
                'amount.*' => 'required|numeric|min:0.01',
                'categoryId.*.*' => 'exists:categories,id',
            ]
        );

        // Create a new budget record
        $budget = Budget::create([
            'type' => $request->input('type'),
            'user_id' => auth()->id(),
            'group_id' => null,
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

        return redirect()->route('budget.index')->with('success', 'User template created successfully');
    }

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

    public function editUserTemplate($budgetId)
    {
        $budget = Budget::find($budgetId);
        $categories = Category::all();

        return view('budget.editUserTemplate', compact('budget', 'categories'));
    }

    public function updateDefaultTemplate(Request $request, $budgetId)
    {
        // dd($request->all());
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

        if (!$budget) {
            return redirect()->back()->with('error', 'Budget not found');
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $budget->update([
            'type' => $request->input('type'),
        ]);

        // Loop through the part allocations and update them
        foreach ($request->input('part_name') as $index => $partName) {
            $partAllocation = $budget->partAllocations()->where('id', $request->input('part_allocation_id')[$index])->first();

            $partAllocation->update([
                'name' => $partName,
                'amount' => $request->input('allocation_amount')[$index],
            ]);

            // Sync the associated categories
            // foreach ($request->input('categories.' . $index) as $categoryId) {
            //     $partAllocation->partCategories()->attach($categoryId);
            // }
            $partAllocation->partCategories()->sync($request->input('categories.' . $index), false);
        }

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully');
    }

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

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $budget->update([
            'type' => $request->input('type'),
        ]);

        // Loop through the part allocations and update them
        foreach ($request->input('part_name') as $index => $partName) {
            $partAllocation = $budget->partAllocations()->where('id', $request->input('part_allocation_id')[$index])->first();

            $partAllocation->update([
                'name' => $partName,
                'amount' => $request->input('amount')[$index],
            ]);

            $partAllocation->partCategories()->sync($request->input('partCategory.' . $index), true);
        }
        return redirect()->route('budget.index')->with('success', 'Budget updated successfully');
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
