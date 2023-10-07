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
        'user_id',
        'group_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function templates()
    {
        return $this->hasMany(BudgetTemplate::class, 'budget_id');
    }

    public function budgetTemplateParts()
    {
        return $this->hasManyThrough(BudgetTemplatePart::class, BudgetTemplate::class, 'budget_id', 'template_id', 'budget_id', 'template_id');
    }
}
