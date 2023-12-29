<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupInvitation extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token'];

    public function group()
    {
        return $this->belongsTo(ExpenseSharingGroup::class);
    }
}
