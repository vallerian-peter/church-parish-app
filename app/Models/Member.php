<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class Member extends Model
{
    protected $fillable  = [
        'user_id',
        'member_id',
        'firstname',
        'middlename',
        'lastname',
        'sex',
        'dateOfBirth',
        'age',
        'ambassador',
        'phone',
        'street',
        'is_guest',
        'group_id',
        'status'
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->leftJoin('groups', 'members.group_id', '=', 'groups.id')
                ->where(function ($query) use ($search) {
                    $guestMatch = null;
                    $lowerSearch = strtolower(trim($search));

                    // Flexible fuzzy match for variations of 'mgeni' and 'simgeni'
                    if (strpos('simgeni', $lowerSearch) !== false || strpos($lowerSearch, 'simgeni') !== false) {
                        $guestMatch = 0;
                    } elseif (strpos('mgeni', $lowerSearch) !== false || strpos($lowerSearch, 'mgeni') !== false) {
                        $guestMatch = 1;
                    }

                    // Standard search fields
                    $query->where('members.id', 'like', '%' . $search . '%')
                        ->orWhere('members.member_id', 'like', '%' . $search . '%')
                        ->orWhere('members.firstname', 'like', '%' . $search . '%')
                        ->orWhere('members.middlename', 'like', '%' . $search . '%')
                        ->orWhere('members.lastname', 'like', '%' . $search . '%')
                        ->orWhere('members.sex', 'like', '%' . $search . '%')
                        ->orWhere('members.dateOfBirth', 'like', '%' . $search . '%')
                        ->orWhere('members.age', 'like', '%' . $search . '%')
                        ->orWhere('members.ambassador', 'like', '%' . $search . '%')
                        ->orWhere('members.street', 'like', '%' . $search . '%')
                        ->orWhere('members.status', 'like', '%' . $search . '%')
                        ->orWhere('groups.name', 'like', '%' . $search . '%')
                        ->orWhere('members.created_at', 'like', '%' . $search . '%');

                    // Match is_guest field if user input looks like 'mgeni' or 'simgeni'
                    if (!is_null($guestMatch)) {
                        $query->orWhere('members.is_guest', '=', $guestMatch);
                    }
                })
                ->select('members.*');
    }


//    public static function search($search)
//    {
//        return empty($search) ? static::query()
//            : static::query()
//                ->leftJoin('groups', 'members.group_id', '=', 'groups.id')
//                ->where(function ($query) use ($search) {
//                    $guestValue = null;
//                    $lowerSearch = strtolower(trim($search));
//
//                    // Check if user typed "mgeni" or "simgeni"
//                    if ($lowerSearch === 'simgeni') {
//                        $guestValue = 0;
//                    } elseif ($lowerSearch === 'mgeni') {
//                        $guestValue = 1;
//                    }
//
//                    // Start building the query
//                    $query->where(function ($subQuery) use ($search) {
//                        $subQuery->where('members.id', 'like', '%' . $search . '%')
//                            ->orWhere('members.member_id', 'like', '%' . $search . '%')
//                            ->orWhere('members.firstname', 'like', '%' . $search . '%')
//                            ->orWhere('members.middlename', 'like', '%' . $search . '%')
//                            ->orWhere('members.lastname', 'like', '%' . $search . '%')
//                            ->orWhere('members.sex', 'like', '%' . $search . '%')
//                            ->orWhere('members.dateOfBirth', 'like', '%' . $search . '%')
//                            ->orWhere('members.age', 'like', '%' . $search . '%')
//                            ->orWhere('members.ambassador', 'like', '%' . $search . '%')
//                            ->orWhere('members.street', 'like', '%' . $search . '%')
//                            ->orWhere('members.status', 'like', '%' . $search . '%')
//                            ->orWhere('groups.name', 'like', '%' . $search . '%')
//                            ->orWhere('members.created_at', 'like', '%' . $search . '%');
//                    });
//
//                    // Only filter is_guest when appropriate
//                    if (!is_null($guestValue)) {
//                        $query->orWhere('members.is_guest', 'like', $guestValue);
//                    }
//                })
//                ->select('members.*');
//    }


//    public static function search($search)
//    {
//        return empty($search) ? static::query()
//            : static::query()
//                ->leftJoin('groups', 'members.group_id', '=', 'groups.id')
//                ->where(function ($query) use ($search) {
//                    // Handle 'Mgeni' and 'Siomgeni' keywords for is_guest
//                    $guestValue = null;
//                    if (stripos(strtolower($search), 'mgeni') !== false && stripos(strtolower($search), 'simgeni') === false) {
//                        $guestValue = 1;
//                    } elseif (stripos(strtolower($search), 'simgeni') !== false) {
//                        $guestValue = 0;
//                    }
//
//                    $query->where('members.id', 'like', '%' . $search . '%')
//                        ->orWhere('members.member_id', 'like', '%' . $search . '%')
//                        ->orWhere('members.firstname', 'like', '%' . $search . '%')
//                        ->orWhere('members.middlename', 'like', '%' . $search . '%')
//                        ->orWhere('members.lastname', 'like', '%' . $search . '%')
//                        ->orWhere('members.sex', 'like', '%' . $search . '%')
//                        ->orWhere('members.dateOfBirth', 'like', '%' . $search . '%')
//                        ->orWhere('members.age', 'like', '%' . $search . '%')
//                        ->orWhere('members.ambassador', 'like', '%' . $search . '%')
//                        ->orWhere('members.street', 'like', '%' . $search . '%')
//                        ->orWhere('members.status', 'like', '%' . $search . '%')
//                        ->orWhere('groups.name', 'like', '%' . $search . '%') // group name from joined table
//                        ->orWhere('members.created_at', 'like', '%' . $search . '%');
//
//                    // Apply guest filter only if keyword is matched
//                    if (!is_null($guestValue)) {
//                        $query->orWhere('members.is_guest', $guestValue);
//                    }
//                })
//                ->select('members.*');
//    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function leader(){
        return $this->hasMany(Leader::class);
    }
}
