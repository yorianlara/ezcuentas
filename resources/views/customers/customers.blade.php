@extends('layouts.master-vertical')

@section('title') {{ config('app.name') }} | Customers @endsection
@section('content')
@section('pagetitle') Customers @endsection
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Customers</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a></li>
                    <li class="breadcrumb-item active">customers</li>
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
                    <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle="tooltip" data-placement="top" title="Add Customer" onclick="crear()">
                        <i class="mdi mdi-plus-circle me-1"></i> 
                        Add
                    </a>
                </div>

                <table id="table" class="table table-sm table-striped"
                    data-search="true"
                    data-unique-id="id"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-show-search-clear-button="true"
                    data-pagination="true"
                    data-url="{{ route('customers.list') }}">
                    <thead class="table-light">
                        <tr>
                            <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                            <th data-field="full_name" data-sortable="true">Full Name</th>
                            <th data-field="email" data-sortable="true">Email</th>
                            <th data-field="phone_number" data-sortable="true">Phone Number</th>
                            <th data-field="company" data-sortable="true">Company</th>
                            <th data-field="category.id" data-visible="false">CategoryID</th>
                            <th data-field="category.name" data-sortable="true">Category</th>
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

<!-- Crear Cliente -->
<div class="modal fade" id="modalCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="needs-validation" novalidate id="frmCustomer">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Customers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="full_name">Full Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="full_name" name="full_name" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="email">Email</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="phone_number">Phone Number</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="company">Company</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="company" name="company" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="full_name">Category</label>
                        <div class="col-md-9">
                            <select class="form-select new" name="category" id="category" required></select>
                            <div class="invalid-feedback text-danger">
                                Please select an option.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label" for="full_name">Status</label>
                        <div class="col-md-9">
                            <div class="form-check form-switch">
                                <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="status"/>
                                <label class="form-check-label" for="status" id="lblstatus">Inactive</label>
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
<!-- Crear Cliente -->

@endsection

@section('script')
<script>
    const $table = $('#table').bootstrapTable({
        locale: 'en-US',
        loadingTemplate: function(loadingMessage) {
            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
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

    function statusFormatter(value,row,index) {
        let color = 'success';
        let name = 'Active';
        if(!value){
            color = 'danger';
            name = 'Inactive';
        }
        return `<span class="me-1 badge-outline-${color} badge">${name}</span>`
    }

    $('.new').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalCustomer'),
        placeholder: "Select...",
    });

    $(document).ready(function() {
        $(document).initSwitchery();

        $('#modalCustomer').on('hide.bs.modal', function() {
            $('#id').val(null);
            $('#full_name').val(null);
            $('#email').val(null);
            $('#phone_number').val(null);
            $('#company').val(null);
            $('#category').val(null).trigger('change');
            $('#frmCustomer').removeClass('was-validated');
        });

        $('#status').on('change',function(){
            $('#lblstatus').toggleText('Inactive', 'Active');
        });

        $('#cerrar').on('click', function() {
            $('#modalCustomer').modal('hide');
        });

        $('#frmCustomer').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            if (!form[0].checkValidity()) return false;

            let datos = form.serialize();
            datos += '&status=' + $('#status').is(':checked');
            $.post('{{ route("customers.save") }}', datos)
            .done(function(data) {
                showToast(data.msg, data.success);
                $('#modalCustomer').modal('hide');
                $table.bootstrapTable('refresh');
            })
            .fail(function(error) {
                console.error(error);
                showToast('An error occurred while processing the data', "error");
            });
        });

        loadCategory();
    });

    function crear() {
        $('#modalCustomer').modal('show');
    }

    function editar(id) {
        let $row = $table.bootstrapTable('getRowByUniqueId', id);

        $('#id').val($row.id);
        $('#full_name').val($row.full_name);
        $('#email').val($row.email);
        $('#phone_number').val($row.phone_number);
        $('#company').val($row.company);
        $('#category').val($row.category.id).trigger('change');
        if ($row.status){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        $('#modalCustomer').modal('show');
    }

    async function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Are you sure you want to delete this record?<br><br>${datos.full_name}`);

        if (confirm) {
            let token = "{{ csrf_token() }}";
            $.post('{{ route("customers.delete") }}', { id, _token: token })
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

    function loadCategory(){
        $.get('{{ route("customerCategory.list") }}')
        .done(function(data){
            $.each(data, function (key, value) {
                $('#category').append(new Option(value.name, value.id));
            });
            $('#category').val(null).trigger('change');
        })
    }
</script>
@endsection
