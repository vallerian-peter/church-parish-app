<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users Pdf</title>
</head>
<body>
<div style="text-align: center; font-size: 40px; font-weight: bold;">Washirika Wote</div>
<div style="font-size: 20px; color: #656565; text-align: center; padding-bottom: 30px; padding-top: 10px;">Parokia ya Kanisa</div>

<table width="100%" cellpadding="5" cellspacing="0" style="border-collapse: collapse; border: 1px solid #000;">
    <thead>
    <tr style="background-color: #000; color: #fff; padding: 10px 2px;">
        <th style="border: 1px solid #000;">#</th>
        <th style="border: 1px solid #000;">Namba ya Mshirika</th>
        <th style="border: 1px solid #000;">Jina Kamili</th>
        <th style="border: 1px solid #000;">Tarehe ya Kuzaliwa</th>
        <th style="border: 1px solid #000;">Umri</th>
        <th style="border: 1px solid #000;">Jinsia</th>
        <th style="border: 1px solid #000;">Simu</th>
        <th style="border: 1px solid #000;">Mtaa</th>
        <th style="border: 1px solid #000;">Balozi</th>
        <th style="border: 1px solid #000;">Ni Mgeni?</th>
        <th style="border: 1px solid #000;">Kikundi</th>
        <th style="border: 1px solid #000;">Hali</th>
        <th style="border: 1px solid #000;">Tarehe ya Kuundwa</th>
    </tr>
    </thead>
    <tbody>
    @foreach($members as $index => $member)
        <tr style="background-color: {{ $index % 2 === 0 ? '#f2f2f2' : '#fff' }}; padding: 10px 2px;">
            <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $member->member_id }}</td>
            <td style="border: 1px solid #000;">{{ $member->firstname .' '. $member->middlename .' '. $member->lastname }}</td>
            <td style="border: 1px solid #000;">{{ $member->dateOfBirth }}</td>
            <td style="border: 1px solid #000;">{{ $member->age }}</td>
            <td style="border: 1px solid #000;">{{ $member->sex }}</td>
            <td style="border: 1px solid #000;">{{ $member->phone }}</td>
            <td style="border: 1px solid #000;">{{ $member->street }}</td>
            <td style="border: 1px solid #000;">{{ $member->ambassador }}</td>
            <td style="border: 1px solid #000;">
                @if($member->is_guest)
                    Ndio
                @else
                    Hapana
                @endif
            </td>
            <td style="border: 1px solid #000;">{{ $member->group->name }}</td>
            <td style="border: 1px solid #000;">{{ $member->status }}</td>
            <td style="border: 1px solid #000;">{{ $member->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
