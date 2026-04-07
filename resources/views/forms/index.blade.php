@extends('layouts.master-vertical')

@section('title') Muebles | Formularios @endsection
@section('content')
@section('pagetitle') Formularios @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Forms List</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
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
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <a href="{{ route('forms.create') }}" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-1"></i> 
                                Add Form
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <button type="button" class="btn btn-success mb-2 mb-sm-0">
                                    <i class="mdi mdi-cog"></i>
                                </button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <!-- end row -->

                    <div class="table-responsive">
                        <table class="table"
                            data-search="true"
                            id="formularios" 
                            data-url="{{ route('forms.list') }}">
                            <thead class="table-light">
                                <tr>
                                    <th data-field="id" data-width="10" class="text-center">#</th>
                                    <th data-field="title">Title</th>
                                    <th data-field="description">Description</th>
                                    <th  class="text-center" data-formatter="actionFormatter">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
<script>
    const   $tableMC = $('#formularios').bootstrapTable({
                locale: 'en-US',
                loadingTemplate: function(loadingMessage) {
                    return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
                },
            });

    function actionFormatter(value, row, index) {
        var url = '{{ route("forms.show", ":id") }}';
        url = url.replace(':id', row.id);
        var buttons ="<ul class='list-inline mb-0'>"+
                        "<li class='list-inline-item'>"+
                            "<a href='"+url+"' class='btn btn-primary bg-gradient btn-sm' data-bs-toggle='tooltip' data-placement='top' title='Editar' onclick='cancelar("+row.id+")' >"+
                                "<i class='fas fa-eye'></i>"+
                            "</a>"+
                        "</li>"+
                    "</ul>";
        return buttons;
    }
</script>
@endsection