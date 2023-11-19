<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Record;
use App\Models\Category;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $categories = Category::all();

        $data = [];
        foreach ($categories as $category) {
            $data[$category->name] = [
                'income' => $this->getTotal('Income', $category->id, $currentMonth),
                'expense' => $this->getTotal('Expense', $category->id, $currentMonth),
            ];
        }

        $totalIncome = array_sum(array_column($data, 'income'));
        $totalExpense = array_sum(array_column($data, 'expense'));

        $netAmount = $totalIncome - $totalExpense;

        if ($request->ajax()) {
            return response()->json([
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'netAmount' => $netAmount,
                'data' => $data,
            ]);
        } else {
            return view('statistic.index', compact('data', 'totalIncome', 'totalExpense', 'netAmount'));
        }
    }

    private function getTotal($type, $category, $month)
    {
        return Record::where('type', $type)
            ->where('category_id', $category)
            ->whereYear('datetime', Carbon::createFromFormat('Y-m', $month)->year)
            ->whereMonth('datetime', Carbon::createFromFormat('Y-m', $month)->month)
            ->sum('amount');
    }

    // public function getTableData(Request $request)
    // {
    //     $user = Auth::user();
    //     $currentMonth = Carbon::now();
    //     $categories = Category::all();

    //     // Fetch records for the current month
    //     $records = Record::where('user_id', $user->id)
    //         ->whereBetween('datetime', [$currentMonth->startOfMonth(), $currentMonth->endOfMonth()])
    //         ->get();

    //     // Group records by category
    //     $groupedRecords = $records->groupBy('category_id');

    //     // Initialize variables
    //     $totalIncome = 0;
    //     $totalExpense = 0;

    //     $incomeCategory = $categories->where('name', 'Income')->first();
    //     $incomeCategoryId = $incomeCategory ? $incomeCategory->id : null;

    //     // Calculate total income and total expense
    //     foreach ($groupedRecords as $categoryId => $records) {
    //         $categoryTotal = $records->sum('amount');

    //         // Check if the category is 'Income' or not
    //         if ($categoryId == $incomeCategoryId) {
    //             $totalIncome += $categoryTotal;
    //         } else {
    //             $totalExpense += $categoryTotal;
    //         }
    //     }

    //     // Calculate net amount
    //     $netAmount = $totalIncome - $totalExpense;

    //     // Pass data to the view
    //     return response()->json([
    //         'totalIncome' => $totalIncome,
    //         'totalExpense' => $totalExpense,
    //         'netAmount' => $netAmount,
    //         'categories' => $categories,
    //         'currentMonth' => $currentMonth,
    //     ]);
    // }

    public function expense(Request $request)
    {

        return view('statistic.expense');
    }

    public function income(Request $request)
    {

        return view('statistic.income');
    }
}
