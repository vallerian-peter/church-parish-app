<?php

namespace App\Livewire;

use App\Exports\BaptismsExport;
use App\Models\Baptism;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BaptismsTable extends Component
{
    use withPagination;

    public $search = '';
    public $perPage = 5;
    public $isSelectedAll = false;
    public $selectedBaptisms = [];
    public $selected = [];
    public $authUser;

    public $inputMemberId = '';
    public $memberNameReturned = '';


    public function mount()
    {
        $this->authUser = Auth::user();
    }

    // **********************************
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
        $baptisms = Baptism::all();

        if ($this->isSelectedAll) {
            $this->selectedBaptisms = $baptisms->pluck('id')->toArray();
        } else {
            $this->selectedBaptisms = [];
        }
    }

    public function deleteSelectedBaptisms()
    {
        $this->selected = $this->selectedBaptisms;
        Baptism::destroy($this->selectedBaptisms);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectedBaptisms = [];

        if ($count === 1) {
            session()->flash('success', 'Ubatizo umefutwa kikamilifu');
        } elseif ($count > 1) {
            session()->flash('success', 'Batizo zimefutwa kikamilifu');
        }
    }

    public function generatePdf()
    {
        $count = count($this->selectedBaptisms);

        if ($count === 0) {
            $data = [
                'baptisms' => Baptism::all()
            ];
        } else {
            $data = [
                'baptisms' => Baptism::query()->whereKey($this->selectedBaptisms)->get()
            ];
        }

        $pdf = Pdf::loadView('pdfs.baptisms-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'orodha-ya-ubatizo.pdf');
    }


    public function exportExcel()
    {
        $count = count($this->selectedBaptisms);
        if ($count == 0) {
            $baptisms = Baptism::all();
            $baptismIds = $baptisms->pluck('id')->toArray();
            return (new BaptismsExport($baptismIds))->download('orodha-ya-ubatizo-excel.xlsx');
        }

        return (new BaptismsExport($this->selectedBaptisms))->download('orodha-ya-ubatizo-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.baptisms-table', [
            'baptisms' => Baptism::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
