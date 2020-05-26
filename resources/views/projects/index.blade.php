@extends('layouts.app')
@section('content')
    <div class="container pl-1 pr-1">
        @if (count($projects) > 0)
            <div>
                <h2 style="display: inline-block">Daftar Proyek</h2>
                <a style="display: inline-block; float:right;" class="btn btn-success" href="#" role="button">Tambah Proyek</a>
            </div>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 30%">Nama Proyek</th>
                        <th scope="col" style="width: 20%">Tahap</th>
                        <th scope="col" style="width: 20%">Terakhir Diubah</th>
                        <th style="width:5%"></th>
                        <th style="width:5%"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td style="width: 30%">
                            <a class="btn btn-link" href="#">{{ $project->name }}</a>
                        </td>
                        <td style="width: 20%">
                            {{ $project->last_process }}
                        </td>
                        <td style="width: 20%">
                            {{ $project->updated_at }}
                        </td>
                        <td style="width: 7.5%">
                            <a class="btn btn-primary" href="#">Lihat</a>
                        </td>
                        <td style="width: 7.5%">
                            <a class="btn btn-danger" href="#">Hapus</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h2 style="display: inline-block">Anda tidak memiliki proyek</h2>
            <a style="display: inline-block; float:right;" class="btn btn-success" href="#" role="button">Tambah Proyek</a>
        @endif

    </div>

@endsection
