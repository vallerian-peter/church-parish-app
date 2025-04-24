<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function father()
    {
        return $this->hasMany(Baptism::class, 'father_member_id');
    }

    public function mother()
    {
        return $this->hasMany(Baptism::class, 'mother_member_id');
    }
}
