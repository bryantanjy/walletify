<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetTemplate extends Model
{
    use HasFactory;

    protected $primaryKey = 'template_id';
    protected $fillable = [
        'template_name',
        'is_default',
    ];

    public function budgets() {
        return $this->hasMany(Budget::class);
    }

    public function budgetTemplateParts() {
        return $this->hasMany(BudgetTemplatePart::class);
    }
}
