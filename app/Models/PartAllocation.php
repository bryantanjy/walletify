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

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_part_allocation', 'part_allocation_id', 'category_id');
    }
}
