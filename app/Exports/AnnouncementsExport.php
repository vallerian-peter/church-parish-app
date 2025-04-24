<?php

namespace App\Exports;

use App\Models\Announcement;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnnouncementsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $announcements;

    public function __construct($announcements)
    {
        $this->announcements = $announcements;
    }

    public function map($announcement): array
    {
        return [
            $announcement->id,
            $announcement->announcement_type,
            $announcement->description,
            $announcement->announcement_asset,
            $announcement->user->name .' ('. Str::title($announcement->user->user_type).')',
            $announcement->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Aina ya Tangazo',
            'Maelezo ya Tangazo',
            'Jina Faili (Faili la Tangazo)',
            'Alie Unda',
            'Tarehe ya Kuundwa'
        ];
    }

    public function query()
    {
        return Announcement::query()->whereKey($this->announcements);
    }

}
