<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Baptisms Pdf</title>
</head>
<body>
<div style="text-align: center; font-size: 40px; font-weight: bold;">Batizo Zote</div>
<div style="font-size: 20px; color: #656565; text-align: center; padding-bottom: 30px; padding-top: 10px;">Parokia ya Kanisa</div>

<table width="100%" cellpadding="5" cellspacing="0" style="border-collapse: collapse; border: 1px solid #000;">
    <thead>
    <tr style="background-color: #000; color: #fff; padding: 10px 2px;">
        <th style="border: 1px solid #000;">#</th>
        <th style="border: 1px solid #000;">Jina la Baba (Namba)</th>
        <th style="border: 1px solid #000;">Jina la Mama (Namba)</th>
        <th style="border: 1px solid #000;">Jina la Mtoto</th>
        <th style="border: 1px solid #000;">Tarehe ya Kuzaliwa</th>
        <th style="border: 1px solid #000;">Umri</th>
        <th style="border: 1px solid #000;">Tarehe ya Kubatizwa</th>
        <th style="border: 1px solid #000;">Alie Unda</th>
        <th style="border: 1px solid #000;">Hali</th>
        <th style="border: 1px solid #000;">Tarehe ya Kuundwa</th>
    </tr>
    </thead>
    <tbody>
    @foreach($baptisms as $index => $baptism)
        <tr style="background-color: {{ $index % 2 === 0 ? '#f2f2f2' : '#fff' }}; padding: 10px 2px;">
            <td style="border: 1px solid #000;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->father->firstname .' '. $baptism->father->middlename .' '. $baptism->father->lastname .' ('.$member->father->member_id .')' }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->mother->firstname .' '. $baptism->mother->middlename .' '. $baptism->mother->lastname .' ('.$member->mother->member_id .')' }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->baby_firstname .' '. $baptism->baby_middlename .' '. $baptism->baby_lastname }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->dateOfBirth }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->age }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->dateOfBaptism }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->user->name .'('. $baptism->user->user_type .')' }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->status }}</td>
            <td style="border: 1px solid #000;">{{ $baptism->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
