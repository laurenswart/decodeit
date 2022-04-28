<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'role_id',
        'password',
        'created_at',
        'last_connected'
    ];

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

    protected $table = 'users';

    /**
     * The role of the user
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The role of the user
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
          foreach ($roles as $role) {
              if ($this->hasRole($role)) {
                return true;
              }
          }
        } else {
          if ($this->hasRole($roles)) {
              return true;
          }
        }
        return false;
    }
    public function hasRole($role)
    {
        if ($this->role->name == $role) {
            return true;
        }
        return false;
    }

    public function isStudent(){
        return $this->role_id === 2;
    }

    public function isTeacher(){
        return $this->role_id === 1;
    }

    

    
}
