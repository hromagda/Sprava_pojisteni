@extends('app')

@section('content')
    <h1>Detail pojištěnce</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Obrázek pojištěnce -->
        <div class="col-md-3 mb-4 d-flex justify-content-center mt-3">
            @if ($insuredPerson->photo)
                <img src="{{ asset('storage/' . $insuredPerson->photo) }}" alt="Fotka pojištěnce" class="img-fluid rounded mb-3">

            @else
                <img src="{{ asset('images/avatar.jpg') }}" alt="Bez fotografie" class="img-fluid rounded mb-3">
            @endif
        </div>

        <!-- Osobní údaje pojištěnce -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h2>{{ $insuredPerson->first_name }} {{ $insuredPerson->last_name }}</h2>
                    <p><strong>Email:</strong> {{ $insuredPerson->email }}</p>
                    <p><strong>Telefon:</strong> {{ $insuredPerson->phone }}</p>
                    <p><strong>Adresa:</strong> {{ $insuredPerson->street }}, {{ $insuredPerson->city }} {{ $insuredPerson->zip_code }}</p>
                </div>
            </div>
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
            <tr class="{{ $insurance->pivot->status === 'archived' ? 'table-secondary' : '' }}">
                <td>{{ $insurance->name }}</td>
                <td>{{ $insurance->pivot->amount }} Kč</td>
                <td>{{ $insurance->pivot->subject }}</td>
                <td>{{ $insurance->pivot->valid_from->format('d.m.Y') }}</td>
                <td>{{ $insurance->pivot->valid_to->format('d.m.Y') }}</td>
                <td>
                    @role('admin|agent')
                    <a href="{{ route('insuredPersons.insurances.edit', [$insuredPerson->id, $insurance->id]) }}" class="btn btn-sm btn-warning">Upravit</a>
                    @endrole
                    @role('admin|agent')
                    <form action="{{ route('insuredPersons.insurances.destroy', [$insuredPerson->id, $insurance->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu chcete odstranit toto pojištění?')">Odstranit</button>
                    </form>
                    @endrole
                    @role('admin|agent')
                    @if ($insurance->pivot->status === 'active')
                        <form action="{{ route('insuredPersons.insurances.archive', [$insuredPerson->id, $insurance->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Opravdu chcete archivovat toto pojištění?')">Archivovat</button>
                        </form>
                    @else
                        <form action="{{ route('insuredPersons.insurances.restore', [$insuredPerson->id, $insurance->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="btn btn-sm btn-success">Obnovit</button>
                        </form>
                    @endif
                    @endrole
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @role('admin|agent')
    <a href="{{ route('insuredPersons.insurances.create', $insuredPerson->id) }}" class="btn btn-primary">Přidat pojištění</a>
    @endrole
    @role('admin|agent')
    <a href="{{ route('insuredPersons.edit', $insuredPerson->id) }}" class="btn btn-warning">Upravit pojištěnce</a>
    @endrole
    @role('admin|agent')
    <form action="{{ route('insuredPersons.destroy', $insuredPerson->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Opravdu chcete odstranit tohoto pojištěnce?')">Odstranit pojištěnce</button>
    </form>
    @endrole
@endsection
