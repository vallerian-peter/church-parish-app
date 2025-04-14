<?php

namespace App\Imports;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        $isGuest = strtolower(trim($row[9])) === 'ndio';

        // Guest validations
        if ($isGuest && ($row[7] || $row[10])) {
            throw new \Exception("Mgeni hawezi kuwa na balozi au kikundi (Mstari wa ID: {$row[0]})");
        }

        if (!$isGuest && (empty($row[7]) || empty($row[10]))) {
            throw new \Exception("Si mgeni? Balozi na Kikundi vinahitajika (Mstari wa ID: {$row[0]})");
        }

        return new Member([
            'user_id' => Auth::id(),
            'member_id' => $row[0],
            'firstname' => Str::title(Str::lower($row[1])),
            'middlename' => Str::title(Str::lower($row[2] ?? '')),
            'lastname' => Str::title(Str::lower($row[3])),
            'sex' => $row[4],
            'dateOfBirth' => $row[5],
            'age' => Carbon::parse($row[5])->age,
            'phone' => $row[6],
            'ambassador' => $isGuest ? null : Str::title(Str::lower($row[7])),
            'street' => $row[8],
            'is_guest' => $isGuest,
            'group_id' => $isGuest ? null : $row[10],
            'status' => Str::title(Str::lower($row[11]))
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => 'required|unique:members,member_id',            // member_id
            '1' => 'required|string|max:50',                       // firstname
            '2' => 'nullable|string|max:50',                       // middlename
            '3' => 'required|string|max:50',                       // lastname
            '4' => 'required|in:Me,Mke',                           // sex
            '5' => 'required|date',                                // dateOfBirth
            '6' => 'required|string|max:20|unique:members,phone',  // phone
            '7' => 'nullable|string|max:100',                      // ambassador
            '8' => 'nullable|string|max:100',                      // street
            '9' => 'nullable|in:ndio,hapana',                      // is_guest
            '10' => 'nullable|integer',                             // group_id
            '11' => 'required|string|max:20',                       // status
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'Namba ya mshirika inahitajika.',
            '0.unique' => 'Namba ya mshirika tayari ipo.',
            '1.required' => 'Jina la kwanza linahitajika.',
            '3.required' => 'Jina la mwisho linahitajika.',
            '4.required' => 'Jinsia inahitajika.',
            '4.in' => 'Chagua jinsia kati ya Me au Mke.',
            '5.required' => 'Tarehe ya kuzaliwa inahitajika.',
            '5.date' => 'Tarehe ya kuzaliwa si sahihi.',
            '6.required' => 'Namba ya simu inahitajika.',
            '6.unique' => 'Namba ya simu tayari ipo.',
            '7.max' => 'Jina la balozi ni refu sana.',
            '8.max' => 'Jina la mtaa ni refu sana.',
            '9.in' => 'Thamani ya mgeni ni batili (inapaswa kuwa ndio au hapana).',
            '11.required' => 'Hali ya mshirika inahitajika.',
        ];
    }
}
