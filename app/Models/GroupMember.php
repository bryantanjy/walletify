<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupMember extends Model
{
    use HasFactory;
    use HasRoles;

    protected $fillable = ['user_id', 'group_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(ExpenseSharingGroup::class);
    }
}
