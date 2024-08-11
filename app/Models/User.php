<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $table = 'users';

    protected $perPage = 15;

    protected $fillable = [
        'id',
        'profile',
        'dni',
        'first_name',
        'last_name',
        'email',
        'password',
        'id_role_user',
        'privileges',
        'status',
        'id_role',
        'id_branch',
        'group_schedule_id',
        'supervisor_id',
        'email_access',
        'username',
        'created_by',
        'updated_by',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];


    static $rules = [
        'dni' => 'required|numeric|digits:8',
        'first_name' => 'required',
        'username' => 'required',
        'domain' => 'required',
        'last_name' => 'required',
        'id_role' => ['required', 'max:36'],
        'id_role_user' => ['required', 'uuid'],
        'id_branch' => ['required', 'uuid'],
        'group_schedule_id' => ['uuid'],
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'email_access' => 'array',
    ];


    public function role_position()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'id_branch');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'id_role_user');
    }

    public function privileges()
    {
        return $this->role->privileges;
    }

    public function hasGroup($key)
    {
        return in_array($key, array_map(function ($privilege) {
            return explode(':', $privilege)[0];
        }, $this->role->privileges));
    }

    public function has($key)
    {
        return in_array($key, $this->role->privileges);
    }

    public function isDev()
    {
        return $this->has('development');
    }

    public function groupSchedule()
    {
        return $this->hasOne(GroupSchedule::class, 'id', 'group_schedule_id');
    }

    public function supervisor()
    {
        return $this->hasOne(User::class, 'id', 'supervisor_id');
    }

    public function edas()
    {
        return $this->hasMany(Eda::class, 'id_user', 'id');
    }

    public function schedules()
    {
        $schedulesMatched = $this->groupSchedule->schedules;
        $customSchedules = Schedule::where('user_id', $this->id)->get();
        $allSchedules = $schedulesMatched->merge($customSchedules);

        $schedulesGenerated = [];

        foreach ($allSchedules as $schedule) {
            for ($date = Carbon::parse($schedule->start_date); $date->lte(Carbon::parse($schedule->end_date)); $date->addDay()) {

                $dayOfWeek = $date->dayOfWeek + 1;

                if ($dayOfWeek == 8) $dayOfWeek = 1;

                if (in_array((string)$dayOfWeek, $schedule->days)) {

                    $schedulesGenerated[] = [
                        'title' => $schedule->title,
                        'from' => Carbon::parse($schedule->from)->setDate($date->year, $date->month, $date->day)->format('Y-m-d H:i:s'),
                        'to' => Carbon::parse($schedule->to)->setDate($date->year, $date->month, $date->day)->format('Y-m-d H:i:s'),
                    ];
                }
            }
        }

        return $schedulesGenerated;
    }
}
