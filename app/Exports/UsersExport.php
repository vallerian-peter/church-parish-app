<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersExport implements FromQuery, WithMapping, WithHeadings, WithTitle
{
    use Exportable;
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->phone,
            $user->email,
            $user->user_type,
            $user->created_at
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Jina Kamili',
            'Namba ya Simu',
            'Barua Pepe',
            'Aina ya Mhusika',
            'Tarehe ya Kuundwa'
        ];
    }

    public function title(): string
    {
        return 'Orodha ya Wahusika wa Parokia';
    }

    public function query()
    {
        return User::query()->whereKey($this->users);
    }
}
