@extends('layouts.master-vertical')
@section('css')
<style>
    .offcanvas-p{
        width: 90% !important;
    }
    .offcanvas-backdrop.show {
        opacity: 1;
        background-color: rgba(15,23,42,.5);
        backdrop-filter: blur(8px);
    }
</style>
@endsection
@section('title') {{config('app.name')}} | Warehouses @endsection
@section('content')
@section('pagetitle') Warehouses @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Warehouses</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">warehouses</li>
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
                    <div id="toolbar">
                        <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Add Warehouse' onclick='crear()'>
                            <i class="mdi mdi-plus-circle me-1"></i> 
                            Add
                        </a>
                    </div>

                    <table id="table"  class="table table-sm table-striped"
                        data-search="true"
                        data-unique-id="id"
                        data-toolbar="#toolbar"
                        data-search="true"
                        data-show-search-clear-button="true"
                        data-pagination="true"
                        data-url="{{route('warehouse.list')}}">
                        <thead class="table-light">
                            <tr>
                                <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="location" data-sortable="true" data-formatter="addressFormatter">Location</th>
                                <th data-field="status" data-sortable="true" data-align="center" data-formatter="statusFormatter">Status</th>
                                <th data-field="action" data-width="150" data-align="center" data-formatter="actionFormatter">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @include('warehouse.stock')
    @include('warehouse.modal')
    
@endsection
@section('script')
<script>
    const TOKEN = '{{ csrf_token() }}';
    const warehouseSave = '{{route("warehouses.store")}}';
    const warehouseUpdate = '{{route("warehouses.update",":id")}}';
    const warehouseDelete = '{{route("warehouses.destroy",":id")}}';
    const stockList = '{{route("stocks.list",":id")}}';

</script>
<!--product js -->
<script src="{{URL::asset('assets/js/vistas/warehouses.index.js')}}"></script>
@endsection