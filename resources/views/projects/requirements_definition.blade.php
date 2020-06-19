@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 pr-1">
        <form id="createRequirements" method="POST" action="{{ route('project.requirements_definition.store', [$project->id] ) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div>
                    <h2 style="display: inline-block">Kebutuhan</h2>
                    <a class="btn btn-danger float-right ml-2" href="{{ URL::previous() }}" style="display:inline-block">Batal</a>
                    <button type="submit" id="save" class="btn btn-success float-right" style="display:inline-block">Simpan</button>
                    <div>Definisikan kebutuhan fungsional dan non-fungsional dari proyek ini</div>
                    <div>Kebutuhan dibuat berdasarkan Future Business Process Diagram</div>
                    <input name="project_id" class="form-control" type="hidden" value="{{ $project->id }}">
                </div>
            </div>
            <div style="background-color: lightcyan">
                <h5>Future Business Process Diagram</h5>
                <small>Geser pada diagram untuk mengubah posisi</small>
                <input id="nav-bpmn-value" style="visibility: hidden" value="{{ $bpmn }}">
                <div id="nav-canvas" style="width: 1132px; height: 400px; border-style: dotted; border-width: 2px"></div>

            </div>
            <div class="row mt-4">
            <div class="col">
                <h4>Kebutuhan Fungsional</h4>
                    <div id="inputFunctionalRequirementsDiv" class="mt-4">
{{--                        <div id="0 form-group">--}}
{{--                            <i class="fas fa-circle"></i>--}}
{{--                            <input type="text" class="form-control functional-req required ml-2 mt-2" id="input1" name="functional_req[]" style="width: 94%; display: inline-block" value="">--}}
{{--                        </div>--}}
                    </div>
                    <button class="btn text-primary mt-2" id="addFunctionalReq" style="display: block; margin-left:auto; margin-right: auto">
                        <i class="fas fa-plus-circle fa-2x"></i>
                    </button>
            </div>
            <div class="col">
                <h4>Kebutuhan Non-Fungsional</h4>
                <div id="inputNonFunctionalRequirementsDiv" class="mt-4">
{{--                    <div id="0 form-group">--}}
{{--                        <i class="fas fa-circle"></i>--}}
{{--                        <input type="text" class="form-control non-functional-req required ml-2 mt-2" id="input1" name="non_functional_req[]" style="width: 94%; display: inline-block" value="">--}}
{{--                    </div>--}}
                </div>
                <button class="btn text-primary mt-2" id="addNonFunctionalReq" style="display: block; margin-left:auto; margin-right: auto">
                    <i class="fas fa-plus-circle fa-2x"></i>
                </button>
            </div>
        </form>
    </div>




    </div>
@endsection

@push('body_scripts')
    <script>
        var functionalRequirements = [];
        var nonFunctionalRequirements = [];
        $(document).ready(function () {
            let functionalRequirementsDiv = $("#inputFunctionalRequirementsDiv");
            let nonFunctionalRequirementsDiv = $("#inputNonFunctionalRequirementsDiv");
            let addFunctionalReq = $("#addFunctionalReq");
            let addNonFunctionalReq = $("#addNonFunctionalReq");


            requirementsInput = {!! json_encode($initRequirements) !!};
            console.log(requirementsInput);
            functionalRequirements = requirementsInput.filter(function (el) {
                return el.type === 'Functional';
            }).map(req => req.requirement);
            nonFunctionalRequirements = requirementsInput.filter(function (el) {
                return el.type === 'Non-Functional';
            }).map(req => req.requirement);

            let countFunctionalReq = functionalRequirements.length - 1;
            let countNonFunctionalReq = nonFunctionalRequirements.length - 1;

            let fillFunctionalReq = '';
            let fillNonFunctionalReq = '';

            // Functional Requirements
            if (functionalRequirements.length === 0) {
                fillFunctionalReq = '<div id="func0 form-group">' +
                    '<i class="fas fa-circle"></i>' +
                    '<input type="text" class="form-control business-goals required ml-2 mt-2" id="input-func1" name="functional_req[]" style="width: 88%; display: inline-block" value="">' +
                    '</div>';
            } else {
                functionalRequirements.forEach(function (req, i) {
                    if (i === 0) {
                        fillFunctionalReq += '<div id="func' + i + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" value="' + req + '" class="form-control business-goals required ml-2 mt-2" id="input' + i + '" name="functional_req[]" style="width:88%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span></div>';
                    } else {
                        fillFunctionalReq += '<div id="func' + i + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" value="' + req + '" class="form-control business-goals required ml-2 mt-2" id="input' + i + '" name="functional_req[]" style="width:88%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span><button href="#" id="remove-func-req' + i + '" class="btn text-danger float-right mt-2"><i class="fas fa-minus-circle"></i></button></div>'
                    }
                })
            }

            // Non-Functional Requirements
            if (nonFunctionalRequirements.length === 0) {
                fillNonFunctionalReq = '<div id="non-func-0 form-group">' +
                    '<i class="fas fa-circle"></i>' +
                    '<input type="text" class="form-control business-goals required ml-2 mt-2" id="input-non-func1" name="non_functional_req[]" style="width: 88%; display: inline-block" value="">' +
                    '</div>';
            } else {
                nonFunctionalRequirements.forEach(function (req, i) {
                    if (i === 0) {
                        fillNonFunctionalReq += '<div id="non-func' + i + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" value="' + req + '" class="form-control non-functional-req required ml-2 mt-2" id="input' + i + '" name="non_functional_req[]" style="width:88%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span></div>';
                    } else {
                        fillNonFunctionalReq += '<div id="non-func' + i + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" value="' + req + '" class="form-control non-functional-req required ml-2 mt-2" id="input' + i + '" name="non_functional_req[]" style="width:88%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span><button href="#" id="remove-non-func-req' + i + '" class="btn text-danger float-right mt-2"><i class="fas fa-minus-circle"></i></button></div>'
                    }
                })
            }


            $(functionalRequirementsDiv).append(fillFunctionalReq);
            $(nonFunctionalRequirementsDiv).append(fillNonFunctionalReq);

            for (let $i=0; $i<functionalRequirements.length; $i++) {
                buttonClickFunctional('#remove-func-req', $i);
            }
            for (let $i=0; $i<nonFunctionalRequirements.length; $i++) {
                buttonClickNonFunctional('#remove-non-func-req', $i);
            }

            $(addFunctionalReq).click(function (e) {
                e.preventDefault();
                countFunctionalReq++;
                const fill = '<div id="func' + countFunctionalReq + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" class="form-control business-goals required ml-2 mt-2" id="input' + countFunctionalReq + '" name="functional_req[]" style="width:88%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span><button href="#" id="remove-func-req' + countFunctionalReq + '" class="btn text-danger float-right mt-2"><i class="fas fa-minus-circle"></i></button></div>';
                $(functionalRequirementsDiv).append(fill);

                buttonClickFunctional('#remove-func-req', countFunctionalReq);
            });

            $(addNonFunctionalReq).click(function (e) {
                e.preventDefault();
                countNonFunctionalReq++;
                const fill = '<div id="non-func' + countNonFunctionalReq + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" class="form-control business-goals required ml-2 mt-2" id="input' + countNonFunctionalReq + '" name="non_functional_req[]" style="width:88%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span><button href="#" id="remove-non-func-req' + countNonFunctionalReq + '" class="btn text-danger float-right mt-2"><i class="fas fa-minus-circle"></i></button></div>';
                $(nonFunctionalRequirementsDiv).append(fill);
                console.log(countNonFunctionalReq);

                buttonClickNonFunctional('#remove-non-func-req', countNonFunctionalReq);

            });

            $('#save').on('click', function(e) {
                e.preventDefault();
                if (!checkRequired()) return;
                $('#createRequirements').submit();
            });
        });

        function buttonClickFunctional(tag, id) {
            $(tag + id).on("click", function(e) {
                e.preventDefault();
                let requirement = {};
                requirement.requirement = $('#input-func' + id).val();
                requirement.type = 'Functional';

                functionalRequirements.splice($.inArray(requirement, functionalRequirements),1);

                $('#func' + id).remove();
            });
        }

        function buttonClickNonFunctional(tag, id) {
            $(tag + id).on("click", function(e) {
                e.preventDefault();
                let requirement = {};
                requirement.requirement = $('#input-non-func' + id).val();
                requirement.type = 'Non-Functional';

                nonFunctionalRequirements.splice($.inArray(requirement, nonFunctionalRequirements),1);

                $('#non-func' + id).remove();
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
    </script>
    <script type="text/javascript" src="/bpmn-import/app.js"></script>
@endpush

@push('head_styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/bpmn-import/vendor/bpmn-js/assets/diagram-js.css" />
    <link rel="stylesheet" href="/bpmn-import/vendor/bpmn-js/assets/bpmn-font/css/bpmn-embedded.css" />
    <link rel="stylesheet" href="/bpmn-import/css/app.css" />
    {{--    <link rel="stylesheet" href="/bpmn-import/css/normalize.css" />--}}
    <link rel="stylesheet" href="/bpmn-import/css/bpmn-js-token-simulation.css" />
@endpush
