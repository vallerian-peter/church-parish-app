<?php

namespace App\Livewire;

use App\Models\Member;
use Illuminate\Support\Str;
use Livewire\Component;

class CheckMemberId extends Component
{
    public $inputMemberId = '';
    public $memberNameReturned = '';


    public function findMemberId()
    {
        if (!empty($this->inputMemberId)) {
            $member = Member::where('member_id', Str::trim($this->inputMemberId))->first();

            if ($member == null) {
                $this->memberNameReturned = "Hakuna mshirika mwenye namba '$this->inputMemberId'";
            } else {
                $this->memberNameReturned = "Jina: $member->firstname  $member->lastname ($member->member_id)";
            }
        } else {
            $this->memberNameReturned = '';
        }
    }


    public function render()
    {
        return view('livewire.check-member-id');
    }
}
