<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
    ];

    public function allocations()
    {
        return $this->belongsToMany(PartAllocation::class, 'part_allocation_categories', 'category_id', 'allocation_id');
    }
}
