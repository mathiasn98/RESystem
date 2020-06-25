@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 py-1" style="height: 600px">
        <form id="createCurrentBusinessProcess" method="POST" action="{{ route('project.save_business_process') }}">
            @csrf
            <div class="form-group">
                <h2 style="display: inline-block">Proses Bisnis Saat Ini</h2>
                @if (Auth::user()->role == 'Software Developer')
                    <a class="btn btn-primary float-right ml-2" href="{{ URL::previous() }}" style="display:inline-block">Kembali</a>
                @else
                    <a class="btn btn-danger float-right ml-2" href="{{ URL::previous() }}" style="display: inline-block">Batal</a>
                    @if($project->last_process == 'CBP')
                        <button id="save-button" type="submit" class="btn btn-success float-right" style="display: inline-block">Simpan</button>
                    @endif
                @endif
                <div>Gambarkan Proses Bisnis yang telah dijalankan di perusahaan</div>
            </div>
            <input id="this-noise" type="hidden" />
            <input id="bpmn-value" name="bpmn" type="hidden"
                   value='{{ $bpmn }}' />

            <input id="bpmn-type" name="type" type="hidden" value="CBP" />
            <input id="project-id" name="project_id" type="hidden" value="{{ $project->id }}" />

        </form>

        @if (Auth::user()->role == 'Software Developer')
            <input id="nav-bpmn-value" style="visibility: hidden" value="{{ $bpmn }}">
            <div id="nav-canvas" style="width: 1200px; height: 600px"></div>
        @else
            <div id="container-drawer">
        @endif

        </div>
    </div>

@endsection

@push('head_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endpush

@push('head_styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/bpmn-import/vendor/bpmn-js/assets/diagram-js.css" />
    <link rel="stylesheet" href="/bpmn-import/vendor/bpmn-js/assets/bpmn-font/css/bpmn-embedded.css" />
    <link rel="stylesheet" href="/bpmn-import/css/app.css" />
{{--    <link rel="stylesheet" href="/bpmn-import/css/normalize.css" />--}}
    <link rel="stylesheet" href="/bpmn-import/css/bpmn-js-token-simulation.css" />
@endpush

@push('body_scripts')
    <script type="text/javascript" src="/bpmn-import/app.js"></script>
@endpush
