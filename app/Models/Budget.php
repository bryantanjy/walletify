<?php

namespace App\Models;

use App\Models\User;
use App\Models\PartAllocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'user_id',
        'expense_sharing_group_id',
    ];

    protected static function boot()
    {
        parent::boot();

        // Attach an event listener to the deleting event
        static::deleting(function ($budget) {
            // Delete associated PartAllocations
            $budget->partAllocations()->each(function ($partAllocation) {
                $partAllocation->partCategories()->detach();
                // Delete the PartAllocation
                $partAllocation->delete();
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function partAllocations()
    {
        return $this->hasMany(PartAllocation::class, 'budget_id');
    }

    public function scopeUserScope(Builder $query, $userId, $sessionType = 'personal')
    {
        if ($sessionType === 'personal') {
            return $query->where('user_id', $userId)->whereNull('expense_sharing_group_id');
        } else {
            // Get the active group id
            $activeGroupId = session('active_group_id');
    
            // Get the ids of all users in the active group
            $groupUserIds = ExpenseSharingGroup::find($activeGroupId)->members->pluck('id');
    
            // Include records where the user_id is in the groupUserIds array and the expense_sharing_group_id matches the active group id
            return $query->whereIn('user_id', $groupUserIds)->where('expense_sharing_group_id', $activeGroupId);
        }
    }
}
