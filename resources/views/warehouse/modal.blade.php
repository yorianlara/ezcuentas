<!-- Crear marcas -->
<div class="modal fade" id="modalWarehouse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form  class="needs-validation" novalidate id="frmWarehouse">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Warehouses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="name">Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="location">Location</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="location" name="location" cols="30" rows="10" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <label class="col-md-6 col-form-label" for="status">Status</label>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" name="status" id="status"/>
                                        <label class="form-check-label" for="status" id="lblstatus">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id" value="">
                    <button type="button" class="btn btn-danger" id="cerrar">
                        <i class="mdi mdi-close-thick mdi-18px "></i>
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save-outline mdi-18px "></i>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Crear Marca -->