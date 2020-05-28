@extends('layouts.extended_app')

@section('content')
    <div class="container pl-1 pr-1">
        <form id="createProject" method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h2 style="display: inline-block">Tambah Proyek</h2>
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
                                    <label><b>Nama Proyek</b></label>
                                </td>
                                <td style="width: 85%">
                                    <input type="text" class="form-control required" name="name">
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td style="width:15%">
                                    <label><b>Deskripsi Proyek</b></label>
                                </td>
                                <td style="width:85%">
                                    <textarea class="form-control required" name="description"></textarea>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td style="width:15%">
                                    <label><b>Kontributor</b></label>
                                </td>
                                <td style="width:85%">
                                    <div id="inputContributorDiv">
                                        <span class="text-muted"><small><i>Minimal 1 Software Developer & 1 Business Owner</i></small></span>
                                        <div id="0">
                                            <input type="text" class="form-control contributor" name="contributor[]" style="width:50%; display:inline-block" value="{{ Auth::user()->username }}" readonly>
                                            <span class="text-muted pl-3" style="display:inline-block;">{{ Auth::user()->role }}</span>
                                            <button class="btn text-primary" id="addContributor" style="display:inline-block; float:right">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </div>
                                        <div id="1" class="mt-2">
                                            <input type="text" class="form-control contributor required"  id="input1" name="contributor[]" style="width:50%; display:inline-block">
                                            <span class="text-muted pl-3" style="display:none;"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('body_scripts')
    <script>
        var registered = [];

        $(document).ready(function() {
            registered.push({!! json_encode(auth()->user()->username) !!});

            var contributorDiv = $("#inputContributorDiv");
            var addButton = $("#addContributor");

            var i = 1;

            complete(i);

            $(addButton).click(function(e) {
                e.preventDefault();

                i++;

                var fill = '<div id="' + i + '" class="mt-2"><input type="text" class="form-control contributor required" id="input' + i + '" name="contributor[]" style="width:50%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span><button href="#" id="remove' + i + '" class="btn text-danger float-right"><i class="fas fa-minus-circle"></i></button></div>';

                $(contributorDiv).append(fill);

                buttonClick(i);
                complete(i);
            });

            $('#save').on('click', function(e) {
                e.preventDefault();
                if (!checkRequired()) return;

                if (checkContributor()) $('#createProject').submit();
            });
        });

        function buttonClick(id) {
            $('#remove' + id).on("click", function(e) {
                e.preventDefault();

                registered.splice($.inArray($('#input' + id).val(), registered),1);

                $('#' + id).remove();
            });
        }

        function complete(id) {
            $("#input" + id).autocomplete({
                source: function(request, response) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('get-all-user') }}',
                        type: "POST",
                        data: request.term,
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        success: function(data) {
                            response($.map(data, function(item) {
                                if (registered.indexOf(item.username) == -1) {
                                    return {
                                        label: item.username,
                                        value: item.username,
                                        desc: item.role,
                                        id: item.id
                                    }
                                } else return;
                            }));
                        },
                        error: function(xhr,textStatus,err) {
                            console.log("readyState: " + xhr.readyState);
                            console.log("responseText: "+ xhr.responseText);
                            console.log("status: " + xhr.status);
                            console.log("text status: " + textStatus);
                            console.log("error: " + err);
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    registered.push(ui.item.value);
                    $(this).parent('div').children('span').text(ui.item.desc);
                    $(this).parent('div').children('span').css('display', 'inline-block');
                }
            });
        }

        function checkRequired() {
            var check = true;
            $('.required').each(function(){
                if( $(this).val() == "" ){
                    alert('Seluruh kolom harus diisi');
                    check = false;
                    return false;
                }
            });
            return check;
        }

        function checkContributor() {
            var check = true;
            var isAnySoftwareDeveloper = false;
            var isAnyBusinessOwner = false;

            var users = {!! json_encode($users) !!};
            $('.contributor').each(function(i, v) {
                if (users.indexOf($(this).val()) == -1) {
                    alert('Terdapat username yang belum terdaftar');
                    check = false;
                    return false;
                }

                if ($(this).parent('div').children('span').text() == "Business Owner") {
                    isAnyBusinessOwner = true;
                } else if ($(this).parent('div').children('span').text() == "Software Developer") {
                    isAnySoftwareDeveloper = true;
                }
            });

            if ((!isAnyBusinessOwner) || (!isAnySoftwareDeveloper)) {
                alert('Harus terdapat paling sedikit 1 Software Developer dan 1 Business Owner');
                check = false;
            }

            return check;
        }
    </script>
@endpush
