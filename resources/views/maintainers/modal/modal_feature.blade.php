    <div class="modal fade" id="modalAttributes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmAttributes">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Feature</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-md-4 col-form-label" for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                            </div>
                            <div class="col-md-2">
                                <label class="col-md-4 col-form-label" for="tipo">Type</label>
                                <select name="input_type" class="form-select" id="tipo" required>
                                    <option value="select">List</option>
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-4 col-form-label" for="status">Status</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="status"/>
                                    <label class="form-check-label" for="status" id="lblstatus">Inactive</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="col-md-4 col-form-label" for="global">Global</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="global"/>
                                    <label class="form-check-label" for="global" id="lblglobal">No</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="divValues">
                            <div id="toolbarVal" class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Input value" aria-label="Input value" aria-describedby="btnGroupAddon" id="nameValue"/>
                                    <div class="form-check form-switch me-2">
                                        <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="statusVal"/>
                                        <label class="form-check-label" for="statusVal" id="lblstatusVal">Inactive</label>
                                    </div>
                                    <button id="btnAddValue" type="button" class="btn btn-primary">
                                        <i class="mdi mdi-plus-thick mdi-18px"></i>
                                        Add Value
                                    </button> 
                                </div>
                            </div>
                            <table id="tableValue"  class="table table-sm table-striped"
                                data-search="true"
                                data-unique-id="id"
                                data-toolbar="#toolbarVal"
                                data-search="true"
                                data-show-search-clear-button="true"
                                data-pagination="true"
                                >
                                <thead class="table-light">
                                    <tr>
                                        <th data-field="id" data-width="10" data-visible="false" data-align="center">#</th>
                                        <th data-field="attribute_id" data-visible="false" data-align="center">#</th>
                                        <th data-field="name" data-sortable="true">Values</th>
                                        <th data-field="status" data-sortable="true" data-align="center" data-formatter="statusFormatter">Status</th>
                                        <th data-field="action" data-width="150" data-align="center" data-formatter="actionFeatureValuesFormatter">Action</th>
                                    </tr>
                                </thead>
                            </table>
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