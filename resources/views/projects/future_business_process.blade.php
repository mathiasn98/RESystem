@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 py-1" style="height: 600px">
        <form id="createCurrentBusinessProcess" method="POST" action="{{ route('project.save_business_process') }}">
            @csrf
            <div class="form-group">
                <h2 style="display: inline-block">Proses Bisnis Proyek</h2>
                <a class="btn btn-danger float-right" href="{{ URL::previous() }}" style="display: inline-block">Batal</a>
                @if($project->last_process == 'FBP' || $project->last_process == 'FIND_PATTERN')
                    <button id="save-button" type="submit" class="btn btn-success float-right mr-2" style="display: inline-block">Simpan</button>
                @endif
                <a class="btn btn-primary float-right mr-4" href="{{ route('project.duplicate_business_process', [$project->id]) }}" style="display: inline-block">Gunakan Proses Bisnis Saat Ini</a>
                <div>Gambarkan Proses Bisnis yang telah dijalankan di perusahaan</div>
                <div style="display: inline-block">Anda juga dapat menggunakan Proses Bisnis Saat Ini (Tahap 2)</div>
            </div>
            <input id="this-noise" type="hidden" />
            <input id="bpmn-value" name="bpmn" type="hidden"
                   value='{{ $bpmn }}' />

            <input id="bpmn-type" name="type" type="hidden" value="FBP" />
            <input id="project-id" name="project_id" type="hidden" value="{{ $project->id }}" />

        </form>

        <div id="container-drawer">

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
