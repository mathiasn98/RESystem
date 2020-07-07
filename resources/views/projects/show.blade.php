@extends('layouts.extended_app')
@section('content')
    <input id="lastProcessIndex" type="hidden" value="{{ $lastProcessIndex }}">
    <div class="container pl-1 pr-1">
        <div class="jumbotron">
            <h2 class="display-4" style="display: inline-block">{{ $project->name }}</h2>
            <div style="display:inline-block; float:right">
                <a class="btn btn-primary mr-2" href="{{ route('project.edit', [$project->id]) }}" style="display:inline-block; background-color: #3490dc">Ubah</a>
                <form method="POST" action="{{ route('project.destroy', [$project->id]) }}" style="display:inline-block; float:right">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" style="background-color: #e3342f" onclick="return confirm('Are you sure you want to delete this usere?');">Hapus</button>
                </form>
            </div>
            <div class="text-muted">
                <small>
{{--                    @if(Auth::user()->role == 'Software Developer')--}}
{{--                        <div>Ini software dev</div>--}}
{{--                    @else--}}
{{--                        <div>Ini business owner</div>--}}
{{--                    @endif--}}

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
    </div>

    <div class="container pl-1 pr-1">
        <ul class="stepper">
            <li class="step active">
                <div class="step-title waves-effect">Pendefinisian Tujuan Bisnis Proyek</div>
                <div class="step-content">
                    <div>Definisikan capaian yang diharapkan dalam proyek ini</div>
                    <div>Contoh:</div>
                    <ul><b>1.</b> Meningkatkan kepuasan konsumen</ul>
                    <ul><b>2.</b> Mendokumentasikan transaksi penjualan</ul>
                    <div class="step-actions">
                        <a class="btn btn-primary" href="{{ route('project.business_goals', [$project->id]) }}">LIHAT</a>
{{--                        <button class="waves-effect waves-dark btn next-step btn-primary">CONTINUE</button>--}}
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Penggambaran Proses Bisnis Saat Ini</div>
                <div class="step-content">
                    <div>Gambarkan proses bisnis yang telah berjalan di perusahaan</div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        @if($lastProcessIndex >= 1)
                            <a class="btn btn-primary" href="{{ route('project.current_business_process', [$project->id]) }}">LIHAT</a>
                        @else
                            <a class="btn btn-primary trigger-alert" href="#">LIHAT</a>
                        @endif
                        {{--                        <button class="waves-effect waves-dark btn next-step btn-primary">CONTINUE</button>--}}
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Gunakan Template</div>
                <div class="step-content">
                    <div>Pilih dan gunakan template proses bisnis yang telah kami sediakan</div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        @if($lastProcessIndex >=2)
                            <a class="btn btn-primary" href="{{ route('project.find_pattern', [$project->id]) }}">LIHAT</a>
                        @else
                            <a class="btn btn-primary trigger-alert" href="#">LIHAT</a>
                        @endif
                            {{--                        <button class="waves-effect waves-dark btn next-step btn-primary">CONTINUE</button>--}}
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Penggambaran Proses Bisnis Proyek</div>
                <div class="step-content">
                    <div>Gambarkan proses bisnis dari sistem yang ingin Anda buat</div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        @if($lastProcessIndex >= 3)
                            <a class="btn btn-primary" href="{{ route('project.future_business_process', [$project->id]) }}">LIHAT</a>
                        @else
                            <a class="btn btn-primary trigger-alert" href="#">LIHAT</a>
                        @endif
                        {{--                        <button class="waves-effect waves-dark btn next-step btn-primary">CONTINUE</button>--}}
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Pendefinisian Kebutuhan</div>
                <div class="step-content">
                    <div>Definisikan <b>kebutuhan fungsional</b> dan <b>kebutuhan non-fungsional</b> untuk perangkat lunak pada proyek ini</div>
                    <div class="step-actions">
                        <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                        @if($lastProcessIndex >= 4)
                            <a class="btn btn-primary" href="{{ route('project.requirements_definition', [$project->id]) }}">LIHAT</a>
                        @else
                            <a class="btn btn-primary trigger-alert" href="#">LIHAT</a>
                        @endif
                        {{--                        <button class="waves-effect waves-dark btn next-step btn-primary">CONTINUE</button>--}}
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Persetujuan Kebutuhan Proyek</div>
                <div class="step-content">
                    @if($lastProcessIndex >= 5)
                        <div>Kebutuhan dapat diunduh pada link <a href="{{ route('project.export', [$project->id]) }}" target="_blank">berikut</a></div>
                    @if($project->status == 'DitolakCBP')
                        @if(Auth::user()->role == 'Business Owner')
                            <div class="alert alert-danger">Kebutuhan ditolak oleh Pengembang Perangkat Lunak dengan meminta pengulangan dari Penggambaran Proses Bisnis Proyek</div>
                        @else
                            <div class="alert alert-danger">Anda telah menolak kebutuhan dengan meminta pengulangan dari Penggambaran Proses Bisnis Proyek</div>
                        @endif
                    @elseif($project->status == 'DitolakBG')
                        @if(Auth::user()->role == 'Business Owner')
                            <div class="alert alert-danger">Kebutuhan ditolak oleh Pengembang Perangkat Lunak dengan meminta pengulangan dari Pendefinisan Tujuan Bisnis Proyek</div>
                        @else
                            <div class="alert alert-danger">Anda telah menolak kebutuhan dengan meminta pengulangan dari Pendefinisan Tujuan Bisnis Proyek</div>
                        @endif
                    @else
                            @if(Auth::user()->role == 'Software Developer')
                                <div>Ajukan persetujuan kebutuhan kepada Pemilik Bisnis atau ulangi tahapan proyek</div>
                            @else
                                <div>Setujui atau tolak permintaan persetujuan proyek</div>
                            @endif
                    @endif
                        <div class="step-actions">
                            @if(Auth::user()->role == 'Business Owner')
                                @if($project->status == 'Aktif')
                                    <div>Silakan tunggu hingga diajukan oleh Pengembang Perangkat Lunak</div>
                                @else
                                    <button class="accept-req waves-effect waves-dark btn btn-success">SETUJU</button>
                                    <button class="reset-req btn btn-danger ml-2">ULANGI</button>
                                @endif
                            @else
                                @if($project->status == 'Diajukan')
                                    <div class="alert alert-primary" role="alert">Silakan tunggu persetujuan dari Pemilik Bisnis</div>
                                @elseif($project->status == 'Disetujui')
                                    <div class="alert alert-success" role="alert">Kebutuhan telah disetujui</div>
                                @elseif($project->status == 'Aktif')
                                    <button class="submit-req waves-effect waves-dark btn btn-primary" href="{{ route('project.submit', [$project->id]) }}">AJUKAN</button>
                                    <button class="reject-req btn btn-danger ml-2">TOLAK</button>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="text-danger">Selesaikan tahap sebelumnya terlebih dahulu</div>
                    @endif
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Unduh Kebutuhan</div>
                <div class="step-content">
                    <div>Kebutuhan dapat diunduh pada tombol di bawah ini</div>
                    <div class="step-actions">
                        @if($lastProcessIndex >= 6)
                            <a class="btn btn-primary" href="{{ route('project.export', [$project->id]) }}" target="_blank">UNDUH</a>
                        @else
                            <button class="btn btn-primary trigger-alert">UNDUH</button>
                        @endif
                    </div>
                </div>
            </li>
        </ul>
        <form id="resetProcess" method="POST" action="{{ route('project.reset') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input id="project_id" name="project_id" class="form-control" type="hidden" value="{{ $project->id }}">
                <input id="reset_from" name="reset_from" class="form-control" type="hidden" value=""/>
            </div>
        </form>

        <form id="rejectProcess" method="POST" action="{{ route('project.reject') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input id="project_id" name="project_id" class="form-control" type="hidden" value="{{ $project->id }}">
                <input id="reject_from" name="reject_from" class="form-control" type="hidden" value=""/>
            </div>
        </form>

        <form id="acceptProcess" method="POST" action="{{ route('project.accept') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input id="project_id" name="project_id" class="form-control" type="hidden" value="{{ $project->id }}">
            </div>
        </form>

        <form id="submitProject" method="POST" action="{{ route('project.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input id="project_id" name="project_id" class="form-control" type="hidden" value="{{ $project->id }}">
            </div>
        </form>
    </div>
@endsection

@push('body_scripts')
    <script>
        $(document).ready(function() {
            var stepper = document.querySelector('.stepper');
            var stepperInstance = new MStepper(stepper, {
                firstActive: $('#lastProcessIndex').val(),
                linearStepsNavigation: true,
                // stepTitleNavigation: false
            });
            console.log($('#lastProcessIndex').val());
            var steps = $('.step');
            for (var i=0; i<$('#lastProcessIndex').val();i++){
                steps[i].classList.add('done');
            }
            $('.trigger-alert').click(function(e) {
                e.preventDefault();
                alert('Silakan selesaikan tahapan sebelumnya terlebih dahulu');
            })

        });

        $('.step-title').click(function(e) {
            var steps = $('.step');
            for (var i=0; i<$('#lastProcessIndex').val();i++){
                steps[i].classList.add('done');
            }
        });

        $('.reset-req').click(function (e) {
            e.preventDefault();
            $.confirm({
                title: 'Ulangi Kebutuhan Proyek',
                content: 'Ulangi dari?',
                buttons: {
                    fromBusinessGoals: {
                        text: 'Pendefinisian Tujuan Bisnis Proyek',
                        btnClass: 'btn-red',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $('#reset_from').val('BUSINESS_GOALS');
                            $('#resetProcess').submit();
                        }
                    },
                    fromRequirementsDefinition: {
                        text: 'Penggambaran Proses Bisnis Proyek',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $('#reset_from').val('FIND_PATTERN');
                            $('#resetProcess').submit();
                        }
                    },
                    cancel: {
                        text: 'Batal',
                        action: function(){

                        }
                    }
                }
            });
        });

        $('.reject-req').click(function (e) {
            e.preventDefault();
            $.confirm({
                title: 'Tolak Persetujuan',
                content: 'Ulangi dari?',
                buttons: {
                    fromBusinessGoals: {
                        text: 'Pendefinisian Tujuan Bisnis Proyek',
                        btnClass: 'btn-red',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $('#reject_from').val('DitolakBG');
                            $('#rejectProcess').submit();
                            $.alert('Penolakan disampaikan ke Pengembang Perangkat Lunak');
                        }
                    },
                    fromRequirementsDefinition: {
                        text: 'Penggambaran Proses Bisnis Proyek',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $('#reject_from').val('DitolakCBP');
                            $('#rejectProcess').submit();
                            $.alert('Penolakan disampaikan ke Pengembang Perangkat Lunak');
                        }
                    },
                    cancel: {
                        text: 'Batal',
                        action: function(){

                        }
                    }
                }
            });
        });

        $('.accept-req').click(function (e) {
            e.preventDefault();
            $.confirm({
                title: 'Persetujuan Kebutuhan Proyek',
                content: 'Setujui kebutuhan?',
                buttons: {
                    confirm: {
                        text: 'OK',
                        action: function(){
                            $('#acceptProcess').submit();
                        }
                    },
                    cancel: {
                        text: 'cancel',
                        action: function(){

                        }
                    }
                }
            })
        });

        $('.submit-req').click(function (e) {
            e.preventDefault();
            $.confirm({
                title: 'Pengajuan',
                content: 'Anda yakin ingin mengajukan?',
                buttons: {
                    confirm: {
                        text: 'OK',
                        action: function(){
                            $('#submitProject').submit();
                        }
                    },
                    cancel: {
                        text: 'cancel',
                        action: function(){
                        }
                    }
                }
            })
        });
    </script>
@endpush

@push('head_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/materialize-stepper@3.1.0/dist/js/mstepper.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endpush

@push('head_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://unpkg.com/materialize-stepper@3.1.0/dist/css/mstepper.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endpush
