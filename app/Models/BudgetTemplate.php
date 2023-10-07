<?php

namespace App\Models;

use App\Models\Budget;
use App\Models\BudgetTemplatePart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetTemplate extends Model
{
    use HasFactory;

    protected $primaryKey = 'template_id';
    protected $fillable = [
        'budget_id',
        'template_name',
        'is_default',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function parts()
    {
        return $this->hasMany(BudgetTemplatePart::class, 'template_id');
    }
}
