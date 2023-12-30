<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class GroupMember extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'group_members'; // Set the table name explicitly

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(ExpenseSharingGroup::class, 'expense_sharing_group_id');
    }
}
