@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }	
</style>
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Inicio</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Trabajo</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Gestionar trabajos </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Trabajos</span> </div>
                        <div class="actions"> <a href="{{ route('create.job') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Agregar</a> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="job-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="jobDatatableAjax">
                                    <thead>
                                        <tr role="row" class="filter">
                                            <td>{!! Form::select('company_id', ['' => 'Seleccione Compañia']+$companies, null, array('id'=>'company_id', 'class'=>'form-control select2-multiple')) !!}</td>
                                            <td><input type="text" class="form-control" name="title" id="title" autocomplete="off" placeholder="Titulo"></td>
                                            <td><input type="text" class="form-control" name="description" id="description" autocomplete="off" placeholder="Descripción"></td>
                                            <td>
                                                <?php $default_country_id = Request::query('country_id', $siteSetting->default_country_id); ?>
                                               
                                                
                                                <span>
                                                    {!! Form::select('country_id', ['' => 'Seleccione País']+$countries, $default_country_id, array('id'=>'country_id', 'class'=>'form-control select2-multiple')) !!}
                                                </span>
                                                

                                                <div id="default_state_dd_">
                                                    {!! Form::select('state_id', ['' => 'Seleccione Departamento'], null, array('id'=>'state_id', 'class'=>'form-control')) !!}
                                                </div>
                                               

                                                <span id="default_city_dd">
                                                    {!! Form::select('city_id', ['' => 'Seleccione Ciudad'], null, array('id'=>'city_id', 'class'=>'form-control')) !!}
                                                </span>
                                            
                                            </td>
                                            <td><select name="is_active" id="is_active" class="form-control">
                                                    <option value="-1">Activo?</option>
                                                    <option value="1" selected="selected">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                                <select name="is_featured" id="is_featured" class="form-control">
                                                    <option value="-1">Destacado?</option>
                                                    <option value="1">Destacado</option>
                                                    <option value="0">No Destacado</option>
                                                </select></td>
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>Empresa</th>
                                            <th>Titulo</th>
                                            <th>Descripcion</th>
                                            <th>Ciudad</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
@endsection
@push('scripts') 
<script>
    $(function () {
        var oTable = $('#jobDatatableAjax').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            dom: 'lBrtip',
            pageLength: 25,
            lengthMenu: [[25, 100, -1], [25, 100, "All"]],
            buttons: [
                'copy','csv','excel','pdf','print'
                ],
                info: false,
            /*		
             "order": [[1, "asc"]],            
             paging: true,
             */
            ajax: {
                url: '{!! route('fetch.data.jobs') !!}',
                data: function (d) {
                    d.company_id = $('#company_id').val();
                    d.title = $('#title').val();
                    d.description = $('#description').val();
                    d.country_id = $('#country_id').val();
                    d.state_id = $('#state_id').val();
                    d.city_id = $('#city_id').val();
                    d.is_active = $('#is_active').val();
                    d.is_featured = $('#is_featured').val();
                }
            }, columns: [
                {data: 'company_id', name: 'company_id'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'city_id', name: 'city_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#job-search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#company_id').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#title').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#description').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#country_id').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
            filterDefaultStates(0);
        });
        $(document).on('change', '#state_id', function (e) {
            oTable.draw();
            e.preventDefault();
            filterDefaultCities(0);
        });
        $(document).on('change', '#city_id', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#is_active').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#is_featured').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        filterDefaultStates(0);
    });
    function deleteJob(id, is_default) {
        var msg = 'Are you sure?';
        if (confirm(msg)) {
            $.post("{{ route('delete.job') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#jobDatatableAjax').DataTable();
                            table.row('jobDtRow' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
        }
    }
    function makeActive(id) {
        $.post("{{ route('make.active.job') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
    function makeNotActive(id) {
        $.post("{{ route('make.not.active.job') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
    function makeFeatured(id) {
        $.post("{{ route('make.featured.job') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
    function makeNotFeatured(id) {
        $.post("{{ route('make.not.featured.job') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
    function filterDefaultStates(state_id)
    {
        let country_id = $('#country_id').val();
        if (country_id != '') {
            $.post("{{ route('filter.default.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_state_dd_').html(response);
                         $('.select2-custom').select2({
                            placeholder: "Seleccione",
                            allowClear: true
                        });
                    });
                }
            }
            function filterDefaultCities(city_id)
            {
                let state_id = $('#state_id').val();
                if (state_id != '') {
                    $.post("{{ route('filter.default.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        console.log(response);
                        $('#default_city_dd').html(response);
                        $('.select2-custom').select2({
                            placeholder: "Seleccione",
                            allowClear: true
                        });
                    });
        }
    }

    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: "Seleccione",
            allowClear: true
        });
    });

</script>
@endpush