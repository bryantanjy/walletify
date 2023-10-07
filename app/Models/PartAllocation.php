<?php

namespace App\Models;

use App\Models\BudgetTemplatePart;
use App\Models\PartAllocationCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartAllocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'allocation_id';
    protected $fillable = [
        'part_id',
        'allocation_amount',
    ];

    public function budgetTemplatePart()
    {
        return $this->belongsTo(BudgetTemplatePart::class, 'part_id');
    }

    public function partAllocationCategories()
    {
        return $this->hasMany(PartAllocationCategory::class, 'allocation_id');
    }
}
