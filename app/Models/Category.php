<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public function partAllocations()
    {
        return $this->belongsToMany(PartAllocation::class, 'category_part_allocation', 'category_id', 'part_allocation_id');
    }
}
