<?php

namespace App\Livewire;

use App\Models\Member;
use Illuminate\Support\Str;
use Livewire\Component;

class BaptismUpdateParentsCheckId extends Component
{
    public $inputFatherMemberId = '';
    public $inputMotherMemberId = '';
    public $fatherId;
    public $motherId;
    public $father;
    public $mother;
    public $fatherNameReturned = '';
    public $motherNameReturned = '';


    public function mount($fatherId, $motherId)
    {
        $this->fatherId = $fatherId;
        $this->motherId = $motherId;

        $this->father = Member::with('father')->find($fatherId);
        $this->mother = Member::with('mother')->find($motherId);

        if ($this->father && $this->father->father) {
            $this->inputFatherMemberId = $this->father->father->member_id;
        }

        if ($this->mother && $this->mother->mother) {
            $this->inputMotherMemberId = $this->mother->mother->member_id;
        }
    }

    public function findFatherMemberId()
    {
        if (!empty($this->inputFatherMemberId)) {
            $father = Member::where('member_id', Str::trim($this->inputFatherMemberId))
                ->where('sex', 'Mwanaume')
                ->first();

            if ($father == null) {
                $this->fatherNameReturned = "Hakuna baba mwenye namba '$this->inputFatherMemberId'";
            } else {
                $this->fatherNameReturned = "Baba: $father->firstname  $father->lastname ($father->member_id)";
            }
        } else {
            $this->fatherNameReturned = '';
        }
    }

    public function findMotherMemberId()
    {
        if (!empty($this->inputMotherMemberId)) {
            $mother = Member::where('member_id', Str::trim($this->inputMotherMemberId))
                ->where('sex', 'Mwanamke')
                ->first();

            if ($mother == null) {
                $this->motherNameReturned = "Hakuna mama mwenye namba '$this->inputMotherMemberId'";
            } else {
                $this->motherNameReturned = "Mama: $mother->firstname  $mother->lastname ($mother->member_id)";
            }
        } else {
            $this->motherNameReturned = '';
        }
    }

    public function render()
    {
        return view('livewire.baptism-update-parents-check-id');
    }
}
