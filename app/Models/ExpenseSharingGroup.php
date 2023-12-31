<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseSharingGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'name', 'description'];

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')->withPivot('role_id')->withTimestamps();
    }


    public function invitations()
    {
        return $this->hasMany(GroupInvitation::class, 'expense_sharing_group_id');
    }
}
