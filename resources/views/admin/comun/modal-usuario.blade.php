    <!-- Modal Usuarios -->
    <div class="modal fade" id="modalUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="frmUsuarios" novalidate>
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUsuariosLabel">Gestión de Usuarios</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertContainer"></div>
                        <div class="row">
                            <!-- Información Básica -->
                            <div class="col-lg-6">
                                <h5 class="mb-3 text-uppercase bg-light p-2">
                                    <i class="mdi mdi-account-circle me-1"></i> Información Personal
                                </h5>

                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre completo" required>
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el email" required>
                                    <div class="invalid-feedback" id="emailError"></div>
                                </div>

                                <!-- Contraseña -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña <span class="text-danger" id="passwordRequired">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Mínimo 8 caracteres (solo para nuevos usuarios)</div>
                                    <div class="invalid-feedback" id="passwordError"></div>
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger" id="passwordConfirmationRequired">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme la contraseña">
                                    <div class="invalid-feedback" id="passwordConfirmationError"></div>
                                </div>
                            </div>

                            <!-- Configuración y Empresas -->
                            <div class="col-lg-6">
                                <!-- Configuración del Usuario -->
                                <h5 class="mb-3 text-uppercase bg-light p-2">
                                    <i class="mdi mdi-cog me-1"></i> Configuración
                                </h5>

                                <!-- Rol de Administrador -->
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="es_admin" name="es_admin" value="1">
                                        <label class="form-check-label" for="es_admin">Usuario Administrador</label>
                                    </div>
                                    <div class="form-text">
                                        Los administradores tienen acceso al panel administrativo global
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" checked>
                                        <label class="form-check-label" for="activo">Usuario Activo</label>
                                    </div>
                                    <div class="form-text">
                                        Los usuarios inactivos no pueden iniciar sesión
                                    </div>
                                </div>

                                <!-- Asignación de Empresas -->
                                <h5 class="mb-3 text-uppercase bg-light p-2 mt-4">
                                    <i class="mdi mdi-office-building me-1"></i> Asignar Empresas
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label mb-0">Seleccionar Empresas</label>
                                    <select class="form-select select2" id="empresas" name="empresas[]" multiple="multiple">
                                    </select>
                                    <div class="invalid-feedback" id="empresasError"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="mdi mdi-close me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="mdi mdi-content-save me-1"></i> <span id="btnText">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal Usuarios -->