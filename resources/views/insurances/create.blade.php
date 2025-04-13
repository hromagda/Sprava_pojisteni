@extends('app')

@section('content')
    <h2 class="mb-4">
        {{ isset($assignedInsurance) ? 'Úprava pojištění' : 'Registrace pojištění' }}:
        {{ $insuredPerson->first_name }} {{ $insuredPerson->last_name }}
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ isset($assignedInsurance) ? route('insuredPersons.insurances.update', [$insuredPerson->id, $assignedInsurance->id]) : route('insuredPersons.insurances.store', $insuredPerson->id) }}">
        @csrf
        @isset($assignedInsurance)
            @method('PUT')  <!-- Pokud upravujeme, použijeme PUT -->
        @endisset

        <div class="mb-3">
            <label class="form-label">Typ pojištění:</label>
            <select name="insurance_id" class="form-select" required>
                @foreach ($insurances as $insurance)
                    <option value="{{ $insurance->id }}" {{ isset($assignedInsurance) && $assignedInsurance->id == $insurance->id ? 'selected' : '' }}>
                        {{ $insurance->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Částka:</label>
                <input type="number" name="amount" class="form-control" value="{{ old('amount', $assignedInsurance->pivot->amount ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Předmět pojištění:</label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject', $assignedInsurance->pivot->subject ?? '') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Platnost od:</label>
                <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from', $assignedInsurance->pivot->valid_from ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Platnost do:</label>
                <input type="date" name="valid_to" class="form-control" value="{{ old('valid_to', $assignedInsurance->pivot->valid_to ?? '') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Poznámka:</label>
            <textarea name="note" class="form-select"></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">{{ isset($assignedInsurance) ? 'Upravit pojištění' : 'Registrovat pojištění' }}</button>
        </div>
    </form>
@endsection
