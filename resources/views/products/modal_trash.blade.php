<div class="modal fade" id="modalTrash" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Trash</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="toolbarTrash" class="btn-group">
                <button id="restore" class="btn btn-success" title="Restore selected products">
                    <i class="bi bi-recycle"></i> 
                    Restore
                </button>
                <button id="destroy" class="btn btn-danger" title="Delete selected products">
                    <i class="bi bi-trash"></i> 
                    Destroy
                </button>
            </div>
            <table id="tableTrash" class="table table-sm table-striped" 
                data-id-field="id" 
                data-unique-id="id"
                data-click-to-select="true" 
                data-search="true"
                data-show-search-clear-button="true" 
                data-toolbar="#toolbarTrash" 
                data-search-align="right" 
                data-pagination="true"
                data-show-jump-to="true" 
                data-show-button-text="true"
                data-buttons-align="left" 
                data-side-pagination="server"
                data-url="{{ route('products.list', "1")}}" >
                <thead class="table-light">
                    <tr>
                        <th data-field="id" data-visible="false" data-align="center">#</th>
                        <th data-field="fila_color" data-visible="false">Color</th>
                        <th data-field="state" data-width="10" data-checkbox="true" data-align="center"></th>
                        <th data-field="cover_image" data-width="100" data-align="center" data-formatter="imageFormatter">Products</th>
                        <th data-field="sku" data-sortable="true" >SKU</th>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="product_type" data-sortable="true">Type</th>
                        <th data-field="category" data-sortable="true" >Category</th>
                        <th data-field="stock_available" data-align="right" data-sortable="true">Qty.</th>
                        <th data-field="color" data-sortable="true">Color</th>
                        <th data-field="status" data-width="100" data-formatter="statusFormatter">Status</th>
                        <th data-field="status_color"data-visible="false" data-width="100">Status Color</th>
                    </tr>
                </thead>
            </table>
            <div class="row">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated d-none" role="progressbar" aria-valuenow="0" style="width: 0%" id="pb"></div>
                </div>
            </div>
            <div class="row " id="mensajes">
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cierra">
                Close
            </button>
        </div>
      </div>
    </div>
</div>