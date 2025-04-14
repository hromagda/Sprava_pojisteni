@extends('app')

@section('content')
    <div class="container mt-4">
    <h1>Seznam pojištěnců</h1>

    <!-- Zobrazíme hlášku o úspěchu, pokud je k dispozici -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @role('admin|agent')
    <a href="{{ route('insuredPersons.create') }}" class="btn btn-primary">Přidat pojištěnce</a>
    @endrole

    <table class="table mt-3">
        <thead>
        <tr>
            <th>Jméno</th>
            <th>Email</th>
            <th>Datum narození</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($insuredPersons as $insuredPerson)
            <tr>
                <td>
                    <a href="{{ route('insuredPersons.show', $insuredPerson->id) }}">
                        {{ $insuredPerson->first_name }} {{ $insuredPerson->last_name }}
                    </a>
                </td>
                <td>{{ $insuredPerson->email }}</td>
                <td>{{ $insuredPerson->birth_date ? $insuredPerson->birth_date->format('d.m.Y') : '' }}</td>
                <td>
                    @role('admin|agent')
                    <a href="{{ route('insuredPersons.edit', $insuredPerson->id) }}" class="btn btn-warning btn-sm">Upravit</a>
                    @endrole

                    @role('admin|agent')
                        <form action="{{ route('insuredPersons.destroy', $insuredPerson->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Opravdu chcete smazat tohoto pojištěnce?')">Smazat</button>
                    </form>
                    @endrole
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>


    <!-- Paginace -->
    <div class="mt-3">
        {{ $insuredPersons->links() }}  <!-- zobrazí se odkazy na stránky -->
    </div>
    </div>

@endsection
