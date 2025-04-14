<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Export Reportu</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #444;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
<h2>Report sjednaných pojištění</h2>

@if(count($results))
    <table>
        <thead>
        <tr>
            <th>Pojištěnec</th>
            <th>Typ pojištění</th>
            <th>Částka</th>
            <th>Předmět</th>
            <th>Platnost od</th>
            <th>Platnost do</th>
            <th>Stav</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $row)
            <tr>
                <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                <td>{{ $row->insurance_name }}</td>
                <td>{{ $row->amount }}</td>
                <td>{{ $row->subject }}</td>
                <td>{{ \Carbon\Carbon::parse($row->valid_from)->format('d.m.Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($row->valid_to)->format('d.m.Y') }}</td>
                <td>{{ $row->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>Žádná data k zobrazení.</p>
@endif
</body>
</html>
