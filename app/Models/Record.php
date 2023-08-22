<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $primaryKey = 'record_id';
    protected $fillable = [
        'account_id',
        'category_id',
        'group_id',
        'record_type',
        'amount',
        'date',
        'time',
        'record_description',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }

    
}
