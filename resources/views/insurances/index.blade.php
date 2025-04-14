@extends('app')

@section('content')
    <div class="container mt-4">
    <h1>Přehled všech pojištění</h1>

    <form method="GET" action="{{ route('insurances.index') }}">
        <div class="mb-3">
            <label for="filter" class="form-label">Filtr pojištění</label>
            <select name="filter" id="filter" class="form-select">
                <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Všechna</option>
                <option value="valid" {{ $filter === 'valid' ? 'selected' : '' }}>Platná</option>
                <option value="expired" {{ $filter === 'expired' ? 'selected' : '' }}>Ukončená</option>
                <option value="upcoming" {{ $filter === 'upcoming' ? 'selected' : '' }}>Nadcházející</option>
                <option value="expiring_soon" {{ $filter === 'expiring_soon' ? 'selected' : '' }}>Expirující do 7 dnů</option>
                <option value="archived" {{ $filter === 'archived' ? 'selected' : '' }}>Archivovaná</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtruj</button>
    </form>

    <!-- Tabulka pojištění -->
    <table class="table">
        <thead>
        <tr>
            <th>Typ pojištění</th>
            <th>Pojištěný</th>
            <th>Částka</th>
            <th>Předmět pojištění</th>
            <th>Platnost od</th>
            <th>Platnost do</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($insurances as $insurance)
            @foreach ($insurance->insuredPersons as $person)
                <tr>

                    <td>{{ $insurance->name }}</td> <!-- Název pojištění -->
                    <td>{{ $person->name }}</td> <!-- Jméno pojištěnce -->
                    <td>{{ $person->pivot->amount }} Kč</td>
                    <td>{{ $person->pivot->subject }}</td>
                    <td>{{ \Carbon\Carbon::parse($person->pivot->valid_from)->format('d.m.Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($person->pivot->valid_to)->format('d.m.Y') }}</td>
                    <td>
                        @if ($person->pivot->status === 'archived')
                            <span class="badge bg-secondary">Archivováno</span>
                        @else
                            <span class="badge bg-success">Aktivní</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    </div>

    <!-- Paginace -->
    <div class="mt-3">
        {{ $insurances->appends(['filter' => $filter])->links() }}  <!-- Paginace s přidáním filtru do URL -->
    </div>
@endsection
