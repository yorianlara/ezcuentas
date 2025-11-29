<div class="modal fade" id="modalDiscount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form class="needs-validation" novalidate id="frmDiscount">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Discount Rule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-2">
                          <div class="nav flex-column nav-pills nav-pills-tab" id="discountsTab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link active" id="infoTab" data-bs-toggle="pill" href="#infoTabContent"
                              role="tab" aria-controls="infoTabContent" aria-selected="true">
                              <i class="mdi mdi-information-outline me-sm-2 fs-4 nav-icons"></i>
                              <span class=" d-sm-inline">Information</span>
                            </a>
                            <a class="nav-link" id="conditionsTab" data-bs-toggle="pill" href="#conditionsTabContent"
                              role="tab" aria-controls="conditionsTabContent" aria-selected="false">
                              <i class="mdi mdi-swap-horizontal-circle-outline me-sm-2 fs-4 nav-icons"></i>
                              Conditions
                            </a>
                            <a class="nav-link" id="actionsTab" data-bs-toggle="pill" href="#actionsTabContent" role="tab"
                              aria-controls="actionsTabContent" aria-selected="false">
                              <i class="mdi mdi-cog-sync-outline me-sm-2 fs-4 nav-icons"></i>
                              Actions
                            </a>
                          </div>
                        </div> <!-- end col-->
                        <div class="col-sm-10 ">
                          <div class="tab-content pt-0">
                            <div class="tab-pane fade active show" id="infoTabContent" role="tabpanel"
                              aria-labelledby="v-pills-home-tab">
                              <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                  <h5 class="mb-2">Name</h5>
                                  <input class="form-control" type="text" name="name" id="name" placeholder="Enter rule name" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                  <h5 class="mb-2">Description</h5>
                                  <input class="form-control" type="text" name="description" id="description" placeholder="Enter description" required>
                                </div>
                                <div class="col-12 col-lg-12">
                                  <label class="col-md-6 col-form-label" for="status">
                                    Status
                                </label>
                                  <div class="col-md-6">
                                    <div class="form-check form-switch">
                                      <input type="checkbox" data-plugin="switchery" data-color="#1bb99a"
                                        data-secondary-color="#ff5d48" id="status" name="status" />
                                      <label class="form-check-label" for="status" id="lblstatus">Inactive</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="conditionsTabContent" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                              <div class="row">
                                <div class="col col-md-3">
                                  <input type="checkbox" name="customersChk" id="customersChk">
                                  <label class="text-muted" for="customersChk">Limit customers</label>
                                </div>
                              </div>
                              <div class="row mb-3 d-none" id="r-customers">
                                <div class="col-12 col-lg-12">
                                  <h5>Customers</h5>
                                  <select class="form-select new" name="customers[]" id="customers" multiple></select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col col-md-3">
                                  <input type="checkbox" name="categoriesChk" id="categoriesChk">
                                  <label class="text-muted" for="categoriesChk">Restrict to customer category</label>
                                </div>
                              </div>
                              <div class="row mb-3 d-none" id="r-categories">
                                <div class="col-12 col-lg-12">
                                  <h5>Customers Categories</h5>
                                  <select class="form-select new" name="customers_categories[]" id="customers_categories" multiple>
                                  </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col col-md-3">
                                  <input type="checkbox" name="productsChk" id="productsChk">
                                  <label class="text-muted" for="productsChk">Restrict to products</label>
                                </div>
                              </div>
                              <div class="row mb-3 d-none" id="r-products">
                                <div class="row mb-3">
                                  <div class="col col-md-7">
                                    <label for="products">Select product</label>
                                    <select name="products" class="prod" id="products"></select>
                                  </div>
                                  <div class="col col-md-2">
                                    <label for="">Add</label><br>
                                    <button type="button" class="btn btn-success" id="addProducts">
                                      <i class="mdi mdi-plus-circle-outline"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="row mb-12">
                                  <div>
                                    <button type="button" class="btn btn-danger btn-sm disabled"
                                      id="deleteProduct">Delete</button>
                                  </div>
                                  <table id="tableProduct" 
                                    class="table table-sm table-striped" 
                                    data-id-field="id" 
                                    data-unique-id="id"
                                    data-click-to-select="true" 
                                    data-height="260">
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
                              <div class="row">
                                <div class="col col-md-3">
                                  <input type="checkbox" name="validChk" id="validChk">
                                  <label class="text-muted" for="validChk">Valid in date range</label>
                                </div>
                              </div>
                              <div class="row d-none" id="valid">
                                <hr>
                                <div class="col-12 col-lg-6">
                                  <h5>From</h5>
                                  <input class="form-control" type="date" name="height" id="height"  placeholder="Enter height">
                                </div>
                                <div class="col-12 col-lg-6">
                                  <h5>To</h5>
                                  <input class="form-control" type="date" name="width" id="width"  placeholder="Enter width">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col col-md-3">
                                  <input type="checkbox" name="eproductsChk" id="eproductsChk">
                                  <label class="text-muted" for="eproductsChk">Excluded products</label>
                                </div>
                              </div>
                              <div class="row mb-3 d-none" id="e-products">
                                <div class="row mb-3">
                                  <div class="col col-md-7">
                                    <label for="eproducts">Select product</label>
                                    <select name="eproducts" class="prod" id="eproducts"></select>
                                  </div>
                                  <div class="col col-md-2">
                                    <label for="">Add</label><br>
                                    <button type="button" class="btn btn-success" id="addEProducts">
                                      <i class="mdi mdi-plus-circle-outline"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="row mb-12">
                                  <div>
                                    <button type="button" class="btn btn-danger btn-sm disabled"
                                      id="deleteEProduct">Delete</button>
                                  </div>
                                  <table id="tableEProduct" 
                                    class="table table-sm table-striped" 
                                    ata-id-field="id" 
                                    data-unique-id="id"
                                    data-click-to-select="true" 
                                    data-height="260">
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
                            </div>
                            <div class="tab-pane fade" id="actionsTabContent" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                              <div class="row">
                                <div class="col-12 col-lg-4">
                                  <h5>Adjustment type</h5>
                                  <select class="form-select new" name="adjustment_type" id="adjustment_type">
                                    <option value="increase">Increase</option>
                                    <option value="decrease">Decrease</option>
                                  </select>
                                </div>
                                <div class="col-12 col-lg-4">
                                  <h5>Price Action</h5>
                                  <select class="form-select new" name="discount_type" id="discount_type">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed</option>
                                  </select>
                                </div>
                                <div class="col-12 col-lg-4">
                                  <h5 class="mb-2">Amount</h5>
                                  <div class="input-group mb-3">
                                    <span class="input-group-text" id="symbol">%</span>
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> <!-- end col-->
                      </div> <!-- end row-->
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