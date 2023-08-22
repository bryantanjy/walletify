<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

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
