<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'age',
        'status'
    ];

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
