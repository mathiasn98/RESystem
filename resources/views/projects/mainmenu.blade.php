@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 pr-1">
        <div class="jumbotron">
            <h2 class="display-4" style="display: inline-block">{{ $project->name }}</h2>
            <div class="text-muted">
                <small>
                    <span>Dibuat pada <b>{{ $project->created_at }}</b> oleh <b>{{ $project->created_by }}</b></span>
                    <p>Terakhir diubah pada <b>{{ $project->updated_at }}</b> oleh <b>{{ $project->updated_by }}</b></p>
                </small>
            </div>
            <p>
                <b>Kontributor: </b>
                @foreach ($contributors as $contributor)
                    @if ($loop->last)
                        <span>{{ $contributor->username }}</span>
                    @else
                        <span>{{ $contributor->username }},</span>
                    @endif
                @endforeach
            </p>
            <hr class="my-4">
            <span class="lead">{{ $project->description }}</span>
        </div>
{{--        {{ $project ?? 'Gaada' }}--}}
{{--        {{ $contributors ?? 'Gaada kontribusi' }}--}}
    </div>

    <div class="container pl-1 pr-1">
        <ul class="stepper linear">
            <li class="step active">
                <div class="step-title waves-effect">Business Goals</div>
                <div class="step-content">
                    <div>Definisi Business Goals</div>
                    <!-- Your step content goes here (like inputs or so) -->
                    <div class="step-actions">
                        <!-- Here goes your actions buttons -->
                        <button class="waves-effect waves-dark btn next-step">CONTINUE</button>
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Current Business Process</div>
                <div class="step-content">
                    <div>Unggah atau gambarkan proses bisnismu saat ini</div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        <button class="waves-effect waves-dark btn next-step">CONTINUE</button>
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Find Pattern</div>
                <div class="step-content">
                    <div>Cari pola untuk Proses Bisnismu</div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        <button class="waves-effect waves-dark btn next-step">CONTINUE</button>
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Future Business Process</div>
                <div class="step-content">
                    <div>Definisikan proses bisnis dari sistem yang ingin Anda buat</div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        <button class="waves-effect waves-dark btn next-step">CONTINUE</button>
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Persetujuan</div>
                <div class="step-content">
                    <div>Kebutuhan dapat diunduh pada link <a>berikut</a></div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        <button class="waves-effect waves-dark btn next-step">CONTINUE</button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
@endsection

@push('body_scripts')
    <script>
        var stepper = document.querySelector('.stepper');
        var stepperInstance = new MStepper(stepper, {
            firstActive: 0,
            linearStepsNavigation: true
        });
    </script>
@endpush

@push('head_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/materialize-stepper@3.1.0/dist/js/mstepper.min.js"></script>
@endpush

@push('head_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://unpkg.com/materialize-stepper@3.1.0/dist/css/mstepper.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
@endpush
