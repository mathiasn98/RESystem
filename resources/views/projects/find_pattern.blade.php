@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 pr-1">
        <div>
            <h2 style="display: inline-block">Daftar Template</h2>
            <a class="btn btn-danger float-right ml-2" href="{{ URL::previous() }}" style="display:inline-block">Batal</a>
            @if($project->last_process == 'FIND_PATTERN')
                <a style="display: inline-block; float:right;" role="button" class="btn btn-primary float-right trigger-alert" href="{{ route('project.skip_pattern', [$project->id]) }}">Lewati</a>
            @endif
        </div>
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 30%">Nama Template</th>
                <th scope="col" style="width: 20%">Kategori Template</th>
                <th style="width:5%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($patterns as $pattern)
                <form method="POST" action="{{ route('project.use_pattern') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}" />
                    <input type="hidden" name="pattern_id" value="{{ $pattern->id }}" />
                    <tr>
                        <td style="width: 30%">
                            <div>{{ $pattern->title }}</div>
                        </td>
                        <td style="width: 20%">
                            {{ $pattern->category }}
                        </td>
                        <td style="width: 5%">
                            @if($project->last_process == 'FIND_PATTERN')
                                <button class="btn btn-primary" type="submit">Gunakan</button>
                            @endif
                        </td>
                    </tr>
                </form>
            @endforeach
            </tbody>
        </table>


    </div>

@endsection

@push('body_scripts')
    <script>
        $(document).ready(function() {
            $('.trigger-alert').confirm({
                title: "Lewati penggunaan template?",
                content: "Anda akan menggambarkan proses bisnis tanpa menggunakan template"
            });
        });
    </script>
@endpush

@push('head_scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endpush

@push('head_styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endpush
