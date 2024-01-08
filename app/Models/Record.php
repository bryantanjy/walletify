<?php

namespace App\Models;

use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Record extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'expense_sharing_group_id',
        'type',
        'amount',
        'datetime',
        'description',
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('description', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('account', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('category', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        return $query;
    }

    public function scopeUserScope(Builder $query, $userId, $sessionType = 'personal')
    {
        if ($sessionType === 'personal') {
            return $query->where('user_id', $userId)->whereNull('expense_sharing_group_id');
        } else {
            // Get the active group id
            $activeGroupId = session('active_group_id');

            // Include records where the user_id is the current user and belongs to the active group
            return $query->where('expense_sharing_group_id', $activeGroupId);
        }
    }

    public function scopeDateRange(Builder $query, $startDate, $endDate)
    {
        return $query->whereBetween('datetime', [$startDate, $endDate]);
    }

    public function scopeSortedBy(Builder $query, $sort)
    {
        return ($sort === 'oldest') ? $query->orderBy('datetime', 'asc') : $query->orderBy('datetime', 'desc');
    }
}
