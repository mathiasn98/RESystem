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
                <div class="step-title waves-effect">Business Goals</div>
                <div class="step-content">
                    <div>Apa tujuan Anda melalui proyek ini?</div>
                    <div>Contoh: <b>Mengurangi waktu antrean</b></div>

                    <div class="step-actions">
                        <a class="btn btn-primary" href="{{ route('project.business_goals', [$project->id]) }}">LIHAT</a>
{{--                        <button class="waves-effect waves-dark btn next-step btn-primary">CONTINUE</button>--}}
                    </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Current Business Process</div>
                <div class="step-content">
                    <div>Unggah atau gambarkan proses bisnismu saat ini</div>
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
                <div class="step-title waves-effect">Find Pattern</div>
                <div class="step-content">
                    <div>Cari pola untuk Proses Bisnismu</div>
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
                <div class="step-title waves-effect">Future Business Process</div>
                <div class="step-content">
                    <div>Definisikan proses bisnis dari sistem yang ingin Anda buat</div>
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
                    <div>Definisikan kebutuhan fungsional dan non-fungsional dari proyek Anda</div>
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
                <div class="step-title waves-effect">Persetujuan</div>
                <div class="step-content">
                    <div>Kebutuhan dapat diunduh pada link <a href="{{ route('project.export', [$project->id]) }}">berikut</a></div>
                        <div class="step-actions">
                            @if($lastProcessIndex >= 5)
                                <button class="accept-req waves-effect waves-dark btn btn-success">SETUJU</button>
                                <button class="reject-req btn btn-danger ml-2">TOLAK</button>
                            @else
                                <button class="btn btn-success trigger-alert" href="#">SETUJU</button>
                                <button class="btn btn-danger trigger-alert" href="#">TOLAK</button>
                            @endif
                        </div>
                </div>
            </li>
            <li class="step inactive">
                <div class="step-title waves-effect">Unduh Kebutuhan</div>
                <div class="step-content">
                    @if($lastProcessIndex >= 6)
                        <div>Kebutuhan dapat diunduh pada tombol di bawah ini</div>
                    @else
                        <div class="text-danger">Selesaikan tahap sebelumnya terlebih dahulu</div>
                    @endif
                    <div class="step-actions">
                        <a class="btn btn-primary" href="{{ route('project.export', [$project->id]) }}">UNDUH</a>
                    </div>
                </div>
            </li>
        </ul>
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

        $('.reject-req').click(function (e) {
            e.preventDefault();
            $.confirm({
                title: 'Tolak Kebutuhan',
                content: 'Ulangi dari tahap?',
                buttons: {
                    fromBusinessGoals: {
                        text: 'Business Goals',
                        btnClass: 'btn-red',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $('#reject_from').val('BUSINESS_GOALS');
                            $('#rejectProcess').submit();
                        }
                    },
                    fromRequirementsDefinition: {
                        text: 'Pendefinisian Kebutuhan',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $('#reject_from').val('REQ_DEF');
                            $('#rejectProcess').submit();
                        }
                    }
                }
            });
        });

        $('.accept-req').click(function (e) {
            e.preventDefault();
            $.confirm({
                title: 'Persetujuan',
                content: 'Setujui kebutuhan?',
                buttons: {
                    confirm: {
                        text: 'Setujui',
                        btnClass: 'btn-primary',
                        action: function(){
                            $('#acceptProcess').submit();
                        }
                    },
                    cancel: {
                        text: 'Batal',
                        btnClass: 'btn-danger',
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
