@extends('layouts.master-vertical')

@section('title') {{config('app.name')}} | Status @endsection
@section('content')
@section('pagetitle') Status @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Products Status</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">Status</li>
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
                        <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Add Status' onclick='crear()'>
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
                        data-url="{{ route('status') }}">
                        <thead class="table-light">
                            <tr>
                                <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="color" data-sortable="true" data-formatter="colorTextFormatter">Color</th>
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
    <div class="modal fade" id="modalStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmStatus">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-md-3 col-form-label" for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-3 col-form-label" for="color">Color</label>
                                <select class="form-select new" name="color" id="color" required>
                                    <option class="text-success" value="success">success</option>
                                    <option class="text-warning" value="warning">warning</option>
                                    <option class="text-primary" value="primary">primary</option>
                                    <option class="text-info" value="info">info</option>
                                    <option class="text-pink" value="pink">pink</option>
                                    <option class="text-purple" value="purple">purple</option>
                                    <option class="text-danger" value="danger">danger</option>
                                    <option class="text-secondary" value="secondary">secondary</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="col-md-6 col-form-label" for="status">Status</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="status"/>
                                        <label class="form-check-label" for="status" id="lblstatus">Inactive</label>
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

    function colorTextFormatter(value,row,index) {
        return `<span class="me-1 text-${value}">${value}</span>`
    }

    // $('.new').select2({
    //     theme: "bootstrap-5",
    //     width: "100%",
    //     dropdownParent: $('#modalStatus'),
    //     placeholder: "Select...",
    // });

    $(document).ready(function(){
        
        $(document).initSwitchery();

        $('#status').on('change',function(){
            $('#lblstatus').toggleText('Inactive', 'Active');
        });

        $('#modalStatus').on('hide.bs.modal',function(){
            $('#id').val(null);
            $('#name').val(null);
            $('#color').val(null);
            if($("#status").is(':checked')){
                $("#status").trigger('click');
                $('#lblstatus').text('Inactive');
            }
            $('#frmStatus').removeClass('was-validated');
        });

        $('#cerrar').on('click',function(){
            $('#modalStatus').modal('hide');
        });

        $('#frmStatus').on('submit',function(e){
            e.preventDefault();

            let form = $(this);
            if(!form[0].checkValidity())  return false;

            let id = $('#id').val();
            let name = $('#name').val();
            let color = $('#color').val();
            let status = $('#status').is(':checked');
            let token = "{{ csrf_token() }}";
            $.post('{{ route("status.save")}}',{"id":id,"name":name,"color":color,"status":status,"_token":token})
            .done(function(data){
                showToast(data.msg,data.success);
                $('#modalStatus').modal('hide');
                $table.bootstrapTable('refresh');
            })
            .fail(function(daterror) {
                console.log(daterror);
                showToast('An error occurred while processing the data',"error");
            })
        })

    });

    function crear() {
        $('#modalStatus').modal('show');
    }

    function editar(id) {        
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        
        $('#id').val($row.id);
        $('#name').val($row.name);
        $('#color').val($row.color);
        if ($row.status){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        $('#modalStatus').modal('show');
    }

    async function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Sure to delete this record?<br><br>${datos.name}`)
        
        if(confirm)
        {
            
            let token = "{{ csrf_token() }}";
            $.post('{{ route("status.delete")}}',{"id":id,"_token":token})
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
        else 
        {
            showToast('Record without changes','warning');
        }
    }



</script>
@endsection