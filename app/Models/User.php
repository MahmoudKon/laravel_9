<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'behalf_id',
        'image',
        'aggregator_id',
        'department_id',
        'annual_credit',
        'finger_print_id',
        'salary_per_monthly',
        'insurance_deduction',
        'email_verified_at',
        'remember_token',
        'mobile_token'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class)->select('id', 'title', 'manager_id', 'manager_of_manager_id');
    }

    public function aggregator()
    {
        return $this->belongsTo(Aggregator::class)->select('id', 'title');
    }

    public function behalf()
    {
        return $this->belongsTo(self::class, 'behalf_id')->select('id', 'name');
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value),
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value && file_exists('uploads/users/' . $value) ? "uploads/users/$value" : null,
        );
    }

    public function scopeFilter($query)
    {
        return $query->when(request('department'), function ($query) {
                        return $query->where('department_id', request('department'));
                    })->when(request()->name, function ($query) {
                        return $query->where('name', 'LIKE', "%".request()->name."%");
                    })->when(request()->email, function ($query) {
                        return $query->where('email', 'LIKE', "%".request()->email."%");
                    });
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions()->pluck('name')->toArray())
                ? true
                : false;
    }

    public function getPermissions($pluck_column = 'id')
    {
        return $this->permissions()->pluck($pluck_column)->toArray();
    }

    public function slug()
    {
        return $this->name;
    }
}
