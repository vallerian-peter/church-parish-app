<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users Pdf</title>
</head>
<body>
<div style="text-align: center; font-size: 40px; font-weight: bold;">Wahusika Wote</div>
<div style="font-size: 20px; color: #656565; text-align: center; padding-bottom: 30px; padding-top: 10px;">Parokia ya Kanisa</div>

<table width="100%" cellpadding="5" cellspacing="0" style="border-collapse: collapse; border: 1px solid #000;">
    <thead>
    <tr style="background-color: #000; color: #fff; padding: 10px 2px;">
        <th style="border: 1px solid #000;">#</th>
        <th style="border: 1px solid #000;">Jina Kamili</th>
        <th style="border: 1px solid #000;">Barua Pepe</th>
        <th style="border: 1px solid #000;">Simu</th>
        <th style="border: 1px solid #000;">Aina ya Mhusika</th>
        <th style="border: 1px solid #000;">Tarehe ya Kuundwa</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $index => $user)
        <tr style="background-color: {{ $index % 2 === 0 ? '#f2f2f2' : '#fff' }}; padding: 10px 2px;">
            <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $user->name }}</td>
            <td style="border: 1px solid #000;">{{ $user->email }}</td>
            <td style="border: 1px solid #000;">{{ $user->phone }}</td>
            <td style="border: 1px solid #000;">{{ Str::title($user->user_type) }}</td>
            <td style="border: 1px solid #000;">{{ $user->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
