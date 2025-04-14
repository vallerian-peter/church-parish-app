<?php

namespace App\Exports;

use App\Models\Group;
use App\Models\LeaderPosition;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class LeaderPositionsExport implements FromQuery
{
    use Exportable;
    protected $positions;

    public function __construct($positions)
    {
        $this->positions = $positions;
    }

    public function map($position): array
    {
        return [
            $position->id,
            $position->name,
            $position->user->name .' ('. Str::title($position->user->user_type).')',
            $position->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Jina la Nafasi',
            'Alie Unda',
            'Tarehe ya Kuundwa'
        ];
    }

    public function query()
    {
        return LeaderPosition::query()->whereKey($this->positions);
    }
}
