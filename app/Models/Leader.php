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
                ->leftJoin('users', 'leaders.user_id', '=', 'users.id')
                ->leftJoin('members', 'leaders.user_id', '=', 'members.member_id')
                ->leftJoin('groups', 'leaders.group_id', '=', 'groups.id')
                ->leftJoin('leader_positions', 'leaders.leader_position_id', '=', 'leader_positions.id')
                ->where(function ($query) use ($search) {
                    $query->where('leaders.id', 'like', '%' . $search . '%')
                        ->orWhere('members.firstname', 'like', '%' . $search . '%')
                        ->orWhere('members.middlename', 'like', '%' . $search . '%')
                        ->orWhere('members.lastname', 'like', '%' . $search . '%')
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
