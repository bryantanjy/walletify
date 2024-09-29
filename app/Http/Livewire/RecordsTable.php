<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Category;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RecordsTable extends Component
{
    use WithPagination;
    public $sort = 'latest';
    public $search = '';
    public $category = '';
    public $startDate;
    public $endDate;
    public $selectedCategories = [];
    public $selectedTypes = [];
    
    public function __construct() {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function sortBy($sortType)
    {
        $this->sort = $sortType;
    }

    public function render()
    {
        $user = Auth::user()->id;
        $currentSession = session('app.user_session_type', 'personal');

        return view(
            'livewire.records-table',
            [
                'records' => Record::with('category', 'user')
                    ->when($this->sort === 'category', fn ($query) => $query->join('categories', 'records.category_id', '=', 'categories.id')
                        ->orderBy('categories.name'))
                    ->when($this->sort === 'type', fn ($query) => $query->orderBy('type'))
                    ->when($this->sort === 'latesst', fn ($query) => $query->orderByDesc('records.datetime'))
                    ->when($this->sort === 'oldest', fn ($query) => $query->orderBy('records.datetime'))
                    ->when($this->sort === 'small_amount', fn ($query) => $query->orderBy('amount'))
                    ->when($this->sort === 'large_amount', fn ($query) => $query->orderByDesc('amount'))
                    ->when(count($this->selectedCategories) > 0, function($query) {
                        $query->whereIn('category_id', $this->selectedCategories);
                    })
                    ->when(count($this->selectedTypes) > 0, function($query) {
                        $query->whereIn('type', $this->selectedTypes);
                    })
                    ->userScope($user, $currentSession)
                    ->dateRange($this->startDate, $this->endDate)
                    ->search($this->search)
                    ->paginate(10),
                // 'totalBalance' => $this->,
                'categories' => Category::all(),
                'accounts' => ($currentSession === 'personal') ? Account::where('user_id', $user)->get() : collect(),
            ]
        );
    }
}
