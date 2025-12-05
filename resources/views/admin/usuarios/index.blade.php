@extends('layouts.admin.admin-master')

@section('title') {{ config('app.name') }} | Usuarios @endsection

@section('content')
@section('pagetitle') Gestión de Usuarios @endsection

@section('css')
<style>
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        font-weight: 600;
    }

    .btn-group .btn {
        margin: 0 2px;
    }

    .badge {
        font-size: 0.75em;
    }
</style>
@endsection

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Usuarios del Sistema</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ config('app.name') }}</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Total Usuarios">Total Usuarios</h5>
                        <h3 class="my-2 py-1"><span data-plugin="counterup" id="totalUsers">{{ $users->count() }}</span></h3>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="mdi mdi-account font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Activos">Activos</h5>
                        <h3 class="my-2 py-1"><span data-plugin="counterup" id="totalActivos">{{ $users->where('activo', true)->count() }}</span></h3>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-success rounded">
                            <i class="mdi mdi-account font-20 text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Deals">Administradores</h5>
                        <h3 class="my-2 py-1"><span data-plugin="counterup" id="totalAdmin">{{ $users->where('es_admin', true)->count() }}</span></h3>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-warning rounded">
                            <i class="mdi mdi-account font-20 text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->
<!-- end col -->
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Toolbar con estadísticas -->
                <div class="row mb-3">
                    <div id="toolbar">
                        <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Nuevo Usuario' onclick='crear()'>
                            <i class="mdi mdi-account-plus me-1"></i> 
                        </a>
                    </div>
                </div>

                <table id="usersTable" class="table table-sm table-striped"
                    data-search="true"
                    data-unique-id="id"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-show-search-clear-button="true"
                    data-pagination="true"
                    data-page-size="10"
                    data-url = "{{ route('admin.usuarios.list') }}">
                    <thead class="table-light">
                        <tr>
                            <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                            <th data-field="name" data-sortable="true">Usuario</th>
                            <th data-field="email" data-sortable="true">Email</th>
                            <th data-field="empresas_count" data-sortable="true" data-align="center" data-formatter="empresasFormatter">Empresas</th>
                            <th data-field="es_admin" data-sortable="true" data-align="center" data-formatter="adminFormatter">Rol</th>
                            <th data-field="activo" data-sortable="true" data-align="center" data-formatter="statusFormatter">Estado</th>
                            <th data-field="created_at" data-sortable="true" data-align="center" data-formatter="dateFormatter">Creado</th>
                            <th data-field="action" data-width="150" data-align="center" data-formatter="actionFormatter">Acciones</th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.comun.modal-usuario')

@endsection

@section('script')
<script>
    const $table = $('#usersTable').bootstrapTable({
        locale: 'es-ES',
        loadingTemplate: function(loadingMessage) {
            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
        },
        onLoadSuccess: function(){
            tool_tips();
        }
    });

    $(document).ready(function() {

        $(document).initSwitchery();

        $('.select2').select2({
            theme: "bootstrap-5",
            width: "100%",
            dropdownParent: $('#modalUsuarios'),
            placeholder: "Seleccione...",
        });

        $('#status').on('change',function(){
            $('#lblstatus').toggleText('Inactive', 'Active');
        });

        $('#modalUsuarios').on('hide.bs.modal',function(){
            $('#frmUsuarios')[0].reset();
            $('#id').val(null);
            $('#name').val(null);
            $('#email').val(null);
            if($("#status").is(':checked')){
                $("#status").trigger('click');
                $('#lblstatus').text('Inactive');
            }
            $('#frmUsuarios').removeClass('was-validated');
        });

        $('#cerrar').on('click',function(){
            $('#modalUsuarios').modal('hide');
        });

        $('#frmUsuarios').on('submit',function(e){
            e.preventDefault();

            let form = $(this);
            if(!form[0].checkValidity())  return false;

            //let data = form.serialize();
            var data = new FormData(form[0]);
            let uri = "{{ route('admin.usuarios.store') }}";
            let method = "POST";
            
            let id = $('#id').val();
            if(id!=''){
                uri = "{{ route('admin.usuarios.update',':usuario') }}".replace(':usuario', id);
                method = "PUT";
                data.append('id', id);
            }

            sendRequest(uri, method, data, function (response) {
                showToast(response.mensaje, response.success );
                if (response.success=="success") {
                    $table.bootstrapTable('refresh');
                    $('#totalUsers').text(response.totalUsers);
                    $('#totalActivos').text(response.totalActivos);
                    $('#totalAdmin').text(response.totalAdmin);
                    $('#modalUsuarios').modal('hide');
                }
            });
        });

        getEmpresas();
    });

    function empresasFormatter(value, row, index) {
        return `<span class="badge bg-primary rounded-pill">${value}</span>`;
    }

    function adminFormatter(value, row, index) {
        if (value) {
            return `<span class="badge bg-warning">Administrador</span>`;
        }
        return `<span class="badge bg-info">Usuario</span>`;
    }

    function statusFormatter(value, row, index) {
        if (value) {
            return `<span class="badge bg-success">Activo</span>`;
        }
        return `<span class="badge bg-danger">Inactivo</span>`;
    }

    function dateFormatter(value, row, index) {
        return new Date(value).toLocaleDateString('es-ES');
        //return value;
    }

    function actionFormatter(value, row, index) {
        var buttons =`<ul class='list-inline mb-0'>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Editar' onclick='editar(${row.id})' >
                                <i class='mdi mdi-file-edit'></i>
                            </a>
                        </li>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='Eliminar' onclick='eliminar(${row.id})' >
                                <i class='mdi mdi-delete'></i>
                            </a>
                        </li>
                    </ul>`;
        return buttons;
    }

    function getEmpresas() {
        let url = "{{ route('admin.empresas.listar') }}?activo=1";
        sendRequest(url, 'GET', null, function(response) {
            console.log(response);
            if (response && response.length > 0) {
                let options;
                response.forEach(empresa => {
                    options += `<option value="${empresa.id}">${empresa.nombre}</option>`;
                });
                $('#empresas').html(options);
                
            } else {
                $('#empresas').html('<option value="">No hay empresas disponibles</option>');
            }
        });
    }

    function crear() {
        $('#modalUsuarios').modal('show');
    }

    function editar(id) {        
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        
        $('#id').val($row.id);
        $('#name').val($row.name);
        $('#email').val($row.email);
        $('#es_admin').prop('checked', $row.es_admin);
        $('#activo').prop('checked', $row.activo);
        $('#modalUsuarios').modal('show');
    }

    async function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Seguro de Eliminar este usuario?<br><br>*${datos.name}*`)
        
        if(confirm)
        {
            let url = "{{ route('admin.usuarios.destroy',':usuario')}}".replace(':usuario', id);
            let method = "DELETE";

            sendRequest(url, method, null, function (response) {
                showToast(response.mensaje, response.success );
                if (response.success=="success") {
                    $table.bootstrapTable('removeByUniqueId', id);
                    $('#totalUsers').text(response.totalUsers);
                    $('#totalActivos').text(response.totalActivos);
                    $('#totalAdmin').text(response.totalAdmin);
                }
            });
        }
        else
        {
            showToast('Registro sin cambios','warning');
        }

    }
</script>


@endsection