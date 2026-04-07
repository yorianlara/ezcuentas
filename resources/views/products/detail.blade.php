<div class="offcanvas offcanvas-end offcanvas-p" data-bs-backdrop="static" tabindex="-1" id="offcanvasDetail"
  aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header bg-primary">
    <input type="hidden" name="id" id="id">
    <button type="button" class="btn-close btn-close-white" id="closeDetail"></button>
    <div class="d-flex justify-content-center">
      <div class="col-auto">
        <h3 class="mb-2 text-light">Products</h3>
      </div>
    </div>
    <div class="row flex-between-end">
    </div>
  </div>
  <div class="offcanvas-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="row justify-content-center">
                                <div class="col-xl-8">
                                    {{-- <div id="product-carousel" class="carousel slide product-detail-carousel" data-bs-ride="carousel"> --}}
                                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner" id="carousel">
                                            
                                        </div>
                                        <div class="carousel-indicators" id="imgOL">

                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#product-carousel" data-bs-slide="prev">
                                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                          <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#product-carousel" data-bs-slide="next">
                                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                          <span class="visually-hidden">Next</span>
                                        </button>
                                        {{-- <ol class="carousel-indicators product-carousel-indicators mt-2" style="overflow-x: auto; " id="imgOL">
                                            
                                        </ol> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div>
                                <div><span class="fw-bold" id="p_name_detail"></span> - <a href="#" class="text-primary" id="pd_categoria"> </a></div>
                                <h4 class="mb-1" id="pd_name">  </h4>

                                <p class="text-muted me-3 font-16">
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                    <span class="mdi mdi-star text-warning"></span>
                                </p>

                                <div class="mt-3">
                                    {{-- <h6 class="text-danger text-uppercase">10 % Off</h6> --}}
                                    {{-- <h4>Price : <b id="pd_price">$ 45</b></h4> --}}
                                    <table class="table table-borderless">
                                        <tr>
                                            <th class="text-center">Product Type</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Wholesale Price</th>
                                            <th class="text-end">MAP</th>
                                            <th class="text-end">MSRP</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center fs-4" id="pd_type"></td>
                                            <td class="text-end" id="pd_price"></td>
                                            <td class="text-end" id="pd_wholesale_price"></td>
                                            <td class="text-end" id="pd_map_price"></td>
                                            <td class="text-end" id="pd_msrp_price"></td>
                                        </tr>
                                    </table>
                                </div>
                                <hr/>
                                <div>
                                    <div class="mt-3">
                                        <h5 class="font-size-14">Description:</h5>
                                        <div class="row">
                                            <div id="description" class="col-lg-12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div id="cardCollpaseInventory" class="collapse show">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-2">
                                  <div class="nav flex-column nav-pills nav-pills-tab" id="inventoryTab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active" id="attributesTab" data-bs-toggle="pill" href="#attributesTabContentD"
                                      role="tab" aria-controls="attributesTabContentD" aria-selected="false">
                                      <i class="mdi mdi-tune me-sm-2 fs-4 nav-icons"></i>
                                      Features
                                    </a>
                                    <a class="nav-link" id="extraTab" data-bs-toggle="pill" href="#extraTabContentD" role="tab"
                                      aria-controls="extraTabContentD" aria-selected="false">
                                      <i class="mdi mdi-folder-information-outline me-sm-2 fs-4 nav-icons"></i>
                                      Colors
                                    </a>
                                    
                                    <a class="nav-link" id="associationsTab" data-bs-toggle="pill" href="#associationTabContentD"
                                      role="tab" aria-controls="associationTabContentD" aria-selected="false">
                                      <i class="mdi mdi-view-grid-plus-outline me-sm-2 fs-4 nav-icons"></i>
                                      Components
                                    </a>
                                    <a class="nav-link" id="notesTab" data-bs-toggle="pill" href="#notesTabContentD" role="tab"
                                      aria-controls="notesTabContentD" aria-selected="false">
                                      <i class="mdi mdi-file-edit-outline me-sm-2 fs-4 nav-icons"></i>
                                      Notes
                                    </a>
                                    <a class="nav-link" id="shippingTab" data-bs-toggle="pill" href="#shippingTabContentD" role="tab"
                                      aria-controls="shippingTabContentD" aria-selected="false">
                                      <i class="mdi mdi-truck-outline me-sm-2 fs-4 nav-icons"></i>
                                      Shipping
                                    </a>
                                  </div>
                                </div> <!-- end col-->
                                <div class="col-sm-10 ">
                                  <div class="tab-content pt-0">                                    
                                    <div class="tab-pane fade active show" id="attributesTabContentD" role="tabpanel"
                                      aria-labelledby="v-pills-profile-tab">
                                      <div class="row mb-12">
                                        <table id="tableAttrD" class="table table-sm table-striped" data-id-field="id" data-unique-id="id"
                                          data-click-to-select="true" data-height="260">
                                          <thead class="table-light">
                                            <tr>
                                              <th data-field="id" data-visible="false">#</th>
                                              <th data-field="attr_id" data-visible="false">NameID</th>
                                              <th data-field="value_id" data-visible="false">ValueID</th>
                                              <th data-field="name">Names</th>
                                              <th data-field="value">Values</th>
                                            </tr>
                                          </thead>
                                        </table>
                                      </div>
                                    </div>
                                    <div class="tab-pane fade" id="extraTabContentD" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                      <div class="row ">
                                        <div class="col-md-12">
                                          <table id="tableMCD" class="table table-sm table-striped" 
                                            data-id-field="id" 
                                            data-unique-id="id"
                                            data-click-to-select="true" 
                                            data-height="260">
                                            <thead class="table-light">
                                              <tr>
                                                <th data-field="id" data-visible="false">ID</th>
                                                <th data-field="parts">Parts</th>
                                                <th data-field="parts_id" data-visible="false">Parts</th>
                                                <th data-field="material">Materials</th>
                                                <th data-field="material_id" data-visible="false">Materials</th>
                                                <th data-field="color">Colors</th>
                                                <th data-field="color_id" data-visible="false">Colors</th>
                                              </tr>
                                            </thead>
                                          </table>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="tab-pane fade" id="associationTabContentD" role="tabpanel"
                                      aria-labelledby="v-pills-settings-tab">
                                      <div class="row g-3">
                                        <ul class="nav nav-tabs nav-bordered nav-justified">
                                          <li class="nav-item">
                                            <a href="#childs-d" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                              <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                              <span class="d-none d-sm-inline-block">Child's</span>
                                            </a>
                                          </li>
                                          <li class="nav-item">
                                            <a href="#bundles-d" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                              <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                              <span class="d-none d-sm-inline-block">Bundle</span>
                                            </a>
                                          </li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="childs-d">
                                            <div class="row mb-12">
                                              <table id="tableChldD" class="table table-sm table-striped" data-id-field="id" data-unique-id="id"
                                                data-click-to-select="true" data-height="260">
                                                <thead class="table-light">
                                                  <tr>
                                                    <th data-field="id" data-visible="false">#</th>
                                                    <th data-field="sku">SKU</th>
                                                    <th data-field="name">Name</th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                          </div>
                                          <div class="tab-pane" id="bundles-d">
                                            <div class="row mb-12">
                                              <table id="tableBndD" class="table table-sm table-striped" data-id-field="id" data-unique-id="id"
                                                data-click-to-select="true" data-height="260">
                                                <thead class="table-light">
                                                  <tr>
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
                                    <div class="tab-pane fade" id="notesTabContentD" role="tabpanel" >
                                      <div class="row ">
                                        <div class="col-md-12">
                                          <textarea class="form-control" name="textNotesD" id="textNotesD" cols="30" rows="10"></textarea>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="tab-pane fade" id="shippingTabContentD" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                      <div class="row g-3">
                                        <ul class="nav nav-tabs nav-bordered nav-justified">
                                          <li class="nav-item">
                                            <a href="#shippingInfo-d" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                              <span class="d-inline-block d-sm-none">
                                                <i class="mdi mdi-information-outline"></i>
                                              </span>
                                              <span class="d-none d-sm-inline-block">Info.</span>
                                            </a>
                                          </li>
                                          <li class="nav-item">
                                            <a href="#shippingDetails-d" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                              <span class="d-inline-block d-sm-none">
                                                <i class="mdi mdi-format-list-bulleted"></i>
                                              </span>
                                              <span class="d-none d-sm-inline-block">Details</span>
                                            </a>
                                          </li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="shippingInfo-d">
                                            <div class="row g-3">
                                              <div class="col-12 col-lg-6">
                                                <label for="ship_via_d">Ship Via</label>
                                                <input type="text" name="ship_via_d" class="form-control" id="ship_via_d" readonly>
                                              </div>
                                              <div class="col-12 col-lg-6">
                                                <label for="package_type_d">Package Type</label>
                                                  <input type="text" name="package_type_d" class="form-control" id="package_type_d" readonly>
                                              </div>
                                            </div>
                                            <div class="row g-3">
                                              <div class="col-12 col-lg-6">
                                                <label class="col-md-3 col-form-label" for="upc_d">UPC#</label>
                                                <div class="input-group">
                                                  <input type="text" autocomplete="off" id="upc_d" name="upc_d" class="form-control" readonly>
                                                </div>
                                              </div>
                                              <div class="col-12 col-lg-6">
                                                <label for="package_type">Barcode</label>
                                                <img src="assets/images/logo-sm.png" alt="image" class="img-fluid img-thumbnail" width="200" id="codigobarraD">
                                                <img src="assets/images/logo-sm.png" alt="image" class="img-fluid img-thumbnail" width="150" id="codigoQRD">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="tab-pane" id="shippingDetails-d">
                                            <div class="row mb-12">
                                              <div class="col col-md-3">
                                                <div class="input-group">
                                                  <span class="input-group-text text-light bg-primary">
                                                    Case Pack
                                                  </span>
                                                  <input type="text" class="form-control" name="casepack_d" id="casepack_d" readonly>
                                                </div>
                                              </div>
                                              <div class="col col-md-3">
                                                <div class="input-group">
                                                  <span class="input-group-text text-light bg-primary">TOTAL BOXES</span>
                                                  <input type="text" class="form-control" name="totalBoxes_d" id="totalBoxes_d" readonly>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row g-3">
                                              <div class="col com-md-12">
                                                <table class="table table-sm table-striped" id="tableShippingD"
                                                  data-show-footer="true" 
                                                  data-id-field="id" 
                                                  data-unique-id="id">
                                                  <thead class="table-primary">
                                                    <tr>
                                                      <th rowspan="2" data-valign="middle" data-visible="false" data-field="id">
                                                        ID
                                                      </th>
                                                      <th colspan="2">
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
                                                      <th rowspan="2" data-valign="middle" data-align="center" data-field="lbs" data-footer-formatter="additionFormatter">
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
                                                    </tr>
                                                    <tr>
                                                      <th data-with="100" data-field="content" data-footer-formatter="idFormatter">Box #</th>
                                                      <th data-field="contenido">Content</th>
                                                    </tr>
                                                  </thead>
                                                </table>
                                              </div>
                                            </div>
                                            <div class="row mt-3">
                                              <div class="table-responsive">
                                                <table id="tblInformation" class="table table-sm table-bordered">
                                                  <tr>
                                                    <td class="bg-primary text-light">Ship Via</td>
                                                    <td class="align-middle text-center" id="gralShipViaD">
                                                      
                                                    </td>
                                                    <td class="bg-primary text-light">Pallet</td>
                                                    <td class="align-middle text-center" id="palletD">

                                                    </td>
                                                    <td class="align-middle bg-primary text-light" width="15%">
                                                      Freight Class
                                                    </td>
                                                    <td id="fclassD" class="align-middle text-end" width="10%">
                                                    </td>
                                                    <td id="densityD" class="align-middle text-end" width="10%">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="text-center" width="15%">Width</td>
                                                    <td class="text-center" width="15%">Length</td>
                                                    <td class="text-center" width="15%">Height +5</td>
                                                    <td class="text-center" width="15%">Lbs</td>
                                                    <td class="bg-primary text-light">Total CBM</td>
                                                    <td colspan="2" class="text-end" id="cbmD"></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="text-center" id="pWidthD"></td>
                                                    <td class="text-center" id="pLenghtD"></td>
                                                    <td class="text-center" id="pHeightD"></td>
                                                    <td class="text-center" id="pLbsD"></td>
                                                    <td class="bg-primary text-light"> Total CBF </td>
                                                    <td colspan="2" class="text-end" id="cbfD"></td>
                                                  </tr>
                                                  <tr>
                                                    <td class="bg-primary text-light">
                                                      Requirements
                                                    </td>
                                                    <td colspan="3" id="reqD"></td>
                                                    <td class="bg-primary text-light">
                                                      Pallet Only Lbs
                                                    </td>
                                                    <td colspan="2" class="text-end" id="polD"></td>
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
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

</div>