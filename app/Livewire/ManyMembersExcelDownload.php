<?php

namespace App\Livewire;

use App\Exports\GroupsExport;
use App\Imports\MembersImport;
use App\Models\Group;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use function Laravel\Prompts\confirm;

class ManyMembersExcelDownload extends Component
{
    public $groups;

    public function mount()
    {
        $this->groups = Group::all();
    }

    public function exportGroups()
    {
        $groupsIds = $this->groups->pluck('id')->toArray();
        return (new GroupsExport($groupsIds))->download('orodha-ya-vikundi-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.many-members-excel-download');
    }
}
