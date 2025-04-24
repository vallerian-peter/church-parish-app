<?php

namespace App\Livewire;

use App\Exports\AnnouncementsExport;
use App\Models\Announcement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementsTable extends Component
{
    use withPagination;

    public $search = '';
    public $perPage = 5;
    public $isSelectedAll = false;
    public $selectedAnnouncements = [];
    public $selected = [];
    public $authUser;

    public function mount()
    {
        $this->authUser = Auth::user();
    }

    public function toggleSelectedAll()
    {
        $announcements = Announcement::all();

        if ($this->isSelectedAll) {
            $this->selectedAnnouncements = $announcements->pluck('id')->toArray();
        } else {
            $this->selectedAnnouncements = [];
        }
    }

    public function deleteSelectedGroups()
    {
        $this->selected = $this->selectedAnnouncements;
        Announcement::destroy($this->selectedAnnouncements);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectedAnnouncements = [];

        if ($count === 1) {
            session()->flash('success', 'Tangazo limefutwa kikamilifu');
        } elseif ($count > 1) {
            session()->flash('success', 'Matangazo yamefutwa kikamilifu');
        }
    }

    public function generatePdf()
    {
        $count = count($this->selectedAnnouncements);

        if ($count === 0) {
            $data = [
                'announcements' => Announcement::all()
            ];
        } else {
            $data = [
                'announcements' => Announcement::query()->whereKey($this->selectedAnnouncements)->get()
            ];
        }

        $pdf = Pdf::loadView('pdfs.announcements-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'orodha-ya-matangazo.pdf');
    }


    public function exportExcel()
    {
        $count = count($this->selectedAnnouncements);
        if ($count == 0) {
            $announcements = Announcement::all();
            $announcementIds = $announcements->pluck('id')->toArray();
            return (new AnnouncementsExport($announcementIds))->download('orodha-ya-matangazo-excel.xlsx');
        }

        return (new AnnouncementsExport($this->selectedAnnouncements))->download('orodha-ya-matangazo-excel.xlsx');
    }

    public function render()
    {
        return view('livewire.announcements-table', [
            'announcements' => Announcement::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
