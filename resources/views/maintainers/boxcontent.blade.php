@extends('layouts.master-vertical')

@section('title') {{config('app.name')}} | Case Pack @endsection
@section('content')
@section('pagetitle') Case Pack @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Forms List</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">Case Pack</li>
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
                        <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Add Case Pack' onclick='crear()'>
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
                        data-url="{{ route('casepack') }}">
                        <thead class="table-light">
                            <tr>
                                <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                                <th data-field="name" data-sortable="true">Name</th>
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
    <!-- Crear marcas -->
    <div class="modal fade" id="modalBoxContent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmBoxContent">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Case Pack</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="name">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label" for="status">Status</label>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="status"/>
                                            <label class="form-check-label" for="status" id="lblstatus">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <!-- Crear Marca -->
@endsection
@section('script')
<script>
    const   $table = $('#table').bootstrapTable({
                locale: 'en-US',
                loadingTemplate: function(loadingMessage) {
                    return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
                },
            });

    function actionFormatter(value, row, index) {
        var buttons ="<ul class='list-inline mb-0'>"+
                        "<li class='list-inline-item'>"+
                            "<a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit' onclick='editar("+row.id+")' >"+
                                "<i class='mdi mdi-file-edit'></i>"+
                            "</a>"+
                        "</li>"+
                        "<li class='list-inline-item'>"+
                            "<a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='delete' onclick='eliminar("+row.id+")' >"+
                                "<i class='mdi mdi-delete'></i>"+
                            "</a>"+
                        "</li>"+
                    "</ul>";
        return buttons;
    }

    function statusFormatter(value,row,index) {
        let color = 'success';
        let name = 'Active';
        if(!value){
            color = 'danger';
            name = 'Inactive';
        }
        return `<span class="me-1 badge-outline-${color} badge">${name}</span>`
    }


    $(document).ready(function(){
        
        $(document).initSwitchery();

        $('#status').on('change',function(){
            $('#lblstatus').toggleText('Inactive', 'Active');
        });

        $('#modalBoxContent').on('hide.bs.modal',function(){
            $('#id').val(null);
            $('#name').val(null);
            if($("#status").is(':checked')){
                $("#status").trigger('click');
                $('#lblstatus').text('Inactive');
            }
            $('#frmBoxContent').removeClass('was-validated');
        });

        $('#cerrar').on('click',function(){
            $('#modalBoxContent').modal('hide');
        });

        $('#frmBoxContent').on('submit',function(e){
            e.preventDefault();
            let id = $('#id').val();
            let name = $('#name').val();
            let status = $('#status').is(':checked');
            let token = "{{ csrf_token() }}";
            $.post('{{ route("casepack.save")}}',{"id":id,"name":name,"status":status,"_token":token})
            .done(function(data){
                showToast(data.msg,data.success);
                $('#modalBoxContent').modal('hide');
                $table.bootstrapTable('refresh');
            })
            .fail(function(daterror) {
                console.log(daterror);
                showToast('An error occurred while processing the data',"error");
            })
        })

    });

    function crear() {
        $('#modalBoxContent').modal('show');
    }

    function editar(id) {        
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        
        $('#id').val($row.id);
        $('#name').val($row.name);
        if ($row.status){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        $('#modalBoxContent').modal('show');
    }

    function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        Swal.fire({
            title: 'Are you sure you want to delete this record?',
            html:'<p><b>'+ datos.name +'</b></p>', 
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si!',
            cancelButtonText: 'No',
            buttonsStyling: false,
            customClass: {
                closeButton: 'btn btn-danger ms-1',
                confirmButton: 'btn btn-success ms-1',
                cancelButton: 'btn btn-danger ms-1',
            },
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(function(result) {
            if(result.value)
            {
                let token = "{{ csrf_token() }}";
                $.post('{{ route("casepack.delete")}}',{"id":id,"_token":token})
                .done(function(data){
                    showToast(data.msg,data.success);
                    if(data.success == 'success'){
                        $table.bootstrapTable('removeByUniqueId', id);
                    }
                })
                .fail(function(daterror) {
                    console.log(daterror);
                    showToast('An error occurred while processing the data',"error");
                })
            }
            else if (result.dismiss === 'cancel')
            {
                showToast('Registro sin cambios','warning');
            }
        });
    }



</script>
@endsection