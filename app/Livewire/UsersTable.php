<?php

namespace App\Livewire;

use App\Exports\UsersExport;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use withPagination;

    public $search = '';
    public $perPage = 5;
    public $isSelectedAll = false;
    public $selectedUsers = [];
    public $selected = [];

    public function toggleSelectedAll()
    {
        $users = User::all();

        if ($this->isSelectedAll) {
            $this->selectedUsers = $users->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function deleteSelectedUsers()
    {
        $this->selected = $this->selectedUsers;
        User::destroy($this->selectedUsers);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectedUsers = [];

        if ($count === 1) {
            session()->flash('success', 'Mhusika amefutwa kikamilifu');
        } elseif ($count > 1) {
            session()->flash('success', 'Wahusika wamefutwa kikamilifu');
        }
    }

    public function generatePdf()
    {
        $count = count($this->selectedUsers);

        if ($count === 0) {
            $data = [
                'users' => User::all()
            ];
        } else {
            $data = [
                'users' => User::query()->whereKey($this->selectedUsers)->get()
            ];
        }

        $pdf = Pdf::loadView('pdfs.users-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'orodha-ya-wahusika.pdf');
    }


    public function exportExcel()
    {
        $count = count($this->selectedUsers);
        if ($count == 0) {
            $users = User::all();
            $userIds = $users->pluck('id')->toArray();
            return (new UsersExport($userIds))->download('orodha-ya-wahusika-excel.xlsx');
        }

        return (new UsersExport($this->selectedUsers))->download('orodha-ya-wahusika-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.users-table', [
            'users' => User::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
