<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $records = Record::where('user_id', $user->id)->get();
            $totalExpesne = 0;
            $totalIncome = 0;

            foreach ($records as $record) {
                if ($record->type === 'Expense') {
                    $totalExpesne += $record->amount;
                } else {
                    $totalIncome += $record->amount;
                }
            }

            $totalBalance = $totalIncome - $totalExpesne;

            $categories = Category::all();
            $accounts = Account::where('user_id', $user->id)->get();
            return view('record.index', compact('records', 'categories', 'accounts', 'totalBalance'));
        } else {
            return redirect('/login');
        }
    }

    // rendering datatable
    public function recordList()
    {
        $user = Auth::user();
        $records = Record::where('user_id', $user->id)->with('user', 'category')
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }, 'category' => function ($query) {
                $query->select('id', 'name');
            }])
            ->select(['id','user_id', 'category_id', 'type', 'datetime', 'description', 'amount'])
            ->get();


        return DataTables::of($records)
            ->addColumn('user', function (Record $record) {
                return $record->user->name;
            })
            ->addColumn('category', function (Record $record) {
                return $record->category->name;
            })
            ->addColumn('action', function (Record $record) {
                // Update Button
                $editButton = "<button class='editRecord' data-id='" . $record->id . "' ><i class='fa-solid fa-pen-to-square'></i></button>";

                // Delete Button
                $deleteButton = "<button class='deleteRecord' data-id='" . $record->id . "' data-bs-toggle='modal' data-bs-target='#deleteModal'><i class='fa-solid fa-trash'></i></button>";

                return $editButton . " " . $deleteButton;
            })
            ->make(true);
    }

    public function create()
    {
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();
        $categories = Category::all();

        return view('record.create', compact('accounts', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'account_id' => 'required',
                'category_id' => 'required',
                'type' => 'required|string',
                'amount' => 'required|numeric',
                'datetime' => 'required',
                'description' => 'nullable|string',
                'group_id' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $record = new Record;
            $record->account_id = $request->input('account_id');
            $record->category_id = $request->input('category_id');
            $record->user_id = auth()->id();
            $record->type = $request->input('type');
            $record->amount = $request->input('amount');
            $record->datetime = $request->input('datetime');
            $record->description = $request->input('description');
            $record->group_id = $request->input('group_id');
            $record->save();
        }
        return redirect()->route('record.index')->with('success', 'Record added successfully');
    }

    public function edit($recordId)
    {
        $record = Record::find($recordId);

        return response()->json($record);
    }

    public function update(Request $request, $recordId)
    {
        $record = Record::find($recordId);

        $validator = Validator::make(
            $request->all(),
            [
                'account_id' => 'required',
                'category_id' => 'required',
                'type' => 'required|string',
                'amount' => 'required|numeric',
                'datetime' => 'required',
                'description' => 'nullable|string',
                'group_id' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('record.edit')
                ->withErrors($validator);
        }

        $record->update([
            $record->user_id => $request->input('user_id'),
            $record->account_id => $request->input('account_id'),
            $record->category_id => $request->input('category_id'),
            $record->type => $request->input('type'),
            $record->amount => $request->input('amount'),
            $record->datetime => $request->input('datetime'),
            $record->description => $request->input('description'),
            $record->group_id => $request->input('group_id'),
        ]);

        return redirect()->route('record.index')->with('success', 'Record updated successfully');
    }

    public function delete(Record $record)
    {
        $userId = Auth::id();
        if ($record->user_id === $userId) {
            $record->delete();
        }
        return redirect()->route('record.index')->with('success', 'Record deleted successfully');
    }
}
