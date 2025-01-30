<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasUuids;

    protected $table = 'users';

    protected $perPage = 25;

    protected $fillable = [
        'id',
        'photoURL',
        'documentId',
        'firstNames',
        'lastNames',
        'email',
        'password',
        'userRoleId',
        'customPrivileges',
        'status',
        'roleId',
        'branchId',
        'managerId',
        'username',
        'createdBy',
        'updatedBy',
        'entryDate',
        'fullName',
        'birthdate',
        'contractId',
        'displayName',
        'contacts',
        'edaInvitedAt',
        'requiredChangePassword'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    static $rules = [
        'documentId' => 'string|required',
        'firstNames' => 'string|required',
        'lastNames' => 'string|required',
        'managerId' => 'uuid|nullable',
        'email' => 'required|email',
        'username' => 'required',
        'roleId' => 'uuid|required',
        'birthdate' => 'date|nullable',
        'userRoleId' => 'uuid|required',
        'entryDate' => 'date|nullable',
        'contractTypeId' => 'uuid|required',
        'password' => 'required|min:8',
        'status' => 'boolean|required',
        'photoURL' => 'string|nullable',
        'customPrivileges' => 'array|nullable',
        'contacts' => 'array|nullable',
    ];

    protected $casts = [
        'password' => 'hashed',
        'entryDate' => 'date',
        'birthdate' => 'date',
        'contacts' => 'array',
        'customPrivileges' => 'array',
    ];

    public function historyEntries()
    {
        return $this->hasMany(HistoryUserEntry::class, 'roleId', 'id')->orderBy('created_at', 'desc');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'roleId');
    }

    public function department()
    {
        return $this->role->department;
    }

    public function area()
    {
        return $this->role->department->area;
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branchId');
    }

    public function createdUser()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function updatedUser()
    {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }

    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'id', 'userRoleId');
    }

    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'managerId');
    }

    public function hasPrivilege($privilege)
    {
        $rolePrivileges = $this->userRole->privileges ?? [];
        $customPrivileges = $this->customPrivileges ?? [];
        $allPrivileges = array_merge($rolePrivileges, $customPrivileges);

        if (in_array('development', $allPrivileges)) return true;
        return in_array($privilege, $allPrivileges);
    }

    public function isDeveloper()
    {
        return $this->hasPrivilege('development');
    }

    public function edas()
    {
        return $this->hasMany(Eda::class, 'userId', 'id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'managerId', 'id');
    }

    public function coworkers($limitCoworkers = 10)
    {
        $level = $this->role->job->level;
        $coworkers = User::whereHas('role', function ($query) use ($level) {
            $query->whereHas('job', function ($query) use ($level) {
                $query->where('level', $level);
            });
        })
            ->where('id', '!=', $this->id)
            ->limit($limitCoworkers)
            ->get();

        return $coworkers;
    }

    public function schedules()
    {
        return $this->hasMany(UserSchedule::class, 'userId', 'id')->where('archived', false);
    }

    public function contractType()
    {
        return $this->hasOne(UserContractType::class, 'id', 'contractTypeId');
    }
}
