const $table = $('#table').bootstrapTable({
    locale: 'en-US',
    loadingTemplate: function (loadingMessage) {
        return '<i class="mdi mdi-spin mdi-loading"></i>';
    },
    onLoadSuccess: function () {
        init_popover();
    }
});

const $tableStock = $('#tableStock');

function actionStockFormatter(value, row, index) {
    var buttons = `<ul class='list-inline mb-0'>
                        <li class='list-inline-item'>
                            <a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit' onclick='editar(${row.id})' >
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

function actionFormatter(value, row, index) {
    var buttons = `<ul class='list-inline mb-0'>
                <li class='list-inline-item'>
                    <a href='javascript:void(0)' class='action-icon text-purple' data-bs-toggle='tooltip' data-placement='top' title='Stock' onclick='showStok(${row.id})' >
                        <i class='mdi mdi-clipboard-list'></i>
                    </a>
                </li>
                <li class='list-inline-item'>
                    <a href='javascript:void(0)' class='action-icon text-warning' data-bs-toggle='tooltip' data-placement='top' title='Edit' onclick='editar(${row.id})' >
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

function statusFormatter(value, row, index) {
    let color = 'success';
    let name = 'Active';
    if (!value) {
        color = 'danger';
        name = 'Inactive';
    }
    return `<span class="me-1 badge-outline-${color} badge">${name}</span>`
}

function addressFormatter(value, row, index) {
    return `<a role="button" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Location" data-bs-content="${value}" data-bs-html="true">
        ${value.replace('<br>', '').substring(0, 60)}...
    </a>`;
}

function imageFormatter(value, row, index) {

    // Filtrar la imagen que es cover
    const coverImage = value.filter(image => image.is_cover === true);

    // Si solo quieres el objeto, puedes acceder al primer elemento del array
    const singleCoverImage = coverImage.length > 0 ? coverImage[0] : null;

    // Verifica si singleCoverImage no es nulo antes de intentar acceder a su propiedad
    if (singleCoverImage) {
        return `<img class="rounded" src="${singleCoverImage.image_url}" height="60px">`;
    } else {
        // Retorna un mensaje o un espacio vacío si no hay imagen de cover
        return `<span class="badge bg-warning text-dark">No Cover Image</span>`; // O simplemente `return '';` para un espacio vacío
    }
}

function categoriesFormatter(value, row, index) {
    // Buscar el objeto donde is_primary es true
    const primaryCategory = value.find(cat => cat.is_primary === true);
    return (primaryCategory) ? primaryCategory.category.name : null;
}

function colorFormatter(value, row, index) {
    // Buscar el atributo cuyo nombre sea "Color"
    const colorAttribute = value.find(attr => attr.attribute.name.toLowerCase() === "color");

    // Obtener el valor del atributo "Color"
    const colorValue = colorAttribute ? colorAttribute.values.name : '-';
    return `<span>${colorValue}</span>`;
}


$(document).ready(function () {

    $(document).initSwitchery();

    $('#status').on('change', function () {
        $('#lblstatus').toggleText('Inactive', 'Active');
    });

    $('#modalWarehouse').on('hide.bs.modal', function () {
        $('#id').val(null);
        $('#name').val(null);
        $('#location').html(null);
        if ($("#status").is(':checked')) {
            $("#status").trigger('click');
            $('#lblstatus').text('Inactive');
        }
        $('#frmWarehouse').removeClass('was-validated');
    });

    $('#cerrar').on('click', function () {
        $('#modalWarehouse').modal('hide');
    });

    $('#frmWarehouse').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        if (!form[0].checkValidity()) return false;
        // Crear objeto FormData con el formulario
        var formData = new FormData($(this)[0]);
        // Obtener el ID del producto
        let prodID = $('#id').val();
        let url = warehouseSave;

        if ($.trim(prodID) != '') {
            url = warehouseUpdate.replace(':id', prodID);  // Ruta para el update
            formData.append('_method', 'patch');
        }

        // Realizar la solicitud AJAX
        $.ajax({
            url: url,
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
                $('#modalWarehouse').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                showToast('An error occurred while processing the data', 'error');
            },
            complete: function () {
                setTimeout(() => {
                    loadingSwal(false);
                }, 300);
            }

        });
    })

    //---Stock-----
    $('#closeStock').on('click', function () {
        $("#offcanvasStock").offcanvas("hide");
    });

});

function crear() {
    $('#modalWarehouse').modal('show');
}

function editar(id) {
    let $row = $table.bootstrapTable('getRowByUniqueId', id);

    $('#id').val($row.id);
    $('#name').val($row.name);
    $('#location').html($row.location);
    if ($row.status) {
        $('#status').trigger('click');
        $('#lblstatus').text('Active');
    }
    $('#modalWarehouse').modal('show');
}

function showStok(id) {
    let $row = $table.bootstrapTable('getRowByUniqueId', id);
    $('#stockTitle').html($row.name + ' Stock');
    initBootstrapTable(id);
    $("#offcanvasStock").offcanvas("show");
}

async function eliminar(id) {
    let datos = $table.bootstrapTable('getRowByUniqueId', id);
    let confirm = await confirmQuestion(`Are you sure you want to delete this record?<br>${datos.name}`)

    if (confirm) {
        let url = warehouseDelete.replace(':id', id);
        $.ajax({
            url: url,
            type: 'delete',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': TOKEN,
            },
            beforeSend: function (data) {
                loadingSwal(true);
            },
            success: function (data) {
                showToast(data.msg, data.success);
                if (data.success == 'success') {
                    $table.bootstrapTable('removeByUniqueId', id);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                showToast('An error occurred while processing the data', 'error');
            },
            complete: function () {
                setTimeout(() => {
                    loadingSwal(false);
                }, 300);
            }
        });
    }
    else {
        showToast('Record without changes', 'warning');
    }

}

function initBootstrapTable(id) {
    let urlStock = stockList.replace(':id', id);
    $tableStock.bootstrapTable('destroy').bootstrapTable({
        locale: 'en-US',
        url: urlStock,
        pageList: "[10, 25, 50, 100, 200, All]",
        pagination: true,
        search: true,
        toolbar: "#toolbarStock",
        showSearchClearButton: true,
        sidePagination: 'server',
        loadingTemplate: function (loadingMessage) {
            return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>';
        }
    });
}