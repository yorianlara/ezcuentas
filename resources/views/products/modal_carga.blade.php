<div class="modal fade" id="modalCarga" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Cargar Archivo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row table-responsive">
                <form id="frmCarga" enctype="multipart/form-data">
                    <table id="tableCarga" class="table table-sm table-strip d-block table-nowrap" 
                        data-toggle="table"
                        data-height="460"
                        data-search="true"
                        data-pagination="false"
                        data-show-footer="false"
                        data-sort-name="id"
                        data-unique-id="id"
                        >
                        <thead class="table-light">
                            <tr>
                                <th data-field="id" data-visible="true" data-align="center" data-sortable="true">ID</th>
                                <th data-field="excel" data-visible="false" data-formatter="excelFromatter">Excel</th>
                                {{-- <th data-field="accion" data-align="center" data-formatter="actionLoadProductFormatter">Acciones</th> --}}
                                <th data-field="product_type_id" data-sortable="true">Product Type ID</th>
                                <th data-field="brand_id" data-sortable="true">Brand ID</th>
                                <th data-field="sku" data-sortable="true">SKU</th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="collection_name" data-sortable="true">Collection</th>
                                <th data-field="title" data-sortable="true">Title</th>
                                <th data-field="description" data-sortable="true" data-formatter="descriptionFormatter">Description</th>
                                <th data-field="notes" data-sortable="true">Notes</th>
                                <th data-field="map_enforced" data-sortable="true">Map Enforced</th>
                                <th data-field="map" data-sortable="true">Map</th>
                                <th data-field="msrp" data-sortable="true">MSRP</th>
                                <th data-field="price" data-sortable="true">Price</th>
                                <th data-field="wholesale_price" data-sortable="true">Wholesale Price</th>
                                <th data-field="upc" data-sortable="true">UPC</th>
                                <th data-field="url_barcode" data-sortable="true">URL Barcode</th>
                                <th data-field="weight" data-sortable="true">Weight</th>
                                <th data-field="weight_unit" data-sortable="true">Weight Unit</th>
                                <th data-field="height" data-sortable="true">Height</th>
                                <th data-field="width" data-sortable="true">Width</th>
                                <th data-field="depth" data-sortable="true">Depth</th>
                                <th data-field="dimension_unit" data-sortable="true">Dimension Unit</th>
                                <th data-field="casepack" data-sortable="true">Casepack</th>
                                <th data-field="ship_via_id" data-sortable="true">Ship Via ID</th>
                                <th data-field="package_type_id" data-sortable="true">Package Type ID</th>
                                <th data-field="is_bundle" data-sortable="true">Is Bundle</th>
                                <th data-field="parent_product_id" data-sortable="true">Parent Product ID</th>
                                <th data-field="status_id" data-sortable="true">Status ID</th>
                                <th data-field="origin_id" data-sortable="true">Origin ID</th>
                                <th data-field="pallet_id" data-sortable="true">Pallet ID</th>
                                <th data-field="boxcontent_id" data-sortable="true">Box Content ID</th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
            <div class="row">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated d-none" role="progressbar" aria-valuenow="0" style="width: 0%" id="pb"></div>
                </div>
            </div>
            <div class="row " id="mensajes">
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="validar">
                <i class="fas fa-spinner" id="proc"></i>
                Procesar
            </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cierra">
                Cerrar
            </button>
        </div>
      </div>
    </div>
</div>