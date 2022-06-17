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
     * The messages written by the user
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    /**
     * Determine if user has one of a list of roles
     * 
     * @param Array[String] Array of role names
     * @return Boolean True if user has one of the roles, false otherwise
     */
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

    /**
     * Determine if user has a certain role
     * 
     * @param String The role name
     * @return Boolean True if user has the role, false otherwise
     */
    public function hasRole($role)
    {
        if ($this->role->name == $role) {
            return true;
        }
        return false;
    }

    /**
     * Determine if user is a student
     * 
     * @return Boolean True if user is a student, false otherwise
     */
    public function isStudent(){
        return $this->role->name === 'student';
    }

    /**
     * Determine if user is a teacher
     * 
     * @return Boolean True if user is a teacher, false otherwise
     */
    public function isTeacher(){
        return $this->role->name === 'teacher';
    }

    

    
}
