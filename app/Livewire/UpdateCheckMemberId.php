<?php

namespace App\Livewire;

use App\Models\Leader;
use App\Models\Member;
use Illuminate\Support\Str;
use Livewire\Component;

class UpdateCheckMemberId extends Component
{
    public $inputMemberId = '';
    public $leaderId;
    public $leader;
    public $memberNameReturned = '';


    public function mount($leaderId)
    {
        $this->leaderId = $leaderId;
        $this->leader = Leader::with('member')->find($leaderId);

        if ($this->leader && $this->leader->member) {
            $this->inputMemberId = $this->leader->member->member_id;
        }
    }

    public function findMemberId()
    {
        if (!empty($this->inputMemberId)) {
            $member = Member::where('member_id', Str::trim($this->inputMemberId))->first();

            if (!$member) {
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
        return view('livewire.update-check-member-id');
    }
}
