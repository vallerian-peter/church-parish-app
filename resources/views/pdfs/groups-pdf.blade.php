<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Groups Pdf</title>
</head>
<body>
<div style="text-align: center; font-size: 40px; font-weight: bold;">Vikundi Vyote</div>
<div style="font-size: 20px; color: #656565; text-align: center; padding-bottom: 30px; padding-top: 10px;">Parokia ya Kanisa</div>

<table width="100%" cellpadding="5" cellspacing="0" style="border-collapse: collapse; border: 1px solid #000;">
    <thead>
        <tr style="background-color: #000; color: #fff; padding: 10px 2px;">
            <th style="border: 1px solid #000;">#</th>
            <th style="border: 1px solid #000;">Jina la Kikundi</th>
            <th style="border: 1px solid #000;">Alie Kiunda</th>
            <th style="border: 1px solid #000;">Hali ya Kikundi</th>
            <th style="border: 1px solid #000;">Tarehe ya Kuundwa</th>
        </tr>
    </thead>
    <tbody>
    @foreach($groups as $index => $group)
        <tr style="background-color: {{ $index % 2 === 0 ? '#f2f2f2' : '#fff' }}; padding: 10px 2px;">
            <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $group->name }}</td>
            <td style="border: 1px solid #000;">{{ $group->user->name .'('. $group->user->user_type .')' }}</td>
            <td style="border: 1px solid #000;">{{ $group->status }}</td>
            <td style="border: 1px solid #000;">{{ $group->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
