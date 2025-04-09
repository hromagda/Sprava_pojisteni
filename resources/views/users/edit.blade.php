@extends('app')

@section('content')
    <div class="container py-4">
        <h1>Upravit roli uživatele</h1>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="role" class="form-label">Vyber roli</label>
                <select name="role" id="role" class="form-select">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Uložit</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Zpět</a>
        </form>
    </div>
@endsection
