@extends('app')

@section('content')
    <h1>Upravit pojištěnce</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('insuredPersons.update', $insuredPerson->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="first_name">Jméno</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $insuredPerson->first_name) }}" required>
        </div>

        <div class="form-group">
            <label for="last_name">Příjmení</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $insuredPerson->last_name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $insuredPerson->email) }}" required>
        </div>

        <div class="form-group">
            <label for="birth_date">Datum narození</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $insuredPerson->birth_date) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $insuredPerson->phone) }}">
        </div>

        <div class="form-group">
            <label for="street">Ulice</label>
            <input type="text" name="street" id="street" class="form-control" value="{{ old('street', $insuredPerson->street) }}">
        </div>

        <div class="form-group">
            <label for="city">Město</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $insuredPerson->city) }}">
        </div>

        <div class="form-group">
            <label for="zip_code">PSČ</label>
            <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ old('zip_code', $insuredPerson->zip_code) }}">
        </div>

        <div class="form-group">
            <label for="photo">Fotografie</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Upravit pojištěnce</button>
    </form>
@endsection
