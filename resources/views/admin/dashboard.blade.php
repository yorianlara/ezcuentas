@extends('layouts.admin.admin-master')

@section('title') {{config('app.name')}} | Dashboard @endsection
@section('content')
@section('pagetitle') Dashboard @endsection

@section('css')
<style>
    .widget-flat {
        border: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .widget-flat:hover {
        transform: translateY(-5px);
    }

    .widget-icon {
        font-size: 24px;
        opacity: 0.7;
    }

    .bg-success-lighten {
        background-color: rgba(10, 179, 156, 0.15) !important;
    }

    .bg-primary-lighten {
        background-color: rgba(98, 110, 212, 0.15) !important;
    }

    .bg-info-lighten {
        background-color: rgba(43, 203, 246, 0.15) !important;
    }

    .bg-warning-lighten {
        background-color: rgba(255, 188, 0, 0.15) !important;
    }
</style>
@endsection

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Dashboard Administrativo</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>     
<!-- end page title --> 

<!-- Estadísticas del Sistema -->
<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-office-building-marker widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Total de Empresas">Empresas</h5>
                <h3 class="mt-3 mb-3">{{ $stats['total_empresas'] }}</h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2">{{ $stats['empresas_activas'] }} activas</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-account-multiple widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Total de Usuarios">Usuarios</h5>
                <h3 class="mt-3 mb-3">{{ $stats['total_usuarios'] }}</h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2">{{ $stats['usuarios_activos'] }} activos</span>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Fin Estadísticas -->

<!-- Acciones Rápidas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Acciones Rápidas</h4>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.empresas.create') }}" class="btn btn-success w-100">
                            <i class="mdi mdi-plus-circle me-1"></i>
                            Nueva Empresa
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-primary w-100">
                            <i class="mdi mdi-office-building me-1"></i>
                            Gestionar Empresas
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-info w-100">
                            <i class="mdi mdi-account-plus me-1"></i>
                            Nuevo Usuario
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-info w-100">
                            <i class="mdi mdi-account-multiple me-1"></i>
                            Gestionar Usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Empresas Recientes -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Empresas Recientes</h4>
                
                @if($empresasRecientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>RIF</th>
                                    <th>Usuarios</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empresasRecientes as $empresa)
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">{{ $empresa->nombre }}</h5>
                                        <small class="text-muted">{{ $empresa->codigo }}</small>
                                    </td>
                                    <td>{{ $empresa->rif }}</td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill">{{ $empresa->users_count }}</span>
                                    </td>
                                    <td>
                                        @if($empresa->activo)
                                            <span class="badge bg-success">Activa</span>
                                        @else
                                            <span class="badge bg-danger">Inactiva</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.empresas.show', $empresa->id) }}" class="btn btn-xs btn-light">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="mdi mdi-office-building-outline display-4 text-muted"></i>
                        <h5 class="mt-2">No hay empresas registradas</h5>
                        <p class="text-muted">Comienza creando tu primera empresa</p>
                        <a href="{{ route('admin.empresas.create') }}" class="btn btn-primary">Crear Empresa</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Usuarios Recientes -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Usuarios Recientes</h4>
                
                @if($usuariosRecientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Empresas</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuariosRecientes as $usuario)
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">{{ $usuario->name }}</h5>
                                    </td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        <span class="badge bg-info rounded-pill">{{ $usuario->empresas_count }}</span>
                                    </td>
                                    <td>
                                        @if($usuario->es_admin)
                                            <span class="badge bg-warning">Administrador</span>
                                        @else
                                            <span class="badge bg-secondary">Usuario</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($usuario->activo)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="mdi mdi-account-multiple-outline display-4 text-muted"></i>
                        <h5 class="mt-2">No hay usuarios registrados</h5>
                        <p class="text-muted">Comienza creando el primer usuario</p>
                        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">Crear Usuario</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Resumen del Sistema -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Resumen del Sistema</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-database-check text-success" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mt-0">Base de Datos</h5>
                                <p class="mb-0">Sistema multi-esquema PostgreSQL</p>
                                <small class="text-muted">Esquema público + esquemas por empresa</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-shield-account text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mt-0">Seguridad</h5>
                                <p class="mb-0">Aislamiento total de datos</p>
                                <small class="text-muted">Cada empresa en su propio esquema</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="mdi mdi-cog text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mt-0">Configuración</h5>
                                <p class="mb-0">Panel administrativo central</p>
                                <small class="text-muted">Gestión de empresas y usuarios</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    // Inicializar tooltips
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // Función para mostrar notificaciones (si no la tienes)
    function showToast(message, type = 'success') {
        // Aquí puedes integrar tu sistema de notificaciones
        console.log(`${type}: ${message}`);
        // Ejemplo con Toastr si lo tienes instalado:
        // toastr[type](message);
    }

    // Función de confirmación
    function confirmQuestion(message) {
        return new Promise((resolve) => {
            // Si usas SweetAlert o similar, intégralo aquí
            if (confirm(message)) {
                resolve(true);
            } else {
                resolve(false);
            }
        });
    }
</script>
@endsection