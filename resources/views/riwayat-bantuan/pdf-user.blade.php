<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Riwayat Bantuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data Riwayat Bantuan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Bantuan</th>
                <th>tanggal_diterima</th>
                <th>keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item['no'] }}</td>
                    <td>{{ is_array($item['jenis_bantuan']) ? implode(', ', $item['jenis_bantuan']) : $item['jenis_bantuan'] }}</td>
                    <td>{{ $item['tanggal_diterima'] }}</td>
                    <td>{{ $item['keterangan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
