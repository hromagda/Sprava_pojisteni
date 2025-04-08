@extends('app')

@section('content')
    <h1>Detail pojištěnce</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h2>{{ $insuredPerson->first_name }} {{ $insuredPerson->last_name }}</h2>
            <p><strong>Email:</strong> {{ $insuredPerson->email }}</p>
            <p><strong>Telefon:</strong> {{ $insuredPerson->phone }}</p>
            <p><strong>Adresa:</strong> {{ $insuredPerson->street }}, {{ $insuredPerson->city }} {{ $insuredPerson->zip_code }}</p>
            <a href="{{ route('insuredPersons.edit', $insuredPerson->id) }}" class="btn btn-warning">Upravit</a>
        </div>
    </div>

    <h3 class="mt-4">Sjednaná pojištění</h3>


    <table class="table">
        <thead>
        <tr>
            <th>Typ</th>
            <th>Částka</th>
            <th>Předmět</th>
            <th>Platnost od</th>
            <th>Platnost do</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($assignedInsurances as $insurance)
            <tr>
                <td>{{ $insurance->name }}</td>
                <td>{{ $insurance->pivot->amount }} Kč</td>
                <td>{{ $insurance->pivot->subject }}</td>
                <td>{{ $insurance->pivot->valid_from->format('d.m.Y') }}</td>
                <td>{{ $insurance->pivot->valid_to->format('d.m.Y') }}</td>
                <td>
                    <a href="{{ route('insuredPersons.insurances.edit', [$insuredPerson->id, $insurance->id]) }}" class="btn btn-sm btn-warning">Upravit</a>
                    <form action="{{ route('insuredPersons.insurances.destroy', [$insuredPerson->id, $insurance->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu chcete odstranit toto pojištění?')">Odstranit</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('insuredPersons.insurances.create', $insuredPerson->id) }}" class="btn btn-primary">Přidat pojištění</a>
    <a href="{{ route('insuredPersons.edit', $insuredPerson->id) }}" class="btn btn-warning">Upravit pojištěnce</a>
    <form action="{{ route('insuredPersons.destroy', $insuredPerson->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Opravdu chcete odstranit tohoto pojištěnce?')">Odstranit pojištěnce</button>
    </form>
@endsection
