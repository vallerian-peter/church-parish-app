<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'user_type',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
                              : static::where('id', 'like', '%'.$search.'%')
                                        ->orWhere('id', 'like', '%'.$search.'%')
                                        ->orWhere('firstname', 'like', '%'.$search.'%')
                                        ->orWhere('lastname', 'like', '%'.$search.'%')
                                        ->orWhere('email', 'like', '%'.$search.'%')
                                        ->orWhere('phone', 'like', '%'.$search.'%')
                                        ->orWhere('created_at', 'like', '%'.$search.'%');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function leaders()
    {
        return $this->hasMany(Member::class);
    }
    public function leaderPositions()
    {
        return $this->hasMany(LeaderPosition::class);
    }
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function baptism()
    {
        return $this->hasMany(Baptism::class);
    }
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
