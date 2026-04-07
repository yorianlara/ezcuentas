@extends('layouts.master-vertical')

@section('title') {{config('app.name')}} | Measures @endsection
@section('content')
@section('pagetitle') Measures @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Measures (UOM)</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">Measures</li>
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
                        <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Add UOM' onclick='crear()'>
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
                        data-url="{{ route('measures') }}">
                        <thead class="table-light">
                            <tr>
                                <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="symbol" data-sortable="true">Symbol</th>
                                <th data-field="type" data-sortable="true">Type</th>
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
    <!-- Crear UOM -->
    <div class="modal fade" id="modalStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmStatus">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Measures</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-4">
                                    <label class="col-md-3 col-form-label" for="name">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label" for="acronym">Acronym</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="acronym" name="acronym" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-4">
                                    <label class="col-md-4 col-form-label" for="type">Type</label>
                                    <div class="col-md-8">
                                        <select class="form-select" name="type" id="type" required>
                                            <option value="weight">weight</option>
                                            <option value="dimension">dimension</option>
                                        </select>
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
    <!-- Crear UOM -->
    
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

        $('#modalStatus').on('hide.bs.modal',function(){
            $('#id').val(null);
            $('#name').val(null);
            $('#acronym').val(null);
            $('#type').val(null).trigger('change');
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
            let acronym = $('#acronym').val();

            // Crear objeto FormData con el formulario
            var formData = new FormData($(this)[0]);
            formData.append('status',$('#status').is(':checked'));

            // Realizar la solicitud AJAX
            $.ajax({
                url: '{{ route("measures.save")}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function (data) {
                    loadingSwal(true);
                },
                success: function (data) {
                    showToast(data.msg, data.success);
                    $table.bootstrapTable('refresh');
                    $('#modalStatus').modal('hide');
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    showToast('An error occurred while processing the data', 'error');
                },
                complete: function () {
                    setTimeout(() => {
                        loadingSwal(false);
                    }, 500);
                }
            });
        })

    });

    function crear() {
        $('#modalStatus').modal('show');
    }

    function editar(id) {        
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        
        $('#id').val($row.id);
        $('#name').val($row.name);
        $('#acronym').val($row.symbol);
        $('#type').val($row.type).trigger('change');
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
            $.post('{{ route("measures.delete")}}',{"id":id,"_token":token})
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
            showToast('Record without changes','warning');
        }
    }



</script>
@endsection