<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAllocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'allocation_id';
    protected $fillable = [
        'budget_id',
        'category_id',
        'allocation_amount',
    ];
}
