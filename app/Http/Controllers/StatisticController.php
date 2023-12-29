<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Record;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ExpenseSharingGroup;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    /**
     *  Index page controller
     */
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

    /**
     *  Calculate total expense and income
     */
    private function getTotal($type, $category, $month)
    {
        $userId = Auth::user()->id;
        $currentSession = session('app.user_session_type', 'personal');

        return Record::userScope($userId, $currentSession)
            ->where('type', $type)
            ->where('category_id', $category)
            ->whereYear('datetime', Carbon::createFromFormat('Y-m', $month)->year)
            ->whereMonth('datetime', Carbon::createFromFormat('Y-m', $month)->month)
            ->sum('amount');
    }

    /**
     * Get daily records for a given type (Expense or Income).
     */
    private function calculateDailyRecords($type, $startDate, $endDate)
    {
        $userId = Auth::user()->id;
        $currentSession = session('app.user_session_type', 'personal');
        $dailyRecords = [];
        $currentDate = Carbon::parse($startDate);

        while ($currentDate->lte(Carbon::parse($endDate))) {
            $dailyRecord = Record::userScope($userId, $currentSession)
                ->whereDate('datetime', $currentDate->toDateString())
                ->where('type', $type)
                ->sum('amount');

            $dailyRecords[$currentDate->format('d M Y')] = $dailyRecord;

            $currentDate->addDay();
        }

        return $dailyRecords;
    }

    /**
     *  Expense or Income page controller
     */
    private function showStatisticPage($type, Request $request)
    {
        $startDate = $request->input('startDate', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('endDate', Carbon::now()->startOfMonth()->toDateString());

        $currentPeriodRecords = $this->calculateDailyRecords($type, $startDate, $endDate);

        $previousPeriodStartDate = Carbon::parse($startDate)->subMonth()->startOfMonth()->toDateString();
        $previousPeriodEndDate = Carbon::parse($endDate)->subMonth()->endOfMonth()->toDateString();
        $previousPeriodRecords = $this->calculateDailyRecords($type, $previousPeriodStartDate, $previousPeriodEndDate);

        if ($request->ajax()) {
            return response()->json([
                'currentPeriod' => $currentPeriodRecords,
                'previousPeriod' => $previousPeriodRecords,
            ]);
        } else {
            $viewName = "statistic.$type"; 
            return view($viewName, compact('currentPeriodRecords', 'previousPeriodRecords'));
        }
    }

    /**
     *  Expense page controller
     */
    public function expense(Request $request)
    {
        return $this->showStatisticPage('Expense', $request);
    }

    /**
     *  Income page controller
     */
    public function income(Request $request)
    {
        return $this->showStatisticPage('Income', $request);
    }
}
