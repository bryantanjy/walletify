<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\BudgetTemplate;
use App\Models\PartAllocation;
use Illuminate\Validation\Rule;
use App\Models\BudgetTemplatePart;
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

            $records = Record::where('user_id', $user->id)->get();
            $budgets = Budget::with('templates')->get();
            $totalExpensesForPart = [];

            foreach ($budgets as $budget) {
                foreach ($budget->templates()->first()->parts() as $part) {
                    $totalExpensesForPart[$part->part_id] = $part->partAllocations()->sum('amount');
                }
            }
            
            return view('budget.index', compact('categories', 'budgets'));
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
        $defaultTemplateRules = [
            'template_name' => 'required|string|max:50',
            'part_name.*' => 'required|string|max:50',
            'allocation_amount.*' => 'required|numeric|min:0.01',
            'category_id.*.*' => 'required',
        ];

        // Validate the request for default template
        $validatedDefaultTemplateData = $request->validate($defaultTemplateRules);

        try {
            // Create a new budget record
            $budget = Budget::create([
                'user_id' => auth()->id(),
                'group_id' => null,
            ]);

            // Create a new budget template record
            $budgetTemplate = BudgetTemplate::create([
                'budget_id' => $budget->budget_id,
                'template_name' => $request->input('template_name'),
                'is_default' => true,
            ]);

            // Loop through the form data
            for ($i = 0; $i < count($request->input('part_name')); $i++) {
                // Create a new budget template part record
                $budgetTemplatePart = BudgetTemplatePart::create([
                    'template_id' => $budgetTemplate->template_id,
                    'part_name' => $request->input('part_name')[$i],
                ]);

                // Create a new part allocation record for the current part
                $partAllocation = PartAllocation::create([
                    'part_id' => $budgetTemplatePart->part_id,
                    'allocation_amount' => $request->input('allocation_amount')[$i],
                ]);

                // Create a new part allocation category record for each category selected for this part
                foreach ($request->input('category_id.' . ($i + 1)) as $categoryId) {
                    PartAllocationCategory::create([
                        'allocation_id' => $partAllocation->allocation_id,
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
            'category_id.*.*' => 'required',
        ];

        // Validate the request for default template
        $validatedUserTemplateData = $request->validate($userTemplateRules);

        try {
            // Create a new budget record
            $budget = Budget::create([
                'user_id' => auth()->id(),
                'group_id' => null,
            ]);

            // Create a new budget template record
            $budgetTemplate = BudgetTemplate::create([
                'budget_id' => $budget->budget_id,
                'template_name' => $request->input('template_name'),
                'is_default' => true,
            ]);

            // Create a new budget template part record and part allocation record for each part
            foreach ($request->input('part_name') as $key => $name) {
                // Create a new budget template part record
                $budgetTemplatePart = BudgetTemplatePart::create([
                    'template_id' => $budgetTemplate->template_id,
                    'part_name' => $name,
                ]);

                // Create a new part allocation record for the current part
                $partAllocation = PartAllocation::create([
                    'part_id' => $budgetTemplatePart->part_id,
                    'allocation_amount' => $request->input('allocation_amount')[$key],
                ]);

                // Create a new part allocation category record for each category selected for this part
                foreach ($request->input('category_id.' . $key) as $categoryId) {
                    PartAllocationCategory::create([
                        'allocation_id' => $partAllocation->allocation_id,
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

    public function edit()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
