<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderPosition extends Model
{
    protected $fillable = [
        'name',
        'user_id'
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->leftJoin('users', 'leader_positons.user_id', '=', 'users.id')
                ->where(function ($query) use ($search) {

                    // Standard search fields
                    $query->where('leader_positons.id', 'like', '%' . $search . '%')
                        ->orWhere('leader_positons.name', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('leader_positons.created_at', 'like', '%' . $search . '%');
                })
                ->select('leader_positons.*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leader()
    {
        return $this->hasMany(Leader::class);
    }
}
