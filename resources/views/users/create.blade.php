@extends('app')

@section('content')
    <div class="container py-4">
        <h1>Přidat nového uživatele</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Jméno</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Vyber roli</label>
                <select name="role" id="role" class="form-select" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Uložit</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Zpět</a>
        </form>
    </div>
@endsection
