    <div class="modal fade" id="modalSubValues" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmSubValAttributes">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Extra Value</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                
                                <label class="col-md-4 col-form-label" for="subValueName">Name</label>
                                <input type="text" class="form-control" id="subValueName" name="subValueName" autocomplete="off" required>
                            </div>
                            <div class="col-md-2">
                                <label class="col-md-4 col-form-label" for="tipoSubValue">Type</label>
                                <select name="input_type" class="form-select" id="tipoSubValue" required>
                                    <option value="select">List</option>
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="divSubValues">
                            <div id="toolbarSubVal" class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Input value" aria-label="Input value" aria-describedby="btnGroupAddon" id="nameSubValue"/>
                                    <button id="btnAddSubValue" type="button" class="btn btn-primary">
                                        <i class="mdi mdi-plus-thick mdi-18px"></i>
                                        Add Value
                                    </button> 
                                </div>
                            </div>
                            <table id="tableSubValue"  class="table table-sm table-striped"
                                data-search="true"
                                data-unique-id="id"
                                data-toolbar="#toolbarSubVal"
                                data-search="true"
                                data-show-search-clear-button="true"
                                data-pagination="true"
                                >
                                <thead class="table-light">
                                    <tr>
                                        <th data-field="id" data-width="10" data-visible="false" data-align="center">#</th>
                                        <th data-field="name" data-sortable="true">Values</th>
                                        <th data-field="action" data-width="150" data-align="center" data-formatter="actionSubValuesFormatter">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="idSubVal">
                        <input type="hidden" name="idValue" id="idValue">
                        <input type="hidden" name="idFeature" id="idFeature">
                        <button type="button" class="btn btn-danger" id="cerrarSubVal">
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