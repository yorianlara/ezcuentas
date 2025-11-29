<div class="offcanvas offcanvas-end offcanvas-p"  data-bs-backdrop="static" tabindex="-1" id="offcanvasStock" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-primary">
        <input type="hidden" name="id" id="id">
        <button type="button" class="btn-close btn-close-white" id="closeStock"></button>
        <div class="d-flex justify-content-center">
            <div class="col-auto">
                <h3 class="mb-2 text-light" id="stockTitle">Stock</h3>
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <div id="alertProduct"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div id="toolbarStock">
                            <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Add Stock' onclick='crear()'>
                                <i class="mdi mdi-plus-circle me-1"></i> 
                                Add
                            </a>
                        </div>
    
                        <table id="tableStock"  class="table table-sm table-striped"
                            data-unique-id="id"
                            >
                            <thead class="table-light">
                                <tr>
                                    <th data-field="id" data-visible="false" class="text-center">#</th>
                                    <th data-field="products.images" class="text-center" data-formatter="imageFormatter">Products</th>
                                    <th data-field="products.sku" data-sortable="true">SKU</th>
                                    <th data-field="products.name" data-sortable="true">Name</th>
                                    <th data-field="products.categories" data-sortable="true" data-formatter="categoriesFormatter">Category</th>
                                    <th data-field="stock" data-align="right" data-sortable="true">Stock</th>
                                    <th data-field="products.attributes" data-sortable="true" data-formatter="colorFormatter">Color</th>
                                    <th  data-align="center" data-formatter="actionStockFormatter">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>