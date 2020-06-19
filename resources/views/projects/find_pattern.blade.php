@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 pr-1">
        <div>
            <h2 style="display: inline-block">Daftar Pattern</h2>
            <a class="btn btn-danger float-right ml-2" href="{{ URL::previous() }}" style="display:inline-block">Batal</a>
            <a style="display: inline-block; float:right;" role="button" class="btn btn-primary float-right" href="{{ route('project.skip_pattern', [$project_id]) }}">Skip</a>
        </div>
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 30%">Nama Pattern</th>
                <th scope="col" style="width: 20%">Kategori Pattern</th>
                <th style="width:5%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($patterns as $pattern)
                <form method="POST" action="{{ route('project.use_pattern') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project_id }}" />
                    <input type="hidden" name="pattern_id" value="{{ $pattern->id }}" />
                    <tr>
                        <td style="width: 30%">
                            <div>{{ $pattern->title }}</div>
                        </td>
                        <td style="width: 20%">
                            {{ $pattern->category }}
                        </td>
                        <td style="width: 5%">
                            <button class="btn btn-primary" type="submit">Gunakan</button>
                        </td>
                    </tr>
                </form>
            @endforeach
            </tbody>
        </table>


    </div>

@endsection
