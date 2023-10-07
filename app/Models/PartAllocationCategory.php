<?php

namespace App\Models;

use App\Models\PartAllocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartAllocationCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'pac_id';
    protected $fillable = [
        'allocation_id',
        'category_id',
    ];

    public function partAllocation()
    {
        return $this->belongsTo(PartAllocation::class, 'allocation_id');
    }
}
