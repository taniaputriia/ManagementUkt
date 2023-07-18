<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembayaran Lunas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <img src="" width="100px">
    <h5 class="text-center">Laporan Pembayaran Lunas</h5>
    <br>

    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Semester</th>
                <th>Nomor Rekening</th>
                <th>UKT</th>

                <th>Status</th>

            </tr>
        </thead>
        <tbody class="text-center">
            @php
                $i = 1;
            @endphp
            @forelse ($data as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item ['student']['nim'] }}</td>
                    <td>{{ $item ['student']['name'] }}</td>
                    <td>{{ $item ['semester']}}</td>
                    <td>{{ $item ['va_number'] }}</td>
                    <td>{{ $item ['tuition_fee'] }}</td>

                    <td>{{ $item ['status'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data Tidak Ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>

