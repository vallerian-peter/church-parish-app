<?php

namespace App\Exports;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MembersExport implements FromQuery, WithMapping, WithHeadings, WithTitle
{
    use Exportable;
    protected $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function map($member): array
    {
        return [
            $member->id,
            $member->member_id,
            $member->firstname,
            $member->middlename,
            $member->lastname,
            $member->sex,
            $member->dateOfBirth,
            $member->phone,
            $member->age,
            $member->ambassador,
            $member->street,
            $member->is_guest == 1 ? 'Mgeni' : 'Simgeni',
            $member->group->name,
            $member->status,
            $member->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Namba ya Mshirika',
            'Jina la Kwanza',
            'Jina la Kati',
            'Jina la Mwisho',
            'Jinsia',
            'Tarehe ya Kuzaliwa',
            'Namba ya Simu',
            'Umri',
            'Balozi',
            'Mtaa',
            'Ni Mgeni?',
            'Kikundi',
            'Hali',
            'Tarehe ya Kuundwa'
        ];
    }

    public function title(): string
    {
        return 'Orodha ya Washirika wa Parokia';
    }

    public function query()
    {
        return Member::query()->whereKey($this->members);
    }
}
