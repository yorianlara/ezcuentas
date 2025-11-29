<div class="modal fade" id="modalValues" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmValues">
                    @csrf
                    <input type="hidden" name="attribute_id" id="attribute_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Value</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="nameVal">Value</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="name" id="nameVal" cols="20" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="orderVal">Order</label>
                                    <div class="col-md-9">
                                        <input type="number" name="orderVal" id="orderVal" min="0" class="form-control" placeholder="Order (0 for default)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label" for="statusVal">Status</label>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="statusVal2"/>
                                            <label class="form-check-label" for="statusVal2" id="lblstatusVal2">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="idVal" id="idVal" value="">
                        <input type="hidden" name="attribute_id" id="attribute_id" value="">
                        <button type="button" class="btn btn-danger" id="cerrarVal">
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