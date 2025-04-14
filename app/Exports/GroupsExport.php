<?php

namespace App\Exports;

use App\Models\Group;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GroupsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $groups;

    public function __construct($groups)
    {
        $this->groups = $groups;
    }

    public function map($group): array
    {
        return [
            $group->id,
            $group->name,
            $group->user->name .' ('. Str::title($group->user->user_type).')',
            $group->status,
            $group->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Jina la Kikundi',
            'Alie Unda',
            'Hali',
            'Tarehe ya Kuundwa'
        ];
    }

    public function query()
    {
        return Group::query()->whereKey($this->groups);
    }

}
