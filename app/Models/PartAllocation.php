<?php

namespace App\Models;

use App\Models\Budget;
use App\Models\CategoryPartAllocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartAllocation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'budget_id',
        'name',
        'amount',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id', 'id');
    }

    public function categoryPartAllocations()
    {
        return $this->hasMany(CategoryPartAllocation::class, 'part_allocation_id');
    }
}
