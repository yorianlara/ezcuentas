@extends('layouts.master-vertical')

@section('title') {{config('app.name')}} | Brands @endsection
@section('content')
@section('pagetitle') Features @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Features</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">Features</li>
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
                        <div class="input-group">
                            <button class="btn btn-success" data-bs-toggle='tooltip' data-placement='top' title='Add Feature' type="button" onclick="crear()">
                                <i class="mdi mdi-plus-circle me-1"></i>
                                Add
                            </button>
                        </div>
                    </div>
                    <table id="table"  class="table table-sm table-striped"
                        data-search="true"
                        data-unique-id="id"
                        data-toolbar="#toolbar"
                        data-search="true"
                        data-show-search-clear-button="true"
                        data-pagination="true"
                        data-detail-view="true"
                        data-url="{{ route("attributes.list") }}"
                        >
                        <thead class="table-light">
                            <tr>
                                <th data-field="id" data-width="10" data-visible="false" data-align="center">#</th>
                                <th data-field="name" data-sortable="true">Feature</th>
                                <th data-field="status" data-width="200" data-sortable="true" data-align="center" data-formatter="statusFormatter">Status</th>
                                <th data-field="is_global" data-width="200" data-sortable="true" data-align="center" data-formatter="globalFormatter">Global</th>
                                <th data-field="input_type" data-width="200" data-sortable="true" data-align="center" data-formatter="typeFormatter">Input Type</th>
                                <th data-field="action" data-width="200" data-align="center" data-formatter="actionFormatter">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <!-- Crear feature -->
    @include('maintainers.modal.modal_feature')
    <!-- Crear feature -->

    <!-- Crear feature -->
    @include('maintainers.modal.modal_values')
    @include('maintainers.modal.modal_subvalues')
    <!-- Crear feature -->

@endsection
@section('script')
<script>
    let rowId;

    const  $table = $('#table').bootstrapTable({
        locale: 'en-US',
        loadingTemplate: function(loadingMessage) {
            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
        },
        onExpandRow: function(index,row,$detail){
            $detail.html('<p class="text-center"><b>Loading data, wait please ...</b></p>');
            sendRequest('{{ route("values.list") }}?attributeID='+row.id,'GET',null,function(data){
                if (data.length > 0) {
                    $detail.html('<table id="tableValue_'+data[0].attribute_id+'" class="table table-sm table-striped" data-detail-view="true" data-unique-id="id" data-pagination="true"></table>').find('table').bootstrapTable({
                        columns: [
                            {field:'id',title: 'ID',visible:false},
                            {field:'attribute_id',title: 'ID',visible:false},
                            {field:'name',title: 'Value',sortable:true},
                            {field:'extra',title: 'Extra',align:'center',sortable:true,formatter:'extraFormatter',width:'200'},
                            {field:'order',title: 'Order',align:'center',sortable:true},
                            {field:'status',title: 'Status',sortable:true,align:'center',formatter:'statusFormatter'},
                            {field:'action',title: 'Action',align:'center',formatter:'actionValuesFormatter',width:'200'},
                                ],
                        data:data,
                        locale: 'en-US',
                        onExpandRow: function(index, row, $detail) {
                            $detail.html('<p class="text-center"><b>Loading data, wait please ...</b></p>');
                            let cont = 1;
                            if (row.extra) {
                                $detail.html('<table id="tableFeatureValueExtra_'+row.id+'" class="table table-sm table-striped" data-unique-id="id" data-pagination="true"></table>').find('table').bootstrapTable({
                                    columns: [
                                        {field:'id',title: 'ID',visible:false},
                                        {field:'idVal',title: 'ID',visible:false},
                                        {field:'idAttr',title: 'ATTR ID',visible:false},
                                        {field:'name',title: 'Name',sortable:true},
                                        {field:'input_type',title: 'Type',sortable:true,width:'300',align:'center',formatter:'typeFormatter'},
                                        {field:'values',title: 'Values',width:'400',formatter:'valuesFormatter'},
                                        {field:'action',title: 'Action',align:'center',formatter:'actionFeatureValuesFormatter',width:'200'},
                                            ],
                                    data:row.extra.map(item => ({ ...item, id: cont++ , idVal:row.id,idAttr:row.attribute_id})),
                                    locale: 'en-US'
                                });
                            } else {
                                $detail.html('<p class="text-center"><b>No Extra values</b></p>');
                            }
                        },
                        loadingTemplate: function loadingTemplate(loadingMessage) {
                            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
                        }
                    });
                }else{
                    $detail.html('<p class="text-center"><b>No matching records found</b></p>');
                }
            });
        },
        onPostBody: function () {
            tool_tips();
        }
    });

    const  $tableValue = $('#tableValue').bootstrapTable({
        locale: 'en-US',
        loadingTemplate: function(loadingMessage) {
            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
        }
    });

    const  $tableSubValue = $('#tableSubValue').bootstrapTable({
        locale: 'en-US',
        loadingTemplate: function(loadingMessage) {
            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
        }
    });

    function actionFormatter(value, row, index) {
        var buttons =`<ul class='list-inline mb-0'>`;
        
        if(row.input_type == 'select' || row.input_type == 'radio' || row.input_type == 'checkbox'){
            buttons +=`<li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-success' data-bs-toggle='tooltip' data-placement='top' title='Add Value' onclick='crearValue(${row.id})' >
                                <i class='mdi mdi-plus-circle'></i>
                            </a>
                        </li>`;
        }
        buttons +=`<li class='list-inline-item'>
                        <a href='javascript:void(0)' class='action-icon text-primary' data-bs-toggle='tooltip' data-placement='top' title='Duplicate Feature' onclick='duplicar(${row.id})' >
                            <i class='mdi mdi-content-duplicate'></i>
                        </a>
                    </li>
                    <li class='list-inline-item'>
                        <a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit Feature' onclick='editar(${row.id})' >
                            <i class='mdi mdi-file-edit'></i>
                        </a>
                    </li>
                    <li class='list-inline-item'>
                        <a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='Delete Feature' onclick='eliminar(${row.id})' >
                            <i class='mdi mdi-delete'></i>
                        </a>
                    </li>
                </ul>`;
        return buttons;
    }

    //sub tabla valores
    function actionValuesFormatter(value, row, index) {
        var buttons =`<ul class='list-inline mb-0'>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-success' data-bs-toggle='tooltip' data-placement='top' title='Add Value' onclick='crearSubValue(${row.id},${row.attribute_id})' >
                                <i class='mdi mdi-plus-circle'></i>
                            </a>
                        </li>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit Value' onclick='editarVal(${row.id},${row.attribute_id})' >
                                <i class='mdi mdi-file-edit'></i>
                            </a>
                        </li>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='Delete Value' onclick='eliminarVal(${row.id},${row.attribute_id})' >
                                <i class='mdi mdi-delete'></i>
                            </a>
                        </li>
                    </ul>`;
        return buttons;
    }
    
    //sub tabla valores extra
    function actionFeatureValuesFormatter(value, row, index) {        
        var buttons =`<ul class='list-inline mb-0'>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit Value' onclick='editarSubVal("${row.id}","${row.idVal}")' >
                                <i class='mdi mdi-file-edit'></i>
                            </a>
                        </li>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='Delete Value' onclick='eliminarExtraVal("${row.id}","${row.idVal}")' >
                                <i class='mdi mdi-delete'></i>
                            </a>
                        </li>
                    </ul>`;
        return buttons;
    }

    //modal sub values
    function actionSubValuesFormatter(value, row, index) {        
        var buttons =`<ul class='list-inline mb-0'>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-danger' data-bs-toggle='tooltip' data-placement='top' title='Delete Value' onclick='eliminaSubVal("${row.id}")' >
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

    function extraFormatter(value,row,index) {
        let color = 'success';
        let name = 'Yes';
        if(!value){
            color = 'danger';
            name = 'No';
        }
        return `<span class="me-1 badge-outline-${color} badge">${name}</span>`
    }

    function typeFormatter(value,row,index) {
        let upperValue = value.toUpperCase();
        return `<span class="me-1 badge-outline-purple badge">${upperValue}</span>`
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

    function valuesFormatter(value, row, index) {
        let values = row.values || [];
        if (values.length > 0) {
            let lista = '<ul>';
            $.each(values, function(i, item) {
                lista += `<li>${item.name}</li>`;
            });
            return lista + '</ul>';
        } else {
            return `<span class="badge badge-soft-purple">No Values</span>`;
        }
    }

    $(document).ready(function(){
        
        $(document).initSwitchery();

        $('#tipo').on('change',function(){
            if($(this).val() == 'select' || $(this).val() == 'radio'){
                $('#divValues').show();
            }else{
                $('#divValues').hide();
            }
        });

        $('#tipoSubValue').on('change',function(){
            if($(this).val() == 'select' || $(this).val() == 'radio'){
                $('#divSubValues').show();
            }else{
                $('#divSubValues').hide();
            }
        });
        
        $('#status').on('change',function(){
            $('#lblstatus').toggleText('Inactive', 'Active');
        });
        
        $('#global').on('change',function(){
            $('#lblglobal').toggleText('No', 'Yes');
        });
        
        $('#statusVal').on('change',function(){
            $('#lblstatusVal').toggleText('Inactive', 'Active');
        });

        $('#statusVal2').on('change',function(){
            $('#lblstatusVal2').toggleText('Inactive', 'Active');
        });

        $('#modalAttributes').on('hide.bs.modal',function(){
            $('#id').val(null);
            $('#name').val(null);
            if($("#status").is(':checked')){
                $("#status").trigger('click');
                $('#lblstatus').text('Inactive');
            }
            if($("#global").is(':checked')){
                $("#global").trigger('click');
                $('#lblglobal').text('No');
            }
            $('#frmAttributes').removeClass('was-validated');
            $tableValue.bootstrapTable('removeAll');
        });

        $('#modalValues').on('hide.bs.modal',function(){
            $('#idVal').val(null);
            $('#nameVal').val(null);
            $('#orderVal').val(0);
            if($("#statusVal").is(':checked')){
                $("#statusVal").trigger('click');
                $('#lblstatusVal').text('Inactive');
            }

            $('#frmValues').removeClass('was-validated');
        });

        $('#modalSubValues').on('hide.bs.modal',function(){
            $('#frmSubValAttributes')[0].reset();
            $tableSubValue.bootstrapTable('load',[]);
            $('#frmSubValAttributes').removeClass('was-validated');
        });

        $('#cerrar').on('click',function(){
            $('#modalAttributes').modal('hide');
        });
        
        $('#cerrarVal').on('click',function(){
            $('#modalValues').modal('hide');
        });
        
        $('#cerrarSubVal').on('click',function(){
            $('#modalSubValues').modal('hide');
        });

        $('#btnAddValue').on('click',function(){
            let attribute_id = ULID.ulid();
            let status = $('#statusVal').is(':checked');
            let data = {
                "id":ULID.ulid(),
                "attribute_id": attribute_id,
                "name":$('#nameValue').val(),
                "status":status
            }
            if(!data.name){
                showToast('Please enter a value','warning');
                return false;
            }
            $tableValue.bootstrapTable('append', data);
            $('#nameValue').val('');
            // if(status){
            //     $('#statusVal').trigger('click');
            //     $('#lblstatusVal').text('Inactive');
            // }
        });

        $('#frmAttributes').on('submit',function(e){
            e.preventDefault();

            let form = $(this);
            if(!form[0].checkValidity())  return false;

            let valores = $tableValue.bootstrapTable('getData', {useCurrentPage: false, includeHiddenRows: true, unfiltered: true});
            let datos = {
                "id":$('#id').val(),
                "name":$('#name').val(),
                "status":$('#status').is(':checked'),
                "is_global":$('#global').is(':checked'),
                "tipo":$('#tipo').val(),
                "values": valores

            }
            sendRequest('{{ route("attributes.save") }}', 'post', datos, function (data) {
                if (data) {
                    showToast(data.msg,data.success);
                    $('#modalAttributes').modal('hide');
                    $table.bootstrapTable('refresh');
                }
            });
        });

        $('#frmValues').on('submit',function(e){
            e.preventDefault();

            let form = $(this);
            if(!form[0].checkValidity())  return false;

            let datos = {
                "id":$('#idVal').val(),
                "attribute_id":$('#attribute_id').val(),
                "name":$('#nameVal').val(),
                "status":$('#statusVal2').is(':checked'),
                'order': $('#orderVal').val() || 0,
            }
            sendRequest('{{ route("values.save") }}', 'post', datos, function (data) {
                if (data) {
                    showToast(data.msg,data.success);
                    $('#modalValues').modal('hide');
                    $table.bootstrapTable('collapseRowByUniqueId', datos.attribute_id);
                    setTimeout(() => {
                        $table.bootstrapTable('expandRowByUniqueId', datos.attribute_id);
                    }, 300);
                }
            });
        });

        $('#frmSubValAttributes').on('submit',function(e){
            e.preventDefault();

            let form = $(this);
            if (!form[0].checkValidity()) return false;

            let idV = $('#idValue').val();
            let idSubVal = $('#idSubVal').val(); // este es el ID existente (si es edición)
            let $row = $("#tableFeatureValueExtra_" + idV).bootstrapTable('getData');

            if ($row.length == 0) {
                let idFeature = $('#idFeature').val();
                let rowData = $('#tableValue_'+idFeature).bootstrapTable('getRowByUniqueId', idV);
                $row = rowData.extra || [];
            }

            let tableData = $tableSubValue.bootstrapTable('getData', {
                useCurrentPage: false,
                includeHiddenRows: true,
                unfiltered: true
            });

            if (tableData.length == 0) {
                tableData = null;
            }

            let newValue = {
                "name": $('#subValueName').val(),
                "input_type": $('#tipoSubValue').val(),
                "values": tableData,
                "id": idSubVal || ULID.ulid(), // si viene idSubVal (edición), lo usamos; si no, uno nuevo
                "idVal": idV
            };

            let index = $row.findIndex(item => item.id == newValue.id);
            if (index !== -1) {
                $row[index] = newValue;
            } else {
                $row.push(newValue);
            }
            
            let filteredRow = $row.map(item => {
                return {
                    name: item.name,
                    input_type: item.input_type,
                    values: item.values
                };
            });

            let datos = {
                "id": idV,
                "attribute_id": $('#idFeature').val(),
                "extra": filteredRow
            };
            
            sendRequest('{{ route("update.extra") }}', 'post', datos, function (data) {
                if (data) {
                    showToast(data.msg,data.success);
                    $('#modalSubValues').modal('hide');

                    $("#tableValue_"+datos.attribute_id).bootstrapTable('updateByUniqueId', {
                        id: datos.id,
                        row: {
                            extra: datos.extra,
                        }
                    });

                     $("#tableValue_"+datos.attribute_id).bootstrapTable('collapseRowByUniqueId', datos.id);

                    setTimeout(() => {
                         $("#tableValue_"+datos.attribute_id).bootstrapTable('expandRowByUniqueId', datos.id);
                    }, 300);
                }
            });
        });
       
        $('#btnAddSubValue').on('click',function(){
            let value_id = ULID.ulid();
            let status = $('#statusVal2').is(':checked');
            let data = {
                "id":value_id,
                "name":$('#nameSubValue').val(),
            }
            if(!data.name){
                showToast('Please enter a value','warning');
                return false;
            }
            $tableSubValue.bootstrapTable('append', data);
            $('#nameSubValue').val('');
        });
    });

    function crear() {
        if(!$('#status').is(':checked')){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        if(!$('#statusVal').is(':checked')){
            $('#statusVal').trigger('click');
            $('#lblstatusVal').text('Active');
        }
        $('#modalAttributes').modal('show');
    }

    function crearValue(id) {
        $('#attribute_id').val(id);
        $('#modalValues').modal('show');
    }

    function editar(id) {        
        let $row = $table.bootstrapTable('getRowByUniqueId', id);
        
        $('#id').val($row.id);
        $('#name').val($row.name);
        if ($row.status){
            $('#status').trigger('click');
            $('#lblstatus').text('Active');
        }
        if ($row.is_global){
            $('#global').trigger('click');
            $('#lblglobal').text('Yes');
        }
        $tableValue.bootstrapTable('load', $row.values || []);
        $('#modalAttributes').modal('show');
    }

    async function duplicar(id){
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let pregunta = await confirmQuestion(`Sure to duplicate this record?<br>${datos.name}`,'<span class="text-muted">⚠️ All related values will be duplicated. ⚠️ </span>');
        if(pregunta)
        {
            let uri = '{{ route("attributes.duplicate",":id")}}';
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
    
    //#ediatr valores
    function editarVal(id,rowid) {
        let $row = $("#tableValue_"+rowid).bootstrapTable('getRowByUniqueId', id);
        
        $('#idVal').val($row.id);
        $('#nameVal').val($row.name);
        $('#attribute_id').val($row.attribute_id);
        $('#orderVal').val($row.order);

        if ($row.status){
            $('#statusVal').trigger('click');
            $('#lblstatusVal').text('Active');
        }
        $('#modalValues').modal('show');
    }

    // sub tabla valores extra
    function editarSubVal(id,rowid) {
        let $row = $("#tableFeatureValueExtra_"+rowid).bootstrapTable('getRowByUniqueId', id);
        
        $('#idSubVal').val(id);
        $('#idValue').val(rowid);
        $('#idFeature').val($row.idAttr);
        $('#subValueName').val($row.name);
        $('#tipoSubValue').val($row.input_type).trigger('change');
        if($row.values){
            $tableSubValue.bootstrapTable('load', $row.values);
        }
        $('#modalSubValues').modal('show');
    }

    function crearSubValue(id,rowid) {
        $('#idValue').val(id);
        $('#idFeature').val(rowid);
        $('#modalSubValues').modal('show');
    }

    //eliminar valores extra -PENDIENTE RUTA Y FUNCION CONTROLADOR-
    async function eliminarExtraVal(id,rowid) {        
        let rowData = $("#tableFeatureValueExtra_"+rowid).bootstrapTable('getRowByUniqueId', id);
        let tableData = $("#tableFeatureValueExtra_"+rowid).bootstrapTable('getData', {useCurrentPage: false, includeHiddenRows: true, unfiltered: true});
        console.log(tableData);
        

        let confirm = await confirmQuestion(`Sure to delete this record?<br><br>${rowData.name}`)
        
        if(confirm)
        {
            let uri = '{{ route("update.extra") }}';
            let index = tableData.filter(item => item.id != id);;

            let datos = {
                "id": rowData.idVal,
                "attribute_id": rowData.idAttr,
                "extra": index
            };

            sendRequest(uri, 'post', datos, function (data) {
                if (data) {
                    showToast(data.msg,data.success);
                    if(data.success == 'success'){
                        $("#tableValue_"+datos.attribute_id).bootstrapTable('updateByUniqueId', {
                            id: datos.id,
                            row: {
                                extra: datos.extra,
                            }
                        });

                        $("#tableFeatureValueExtra_"+id).bootstrapTable('removeByUniqueId', id);
                    }
                }
            });
        }
        else
        {
            showToast('Record without changes','warning');
        }
    }

    //Elimina values
    async function eliminarVal(id, rowid) {
        let datos= $("#tableValue_"+rowid).bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Sure to delete this record?<br>${datos.name}`);
        
        if(confirm)
        {
            let uri = '{{ route("values.delete",":id")}}';
            uri = uri.replace(':id',id);
            sendRequest(uri, 'post', null, function (data) {
                if (data) {
                    showToast(data.msg,data.success);
                    if(data.success == 'success'){
                        $("#tableValue_"+rowid).bootstrapTable('removeByUniqueId', id);
                        $table.bootstrapTable('collapseRowByUniqueId', rowid);
                        setTimeout(() => {
                            $table.bootstrapTable('expandRowByUniqueId', rowid);
                        }, 300);
                    }
                }
            });
        }
        else
        {
            showToast('Record without changes','warning');
        }
    }

    //modal sub values
    async function eliminaSubVal(id) {
        let datos = $tableSubValue.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Sure to delete this record?<br>${datos.name}`);
        
        if(confirm)
        {
            $tableSubValue.bootstrapTable('removeByUniqueId', id);
        }
        else
        {
            showToast('Record without changes','warning');
        }
    }


    async function eliminarFeaVal(id) {
        let datos = $tableValue.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Sure to delete this record?<br>${datos.name}`);
        
        if(confirm)
        {
            $tableValue.bootstrapTable('removeByUniqueId', id);
        }
        else
        {
            showToast('Record without changes','warning');
        }
    }

    async function eliminar(id) {
        let datos = $table.bootstrapTable('getRowByUniqueId', id);
        let confirm = await confirmQuestion(`Sure to delete this record?<br>${datos.name}`,'<span class="text-muted">⚠️ All related values will be removed. ⚠️ </span>')
        
        if(confirm)
        {
            let uri = '{{ route("attributes.delete",":id")}}';
            uri = uri.replace(':id',id);

            sendRequest(uri, 'post', null, function (data) {
                if (data) {
                    showToast(data.msg,data.success);
                    if(data.success == 'success'){
                        $table.bootstrapTable('removeByUniqueId', id);
                    }
                }
            });
        }
        else
        {
            showToast('Record without changes','warning');
        }
    }

</script>
@endsection