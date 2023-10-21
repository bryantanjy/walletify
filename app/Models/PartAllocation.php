<?php

namespace App\Models;

use App\Models\BudgetTemplatePart;
use App\Models\PartAllocationCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartAllocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'part_allocation_id';
    protected $fillable = [
        'budget_id',
        'part_name',
        'allocation_amount',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function partAllocationCategories()
    {
        return $this->hasMany(PartAllocationCategory::class, 'part_allocation_id');
    }
}
