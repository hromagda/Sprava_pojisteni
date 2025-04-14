@extends('app')

@section('content')
    <div class="container">
        <h2>Reporty</h2>

        <form method="GET" action="{{ route('reports.index') }}" class="mb-4">
            <div class="row g-3">

                {{-- Typ pojištění --}}
                <div class="col-md-3">
                    <label for="insurance_id" class="form-label">Typ pojištění</label>
                    <select name="insurance_id" class="form-select">
                        <option value="">-- Vyberte --</option>
                        @foreach ($insurances as $insurance)
                            <option value="{{ $insurance->id }}" {{ request('insurance_id') == $insurance->id ? 'selected' : '' }}>
                                {{ $insurance->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pojištěnec --}}
                <div class="col-md-3">
                    <label for="insured_person_id" class="form-label">Pojištěnec</label>
                    <select name="insured_person_id" class="form-select">
                        <option value="">-- Vyberte --</option>
                        @foreach ($insuredPeople as $person)
                            <option value="{{ $person->id }}" {{ request('insured_person_id') == $person->id ? 'selected' : '' }}>
                                {{ $person->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Datum od --}}
                <div class="col-md-2">
                    <label for="from" class="form-label">Od</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                {{-- Datum do --}}
                <div class="col-md-2">
                    <label for="to" class="form-label">Do</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                {{-- Stav pojištění --}}
                <div class="col-md-2">
                    <label for="status" class="form-label">Stav</label>
                    <select name="status" class="form-select">
                        <option value="">-- Vše --</option>
                        <option value="aktivní" {{ request('status') == 'aktivní' ? 'selected' : '' }}>Aktivní</option>
                        <option value="ukončené" {{ request('status') == 'ukončené' ? 'selected' : '' }}>Ukončené</option>
                        <option value="archivované" {{ request('status') == 'archivované' ? 'selected' : '' }}>Archivované</option>
                        <option value="nadcházející" {{ request('status') == 'nadcházející' ? 'selected' : '' }}>Nadcházející</option>
                    </select>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Vyhledat</button>
                </div>
            </div>
        </form>

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
