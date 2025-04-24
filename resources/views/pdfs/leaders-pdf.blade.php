<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Leaders Pdf</title>
</head>
<body>
<div style="text-align: center; font-size: 40px; font-weight: bold;">Viongozi Wote</div>
<div style="font-size: 20px; color: #656565; text-align: center; padding-bottom: 30px; padding-top: 10px;">Parokia ya Kanisa</div>

<table width="100%" cellpadding="5" cellspacing="0" style="border-collapse: collapse; border: 1px solid #000;">
    <thead>
    <tr style="background-color: #000; color: #fff; padding: 10px 2px;">
        <th style="border: 1px solid #000;">#</th>
        <th style="border: 1px solid #000;">Namba ya Mshirika</th>
        <th style="border: 1px solid #000;">Jina Kamili</th>
        <th style="border: 1px solid #000;">Nafasi</th>
        <th style="border: 1px solid #000;">Kikundi</th>
        <th style="border: 1px solid #000;">Alie Unda</th>
        <th style="border: 1px solid #000;">Hali ya Kikundi</th>
        <th style="border: 1px solid #000;">Tarehe ya Kuundwa</th>
    </tr>
    </thead>
    <tbody>
    @foreach($leaders as $index => $leader)
        <tr style="background-color: {{ $index % 2 === 0 ? '#f2f2f2' : '#fff' }}; padding: 10px 2px;">
            <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $leader->member->member_id }}</td>
            <td style="border: 1px solid #000;">{{ $leader->member->firstname .' '. $leader->member->middlename .' '. $leader->member->lastname }}</td>
            <td style="border: 1px solid #000;">{{ $leader->leaderPosition->name }}</td>
            <td style="border: 1px solid #000;">{{ $leader->group->name }}</td>
            <td style="border: 1px solid #000;">{{ $leader->user->name .'('. $leader->user->user_type .')' }}</td>
            <td style="border: 1px solid #000;">{{ $leader->status }}</td>
            <td style="border: 1px solid #000;">{{ $leader->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
