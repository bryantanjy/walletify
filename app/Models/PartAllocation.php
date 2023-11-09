<?php

namespace App\Models;

use App\Models\BudgetTemplatePart;
use App\Models\PartAllocationCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'name',
        'amount',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id', 'id');
    }

    public function partAllocationCategories()
    {
        return $this->hasMany(PartAllocationCategory::class, 'part_allocation_id');
    }
}
