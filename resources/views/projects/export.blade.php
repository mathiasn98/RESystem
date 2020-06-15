@extends('layouts.extended_app')
@section('content')
    <div class="form">
        <form id="submitDownload" action="{{ route('project.download', ['project_id', $project->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="html" name="html">
        </form>
    </div>

    <div id="cbp-canvas" style="width: 1200px; height: 600px"></div>
    <div id="fbp-canvas" style="width: 1200px; height: 600px"></div>

    <input id="cbp-bpmn-value" style="visibility: hidden" value="{{ $bpmn_cbp[0]['bpmn'] }}">
    <input id="fbp-bpmn-value" style="visibility: hidden" value="{{ $bpmn_fbp[0]['bpmn'] }}">

    <canvas id="cbp-bpmn-canvas" width="1200" height="600"></canvas>
    <canvas id="fbp-bpmn-canvas" width="1200" height="600"></canvas>


    <div id="container-drawer"></div>

    <div id="download" class="content">
        <h1><b>Proyek:</b> {{ $project->name }}</h1>

        <div>
            <div class="text-muted">
                <small>
                    <span>Dibuat pada <b>{{ $project->created_at }}</b> oleh <b>{{ $project->created_by }}</b></span>
                    <br>
                    <span>Terakhir diubah pada <b>{{ $project->updated_at }}</b> oleh <b>{{ $project->updated_by }}</b></span>
                </small>
            </div>
        </div>

        <input id="bpmn-value" name="bpmn" type="hidden"
               value='{{ $bpmn_cbp }}' />

        <h2>Daftar Business Goals</h2>
        <ol class="list-group">
            @foreach($business_goals as $business_goal)
                <li class="list-group-item">
                    <div>{{ $business_goal }}</div>
                </li>
            @endforeach
        </ol>

        <h2></h2>

        <h2>Daftar Kebutuhan Fungsional</h2>
        <ol class="list-group">
            @foreach($requirements as $requirement)
                @if($requirement->type == "Functional")
                    <li class="list-group-item">
                        <div>{{ $requirement->requirement }}</div>
                    </li>
                @endif
            @endforeach
        </ol>

        <h2>Daftar Kebutuhan Non-Fungsional</h2>
        <ol class="list-group">
            @foreach($requirements as $requirement)
                @if($requirement->type == "Non-Functional")
                    <li class="list-group-item">
                        <div>{{ $requirement->requirement }}</div>
                    </li>
                @endif
            @endforeach
        </ol>

        <h2>Current Business Process</h2>
        <div>
            <img id="cbp-img-png" style="width: 800px">
        </div>

        <h2>Future Business Process</h2>
        <div>
            <img id="fbp-img-png" style="width: 800px">
        </div>
    </div>
@endsection

@push('body_scripts')
    <script type="text/javascript" src="https://unpkg.com/canvg@3.0.4/lib/umd.js"></script>
    <script type="text/javascript" src="/bpmn-import/app.js"></script>
    <script type="text/javascript">
        var $j = jQuery.noConflict();

            $j(document).ready(function() {
                $j('#html').val($j('#download').html());
                $j('#submitDownload').submit();
            });
    </script>
@endpush

@push('head_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endpush
</html>
