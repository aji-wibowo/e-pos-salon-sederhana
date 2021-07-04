<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Transaksi</title>
</head>

<body>
    <h3>Laporan Transaksi Tanggal {{ $date_from }} sampai {{ $date_to }}</h3>
    <table style="width: 100%; text-align: left">
        <thead>
            <tr>
                <th align="left">ID</th>
                <th align="left">Nama Customer</th>
                <th align="left">Nama Kasir</th>
                <th align="left">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->customer->name }}</td>
                    <td>{{ $t->cashier->name }}</td>
                    <td>Rp. {{ $t->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
