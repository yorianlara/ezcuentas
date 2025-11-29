<div class="offcanvas offcanvas-end offcanvas-p" data-bs-backdrop="static" tabindex="-1" id="offcanvasRight"
  aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header bg-primary">
    <input type="hidden" name="id" id="id">
    <button type="button" class="btn-close btn-close-white" id="closeProduct"></button>
    <div class="d-flex justify-content-center">
      <div class="col-auto">
        <h3 class="mb-2 text-light">Products</h3>
      </div>
    </div>
    <div class="row flex-between-end">
      <div class="col-auto">
        <button class="btn btn-info me-2 mb-2 mb-sm-0" type="button" id="toggleAllBtn">
          <i class="mdi mdi-chevron-up"></i> Collapse All
        </button>
        <button class="btn btn-danger me-2 mb-2 mb-sm-0" type="button" id="prodCancel">
          <i class="mdi mdi-close-thick mdi-18px "></i>
          Discard
        </button>
        <button class="btn btn-success me-2 mb-2 mb-sm-0" type="button" id="prodSave">
          <i class="mdi mdi-content-save-outline mdi-18px "></i>
          Save
        </button>
        <button class="btn btn-success me-2 mb-2 mb-sm-0" type="button" id="prodSaveClose">
          <i class="mdi mdi-content-save-outline mdi-18px "></i>
          Save & Close
        </button>
      </div>
    </div>
  </div>
  <div class="offcanvas-body">
    <div id="alertProduct"></div>
    <div class="row">
      <form class="mb-9" action="#" id="formProducts">
        <div class="row">
          <div class="col-12 col-xl-9">
            <!-- Basic Info -->
            <div class="card border border-primary mb-3">
              <div class="card-header">
                <div class="card-widgets">
                  <a data-bs-toggle="collapse" class="toggleCards" href="#cardCollpaseInfo" role="button" aria-expanded="false" aria-controls="cardCollpaseInfo">
                    <i class="mdi mdi-minus"></i>
                  </a>
                </div>
                <h5 id="basic_info">Product</h5>
              </div><!-- end card-header -->
              <div id="cardCollpaseInfo" class="collapse show cont">
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-6">
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="product_type">
                          Type <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                          <div class="input-group">
                            <select class="form-select new" id="product_type" name="product_type" required>
                            </select>
                            <button type="button" class="btn btn-primary btnAddOpt" data-type="pt"
                              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                              data-bs-title="Add Option">
                              <i class="bi-plus"></i>
                            </button>
                            <div class="invalid-feedback text-danger">
                              Please select an option.
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label " for="sku">SKU <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                          <div class="input-group">
                            <input type="text" autocomplete="off" class="form-control input_capital" id="sku" name="sku" required>
                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip"
                              data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Generate SKU" id="SKGenerate">
                              <i class="bi bi-arrow-clockwise"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="name">Name <span
                            class="text-danger">*</span></label>
                        <div class="col-md-9">
                          <input type="text" autocomplete="off" id="name" name="name" class="form-control" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="statusP">Status <span
                            class="text-danger">*</span></label>
                        <div class="col-md-9">
                          <div class="input-group">
                            <select class="form-select new" id="statusP" name="statusP" required>
                            </select>
                            <button type="button" class="btn btn-primary btnAddOpt" data-type="ps"
                              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                              data-bs-title="Add Option">
                              <i class="bi-plus"></i>
                            </button>
                            <div class="invalid-feedback text-danger">
                              Please select an option.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- end col -->
                    <div class="col-6">
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="origin">Origin <span
                            class="text-danger">*</span></label>
                        <div class="col-md-9">
                          <div class="input-group">
                            <select class="form-select new" id="origin" name="origin" required>
                            </select>
                            <button type="button" class="btn btn-primary btnAddOpt" data-type="po"
                              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                              data-bs-title="Add Option">
                              <i class="bi-plus"></i>
                            </button>
                            <div class="invalid-feedback text-danger">
                              Please select an option.
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="brand">Brand <span
                            class="text-danger">*</span></label>
                        <div class="col-md-9">
                          <div class="input-group">
                            <select class="form-select new" id="brand" name="brand" required>
                            </select>
                            <button type="button" class="btn btn-primary btnAddOpt" data-type="pb"
                              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                              data-bs-title="Add Option">
                              <i class="bi-plus"></i>
                            </button>
                            <div class="invalid-feedback text-danger">
                              Please select an option.
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="collection">Collection</label>
                        <div class="col-md-9">
                          <input type="text" autocomplete="off" id="collection" name="collection" class="form-control">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="wholesale_price">Wholesale price</label>
                        <div class="col-md-3">
                          <input class="form-control" type="number" min="0" name="wholesale_price" id="wholesale_price" step="0.01">
                        </div>
                        <label class="col-md-3 col-form-label" for="mapCtrl">Map Controller</label>
                        <div class="col-md-3">
                            <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="mapCtrl" name="mapCtrl" />
                            <label class="form-check-label" for="mapCtrl" id="lblmapCtrl">No</label>
                        </div>    
                      </div>
                    </div> <!-- end col -->
                  </div> <!-- end row -->
                  <div class="row">
                    <div class="col-12 col-lg-2">
                      <h5 class="mb-2">Height</h5>
                      <input class="form-control" type="number" min="0" name="height" id="height" step="0.01"
                        placeholder="Enter height">
                    </div>
                    <div class="col-12 col-lg-2">
                      <h5 class="mb-2">Width</h5>
                      <input class="form-control" type="number" min="0" name="width" id="width" step="0.01"
                        placeholder="Enter width">
                    </div>
                    <div class="col-12 col-lg-2">
                      <h5 class="mb-2">Large</h5>
                      <input class="form-control" type="number" min="0" name="depth" id="depth" step="0.01"
                        placeholder="Enter large">
                    </div>
                    <div class="col-12 col-lg-2">
                      <h5 class="mb-2">Dimension Unit</h5>
                      <select class="form-select new" name="dimension_unit" id="dimension_unit">
                      </select>
                    </div>
                    <div class="col-12 col-lg-2">
                      <h5 class="mb-2">Weight</h5>
                      <input class="form-control" type="number" min="0" name="weight" id="weight" step="0.01"
                        placeholder="Enter weight">
                    </div>
                    <div class="col-12 col-lg-2">
                      <h5 class="mb-2">Weight Unit</h5>
                      <select class="form-select new" name="weight_unit" id="weight_unit">
                      </select>
                    </div>
                  </div>
                </div><!-- end card-body -->
              </div><!-- card collapse -->
            </div> <!-- end card -->

            <!-- Inventory -->
            <div class="card border border-primary mb-3">
              <div class="card-header">
                <div class="card-widgets">
                  <a data-bs-toggle="collapse" class="toggleCards" href="#cardCollpaseInventory" role="button" aria-expanded="false"
                    aria-controls="cardCollpaseInventory">
                    <i class="mdi mdi-minus"></i>
                  </a>
                </div>
                <h5 id="inventoryInfo">Details</h5>
              </div>
              <div id="cardCollpaseInventory" class="collapse show cont">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-2">
                      <div class="nav flex-column nav-pills nav-pills-tab" id="inventoryTab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="attributesTab" data-bs-toggle="pill" href="#attributesTabContent"
                          role="tab" aria-controls="attributesTabContent" aria-selected="false">
                          <i class="mdi mdi-tune me-sm-2 fs-4 nav-icons"></i>
                          Features
                        </a>
                        <a class="nav-link" id="extraTab" data-bs-toggle="pill" href="#extraTabContent" role="tab"
                          aria-controls="extraTabContent" aria-selected="false">
                          <i class="mdi mdi-folder-information-outline me-sm-2 fs-4 nav-icons"></i>
                          Colors
                        </a>
                        <a class="nav-link" id="associationsTab" data-bs-toggle="pill" href="#associationTabContent"
                          role="tab" aria-controls="associationTabContent" aria-selected="false">
                          <i class="mdi mdi-view-grid-plus-outline me-sm-2 fs-4 nav-icons"></i>
                          Components
                        </a>
                        
                        <a class="nav-link" id="shippingTab" data-bs-toggle="pill" href="#shippingTabContent" role="tab"
                          aria-controls="shippingTabContent" aria-selected="false">
                          <i class="mdi mdi-truck-outline me-sm-2 fs-4 nav-icons"></i>
                          Shipping
                        </a>
                        {{-- <a class="nav-link" id="thirdPartyTab" data-bs-toggle="pill" href="#thirdPartyTabContent"
                          role="tab" aria-controls="thirdPartyTabContent" aria-selected="false">
                          <i class="mdi mdi-numeric-3-box-outline me-sm-2 fs-4 nav-icons"></i>
                          Third Party Info
                        </a> --}}
                      </div>
                    </div> <!-- end col-->
                    <div class="col-sm-10 ">
                      <div class="tab-content pt-0">
                        <div class="tab-pane fade active show" id="attributesTabContent" role="tabpanel"
                          aria-labelledby="v-pills-profile-tab">
                          <div class="row mb-12">
                            <div class="row" id="attributes-container">
                                
                            </div>
                             <div id="extraFieldsContainer" class="row">
                              <!-- Los campos extra se cargarán aquí dinámicamente -->
                             </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="extraTabContent" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                          <div class="row mb-3">
                            <div class="col-md-3">
                              <label for="product_part">Prod. Part</label>
                              <div class="input-group">
                                <select class="form-select new" id="product_part" name="product_part">
                                </select>
                                <button type="button" class="btn btn-primary btnAddOpt" data-type="pp"
                                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                  data-bs-title="Add Option">
                                  <i class="bi-plus"></i>
                                </button>
                                <div class="invalid-feedback text-danger">
                                  Please select an option.
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <label for="material">Material</label>
                              <div class="input-group">
                                <select class="form-select new" id="material" name="material">
                                </select>
                                <button type="button" class="btn btn-primary btnAddOpt" data-type="pm"
                                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                  data-bs-title="Add Option">
                                  <i class="bi-plus"></i>
                                </button>
                                <div class="invalid-feedback text-danger">
                                  Please select an option.
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <label for="color">Color</label>
                              <div class="input-group">
                                <select class="form-select new" id="color" name="color">
                                </select>
                                <button type="button" class="btn btn-primary btnAddOpt" data-type="pc"
                                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                  data-bs-title="Add Option">
                                  <i class="bi-plus"></i>
                                </button>
                                <div class="invalid-feedback text-danger">
                                  Please select an option.
                                </div>
                              </div>
                            </div>
                            <div class="col col-md-1">
                              <label for="agregar">Add</label><br>
                              <button type="button" class="btn btn-success" id="agregarMC">
                                <i class="mdi mdi-plus-circle-outline"></i>
                              </button>
                            </div>
                          </div>
                          <div class="row ">
                            <div class="col-md-12">
                              <div>
                                <button type="button" class="btn btn-danger btn-sm disabled"
                                  id="deleteMC">Delete</button>
                              </div>
                              <table id="tableMC" class="table table-sm table-striped" data-id-field="id" data-unique-id="id"
                                data-click-to-select="true" data-height="260">
                                <thead class="table-light">
                                  <tr>
                                    <th data-field="state" data-checkbox="true">
                                    </th>
                                    <th data-field="id" data-visible="false">
                                      ID
                                    </th>
                                    <th data-field="parts">
                                      Parts
                                    </th>
                                    <th data-field="parts_id" data-visible="false">
                                      Parts
                                    </th>
                                    <th data-field="material">
                                      Materials
                                    </th>
                                    <th data-field="material_id" data-visible="false">
                                      Materials
                                    </th>
                                    <th data-field="color">
                                      Colors
                                    </th>
                                    <th data-field="color_id" data-visible="false">
                                      Colors
                                    </th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>

                        </div>
                        <div class="tab-pane fade" id="associationTabContent" role="tabpanel"
                          aria-labelledby="v-pills-settings-tab">
                          <div class="row g-3">
                            <ul class="nav nav-tabs nav-bordered nav-justified">
                              <li class="nav-item"> 
                                <a href="#childs" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                  <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                  <span class="d-none d-sm-inline-block">Child's</span>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="#bundles" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                  <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                  <span class="d-none d-sm-inline-block">Bundle</span>
                                </a>
                              </li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="childs">
                                <div class="row mb-3">
                                  <div class="col col-md-7">
                                    <label for="child_products">Select child products</label>
                                    <select name="child_products" id="child_products"></select>
                                  </div>
                                  <div class="col col-md-2">
                                    <label for="">Add</label><br>
                                    <button type="button" class="btn btn-success" id="addChld">
                                      <i class="mdi mdi-plus-circle-outline"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="row mb-12">
                                  <div>
                                    <button type="button" class="btn btn-danger btn-sm disabled"
                                      id="deleteChld">Delete</button>
                                  </div>
                                  <table id="tableChld" class="table table-sm table-striped" data-id-field="id" data-unique-id="id" data-click-to-select="true" data-height="260">
                                    <thead class="table-light">
                                      <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="id" data-visible="false">#</th>
                                        <th data-field="sku">SKU</th>
                                        <th data-field="name">Name</th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                              <div class="tab-pane" id="bundles">
                                <div class="row mb-3">
                                  <div class="col col-md-7">
                                    <label for="bundle_products">Select products to bundle</label>
                                    <select name="bundle_products" id="bundle_products"></select>
                                  </div>
                                  <div class="col col-md-3">
                                    <label for="qty">Quantity</label>
                                    <input class="form-control" type="number" min="0" name="qty" id="qty" step="1" placeholder="Enter quantity">
                                  </div>
                                  <div class="col col-md-2">
                                    <label for="">Add</label><br>
                                    <button type="button" class="btn btn-success" id="addBnd">
                                      <i class="mdi mdi-plus-circle-outline"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="row mb-12">
                                  <div>
                                    <button type="button" class="btn btn-danger btn-sm disabled" id="deleteBnd">
                                      Delete
                                    </button>
                                  </div>
                                  <table id="tableBnd" class="table table-sm table-striped" data-id-field="id" data-unique-id="id" data-click-to-select="true" data-height="260">
                                    <thead class="table-light">
                                      <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="id" data-visible="false">#</th>
                                        <th data-field="sku">SKU</th>
                                        <th data-field="name">Name</th>
                                        <th data-field="qty">Qty</th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="thirdPartyTabContent" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                          <div class="row mb-3">
                            <div class="col col-md-5">
                              <label for="">Customer</label>
                              <div class="input-group">
                                <select class="form-select new" name="customer" id="customer"></select>
                                <button type="button" class="btn btn-primary btnAddCust" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                  data-bs-title="Add">
                                  <i class="bi-plus"></i>
                                </button>
                                <div class="invalid-feedback text-danger">
                                  Please select an option.
                                </div>
                              </div>
                            </div>
                            <div class="col col-md-5">
                              <label for="">Third Party SKU</label>
                              <input type="text" class="form-control" name="tpsku" id="tpsku">
                            </div>
                            <div class="col col-md-2">
                              <label for="">Add</label><br>
                              <button type="button" class="btn btn-success" id="addTPsku">
                                <i class="mdi mdi-plus-circle-outline"></i>
                              </button>
                            </div>
                          </div>
                          <div class="row mb-12">
                            <div>
                              <button type="button" class="btn btn-danger btn-sm disabled" id="deleteTPsku">
                                Delete
                              </button>
                            </div>
                            <table id="tableTPSKU" class="table table-sm table-striped" data-id-field="id" data-unique-id="id" data-click-to-select="true" data-height="260">
                              <thead class="table-light">
                                <tr>
                                  <th data-field="state" data-checkbox="true"></th>
                                  <th data-field="id" data-visible="false">#</th>
                                  <th data-field="customer_id" data-visible="false">NameID</th>
                                  <th data-field="customer">Customer</th>
                                  <th data-field="customer_sku">SKU</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="shippingTabContent" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                          <div class="row g-3">
                            <ul class="nav nav-tabs nav-bordered nav-justified">
                              <li class="nav-item">
                                <a href="#shippingInfo" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                  <span class="d-inline-block d-sm-none">
                                    <i class="mdi mdi-information-outline"></i>
                                  </span>
                                  <span class="d-none d-sm-inline-block">Info.</span>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="#shippingDetails" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                  <span class="d-inline-block d-sm-none">
                                    <i class="mdi mdi-format-list-bulleted"></i>
                                  </span>
                                  <span class="d-none d-sm-inline-block">Details</span>
                                </a>
                              </li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="shippingInfo">
                                <div class="row g-3">
                                  <div class="col-12 col-lg-6">
                                    <label for="ship_via">Ship Via</label>
                                    <select name="ship_via" class="form-select new" id="ship_via">
                                    </select>
                                  </div>
                                  <div class="col-12 col-lg-6">
                                    <label for="package_type">Package Type</label>
                                    <div class="input-group">
                                      <select name="package_type" class="form-select new" id="package_type">
                                      </select>
                                      <button type="button" class="btn btn-primary btnAddOpt" data-type="ppt"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="custom-tooltip" data-bs-title="Add Option">
                                        <i class="bi-plus"></i>
                                      </button>
                                      <div class="invalid-feedback text-danger">
                                        Please select an option.
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row g-3">
                                  <div class="col-12 col-lg-6">
                                    <label class="col-md-3 col-form-label" for="upc">UPC#</label>
                                    <div class="input-group">
                                      <input type="text" autocomplete="off" id="upc" name="upc" class="form-control">
                                      <button class="btn btn-primary waves-effect waves-light" type="button" id="barcode">
                                        <i class="fas fa-barcode"></i>
                                      </button>
                                    </div>
                                  </div>
                                  <div class="col-12 col-lg-6">
                                    <label for="package_type">Barcode</label>
                                    <img src="assets/images/logo-sm.png" alt="image" class="img-fluid img-thumbnail" width="200" id="codigobarra">
                                    <img src="assets/images/logo-sm.png" alt="image" class="img-fluid img-thumbnail" width="150" id="codigoQR">
                                  </div>
                                </div>
                              </div>
                              <div class="tab-pane" id="shippingDetails">
                                <div class="btn-group" role="group" aria-label="Basic example" id="shippingDetailsButtons">
                                  <button type="button" class="btn btn-primary mb-3" id="addShippingDetails">
                                    <i class="mdi mdi-plus-circle me-1"></i> 
                                    Add Shipping Details
                                  </button>
                                  <button type="button" class="btn btn-success mb-3" id="generateChild">
                                    <i class="mdi mdi-cog-sync me-1"></i> 
                                    Generate child's
                                  </button>
                                  <input type="hidden" name="countChild" id="countChild">
                                </div>
                                <div class="card card-body border border-primary" id="shippingDetailsCard">
                                  <div class="row">
                                    <div class="col col-md-4">
                                      <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="contentBoxD">
                                          Content 
                                        </label>
                                        <div class="col-md-9">
                                          <div class="input-group">
                                            <select class="form-select new" id="contentBoxD" name="contentBoxD">
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col col-md-4">
                                      <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="shipViaD">
                                          Ship Via
                                        </label>
                                        <div class="col-md-9">
                                          <div class="input-group">
                                            <select class="form-select new" id="shipViaDetail" name="shipViaD">
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col col-md-4">
                                      <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="packingDetail">
                                          Packing
                                        </label>
                                        <div class="col-md-9">
                                          <div class="input-group">
                                            <select class="form-select new" id="packingDetail" name="packingDetail">
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col col-md-12">
                                      <div class="input-group mb-3">
                                      <input type="number" class="form-control" placeholder="Length" aria-label="links" aria-describedby="button-addon2" id="shipDlength">
                                      <input type="number" class="form-control" placeholder="Width" aria-label="links" aria-describedby="button-addon2" id="shipDwidth">
                                      <input type="number" class="form-control" placeholder="Height" aria-label="links" aria-describedby="button-addon2" id="shipDheight">
                                      <input type="number" class="form-control" placeholder="Lbs" aria-label="links" aria-describedby="button-addon2" id="shipDlbs">
                                      <input type="number" class="form-control" placeholder="CBM" aria-label="Content" aria-describedby="button-addon2" id="shipDcbm" readonly>
                                      <button class="btn btn-outline-success" type="button" id="addShippingDetail">
                                          <i class="mdi mdi-plus-circle me-1"></i> 
                                          Add
                                      </button>
                                      <button class="btn btn-outline-danger" type="button" id="cancelShippingDetail">
                                          <i class="mdi mdi-close-circle me-1"></i> 
                                          Close
                                      </button>
                                    </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row g-3">
                                  <div class="col com-md-12">
                                    <table class="table table-sm table-striped" 
                                      id="tableShipping"
                                      data-show-footer="true" 
                                      data-sort-name="content"
                                      data-sort-order="asc"
                                      data-id-field="id" 
                                      data-unique-id="id">
                                      <thead class="table-primary">
                                        <tr>
                                          <th rowspan="2" data-valign="middle" data-visible="false" data-field="id">
                                            ID
                                          </th>
                                          <th colspan="3" class="text-center">
                                            Case Pack
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-align="center" data-field="large">
                                            L
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-align="center" data-field="width">
                                            W
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-align="center" data-field="height">
                                            H
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-align="right" data-field="lbs" data-footer-formatter="additionFormatter">
                                            Lbs
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-field="shipvia">
                                            Ship Via
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-field="packing">
                                            Packing
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-align="right" data-field="cbm" data-footer-formatter="additionFormatter">
                                            CBM
                                          </th>
                                          <th rowspan="2" data-valign="middle" data-align="center"  data-formatter="shippingActionFormatter">
                                            Delete
                                          </th>
                                        </tr>
                                        <tr>
                                          <th data-with="100" data-field="content" data-footer-formatter="idFormatter">
                                            Box #
                                          </th>
                                          <th data-field="box_content_text">
                                            Content
                                          </th>
                                          <th data-field="box_content_id" data-visible="false">
                                            Box C.
                                          </th>
                                        </tr>
                                      </thead>
                                    </table>
                                  </div>
                                </div>
                                <div class="row mt-3">
                                  <div class="table-responsive">
                                    <table id="tblInformation" class="table table-sm table-bordered">
                                      <tr>
                                        <td colspan="2">
                                          <select class="form-select new" name="gralShipVia" id="gralShipVia">
                                          </select>
                                          <div class="invalid-feedback text-danger">
                                            Please select an option.
                                          </div>
                                        </td>
                                        <td colspan="2">
                                          <div class="input-group">
                                            <select class="form-select new" name="pallet" id="pallet">
                                            </select>
                                            <button type="button" class="btn btn-primary btnAddOpt" data-type="pal"
                                              data-bs-toggle="tooltip" data-bs-placement="top"
                                              data-bs-custom-class="custom-tooltip" data-bs-title="Add Option">
                                              <i class="bi-plus"></i>
                                            </button>
                                            <div class="invalid-feedback text-danger">
                                              Please select an option.
                                            </div>
                                          </div>
                                        </td>
                                        <td class="align-middle bg-primary text-light" width="15%">
                                          Freight Class
                                        </td>
                                        <td id="fclass" class="align-middle text-end" width="10%">
                                        </td>
                                        <td id="density" class="align-middle text-end" width="10%">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="text-center" width="15%">Width</td>
                                        <td class="text-center" width="15%">Length</td>
                                        <td class="text-center" width="15%">Height +5</td>
                                        <td class="text-center" width="15%">Lbs</td>
                                        <td class="bg-primary text-light">Total CBM</td>
                                        <td colspan="2" class="text-end" id="cbm"></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center" id="pWidth"></td>
                                        <td class="text-center" id="pLenght"></td>
                                        <td class="text-center" id="pHeight"></td>
                                        <td class="text-center" id="pLbs"></td>
                                        <td class="bg-primary text-light"> Total CBF </td>
                                        <td colspan="2" class="text-end" id="cbf"></td>
                                      </tr>
                                      <tr>
                                        <td class="bg-primary text-light">
                                          Requirements
                                        </td>
                                        <td colspan="3" id="req" contenteditable="true"></td>
                                        <td class="bg-primary text-light">
                                          Pallet Only Lbs
                                        </td>
                                        <td colspan="2" class="text-end" id="pol"></td>
                                      </tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- end col-->
                  </div> <!-- end row-->
                </div>
              </div>
            </div>

            <!-- Display images -->
            <div class="card border border-primary mb-3">
              <div class="card-header">
                <div class="card-widgets">
                  <a data-bs-toggle="collapse" class="toggleCards" href="#cardCollpaseImg" role="button" aria-expanded="false"
                    aria-controls="cardCollpaseImg"><i class="mdi mdi-minus"></i></a>
                </div>
                <h5 id="displayImagesInfo">Display images</h5>
              </div>
              <div id="cardCollpaseImg" class="collapse show cont">
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-5">
                      <label for="cover">Main Image</label>
                      <input type="file" name="cover" accept="image/*,application/pdf" id="cover">
                    </div>
                    <!-- end col -->
                    <div class="col-7">
                      {{-- <input type="file" class="form-control" name="image" id="otherImage">
                      --}}
                      <label for="uploadBtn">Others Images</label><br>
                      <button type="button" id="uploadBtn" class="btn btn-primary mb-2">
                        <i class="bi-folder2-open"></i>
                        Browse ...
                      </button>
                      <!-- Input para seleccionar múltiples imágenes -->
                      <input type="file" id="otherImage" class="d-none" accept="image/*,application/pdf" onchange="loadFile(event)" multiple>

                      <!-- Contenedor donde se mostrarán las imágenes -->
                      <div id="idimage" class="image-container"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end card-box-->
          </div>
          <div class="col-12 col-xl-3">
            <!-- Categories Sidebar -->
            <div class="card border border-primary mb-3">
              <div class="card-header">
                <div class="card-widgets">
                  <a data-bs-toggle="collapse" class="toggleCards" href="#cardCollpase9" role="button" aria-expanded="false"
                    aria-controls="cardCollpase2">
                    <i class="mdi mdi-minus"></i>
                  </a>
                </div>
                <h5 class="mb-2" id="category_info">Categories <span class="text-danger">*</span></h5>
              </div>
              <div id="cardCollpase9" class="collapse show cont">
                <div class="card-body">
                  <div class="row">                    

                      <div class="input-group">
                        <input type="text" class="form-control" name="jstree_q" id="jstree_q" placeholder="Search">
                        <button class="btn btn-primary waves-effect waves-light" type="button" id="searchClear">
                          <i class="far fa-trash-alt"></i>
                        </button>
                      </div>

                  </div>
                  <h5 id="event_result">

                  </h5>
                  <div id="jstree">

                  </div>
                </div>
              </div>
            </div>
            <!-- Description Sidebar-->
            <div class="card border border-primary mb-3" id="aiCardDescription">
              <div class="card-header">
                <div class="card-widgets">
                  <a data-bs-toggle="collapse"  class="toggleCards" href="#cardDescription" role="button" aria-expanded="false"
                    aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                </div>
                <h5 class="mb-2" id="description_info">Description</h5>
              </div>
              <div id="cardDescription" class="collapse show cont">
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col col-md-12">
                      <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-sm" id="generate">
                          <i class="mdi mdi-head-snowflake-outline"></i>
                          AI Description
                        </button>
                      </div>
                      <label for="titleDescription">Title</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="titleDescription" name="title"
                          aria-describedby="basic-addon1">
                        <span class="input-group-text" id="candado"><i id="imgLock"
                            class="mdi mdi-lock-open-variant-outline"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col col-md-12">
                      <label for="titleDescription">Description</label>
                      <textarea class="form-control" name="textDescription" id="textDescription" cols="30"
                        rows="10"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Notes Sidebar -->
            <div class="card border border-primary mb-3">
              <div class="card-header">
                <div class="card-widgets">
                  <a data-bs-toggle="collapse" class="toggleCards" href="#cardCollpase11" role="button" aria-expanded="false"
                    aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                </div>
                <h5 class="mb-2" id="notes_info">Notes</h5>
              </div>
              <div id="cardCollpase11" class="collapse show cont">
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col col-md-12">
                      <label for="textNotes">Notes</label>
                      <textarea class="form-control" name="textNotes" id="textNotes" cols="30"
                        rows="10"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="d-none" id="qrcode">

</div>