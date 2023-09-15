<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetTemplatePart extends Model
{
    use HasFactory;

    protected $primaryKey = 'part_id';
    protected $fillable = [
        'template_id',
        'part_name',
        'amount',
    ];
}
