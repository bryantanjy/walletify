<?php

namespace App\Models;

use App\Models\BudgetTemplate;
use App\Models\PartAllocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetTemplatePart extends Model
{
    use HasFactory;

    protected $primaryKey = 'part_id';
    protected $fillable = [
        'template_id',
        'part_name',
    ];

    public function template()
    {
        return $this->belongsTo(BudgetTemplate::class, 'template_id');
    }

    public function partAllocations()
    {
        return $this->hasMany(PartAllocation::class, 'part_id');
    }
}
