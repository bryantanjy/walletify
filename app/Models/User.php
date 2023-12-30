<?php

namespace App\Models;

use App\Models\Record;
use App\Models\Account;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use App\Models\ExpenseSharingGroup;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'user_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(ExpenseSharingGroup::class, 'group_members', 'expense_sharing_group_id', 'user_id');
    }

    public function assignRole(Role $role, $groupId)
    {
        // Check if the user already has the role within this group
        if (!$this->hasRole($role->name, $groupId)) {
            // Assign the role within the context of this group
            $this->roles()->attach($role, ['model_id' => $groupId, 'model_type' => ExpenseSharingGroup::class]);
        }
    }
}
