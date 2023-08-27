<?php

namespace App\Models;

use App\Models\User;
use App\Models\Record;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
    protected $primaryKey = 'account_id';
    protected $fillable = [
        'user_id',
        'account_type',
        'account_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'account_id', 'account_id');
    }
}
