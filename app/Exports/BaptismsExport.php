<?php

namespace App\Exports;

use App\Models\Baptism;
use App\Models\Leader;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BaptismsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $baptisms;

    public function __construct($baptisms)
    {
        $this->baptisms = $baptisms;
    }

    public function map($baptism): array
    {
        return [
            $baptism->id,
            $baptism->father->firstname .' '. $baptism->father->middlename .' '. $baptism->father->lastname .' ('. $baptism->father->member_id .')',
            $baptism->mother->firstname .' '. $baptism->mother->middlename .' '. $baptism->mother->lastname .' ('. $baptism->mother->member_id .')',
            $baptism->baby_firstname .' '. $baptism->baby_middlename .' '. $baptism->baby_lastname,
            $baptism->dateOfBirth,
            $baptism->age,
            $baptism->dateOfBaptism,
            $baptism->user->name .' ('. Str::title($baptism->user->user_type).')',
            $baptism->status,
            $baptism->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Jina la Baba (Namba)',
            'Jina la Mama (Namba)',
            'Jina la Mtoto',
            'Tarehe ya Kuzaliwa',
            'Umri',
            'Tarehe ya Kubatizwa',
            'Alie Unda',
            'Hali',
            'Tarehe ya Kuundwa'
        ];
    }

    public function query()
    {
        return Baptism::query()->whereKey($this->baptisms);
    }
}
