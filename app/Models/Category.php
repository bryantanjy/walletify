<?php

namespace App\Models;

use App\Models\CategoryPartAllocation;
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
    
    public function categoryPartAllocations()
    {
        return $this->hasMany(CategoryPartAllocation::class, 'category_id');
    }
}
