@extends('layouts.master-vertical')

@section('title') {{ config('app.name') }} | Discounts @endsection
@section('css')
<style>
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice{
        color: #fff; !important
    }  
</style>

@endsection
@section('content')
@section('pagetitle') Discounts @endsection
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Discounts</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a></li>
                    <li class="breadcrumb-item active">Discounts</li>
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
                    <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle="tooltip" data-placement="top" title="Add Rule" onclick="crear()">
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
                    data-url="{{ route('discounts.list') }}">
                    <thead class="table-light">
                        <tr>
                            <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                            <th data-field="name" data-sortable="true">Rule</th>
                            <th data-field="description" data-sortable="true">Description</th>
                            <th data-field="adjustment_type" data-sortable="true" data-formatter="adjustmentFormatter">Adjustment type</th>
                            <th data-field="amount" data-align="right" data-sortable="true" data-formatter="amountFormatter">Amount</th>
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
@include('products_discounts.modal')
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

    const $tableEProducts = $('#tableEProduct').bootstrapTable({
        locale: 'en-US',
        loadingTemplate: function (loadingMessage) {
            return '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>';
        },
        onCheck: function () {
            $('#deleteEProduct').removeClass('disabled');
        },
        onCheckAll: function () {
            $('#deleteEProduct').removeClass('disabled');
        },
        onUncheck: function () {
            verificaEChld();
        },
        onUncheckAll: function () {
            $('#deleteEProduct').addClass('disabled');
        }
    });

    const $tableProducts = $('#tableProduct').bootstrapTable({
        locale: 'en-US',
        loadingTemplate: function (loadingMessage) {
            return '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>';
        },
        onCheck: function () {
            $('#deleteProduct').removeClass('disabled');
        },
        onCheckAll: function () {
            $('#deleteProduct').removeClass('disabled');
        },
        onUncheck: function () {
            verificaChld();
        },
        onUncheckAll: function () {
            $('#deleteProduct').addClass('disabled');
        }
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

    function adjustmentFormatter(value, row, index) {
        if (!value) return '';

        // Capitalizar la primera letra
        let text = value.charAt(0).toUpperCase() + value.slice(1);

        // Elegir icono según el valor
        let icon = '';
        if (value === 'decrease') {
            icon = '<i class="mdi mdi-download text-danger"></i>';
        } else if (value === 'increase') {
            icon = '<i class="mdi mdi-upload text-success"></i>';
        }

        return icon + ' ' + text;
    }

    function amountFormatter(value, row, index) {
        if (!value) return '';

        if(row.discount_type === 'percentage'){
            var icon = '<i class="mdi mdi-percent"></i>';
        }else{
            var icon = '<i class="mdi mdi-currency-usd"></i>';
        }
        return value + ' ' + icon;
    }

    $('.new').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalDiscount'),
        placeholder: "Select...",
    });

    $(document).ready(function() {

        $(document).initSwitchery();

        $('.new').val(null).trigger('change');

        $('#modalDiscount').on('hide.bs.modal', function() {
            $('#frmDiscount')[0].reset();
            $('#id').val(null);
            $('.new').val(null).trigger('change');
            $tableProducts.bootstrapTable('removeAll');
            $('#frmDiscount').removeClass('was-validated');
            $('#r-customers').addClass('d-none');
            $('#r-categories').addClass('d-none');
            $('#e-products').addClass('d-none');
        });

        $('#cerrar').on('click', function() {
            $('#modalDiscount').modal('hide');
        });

        $('#status').on('change',function(){
            $('#lblstatus').toggleText('Inactive', 'Active');
        });

        $('#validChk').on('change',function(){
            $('#valid').toggleClass('d-none', '');
        });
        
        $('#productsChk').on('click',function(){
            if($('#productsChk').is(':checked')){
                $('#r-products').removeClass('d-none');
            }else{
                $('#r-products').addClass('d-none');
            }
            $('#products').val(null).trigger('change');
        });
        
        $('#eproductsChk').on('click',function(){
            if($('#eproductsChk').is(':checked')){
                $('#e-products').removeClass('d-none');
            }else{
                $('#e-products').addClass('d-none');
            }
            $('#eproducts').val(null).trigger('change');
        });
        
        $('#categoriesChk').on('click',function(){
            if($('#categoriesChk').is(':checked')){
                $('#r-categories').removeClass('d-none');
            }else{
                $('#r-categories').addClass('d-none');
            }
            $('#customers_categories').val(null).trigger('change');
        });
        
        $('#customersChk').on('click',function(){
            if($(this).is(':checked')){
                $('#r-customers').removeClass('d-none');
            }else{
                $('#r-customers').addClass('d-none');
            }
            $('#customers').val(null).trigger('change');
        });

        $('#discount_type').on('change',function(){
            $('#symbol').toggleText('%', '$');
        });

        $('#frmDiscount').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            if (!form[0].checkValidity()) return false;

            var formData = new FormData(form[0]);
            formData.append('status',$('#status').is(':checked'));
            let dataTableProducts = $tableProducts.bootstrapTable('getData');
            let dataTableEProducts = $tableEProducts.bootstrapTable('getData');
            formData.append('status',$('#status').is(':checked'));

            if(dataTableProducts.length > 0){
                formData.append('dataProducts',JSON.stringify(dataTableProducts));
            }

            if(dataTableEProducts.length > 0){
                formData.append('dataEProducts',JSON.stringify(dataTableEProducts));
            }
            

            $.ajax({
                url: '{{ route("discounts.save") }}',
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
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    showToast('An error occurred while processing the data', "error");
                },
                complete: function () {
                    setTimeout(() => {
                        loadingSwal(false);
                        $('#modalDiscount').modal('hide');
                    }, 500);
                }
            });
        });

        $('#addEProducts').on('click', async function () {
            const products_products_id = $('#eproducts').val();
            const products_products = $('#eproducts option:selected').text();

            // Validación de selección de atributos y valores
            if (!products_products_id) {
                showToast('Select product to continue', 'error');
                return false;
            }

            // Verificar si ya está el atributo en la tabla
            prevData = $tableEProducts.bootstrapTable('getData');
            let result = prevData.find(item => item.id == products_products_id);
            if (result) {
                showToast('This product are already listed, please check', 'error');
                return false;
            }

            // Agregar nueva fila a la tabla
            let data = [{
                'id': products_products_id,
                'sku': products_products.split('|')[0],
                'name': products_products.split('|')[1],
            }];

            $tableEProducts.bootstrapTable('append', data);

            // Limpiar los campos del formulario
            $('#eproducts').val(null).trigger('change');
        });

        $('#deleteEProduct').on('click', async function () {
            let confirm = await confirmQuestion('Are you sure to delete this item?');
            if (confirm) {
                let content = $tableEProducts.bootstrapTable('getSelections');
                $.each(content, function (k, v) {
                    $tableEProducts.bootstrapTable('removeByUniqueId', v.id);
                });
                verificaEChld();
            }
        });
        
        $('#addProducts').on('click', async function () {
            const products_products_id = $('#products').val();
            const products_products = $('#products option:selected').text();

            // Validación de selección de atributos y valores
            if (!products_products_id) {
                showToast('Select product to continue', 'error');
                return false;
            }

            // Verificar si ya está el atributo en la tabla
            prevData = $tableProducts.bootstrapTable('getData');
            let result = prevData.find(item => item.id == products_products_id);
            if (result) {
                showToast('This product are already listed, please check', 'error');
                return false;
            }

            // Agregar nueva fila a la tabla
            let data = [{
                'id': products_products_id,
                'sku': products_products.split('|')[0],
                'name': products_products.split('|')[1],
            }];

            $tableProducts.bootstrapTable('append', data);

            // Limpiar los campos del formulario
            $('#products').val(null).trigger('change');
        });

        $('#deleteProduct').on('click', async function () {
            let confirm = await confirmQuestion('Are you sure to delete this item?');
            if (confirm) {
                let content = $tableProducts.bootstrapTable('getSelections');
                $.each(content, function (k, v) {
                    $tableProducts.bootstrapTable('removeByUniqueId', v.id);
                });
                verificaChld();
            }
        });

        loadCategory();
        loadCustomers();
    });

    function verificaEChld() {
        let content = $tableEProducts.bootstrapTable('getSelections');
        let hasit = $('#deleteEProduct').hasClass('disabled');
        if (content.length == 0 && !hasit) {
            $('#deleteEProduct').addClass('disabled');
        }
    }
    
    function verificaChld() {
        let content = $tableProducts.bootstrapTable('getSelections');
        let hasit = $('#deleteProduct').hasClass('disabled');
        if (content.length == 0 && !hasit) {
            $('#deleteProduct').addClass('disabled');
        }
    }

    function crear() {
        if(!$('#status').is(':checked')){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        $('#modalDiscount').modal('show');

    }

    function editar(id) {
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        // console.log($row);
        
        $('#id').val($row.id);
        $('#name').val($row.name);
        $('#description').val($row.description);
        if ($row.status){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        if ($row.customers_ids != null){
            $('#customersChk').trigger('click').trigger('change');
            const idsArrayC = $row.customers_ids.map(item => item.id);
            $('#customers').val(idsArrayC).trigger('change');
        }
        if ($row.customers_category_ids != null){
            $('#categoriesChk').trigger('click').trigger('change');
            const idsArrayCC = $row.customers_category_ids.map(item => item.id);
            $('#customers_categories').val(idsArrayCC).trigger('change');
        }
        if ($row.products_discount){
            $('#productsChk').trigger('click').trigger('change');
            // Crear el arreglo con los campos requeridos
            const result = $row.products_discount.map(function(item) {
                return {
                    id: item.products.id,
                    name: item.products.name,
                    sku: item.products.sku
                };
            });
            $tableProducts.bootstrapTable('append', result);
        }       
        if($row.valid_from != null){
            if(!$('#validChk').is(':checked')){
                $('#productsChk').trigger('click');
            }
        }
        if($row.discount_type != null){
            $('#discount_type').val($row.discount_type).trigger('change');
        }

        if($row.adjustment_type != null){
            $('#adjustment_type').val($row.adjustment_type).trigger('change');
        }

        $('#amount').val($row.amount);

        $('#modalDiscount').modal('show');
    }

    async function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Are you sure you want to delete this record?<br><br>${datos.name}`);
        console.log(confirm);
        
        if (confirm) {
            let token = "{{ csrf_token() }}";
            let url = '{{ route("discounts.delete",":id") }}';
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

    function loadCategory(){
        $.get('{{ route("customerCategory.list") }}')
        .done(function(data){
            $.each(data, function (key, value) {
                $('#customers_categories').append(new Option(value.name, value.id));
            });
            $('#customers_categories').val(null).trigger('change');
        })
    }

    function loadCustomers() {
        $.get('{{ route("customers.list") }}')
        .done(function(data){
            $.each(data, function (key, value) {
                $('#customers').append(new Option(value.company, value.id));
            });
            $('#customers').val(null).trigger('change');
        })
    }

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }

        var texto = state.text.split('|');
        var text = '<small>SKU:</small> ' + $.trim(texto[0]) + '- <small>Name</small>:' + $.trim(texto[1]);
        var $state = $(
            '<span><img src="' + state.imageUrl + '" class="rounded" height="45px" /><br>' + text + '</span>'
        );
        return $state;
    };

    $(".prod").select2({
        templateResult: formatState,
        theme: "bootstrap-5",
        width: "100%",
        placeholder: "Seleccione...",
        dropdownParent: $("#modalDiscount"),
        tokenSeparators: [",", " "],
        ajax: {
            url: '{{ route("list.select2") }}',
            dataType: "json",
            //delay: 250,
            data: function (params) {
                var queryParameters = {
                    q: params.term, // search term
                    page: params.page,
                };
                return queryParameters;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.items, function (item) {
                        // Buscar la imagen de portada (is_cover: true)
                        var coverImage = item.images.find(function (image) {
                            return image.is_cover === true;
                        });

                        // Extraer la URL de la imagen de portada si existe
                        var imageUrl = coverImage ? coverImage.image_url : '';
                        return {
                            text: `${item.sku} | ${item.name}`,
                            id: item.id,
                            sku: item.sku,
                            imageUrl: imageUrl
                        };
                    }),
                    pagination: {
                        more: params.page * 30 < data.total_count,
                    },
                };
            },
            cache: true,
        },
    });
</script>
@endsection
