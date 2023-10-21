<?php

namespace App\Models;

use App\Models\User;
use App\Models\BudgetTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $primaryKey = 'budget_id';
    protected $fillable = [
        'template_name',
        'user_id',
        'group_id',
    ];

    public function partAllocations()
    {
        return $this->hasMany(PartAllocation::class, 'budget_id');
    }
}
