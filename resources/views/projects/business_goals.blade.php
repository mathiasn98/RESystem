@extends('layouts.extended_app')
@section('content')
    <div class="container pl-1 pr-1">
        <form id="createBusinessGoals" method="POST" action="{{ route('project.business_goal.store', [$project->id] ) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div>
                    <h2 style="display: inline-block">Business Goals</h2>
                    <a class="btn btn-danger float-right ml-2" href="{{ URL::previous() }}" style="display:inline-block">Batal</a>
                    <button type="submit" id="save" class="btn btn-success float-right" style="display:inline-block">Simpan</button>
                    <div>Tuliskan tujuan bisnis dari proyek yang Anda buat</div>
                    <input name="project_id" class="form-control" type="hidden" value="{{ $project->id }}">
                </div>
            </div>
            <div id="inputBusinessGoalsDiv" class="mt-4">
{{--                <div id="0 form-group">--}}
{{--                    <i class="fas fa-circle"></i>--}}
{{--                    <input type="text" class="form-control business-goals required ml-2 mt-2" id="input1" name="business_goals[]" style="width: 94%; display: inline-block" value="">--}}
{{--                </div>--}}
            </div>
            <button class="btn text-primary mt-2" id="addBusinessGoals" style="display: block; margin-left:auto; margin-right: auto">
                <i class="fas fa-plus-circle fa-2x"></i>
            </button>
        </form>

    </div>
@endsection

@push('body_scripts')
    <script>
        var businessGoals = [];
        $(document).ready(function () {
            var businessGoalsDiv = $("#inputBusinessGoalsDiv");
            var addButton = $("#addBusinessGoals");

            businessGoals = {!! json_encode($initBusinessGoals) !!};

            var countBusinessGoals = businessGoals.length - 1;

            var fill = '';

            if (businessGoals.length === 0) {
                fill = '<div id="0 form-group">' +
                    '<i class="fas fa-circle"></i>' +
                    '<input type="text" class="form-control business-goals required ml-2 mt-2" id="input1" name="business_goals[]" style="width: 94%; display: inline-block" value="">' +
                    '</div>';
            } else {
                businessGoals.forEach(function (businessGoal, i) {
                    if (i === 0) {
                        fill += '<div id="' + i + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" value="' + businessGoal + '" class="form-control business-goals required ml-2 mt-2" id="input' + i + '" name="business_goals[]" style="width:94%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span></div>';
                    } else {
                        fill += '<div id="' + i + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" value="' + businessGoal + '" class="form-control business-goals required ml-2 mt-2" id="input' + i + '" name="business_goals[]" style="width:94%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span><button href="#" id="remove' + i + '" class="btn text-danger float-right mt-2"><i class="fas fa-minus-circle"></i></button></div>'
                    }
                })
            }


            $(businessGoalsDiv).append(fill);
            for ($i=0; $i<businessGoals.length; $i++) {
                buttonClick($i);
            }

            $(addButton).click(function (e) {
                e.preventDefault();
                countBusinessGoals++;
                const fill = '<div id="' + countBusinessGoals + '" class="form-group mt-2"><i class="fas fa-circle"></i><input type="text" class="form-control business-goals required ml-2 mt-2" id="input' + countBusinessGoals + '" name="business_goals[]" style="width:94%; display:inline-block"><span class="text-muted pl-3" style="display:none"></span><button href="#" id="remove' + countBusinessGoals + '" class="btn text-danger float-right mt-2"><i class="fas fa-minus-circle"></i></button></div>';
                $(businessGoalsDiv).append(fill);

                buttonClick(countBusinessGoals);

            });

            $('#save').on('click', function(e) {
                e.preventDefault();
                if (!checkRequired()) return;
                $('#createBusinessGoals').submit();
            });
        });

        function buttonClick(id) {
            $('#remove' + id).on("click", function(e) {
                e.preventDefault();

                businessGoals.splice($.inArray($('#input' + id).val(), businessGoals),1);

                $('#' + id).remove();
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
@endpush
