<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Baptism extends Model
{
    protected $fillable = [
        'user_id',
        'father_member_id',
        'mother_member_id',
        'baby_firstname',
        'baby_middlename',
        'baby_lastname',
        'dateOfBirth',
        'dateOfBaptism',
        'age',
        'status'
    ];


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->leftJoin('users', 'baptisms.user_id', '=', 'users.id')
                ->leftJoin('members', 'baptisms.father_member_id', '=', 'members.id')
                ->leftJoin('members', 'baptisms.mother_member_id', '=', 'members.id')
                ->where(function ($query) use ($search) {
                    $query->where('baptisms.id', 'like', '%' . $search . '%')
                        ->orWhere('members.firstname', 'like', '%' . $search . '%')
                        ->orWhere('members.middlename', 'like', '%' . $search . '%')
                        ->orWhere('members.lastname', 'like', '%' . $search . '%')
//                        ->orWhere('members.member_id', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.status', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.dateOfBaptism', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.baby_firstname', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.baby_middlename', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.baby_lastname', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.dateOfBirth', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.age', 'like', '%' . $search . '%')
                        ->orWhere('baptisms.created_at', 'like', '%' . $search . '%');
                })
                ->select('baptisms.*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function father()
    {
        return $this->belongsTo(Member::class, 'father_member_id');
    }

    public function mother()
    {
        return $this->belongsTo(Member::class, 'mother_member_id');
    }

}
