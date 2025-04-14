<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $fillable = [
        'user_id',
        'member_id',
        'group_id',
        'leader_position_id',
        'status'
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->leftJoin('users', 'leader.user_id', '=', 'users.id')
                ->leftJoin('members', 'leader.user_id', '=', 'members.member_id')
                ->leftJoin('groups', 'leader.group_id', '=', 'groups.id')
                ->leftJoin('leader_positions', 'leader.leader_positions_id', '=', 'leader_positions.id')
                ->where(function ($query) use ($search) {

                    // Standard search fields
                    $query->where('leaders.id', 'like', '%' . $search . '%')
                        ->orWhere('members.name', 'like', '%' . $search . '%')
                        ->orWhere('groups.name', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('leader_positions.name', 'like', '%' . $search . '%')
                        ->orWhere('leaders.status', 'like', '%' . $search . '%')
                        ->orWhere('leaders.created_at', 'like', '%' . $search . '%');
                })
                ->select('leaders.*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function leaderPosition()
    {
        return $this->belongsTo(LeaderPosition::class, 'leader_position_id');
    }
}
