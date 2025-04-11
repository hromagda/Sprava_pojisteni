@extends('app')

@section('content')
    <div class="container py-4">
        <h1>Správa uživatelů</h1>

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Přidat nového uživatele</a>

        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>Jméno</th>
                <th>Email</th>
                <th>Role</th>
                <th>Oprávnění</th>  <!-- Přidáme sloupec pro oprávnění -->
                <th>Akce</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->join(', ') }}</td>
                    <td>{{ $user->getPermissionsViaRoles()->pluck('name')->join(', ') }}</td>  <!-- Zde přidáme oprávnění -->
                    <td>
                        @can('edit users')
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">Upravit uživatele</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
