<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'user_id',
        'announcement_type',
        'description',
        'announcement_asset',
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->leftJoin('users', 'announcements.user_id', '=', 'users.id')
                ->where(function ($query) use ($search) {

                    // Standard search fields
                    $query->where('announcements.id', 'like', '%' . $search . '%')
                        ->orWhere('announcements.announcement_type', 'like', '%' . $search . '%')
                        ->orWhere('announcements.description', 'like', '%' . $search . '%')
                        ->orWhere('announcements.announcement_asset', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('announcements.created_at', 'like', '%' . $search . '%');
                })
                ->select('announcements.*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
