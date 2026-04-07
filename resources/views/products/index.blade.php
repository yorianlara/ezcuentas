@extends('layouts.master-vertical')
@section('css')
<!-- switchery -->
<link href="{{URL::asset('assets/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />
<!-- JumpTO BT -->
<link href="{{URL::asset('/assets/libs/bootstrap-table/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css')}}" rel="stylesheet" type="text/css" />
<!-- JS Tree -->
<link href="{{URL::asset('/assets/libs/jstree/themes/default/style.min.css')}}" rel="stylesheet" type="text/css" />
<!-- FileInput css -->
<link href="{{URL::asset('assets/libs/fileinput/fileinput.css')}}" rel="stylesheet" type="text/css" />
<!-- FileInput css -->
<link href="{{URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{URL::asset('assets/css/vistas/products.index.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/libs/hopscotch/css/hopscotch.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Lightbox css -->
<link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}" rel="stylesheet" type="text/css" />

<style>
    .carousel-indicators [data-bs-target] {
        background-color: #535353 !important;
    }
    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23535353'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    }
    .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23535353'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e") !important;
    }

</style>
@endsection
@section('title') {{ config('app.name') }} | Products @endsection
@section('content')
@section('pagetitle') Products @endsection
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Products List</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                    <li class="breadcrumb-item active">Products List</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link  btn btn-info active waves-effect mb-2 mb-sm-0" id="pills-home-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                            aria-controls="pills-home" aria-selected="true">
                            <i class="bi-card-checklist"></i>
                            Main View
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div id="toolbar">
                            <div class="btn-group" role="group">
                                <button class="btn btn-purple dropdown-toggle me-1" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-star-circle"></i>
                                    Actions
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item " href="javascript:void(0)"
                                            onclick="crear()" id="crea">
                                            <i class="bi-plus-circle text-primary"></i> 
                                            New
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-dark actBtn disabled" href="javascript:void(0)"
                                            onclick="editar()" id="edita">
                                            <i class="bi-pencil-square"></i> 
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-dark actBtn disabled" href="javascript:void(0)"
                                            onclick="borrar()" id="borrar">
                                            <i class="bi-trash"></i> 
                                            Delete
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-dark actBtn disabled" href="javascript:void(0)" 
                                            onclick="duplica()" id="duplica">
                                            <i class="bi-box-arrow-up-right"></i> 
                                            Duplicate
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="addList()">
                                            <i class="bi-card-checklist text-purple"></i> 
                                            Add View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="btnExcel">
                                            <i class="bi-file-earmark-excel text-success"></i> 
                                            Import Excel
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="dropbox">
                                            <i class="mdi mdi-dropbox text-primary"></i> 
                                            Dropbox Sync
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-info dropdown-toggle me-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-cloud-download"></i>
                                    Download
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ URL::asset('assets/excel/products.xlsx') }}" target="blank">
                                            <i class="text-success mdi mdi-file-excel-outline"></i>
                                            Excel Template for Products
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="makeTear()">
                                            <i class="text-danger mdi mdi-file-pdf-box"></i>
                                            Tearsheet
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="makeBox()">
                                            <i class="text-primary mdi mdi-package-variant-closed"></i>
                                            Box Label
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="downloadImg()">
                                            <i class="mdi mdi-image text-info"></i>
                                            Images
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank" href="{{ route('stockList') }}" id="stock_list">
                                            <i class="text-purple mdi mdi-view-list-outline icono"></i>
                                            <i class="mdi mdi-spin mdi-loading d-none pausa"></i>
                                            Stock List
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="show_price_list()" id="price_list">
                                            <i class="text-purple mdi mdi-view-list-outline icono"></i>
                                            <i class="mdi mdi-spin mdi-loading d-none pausa"></i>
                                            Price List
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="export_data()" id="image_cache">
                                            <i class="text-success mdi mdi-file-excel-outline"></i>
                                            Export Data
                                        </a>
                                    </li>
                                    {{--<li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="upload_thumbs()" id="upload_thumbs">
                                            <i class="mdi mdi-image text-info"></i>
                                            Upload thumbs
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="clear_cache()()" id="clear_cache">
                                            <i class="mdi mdi-image text-info"></i>
                                            Clear cache
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                            @include('products.form_filtrado')
                            <div class="btn-group" role="group">
                                <button class="btn btn-warning text-dark me-1" type="button" id="trash">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                    Recycling bin
                                </button>
                            </div>
                            
                        </div>

                        <table id="table" class="table table-sm table-striped" 
                            data-id-field="id" 
                            data-unique-id="id"
                            data-click-to-select="true" 
                            data-toolbar="#toolbar" 
                            data-search="true"
                            data-show-search-clear-button="true" 
                            data-search-align="right" 
                            data-pagination="true"
                            data-show-jump-to="true" 
                            data-show-button-text="true"
                            data-buttons-align="left" 
                            data-show-custom-view="true"
                            data-custom-view="customViewFormatter" 
                            data-show-custom-view-button="true"
                            data-side-pagination="server"
                            data-query-params="queryParams"
                            data-row-style="rowStyle"
                            data-url="{{ route('products.list')}}" >
                            <thead class="table-light">
                                <tr>
                                    <th data-field="id" data-visible="false" data-align="center">#</th>
                                    <th data-field="fila_color" data-visible="false">Color</th>
                                    <th data-field="state" data-width="10" data-checkbox="true" data-align="center"></th>
                                    <th data-field="cover_image" data-width="100" data-align="center" data-click-to-select="false" data-formatter="imageFormatter">Products</th>
                                    <th data-field="sku" data-sortable="true" data-formatter="skuFormatter">SKU</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="product_type" data-sortable="true">Type</th>
                                    <th data-field="category" data-sortable="true" >Category</th>
                                    <th data-field="stock_available" data-align="right" data-sortable="true">Qty.</th>
                                    <th data-field="color" data-sortable="true">Color</th>
                                    <th data-field="status" data-width="150" data-formatter="statusFormatter">Status</th>
                                    <th data-field="status_color"data-visible="false" data-width="100">Status Color</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <template id="profileTemplate">
                    <div class="col-3 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0 text-truncated">%SKU%</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-8 col-md-6">
                                        <h4 class="mb-0 text-truncated">%NAME%</h4>
                                        <p><span class="badge badge-outline-warning text-dark">%BRAND%</span></p>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-6 text-center">
                                        <img src="%IMAGE%" alt="" class="mx-auto rounded-circle img-fluid"
                                            style="height: 80px;">
                                        <br>
                                        {{-- <ul class="list-inline ratings text-center" title="Ratings">
                                            <li class="list-inline-item">
                                                <a href="#"><span class="fa fa-star"></span></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#"><span class="fa fa-star"></span></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#"><span class="fa fa-star"></span></a>
                                            </li>
                                        </ul> --}}
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <p class="lead">%DESCRIPTION%</p>
                                        <p>
                                            <li class="badge bg-%COLOR%">%STATUS%</li>
                                            <li class="badge badge-outline-dark">%BUNDLE%</li>
                                        </p>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <h4 class="mb-0">%FOLLOWER%</h4>
                                        <small>Price</small>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <h4 class="mb-0">%FOLLOWING%</h4>
                                        <small>Wholesale</small>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <h5 class="mb-0">%SNIPPETS%</h5>
                                        <small>Type</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
@include('products.create')
@include('products.detail')
@include('products.modal')
@include('products.modalD')
@include('products.modal_excel')
@include('products.modal_excel_cb')
@include('products.modal_carga')
@include('products.products_list_modal')
@include('products.modal_trash')
@include('comun.svg')
@include('maintainers.modal.modal_category')
@endsection
@section('script')
<!-- switchery -->
<script src="{{URL::asset('assets/libs/mohithg-switchery/switchery.min.js')}}"></script>
<!-- FileInput -->
<script src="{{URL::asset('assets/libs/fileinput/fileinput.js')}}"></script>
<!-- JumpTO BT -->
<script src="{{URL::asset('/assets/libs/bootstrap-table/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js')}}">
</script>
<!-- Custom View BT -->
<script src="{{URL::asset('/assets/libs/bootstrap-table/extensions/custom-view/bootstrap-table-custom-view.min.js')}}">
</script>
<!--jsTree -->
<script src="{{URL::asset('assets/libs/jstree/jstree.min.js')}}"></script>
<!--jsBarcode -->
<script src="{{URL::asset('assets/libs/JsBarcode/JsBarcode.all.min.js')}}"></script>
<!--QRcode -->
<script src="{{URL::asset('assets/libs/qrcode.js/qrcode.js')}}"></script>


<script src="{{URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>



<script>
    const listChild = '{{route("list.child")}}';
    const bundleProducts = '{{route("list.select2")}}';
    const TOKEN = '{{ csrf_token() }}';
    const generateAI = '{{route("products.generate")}}';
    const generateSKU = '{{route("generar.sku")}}';
    const attrURL = '{{route("values.list")}}?status=true&attributeID=';
    const categoriesList = '{{ route("categories.list") }}';
    const categoriesListParents = '{{ route("categories.parents") }}';
    const productTypes = '{{route("products.types")}}?status=true';
    const productStatus = '{{route("status")}}?status=true';
    const productOrigin = '{{route("origin")}}?status=true';
    const productBrands = '{{route("brands")}}?status=true';
    const productMeasures = '{{route("measures")}}?status=true';
    const productParts = '{{route("products.parts")}}?status=true';
    const productMaterial = '{{route("products.materials")}}?status=true';
    const productColors = '{{route("product.colors")}}?status=true';
    const productAttributes = '{{route("attributes.list")}}?status=true';
    const productShipVia = '{{route("ship.via")}}?status=true';
    const productPallets = '{{route("pallets")}}?status=true';
    const productBoxContent = '{{route("boxContent")}}?status=true';
    const customers = '{{route("customers.list")}}?status=true';
    const productSave = '{{route("products.store")}}';
    const productUpdate = '{{route("products.update",":id")}}';
    const packageType = '{{route("packages.type")}}';
    const checkSKU = '{{route("products.checkSKU",":sku")}}';
    const urlDelImg = '{{route("image")}}';
    const ProductsTypeSave = '{{route("ProductsType.save")}}';
    const ProductStatusSave = '{{route("status.save")}}';
    const ProductOriginSave = '{{route("origin.save")}}';
    const ProductBrandSave = '{{route("brands.save")}}';
    const ProductPartsSave = '{{route("productsParts.save")}}';
    const ProductMaterialSave = '{{route("productsMaterials.save")}}';
    const ProductValueSave = '{{route("values.save")}}';
    const ProductAttributeSave = '{{route("attributes.save")}}';
    const ProductPackageTypeSave = '{{route("packages-type.save")}}';
    const ProductPalletsSave = '{{route("pallets.save")}}';
    const getFormPallets = '{{route("formPallets")}}';
    const getFormStandard = '{{route("formStandard")}}';
    const productShow = '{{route("products.show",":id")}}';
    const tearPdf = '{{ route("tearPdf",":id") }}';
    const boxPdf = '{{ route("boxPdf",":id") }}';
    const frmCategory = '{{ route("form.category") }}';
    const frmSub = '{{ route("form.sub") }}';
    const categorySave = '{{ route("categories.store") }}';
    const imgDown = '{{ route("down.img") }}';
    const priceList = '{{ route("priceList") }}';
    const excelImport = '{{ route("excel.import") }}';
    const excelProcesss = '{{ route("excel.process") }}';
    const productDuplicate = '{{ route("product.duplicate",":id") }}';
    const casabiancaExcel ="{{ route('excel.casabianca') }}";
    const dropboxSync = '{{ route("dropbox.sync") }}';
    const productDelete = '{{ route("products.delete") }}';
    const productRestore = '{{ route("products.restore") }}';
    const productDestroy = '{{ route("products.destroy",":id") }}';
    const ProductsAttributesCategories = "{{ route('attributes.category', ':id') }}";
    const generateChild = "{{ route('generateChild', ':id') }}";
    const exportData = "{{ route('export.data') }}";
</script>
<!--product js -->
<script src="{{URL::asset('assets/libs/hopscotch/js/hopscotch.min.js')}}"></script>
<script src="{{URL::asset('assets/js/pages/tour.init.js')}}"></script>
<script src="{{URL::asset('assets/js/vistas/product.index.js')}}"></script>



@endsection