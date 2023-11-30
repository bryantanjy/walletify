<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSharingGroup extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description'];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }
}
