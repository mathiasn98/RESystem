@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 pr-1">
        @if (count($projects) > 0)
            <div>
                <h2 style="display: inline-block">Daftar Proyek</h2>
                <a style="display: inline-block; float:right;" class="btn btn-success" href="{{ route('project.create') }}" role="button">Tambah Proyek</a>
            </div>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 25%">Nama Proyek</th>
                        <th scope="col" style="width: 25%">Tahap</th>
                        <th scope="col" style="width: 20%">Terakhir Diubah</th>
                        <th style="width:5%"></th>
                        <th style="width:5%"></th>
                        <th style="width:5%"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td style="width: 25%">
                            <a class="btn btn-link" href="{{ route('project.show', [$project->id]) }}">{{ $project->name }}</a>
                        </td>
                        <td style="width: 25%">
                            {{ $project->last_process }}
                        </td>
                        <td style="width: 20%">
                            {{ $project->updated_at }}
                        </td>
                        <td style="width: 5%">
                            <a class="btn btn-primary" href="{{ route('project.show', [$project->id]) }}">Lihat</a>
                        </td>
                        <td style="width:5%">
                            <a class="btn btn-secondary" href="{{ route('project.edit', [$project->id]) }}">Ubah</a>
                        </td>
                        <td style="width: 5%">
                            <form method="POST" action="{{ route('project.destroy', [$project->id]) }}" style="display:inline-block; float:right">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Apakah yakin untuk menghapus?')" href="{{ route('project.destroy', [$project->id]) }}">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h2 style="display: inline-block">Anda tidak memiliki proyek</h2>
            <a style="display: inline-block; float:right;" class="btn btn-success" href="{{ route('project.create') }}" role="button">Tambah Proyek</a>
        @endif

    </div>

@endsection
