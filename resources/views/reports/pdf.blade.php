@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Reporty</h2>


        @if(count($results))
            <div class="mb-3">
                <a href="{{ route('reports.export.csv', request()->all()) }}" class="btn btn-success me-2">Export do CSV</a>
                <a href="{{ route('reports.export.pdf', request()->all()) }}" class="btn btn-danger">Export do PDF</a>
            </div>

            <table class="table table-bordered">
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
        @endif
    </div>
@endsection
