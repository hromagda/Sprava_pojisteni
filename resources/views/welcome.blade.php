@extends('app')

@section('content')
    <!-- Pohledy Uvod -->
    <section class="welcome-section">
        <div class="welcome-image">
            <div class="overlay">
                <h1>Vítejte v evidenci pojištění</h1>
            </div>
        </div>
        <div>
            <p class="welcome-text">Začněte s evidencí zde</p>
            <a href="{{ route('insuredPersons.create') }}" class="btn btn-primary btn-uvod">Zaeviduj pojištěnce</a>
        </div>
    </section>
@endsection
