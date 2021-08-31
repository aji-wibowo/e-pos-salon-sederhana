<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Jurnal</title>
</head>

<body>
    <h3>Laporan Jurnal Tanggal {{ $date_from }} sampai {{ $date_to }}</h3>
    <table style="width: 100%; text-align: left">
        <<thead>
            <tr>
                <th align="left">ID</th>
                <th align="left">Kode Akun</th>
                <th align="left">Kas</th>
                <th align="left">Type</th>
                <th align="left">Status</th>
                <th align="left">Normal Saldo</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->account_code }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->type_of_account }}</td>
                        <td>{{ $u->account_status }}</td>
                        <td>{{ $u->normal_saldo }}</td>
                    </tr>
                @endforeach
            </tbody>
    </table>
</body>

</html>
