<?php

namespace App\Livewire;

use App\Exports\GroupsExport;
use App\Models\Group;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GroupsTable extends Component
{
    use withPagination;

    public $search = '';
    public $perPage = 5;
    public $isSelectedAll = false;
    public $selectedGroups = [];
    public $selected = [];
    public $authUser;

    public function mount()
    {
        $this->authUser = Auth::user();
    }

    public function toggleSelectedAll()
    {
        $groups = Group::all();

        if ($this->isSelectedAll) {
            $this->selectedGroups = $groups->pluck('id')->toArray();
        } else {
            $this->selectedGroups = [];
        }
    }

    public function deleteSelectedGroups()
    {
        $this->selected = $this->selectedGroups;
        Group::destroy($this->selectedGroups);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectedGroups = [];

        if ($count === 1) {
            session()->flash('success', 'Kikundi kimefutwa kikamilifu');
        } elseif ($count > 1) {
            session()->flash('success', 'Vikundi vimefutwa kikamilifu');
        }
    }

    public function generatePdf()
    {
        $count = count($this->selectedGroups);

        if ($count === 0) {
            $data = [
                'groups' => Group::all()
            ];
        } else {
            $data = [
                'groups' => Group::query()->whereKey($this->selectedGroups)->get()
            ];
        }

        $pdf = Pdf::loadView('pdfs.groups-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'orodha-ya-vikundi.pdf');
    }


    public function exportExcel()
    {
        $count = count($this->selectedGroups);
        if ($count == 0) {
            $groups = Group::all();
            $groupIds = $groups->pluck('id')->toArray();
            return (new GroupsExport($groupIds))->download('orodha-ya-vikundi-excel.xlsx');
        }

        return (new GroupsExport($this->selectedGroups))->download('orodha-ya-vikundi-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.groups-table', [
            'groups' => Group::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
