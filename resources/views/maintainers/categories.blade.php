@extends('layouts.master-vertical')

@section('title') {{config('app.name')}} | Categories @endsection
@section('content')
@section('pagetitle') Categories @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Categories</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                        <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle='tooltip' data-placement='top' title='Add Categories' onclick='crear()'>
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
                        data-url="{{ route('categories.list') }}">
                        <thead class="table-light">
                            <tr>
                                <th data-field="id" data-width="10" data-sortable="true" data-visible="true">#</th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="parent_category_id" data-visible="false">ParentID</th>
                                <th data-field="parent.name" data-sortable="true">Parent Category</th>
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
    <div class="modal fade" id="modalCategories" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmCategories">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Categories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-md-4 col-form-label" for="parent_category">Parent</label>
                                <select name="parent_category" id="parent">
                                    @foreach ($categorias as $category )
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-4 col-form-label" for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                            </div>
                            <div class="col-md-4">                                
                                <label class="col-md-4 col-form-label" for="status">Status</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="status"/>
                                    <label class="form-check-label" for="status" id="lblstatus">Inactive</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 d-none" id="divAttributes">
                            <table id="tableAttr"  class="table table-sm table-striped"
                                data-search="true"
                                data-unique-id="id"
                                data-search="true"
                                data-show-search-clear-button="true"
                                data-height="460"
                                data-maintain-meta-data="true"
                                data-click-to-select="true"
                                data-url="{{ route("attributes.list") }}"
                                >
                                <thead class="table-light">
                                    <tr>
                                        <th data-field="state" data-checkbox="true" data-formatter="stateFormatter" ></th>
                                        <th data-field="id" data-width="10" data-visible="true" data-align="center">#</th>
                                        <th data-field="name" data-sortable="true">Features</th>
                                        <th data-field="status" data-sortable="true" data-align="center" data-formatter="statusFormatter">Status</th>
                                        <th data-field="is_global" data-sortable="true" data-align="center" data-formatter="globalFormatter">Global</th>
                                    </tr>
                                </thead>
                            </table>
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
    let selectedRows = [];

    const   $table = $('#table').bootstrapTable({
                locale: 'en-US',
                loadingTemplate: function(loadingMessage) {
                    return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
                },
                onPostBody: function () {
                    tool_tips();
                }
            });

    const   $tableAttr = $('#tableAttr').bootstrapTable({
                locale: 'en-US',
                loadingTemplate: function(loadingMessage) {
                    return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
                },
                onPostBody: function (rows) {
                    rows.forEach(row => {
                        if (row.is_global) {
                            const id = row.id;
                            if (!selectedRows.includes(id)) {
                                selectedRows.push(id);
                            }
                        }
                    });
                    $('#tableAttr').bootstrapTable('checkBy', { field: 'id', values: selectedRows });
                    tool_tips();
                },
                onCheck: function(row) {
                    const id = row.id;
                    if (!selectedRows.includes(id)) {
                        selectedRows.push(id);
                    }
                },
                onUncheck: function(row) {
                    if (!row.is_global) {
                        selectedRows = selectedRows.filter(itemId => itemId !== row.id);
                    }
                },
                onCheckAll: function(rows) {
                    rows.forEach(row => {
                        const id = row.id;
                        if (!selectedRows.includes(id)) {
                            selectedRows.push(id);
                        }
                    });
                },
                onUncheckAll: function(rows) {
                    selectedRows =[];
                    rows.forEach(row => {
                        if (row.is_global) {
                            const id = row.id;
                            if (!selectedRows.includes(id)) {
                                selectedRows.push(id);
                            }
                        }
                    });
                }
            });
    
    function stateFormatter(value, row, index) {
        return {
            disabled: row.is_global,
            checked: row.is_global
        };
    }

    function globalFormatter(value,row,index) {
        let color = 'success';
        let name = 'Yes';
        if(!value){
            color = 'danger';
            name = 'No';
        }
        return `<span class="me-1 badge-outline-${color} badge">${name}</span>`
    }


    function actionFormatter(value, row, index) {
        var buttons =`<ul class='list-inline mb-0'>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-primary' data-bs-toggle='tooltip' data-placement='top' title='Duplicate Feature' onclick='duplicar(${row.id})' >
                                <i class='mdi mdi-content-duplicate'></i>
                            </a>
                        </li>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit' onclick='editar(${row.id},${row.parent_category_id})' >
                                <i class='mdi mdi-file-edit'></i>
                            </a>
                        </li>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='Delete' onclick='eliminar(${row.id})' >
                                <i class='mdi mdi-delete'></i>
                            </a>
                        </li>
                    </ul>`;
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

        $('#parent').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#modalCategories'),
            placeholder: "Select...",
            allowClear: true
        });
            
        $(document).initSwitchery();

        $('#parent').val(null).trigger('change');

        $('#status').on('change',function(){
            $('#lblstatus').toggleText('Inactive', 'Active');
        });

        $('#modalCategories').on('hide.bs.modal',function(){
            $('#id').val(null);
            $('#name').val(null);
            if($("#status").is(':checked')){
                $("#status").trigger('click');
                $('#lblstatus').text('Inactive');
            }
            $('#parent').val(null).trigger('change');
            $tableAttr.bootstrapTable('resetSearch');
            $tableAttr.bootstrapTable('uncheckAll');
            $('#frmCategories').removeClass('was-validated');
        });

        $('#modalCategories').on('shown.bs.modal', function () {
            setTimeout(() => {
                $tableAttr.bootstrapTable('resetView');
            }, 1000); 
        });
        
        $('#cerrar').on('click',function(){
            $('#modalCategories').modal('hide');
        });

        $('#frmCategories').on('submit', async function (e) {
            e.preventDefault();
            $('#tableAttr').bootstrapTable('resetSearch');

            let form = $(this)[0];

            if (!form.checkValidity()) {
                return;
            }

            let id = $('#id').val();
            let url = "{{ route('categories.store') }}";
            let method = 'POST';

            let parentId = $('#parent').val();
            
            let formData = new FormData(form);
            formData.append('status', $('#status').is(':checked') );
            if(parentId){
                formData.append('features', selectedRows);
            }

            if (id) {
                let update = "{{ route('categories.update', ':id') }}";
                url = update.replace(':id', id);
                formData.append('_method', 'PATCH');
            }

            try {

                sendRequest(url,method,formData,function(data){
                    showToast(data.msg, data.success);
                    $('#modalCategories').modal('hide');
                    
                    if (data.success === 'error') {
                        console.error(data.error);
                        showToast('An error occurred while processing the data', 'error');
                    } else {
                        $table.bootstrapTable('refresh');
                    }
                });
                
                selectedRows = [];
                
            } catch (error) {
                console.error('Error:', error);
            }
        });

        $('#parent').on('change', function() {
            let parentId = $(this).val();
            if (parentId) {
                $('#divAttributes').removeClass('d-none');
                setTimeout(() => {
                    $tableAttr.bootstrapTable('resetView');
                }, 500);
            }else {
                $('#divAttributes').addClass('d-none');
            }
        });

    });

    function crear() {
        $('#modalCategories').modal('show');
    }

    function editar(id,parent = null) {        
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        const attributeIds = $row.attributes.map(attr => attr.id);
        selectedRows = attributeIds;
        $tableAttr.bootstrapTable('checkBy', { field: 'id', values: attributeIds })
        
        $('#id').val($row.id);
        $('#name').val($row.name);
        if ($row.status){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        $('#parent').val(parent).trigger('change');
        $('#modalCategories').modal('show');
    }

    async function duplicar(id){
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let pregunta = await confirmQuestion(`Sure to duplicate this record?<br>${datos.name}`,'<span class="text-muted">⚠️ All related values will be duplicated. ⚠️ </span>');
        if(pregunta)
        {
            let uri = '{{ route("categories.duplicate",":id")}}';
            uri = uri.replace(':id',id);
            sendRequest(uri, 'post', null, function (data) {
                if (data) {
                    showToast(data.msg,data.success);
                    if(data.success == 'success'){
                        $table.bootstrapTable('refresh');
                    }
                }
            });
        }
        else
        {
            showToast('Record without changes','warning');
        }
    }

    async function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let msg = `Sure to delete this record?<br><br>${datos.name}`;
        
        if (datos.parent_category_id) {
            msg += `<br>from parent → ${datos.parent.name}`;
        }

        let resp = await confirmQuestion(msg);
        if(resp)
        {
            let url = "{{ route('categories.destroy',':id') }}";
            url = url.replace(':id',id);

            sendRequest(url, 'DELETE', null, function (response) {
                if (response) {
                    showToast(response.msg,response.success);
                    if(response.success == 'error'){
                        console.error(response.error);
                        showToast('An error occurred while processing the data',"error");
                    }else{
                        $table.bootstrapTable('removeByUniqueId', id);
                    }
                }
            });
        }
    }

</script>
@endsection