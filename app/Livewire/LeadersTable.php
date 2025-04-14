<?php

namespace App\Livewire;

use App\Exports\GroupsExport;
use App\Exports\LeadersExport;
use App\Models\Group;
use App\Models\Leader;
use App\Models\LeaderPosition;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LeadersTable extends Component
{

    use withPagination;

    public $search = '';
    public $perPage = 5;
    public $isSelectedAll = false;
    public $selectedLeaders = [];
    public $selected = [];
    public $authUser;
    public $groups;
    public $leaderPositions;

    public $inputMemberId = '';
    public $memberNameReturned = '';


    public function mount()
    {
        $this->authUser = Auth::user();
        $this->groups = Group::all();
        $this->leaderPositions = LeaderPosition::all();
    }

    public function findMemberId()
    {
        if (!empty($this->inputMemberId)){
            $member = Member::where('member_id', 'like', '%'. $this->inputMemberId .'%')->first();
            if($member->isEmpty()){
                $this->memberNameReturned = "No member with no. '$this->inputMemberId' ";
            }else{
                $this->memberNameReturned = $member->name;
            }
        }else{
            $this->memberNameReturned = '';
        }
    }

    public function toggleSelectedAll()
    {
        $leaders = Leader::all();

        if ($this->isSelectedAll) {
            $this->selectedLeaders = $leaders->pluck('id')->toArray();
        } else {
            $this->selectedLeaders = [];
        }
    }

    public function deleteSelectedLeaders()
    {
        $this->selected = $this->selectedLeaders;
        Leader::destroy($this->selectedLeaders);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectedLeaders = [];

        if ($count === 1) {
            session()->flash('success', 'Kiongozi amefutwa kikamilifu');
        } elseif ($count > 1) {
            session()->flash('success', 'Viongozi wamefutwa kikamilifu');
        }
    }

    public function generatePdf()
    {
        $count = count($this->selectedLeaders);

        if ($count === 0) {
            $data = [
                'leaders' => Leader::all()
            ];
        } else {
            $data = [
                'leaders' => Leader::query()->whereKey($this->selectedLeaders)->get()
            ];
        }

        $pdf = Pdf::loadView('pdfs.leaders-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'orodha-ya-viongozi.pdf');
    }


    public function exportExcel()
    {
        $count = count($this->selectedLeaders);
        if ($count == 0) {
            $leaders = Leader::all();
            $leaderIds = $leaders->pluck('id')->toArray();
            return (new LeadersExport($leaderIds))->download('orodha-ya-viongozi-excel.xlsx');
        }

        return (new LeadersExport($this->selectedLeaders))->download('orodha-ya-vikundi-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.leaders-table', [
            'leaders' => Leader::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
