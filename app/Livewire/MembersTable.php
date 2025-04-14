<?php

namespace App\Livewire;

use App\Exports\MembersExport;
use App\Exports\UsersExport;
use App\Models\Group;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MembersTable extends Component
{
    use withPagination;

    public $groups;
    public $user;
    public $search = '';
    public $perPage = 5;
    public $isSelectedAll = false;
    public $selectedMembers = [];
    public $selected = [];

    public function mount()
    {
        $this->groups = Group::all();
        $this->user = Auth::user();
    }

    public function toggleSelectedAll()
    {
        $members = Member::all();

        if ($this->isSelectedAll) {
            $this->selectedMembers = $members->pluck('id')->toArray();
        } else {
            $this->selectedMembers = [];
        }
    }

    public function deleteSelectedMembers()
    {
        $this->selected = $this->selectedMembers;
        Member::destroy($this->selectedMembers);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectedMembers = [];

        if ($count === 1) {
            session()->flash('success', 'Mshirika amefutwa kikamilifu');
        } elseif ($count > 1) {
            session()->flash('success', 'Washirika wamefutwa kikamilifu');
        }
    }

    public function generatePdf()
    {
        $count = count($this->selectedMembers);

        if ($count === 0) {
            $data = [
                'members' => Member::all()
            ];
        } else {
            $data = [
                'members' => Member::query()->whereKey($this->selectedMembers)->get()
            ];
        }

        $pdf = Pdf::loadView('pdfs.members-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'orodha-ya-washirika.pdf');
    }


    public function exportExcel()
    {
        $count = count($this->selectedMembers);
        if ($count == 0) {
            $members = Member::all();
            $memberIds = $members->pluck('id')->toArray();
            return (new MembersExport($memberIds))->download('orodha-ya-washirika-excel.xlsx');
        }

        return (new UsersExport($this->selectedMembers))->download('orodha-ya-washirika-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.members-table', [
            'members' => Member::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
