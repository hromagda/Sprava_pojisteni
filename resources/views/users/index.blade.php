@extends('app')

@section('content')
    <div class="container py-4">
        <h1>Správa uživatelů</h1>

        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>Jméno</th>
                <th>Email</th>
                <th>Role</th>
                <th>Akce</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->join(', ') }}</td>
                    <td>
                        @can('edit users')
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">Upravit roli</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
