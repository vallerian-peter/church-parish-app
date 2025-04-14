<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status'
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->leftJoin('users', 'groups.user_id', '=', 'users.id')
                ->where(function ($query) use ($search) {

                    // Standard search fields
                    $query->where('groups.id', 'like', '%' . $search . '%')
                        ->orWhere('groups.name', 'like', '%' . $search . '%')
                        ->orWhere('groups.status', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('groups.created_at', 'like', '%' . $search . '%');
                })
                ->select('groups.*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member(){
        return $this->hasMany(Member::class);
    }

    public function leader(){
        return $this->hasMany(Leader::class);
    }
}
