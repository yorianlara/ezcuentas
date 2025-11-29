@extends('layouts.master-vertical')

@section('title') {{config('app.name')}} | Customer Settings @endsection
@section('content')
@section('pagetitle') Customer Settings @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Customer Settings</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">Customer Settings</li>
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
                        <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Add Customer Settings' onclick='crear()'>
                            <i class="mdi mdi-plus-circle me-1"></i> 
                            Add
                        </a>
                    </div>

                    <table id="table" class="table align-middle table-nowrap table-sm mb-0"
                    data-page-list="[10, 25, 50, 100, all]" 
                    data-pagination="true" 
                    data-unique-id="id"
                    data-detail-view="true"
                    data-url="{{ route('customerSettings.list') }}">
                    <thead class="table-light">
                            <tr>
                                <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                                <th data-field="full_name" data-sortable="true">Full Name</th>
                                <th data-field="company" data-sortable="true">Company	</th>
                                <th data-field="action" data-width="150" data-align="center" data-formatter="actionFormatter">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- Crear -->
    <div class="modal fade" id="modalCustomerSettings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmCustomerSettings">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Customer Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="customer">Customer</label>
                                    <div class="col-md-9">
                                        <select class="form-select new" name="customer" id="customer" required>
                                        </select>
                                        <div class="invalid-feedback text-danger">
                                            Please select an option.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="exportExcel">Export format to Excel</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="exportExcel" id="exportExcel" rows="3" placeholder="Place the names of the columns that you want to export separated by comma (,)"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="exportCSV">Export format to CSV</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="exportCSV" id="exportCSV" rows="3" placeholder="Place the names of the columns that you want to export separated by comma (,)"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="catalogTemplate">Catalog template</label>
                                    <div class="col-md-9">
                                        <select class="form-select new" name="catalogTemplate" id="catalogTemplate" required>
                                            <option value="presentacion"> Presentation</option>
                                        </select>
                                        <div class="invalid-feedback text-danger">
                                            Please select an option.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label" for="email">Send by email</label>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="email"/>
                                            <label class="form-check-label" for="email" id="lblemail">NO</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
    <!-- Crear -->
@endsection
@section('script')
<script>

    const $table = $('#table').bootstrapTable({
        locale: 'en-US',
        loadingTemplate: function(loadingMessage) {
            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
        },
        onExpandRow: function(index,row,$detail){
            
            $detail.html('<p class="text-center"><b>Loading data, wait please ...</b></p>');

            fetchCustomerDetails(row.id)
            .then(res => {
                $detail.html('<table class="table data-pagination="true" table-sm"></table>').find('table').bootstrapTable({
                    columns: [
                        {field:'id',title: 'ID',visible:false},
                        {field:'key',title: 'Key'},
                        {field:'value',title: 'Value'},
                            ],
                    data:res,
                    locale: 'en-US',
                    loadingTemplate: function loadingTemplate(loadingMessage) {
                        return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
                    }
                });
            })
            .catch(error => {
                $detail.html('<p class="text-center"><b>No records were found</b></p>');
            });
        },
    });

    function actionFormatter(value, row, index) {
        var buttons =   "<ul class='list-inline mb-0'>" +
                            "<li class='list-inline-item'>" +
                                "<a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit' onclick='editar(" + row.id + ")'>" +
                                    "<i class='mdi mdi-file-edit'></i>" +
                                "</a>" +
                            "</li>" +
                            "<li class='list-inline-item'>" +
                                "<a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='Delete' onclick='eliminar(" + row.id + ")'>" +
                                    "<i class='mdi mdi-delete'></i>" +
                                "</a>" +
                            "</li>" +
                        "</ul>";
        return buttons;
    }

    $('.new').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalCustomerSettings'),
        placeholder: "Select...",
    });

    $(document).ready(function(){
        
        $(document).initSwitchery();

        $('.new').val(null).trigger('change');

        $('#email').on('change',function(){
            $('#lblemail').toggleText('YES', 'NO');
        });

        $('#cerrar').on('click',function(){
            $('#modalCustomerSettings').modal('hide');
        });

        $('#modalCustomerSettings').on('hide.bs.modal',function(){
            if($("#email").is(':checked')){
                $("#email").trigger('click');
                $('#lblemail').text('NO');
            }
            $('#frmCustomerSettings')[0].reset();
            $('#catalogTemplate').val(null).trigger('change');
            $('#customer').val(null).trigger('change');
            $('#frmCustomerSettings').removeClass('was-validated');
        });

        $('#frmCustomerSettings').on('submit',function(e){
            e.preventDefault();

            $(this).addClass('was-validated');
            let form = $(this);

            if(!form[0].checkValidity())  return false;
            let email = $('#email').is(':checked');
            let datos = form.serialize();
            datos += '&sendByEmail='+email;

            $.post('{{ route("customerSettings.save")}}',datos)
            .done(function(data){
                showToast(data.msg,data.success);
                if (data.success=='success') {
                    $table.bootstrapTable('refresh');
                }
                $('#modalCustomerSettings').modal('hide');
            })
            .fail(function(daterror) {
                console.log(daterror);
                showToast('An error occurred while processing the data',"error");
            })
        })

        loadCustomer();
        
    });

    function crear() {
        $('#modalCustomerSettings').modal('show');
    }

    function editar(id) {
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        $table.bootstrapTable('collapseRowByUniqueId', id)

        $('#customer').val($row.id).trigger('change');

        fetchCustomerDetails($row.id)
        .then(res => {
            $.each(res,function(k,v) {
                if(v.key == 'catalogTemplate'){
                    $('#'+v.key).val(v.value).trigger('change');
                }else if(v.key == 'sendByEmail'){
                    if(v.value.toLowerCase() === "true"){
                        $('#email').trigger('click');
                        $('#lblemail').text('YES');
                    }
                }else{
                    $('#'+ v.key).val(v.value);
                }
                
            });
            $('#modalCustomerSettings').modal('show');
        })
        .catch(error => {
            $detail.html('<p class="text-center"><b>No records were found</b></p>');
        });
    }

    async function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Are you sure you want to delete this record?<br><br>${datos.full_name} | ${datos.company}`);
        
        if (confirm) {
            let token = "{{ csrf_token() }}";
            let url = '{{ route("customerSettings.delete",":id") }}';
            url = url.replace(":id",id);

            $.post(url, { _token: token })
            .done(function(data) {
                showToast(data.msg, data.success);
                if (data.success == 'success') {
                    $table.bootstrapTable('removeByUniqueId', id);
                }
            })
            .fail(function(error) {
                console.error(error);
                showToast('An error occurred while processing the data', "error");
            });
        } else {
            showToast('Record without changes', 'warning');
        }
    }

    function loadCustomer() {
        $.get('{{ route("customers.list") }}')
            .done(function(data) {
                $.each(data, function (key, value) {
                    $('#customer').append(new Option(value.company, value.id));
                });
                $('#customer').val(null).trigger('change');
            });
    }

    async function fetchCustomerDetails(id) {
        try {
            // Construir la URL con el ID proporcionado
            let urlDetail = "{{ route('customerSettings.listDetail', ':id') }}";
            urlDetail = urlDetail.replace(':id', id);

            // Realizar la solicitud AJAX usando $.get
            const response = await $.get(urlDetail);
            return response; // Devolver el resultado
        } catch (error) {
            throw error; // Lanzar el error para manejo adicional
        }
    }


</script>
@endsection