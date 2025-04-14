<?php

namespace App\Livewire;

use App\Exports\GroupsExport;
use App\Exports\LeaderPositionsExport;
use App\Models\Group;
use App\Models\LeaderPosition;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LeaderPositionsTable extends Component
{
    use withPagination;

    public $search = '';
    public $perPage = 5;
    public $isSelectedAll = false;
    public $selectedLeaderPositions = [];
    public $selected = [];
    public $authUser;

    public function mount()
    {
        $this->authUser = Auth::user();
    }

    public function toggleSelectedAll()
    {
        $positions = LeaderPosition::all();

        if ($this->isSelectedAll) {
            $this->selectedLeaderPositions = $positions->pluck('id')->toArray();
        } else {
            $this->selectedLeaderPositions = [];
        }
    }

    public function deleteSelectedLeaderPositions()
    {
        $this->selected = $this->selectedLeaderPositions;
        LeaderPosition::destroy($this->selectedLeaderPositions);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectedLeaderPositions = [];

        if ($count === 1) {
            session()->flash('success', 'Nafasi imefutwa kikamilifu');
        } elseif ($count > 1) {
            session()->flash('success', 'Nafasi zimefutwa kikamilifu');
        }
    }

    public function generatePdf()
    {
        $count = count($this->selectedLeaderPositions);

        if ($count === 0) {
            $data = [
                'positions' => LeaderPosition::all()
            ];
        } else {
            $data = [
                'positions' => LeaderPosition::query()->whereKey($this->selectedLeaderPositions)->get()
            ];
        }

        $pdf = Pdf::loadView('pdfs.positions-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'orodha-ya-nafasi-za-viongozi.pdf');
    }


    public function exportExcel()
    {
        $count = count($this->selectedLeaderPositions);
        if ($count == 0) {
            $positions = LeaderPosition::all();
            $positionsId = $positions->pluck('id')->toArray();
            return (new LeaderPositionsExport($positionsId))->download('orodha-ya-nafasi-za-viongozi-excel.xlsx');
        }

        return (new LeaderPositionsExport($this->selectedLeaderPositions))->download('orodha-ya-nafasi-za-viongozi-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.leader-positions-table', [
            'positions' => LeaderPosition::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
