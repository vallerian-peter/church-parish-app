<?php

namespace App\Exports;

use App\Models\Leader;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeadersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $leaders;

    public function __construct($leaders)
    {
        $this->leaders = $leaders;
    }

    public function map($leader): array
    {
        return [
            $leader->id,
            $leader->member->member_id,
            $leader->member->firstname .' '. $leader->member->middlename .' '.  $leader->member->lasstname,
            $leader->leaderPosition->name,
            $leader->group->name,
            $leader->user->name .' ('. Str::title($leader->user->user_type).')',
            $leader->status,
            $leader->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Namba ya Mshirika',
            'Jina Kamili',
            'Nafasi',
            'Kikundi',
            'Alie Unda',
            'Hali',
            'Tarehe ya Kuundwa'
        ];
    }

    public function query()
    {
        return Leader::query()->whereKey($this->leaders);
    }

}
