@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 pr-1">
        <form id="addBpmn" method="POST" action="{{ route('project.add_bpmn_pattern') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h2 style="display: inline-block">Tambah Pattern</h2>
                <a class="btn btn-danger float-right ml-2" href="{{ URL::previous() }}" style="display: inline-block">Batal</a>
                <button id="save" type="submit" class="btn btn-success float-right" style="display: inline-block">Simpan</button>
            </div>
            <div class="card pl-2 pr-2 mt-2">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <input class="form-control" name="last_process" type="hidden" value="BUSINESS_GOALS">
                        <tr class="form-group">
                            <td style="width: 15%">
                                <label><b>Title</b></label>
                            </td>
                            <td style="width: 85%">
                                <input type="text" name="title">
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td style="width:15%">
                                <label><b>Category</b></label>
                            </td>
                            <td style="width:85%">
                                <input type="text" name="category">
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td style="width:15%">
                                <label><b>Description</b></label>
                            </td>
                            <td style="width:85%">
                                <input type="text" name="description">
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td style="width:15%">
                                <label><b>Bpmn</b></label>
                            </td>
                            <td style="width:85%">
                                <input type="text" name="bpmn">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection
