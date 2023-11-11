<?php

namespace App\Models;

use App\Models\Category;
use App\Models\PartAllocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryPartAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_allocation_id',
        'category_id',
    ];

    public function allocation()
    {
        return $this->belongsTo(PartAllocation::class, 'part_allocation_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
