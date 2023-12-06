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
    public function hasVerifiedEmail()
    {
        return $this->has_changed_email || parent::hasVerifiedEmail();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'profile_image',
        'is_online',
        'name_updated_at',
        'has_login_alerts',
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
        'has_changed_email' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ownedHome()
    {
        return $this->hasOne(Home::class, 'owner_id');
    }

    public function home()
    {
        return $this->hasOne(Home::class);
    }

    public function homes()
    {
        return $this->hasMany(Home::class, 'owner_id');
    }

    public function homeMembers()
    {
        return $this->hasMany(HomeMember::class, 'member_id');
    }
}