<script type="text/javascript" src="http://code.google.com/p/jquery-"></script>
<h5>{{ __('Job Details') }}</h5>

@if (isset($job))
    {!! Form::model($job, [
        'method' => 'put',
        'route' => ['update.front.job', $job->id],
        'class' => 'form',
        'id' => 'form',
    ]) !!}
    {!! Form::hidden('id', $job->id) !!}
@else
    {!! Form::open(['method' => 'post', 'route' => ['store.front.job'], 'class' => 'form', 'id' => 'form']) !!}
@endif

{!! Form::hidden('ley2225', true) !!}

<div class="row">
    <div class="col-md-12">
        {!! Form::label('Job title', __('Job title'), ['class' => ['bold', 'my-1']]) !!}
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'title') !!}"> {!! Form::text('title', null, [
            'class' => 'pascalCase form-control',
            'id' => 'title',
            'placeholder' => __('Job title'),
        ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'title') !!} </div>
    </div>


    <div class="col-md-12">
        {!! Form::label('Schedule', __('Schedule'), ['class' => ['bold', 'my-1']]) !!}
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'schedule') !!}"> {!! Form::text('schedule', null, [
            'class' => 'pascalCase form-control',
            'id' => 'schedule',
            'placeholder' => __('Describa la jornada laboral'),
        ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'schedule') !!} </div>
    </div>


    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}">
            {!! Form::label('Offer Description', __('Offer Description'), ['class' => 'bold']) !!}
            {!! Form::textarea('description', null, [
                //
                'class' => 'form-control',
                'id' => 'description',
                'placeholder' => __('Job description'),
                'maxlength' => '10',
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'description') !!} </div>
    </div>

    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'skills') !!}">
            <?php
            $skills = old('skills', $jobSkillIds);
            ?>
            {!! Form::label('Skills Required', __('Skills Required'), ['class' => 'bold']) !!}
            {!! Form::select('skills[]', $jobSkills, $skills, [
                'class' => 'form-control select2-multiple',
                'id' => 'skills',
                'multiple' => 'multiple',
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'skills') !!} </div>
    </div>
    <div class="col-md-4">
        {!! Form::label('Country', __('Country'), ['class' => ['bold', 'my-1']]) !!}
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div"> {!! Form::select(
            'country_id',
            ['' => __('Select Country')] + $countries,
            old('country_id', isset($job) ? $job->country_id : $siteSetting->default_country_id),
            ['class' => 'form-control', 'id' => 'country_id'],
        ) !!}
            {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} </div>
    </div>
    <div class="col-md-4">
        {!! Form::label('State', __('State'), ['class' => ['bold', 'my-1']]) !!}
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}" id="state_id_div"> <span id="default_state_dd">
                {!! Form::select('state_id', ['' => __('Select State')], null, ['class' => 'form-control', 'id' => 'state_id']) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!} </div>
    </div>
    <div class="col-md-4">
        {!! Form::label('City', __('City'), ['class' => ['bold', 'my-1']]) !!}
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}" id="city_id_div"> <span id="default_city_dd">
                {!! Form::select('city_id', ['' => __('Select City')], null, ['class' => 'form-control', 'id' => 'city_id']) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!} </div>
    </div>
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div">
            {!! Form::label('Offer Description', __('Salary Range'), ['class' => 'bold']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_from') !!}" id="salary_from_div"> {!! Form::text('salary_from', null, [
            'class' => 'form-control number-1 inputform ',
            'id' => 'salary_from',
            'placeholder' => __('Salary from'),
        ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'salary_from') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_to') !!}" id="salary_to_div">
            {!! Form::text('salary_to', null, [
                'class' => 'form-control number-1 inputform ',
                'id' => 'salary_to',
                'placeholder' => __('Salary to'),
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'salary_to') !!} </div>
    </div>
    {{-- <div class="col-md-4">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_currency') !!}" id="salary_currency_div">
            @php
                $salary_currency = Request::get('salary_currency', isset($job) ? $job->salary_currency : $siteSetting->default_currency_code);
            @endphp

            {!! Form::select('salary_currency', ['' => __('Select Salary Currency')] + $currencies, $salary_currency, [
                'class' => 'form-control',
                'id' => 'salary_currency',
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!} </div>
    </div> --}}
    <div class="col-md-8">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_period_id') !!}" id="salary_period_id_div"> {!! Form::select('salary_period_id', $salaryPeriods, null, [
            'class' => 'form-control',
            'id' => 'salary_period_id',
            'placeholder' => __('Select Salary Period'),
        ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'salary_period_id') !!} </div>
    </div>
    <div class="col-md-4">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'hide_salary') !!}"> {!! Form::label('hide_salary', __('Hide Salary?'), ['class' => 'bold']) !!}
            <div class="radio-list">
                <?php
                $hide_salary_1 = '';
                $hide_salary_2 = 'checked="checked"';
                if (old('hide_salary', isset($job) ? $job->hide_salary : 0) == 1) {
                    $hide_salary_1 = 'checked="checked"';
                    $hide_salary_2 = '';
                }
                ?>
                <label class="radio-inline">
                    <input id="hide_salary_yes" name="hide_salary" type="radio" value="1" {{ $hide_salary_1 }}>
                    {{ __('Yes') }} </label>
                <label class="radio-inline">
                    <input id="hide_salary_no" name="hide_salary" type="radio" value="0" {{ $hide_salary_2 }}>
                    {{ __('No') }} </label>
            </div>
            {!! APFrmErrHelp::showErrors($errors, 'hide_salary') !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'degree_level_id') !!}">
            <?php
            $selecteds = old('degree_level_id', $degreeLevelIds);
            ?>
            {!! Form::label('Degree Level', __('Degree Level'), ['class' => 'bold']) !!}
            {!! Form::select('degree_level_id[]', $degreeLevels, $selecteds, [
                'class' => 'form-control select2-multiple',
                'id' => 'degree_level_id',
                'multiple' => 'multiple',
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!} </div>
    </div>

    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}">
            <?php
            $selecteds = old('career_level_id', $careerLevelIds);
            ?>
            {!! Form::label('Career Level', __('Career Level'), ['class' => 'bold']) !!}
            {!! Form::select('career_level_id[]', $careerLevels, $selecteds, [
                'class' => 'form-control select2-multiple',
                'id' => 'career_level_id',
                'multiple' => 'multiple',
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!} </div>
    </div>



    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}">
            <?php
            $selecteds = old('functional_area_id', $fareasIds);
            ?>
            {!! Form::label('Functional Area', __('Functional Area'), ['class' => 'bold']) !!}
            {!! Form::select('functional_area_id[]', $functionalAreas, $selecteds, [
                'class' => 'form-control select2-multiple',
                'id' => 'functional_area_id',
                'multiple' => 'multiple',
            ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!} </div>
    </div>


    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_type_id') !!}" id="job_type_id_div"> {!! Form::select('job_type_id', ['' => __('Select Job Type')] + $jobTypes, null, [
            'class' => 'form-control',
            'id' => 'job_type_id',
        ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'job_type_id') !!} </div>
    </div>

    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'num_of_positions') !!}" id="num_of_positions_div"> {!! Form::select(
            'num_of_positions',
            ['' => __('Select number of Positions')] + MiscHelper::getNumPositions(),
            null,
            ['class' => 'form-control', 'id' => 'num_of_positions'],
        ) !!}
            {!! APFrmErrHelp::showErrors($errors, 'num_of_positions') !!} </div>
    </div>

    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'expiry_date') !!}"> {!! Form::text('expiry_date', null, [
            'class' => 'form-control datepicker inputform',
            'id' => 'expiry_date',
            'placeholder' => __('Job expiry date'),
            'autocomplete' => 'off',
        ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'expiry_date') !!} </div>
    </div>

    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}" id="job_experience_id_div"> {!! Form::select('job_experience_id', ['' => __('Select Required job experience')] + $jobExperiences, null, [
            'class' => 'form-control',
            'id' => 'job_experience_id',
        ]) !!}
            {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!} </div>
    </div>

    <div class="col-md-6">
        <label class="radio-inline">Mostrar informacion de la empresa</label>
        <br>
        <input id="is_freelance_yes" class="my-1" name="mostrarInfo" type="radio" value="0">{{ __('No') }}
    </div>

    <br>
    <hr>

    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'is_freelance') !!}"> {!! Form::label('is_freelance', __('Is Freelance?'), ['class' => 'bold']) !!}
            <div class="radio-list">
                <?php
                $is_freelance_1 = '';
                $is_freelance_2 = 'checked="checked"';
                if (old('is_freelance', isset($job) ? $job->is_freelance : 0) == 1) {
                    $is_freelance_1 = 'checked="checked"';
                    $is_freelance_2 = '';
                }
                ?>
                <label class="radio-inline">
                    <input id="is_freelance_yes" name="is_freelance" type="radio" value="1"
                        {{ $is_freelance_1 }}>
                    {{ __('Yes') }} </label>
                <label class="radio-inline">
                    <input id="is_freelance_no" name="is_freelance" type="radio" value="0" {{ $is_freelance_2 }}>
                    {{ __('No') }} </label>

            </div>
            {!! APFrmErrHelp::showErrors($errors, 'is_freelance') !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'pcd') !!}"> {!! Form::label('pcd', __('Puede aplicar persona en condición de discapacidad?'), ['class' => 'bold']) !!}

            <div class="radio-list">

                <?php
                
                $pcd_2 = '';
                
                $pcd_1 = 'checked="checked"';
                
                if (old('pcd', isset($job) ? $job->pcd : 0) == 1) {
                    $pcd_1 = 'checked="checked"';
                
                    $pcd_2 = '';
                }
                
                ?>

                <label class="radio-inline">

                    <input id="pcd_yes" name="pcd" type="radio" value="1" {{ $pcd_1 }}>

                    {{ __('Yes') }} </label>

                <label class="radio-inline">

                    <input id="pcd_no" name="pcd" type="radio" value="0" {{ $pcd_2 }}>

                    {{ __('No') }} </label>

                <br>

                <br>


            </div>

            {!! APFrmErrHelp::showErrors($errors, 'pcd') !!}

        </div>
    </div>
    <div class="col-md-12">
        <div class="formrow">
            <button type="submit" class="btn">{{ isset($job) ? __('Update Job') : __('Post offer') }} <i
                    class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
<input type="file" name="image" id="image" style="display:none;" accept="image/*" />
{!! Form::close() !!}
<hr>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="btnShowModal"
    style="display: none"></button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Para la publicación de la vacante lo invitamos a leer la
                <br>
                <a target="_blanck"
                    href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=188807#:~:text=ART%C3%8DCULO%2012.&text=Los%20trabajadores%20dependientes%20o%20independientes,sobre%20un%20(1)%20SMMLV.">
                    Ley 2225 de 2022</a>

                la cual indica que usted como empresario debe reportar los oferentes contratados o la razón de la no
                contratación.

                <br>
                <br>
                si esta deacuerdo por favor de click en <b>Aceptar</b>.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="aceptarBtn" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style type="text/css">
        .inputform {
            height: 28px !important;
        }

        .datepicker>div {
            display: block;
        }
    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            const form = document.getElementById('form');
            const btnShowModal = document.getElementById('btnShowModal');
            const aceptarBtn = document.getElementById('aceptarBtn');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Evita que el formulario se envíe de manera convencional
                btnShowModal.click();

                aceptarBtn.addEventListener('click', function() {
                    form.submit();
                });

            });

            // Fetch the preselected item, and add to the control
            var studentSelect = $('.selected-remote');
            $.ajax({
                type: 'GET',
                url: '/api/proffesions?name=' + <?php echo isset($job->position) ? '"' . $job->position . '"' : '"' . '"'; ?>
            }).then(function(data) {
                var option = new Option(data.text, data.id, true, true);
                studentSelect.append(option).trigger('change');

            });



            $('.select2-multiple').select2({
                placeholder: "{{ __('Select Required Skills') }}",
                allowClear: true
            });

            $('.select').select2({
                placeholder: "{{ __('Select') }}",
                allowClear: true
            });

            $(".datepicker").datepicker({
                autoclose: true,
                format: 'yyyy-m-d'
            });

            $('#country_id').on('change', function(e) {
                e.preventDefault();
                filterLangStates(0);

            });

            $(document).on('change', '#state_id', function(e) {
                e.preventDefault();
                filterLangCities(0);
            });

            filterLangStates(<?php echo old('state_id', isset($job) ? $job->state_id : 0); ?>);

            function filterLangStates(state_id) {
                var country_id = $('#country_id').val();
                if (country_id != '') {
                    $.post("{{ route('filter.lang.states.dropdown') }}", {
                            country_id: country_id,
                            state_id: state_id,
                            _method: 'POST',
                            _token: '{{ csrf_token() }}'
                        })

                        .done(function(response) {
                            $('#default_state_dd').html(response);
                            filterLangCities(<?php echo old('city_id', isset($job) ? $job->city_id : 0); ?>);
                        });

                }

            }

            function filterLangCities(city_id) {
                var state_id = $('#state_id').val();
                if (state_id != '') {
                    $.post("{{ route('filter.lang.cities.dropdown') }}", {
                            state_id: state_id,
                            city_id: city_id,
                            _method: 'POST',
                            _token: '{{ csrf_token() }}'
                        })

                        .done(function(response) {
                            $('#default_city_dd').html(response);
                            $('#state_id').select2();
                            $('#city_id').select2();
                        });
                }
            }
        });
    </script>

    @include('includes.tinyMCEFront')
@endpush
