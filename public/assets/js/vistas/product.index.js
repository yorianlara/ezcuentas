var arrayCollection = [];
var to = false;
var closeWindow = false;
var counter = 0;
var boxCount = 0;
var cargaAllData = 0;

let pool = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
let pool2 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
let $table0 = null;
let $table1 = null;
let $table2 = null;
let $table3 = null;
let $table4 = null;
let $table5 = null;
let $table6 = null;
let $table7 = null;
let $table8 = null;
let $table9 = null;

const iconos = [
    "mdi-numeric-1-circle",
    "mdi-numeric-2-circle",
    "mdi-numeric-3-circle",
    "mdi-numeric-4-circle",
    "mdi-numeric-5-circle",
    "mdi-numeric-6-circle",
    "mdi-numeric-7-circle",
    "mdi-numeric-8-circle",
    "mdi-numeric-9-circle",
    "mdi-numeric-10-circle",
];

const colors = ["secondary", "success", "danger", "warning", "info", "pink", "purple", "light", "dark", "primary"];

// Contenedor global para las imágenes seleccionadas y IDs de imágenes cargadas por AJAX
var selectedFiles = [];
var deletedImageIds = [];
var deletedAttrIds = [];
var deletedChildIds = [];
var deletedBundleIds = [];
var deletedPMCs = [];
var deletedTPSKUs = [];
var dataContentBox = {};

//----- Calculo CBM -- FREIGTH CLASS -----
var largo, ancho, alto, peso, u_medida, u_peso, empaque, enviar_por;

//variable para determinar si es nuevo registro o edición
var isNew = true;
//variable para verificar si se puede o no generar titulo del producto
var isLock = false;
//variable para determinar tipo de select seleccionado
var typeSelect = null;

//variable para determinar el tipo de listado
var customerSelectType = 0;

var xlsPdfType = "pdf";

const $table = $('#table').bootstrapTable({
    locale: 'en-US',
    loadingTemplate: () => '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>',

    // Eventos de selección
    onCheck: toggleActions,
    onCheckAll: toggleActions,
    onUncheck: verificaEdit,
    onUncheckAll: disableActions,

    // Después de renderizar la tabla
    onPostBody: () => {
        tool_tips();
        galeria();
    }
});

const $tableBnd = $('#tableBnd').bootstrapTable({
    locale: 'en-US',
    loadingTemplate: function (loadingMessage) {
        return '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>';
    },
    onCheck: function () {
        $('#deleteBnd').removeClass('disabled');
    },
    onCheckAll: function () {
        $('#deleteBnd').removeClass('disabled');
    },
    onUncheck: function () {
        verificaBnd();
    },
    onUncheckAll: function () {
        $('#deleteBnd').addClass('disabled');
    }
});

const $tableChld = $('#tableChld').bootstrapTable({
    locale: 'en-US',
    loadingTemplate: function (loadingMessage) {
        return '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>';
    },
    onCheck: function () {
        $('#deleteChld').removeClass('disabled');
    },
    onCheckAll: function () {
        $('#deleteChld').removeClass('disabled');
    },
    onUncheck: function () {
        let contentChld = $tableChld.bootstrapTable('getSelections');
        if (contentChld.length == 0) {
            $('#deleteChld').addClass('disabled');
        }
    },
    onUncheckAll: function () {
        $('#deleteChld').addClass('disabled');
    }
});

const $tableMC = $('#tableMC').bootstrapTable({
    locale: 'en-US',
    loadingTemplate: function (loadingMessage) {
        return '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>';
    },
    onCheck: function () {
        $('#deleteMC').removeClass('disabled');
    },
    onCheckAll: function () {
        $('#deleteMC').removeClass('disabled');
    },
    onUncheck: function () {
        verifica();
    },
    onUncheckAll: function () {
        $('#deleteMC').addClass('disabled');
    }
});

const $tableShipping = $('#tableShipping').bootstrapTable({
    locale: 'en-US',
    onPostBody: function (data) {
        if(data.length > 0){
            $('#gralShipVia').prop('required', true);
            $('#pallet').prop('required', true);
        }
    }
});

const $tableCustomers = $('#tableCustomers').bootstrapTable({
    locale: 'en-US',
});

const $tableTPSKU = $('#tableTPSKU').bootstrapTable({
    locale: 'en-US',
    onCheck: function () {
        $('#deleteTPsku').removeClass('disabled');
    },
    onCheckAll: function () {
        $('#deleteTPsku').removeClass('disabled');
    },
    onUncheck: function () {
        verificaTPSKU();
    },
    onUncheckAll: function () {
        $('#deleteTPsku').addClass('disabled');
    }
});

const $tableCarga = $('#tableCarga').bootstrapTable({
    locale: 'en-US',
    loadingTemplate: function loadingTemplate(loadingMessage) {
        return '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>';
    },
    onPostBody:function(){
        init_popover();
        makeCellsEditable();
    }
});
//Tabla detalles
const $tableMCD = $('#tableMCD').bootstrapTable({
    locale: 'en-US',
});

const $tableAttrD = $('#tableAttrD').bootstrapTable({
    locale: 'en-US',
});

const $tableTPSKUD = $('#tableTPSKUD').bootstrapTable({
    locale: 'en-US',
});

const $tableChldD = $('#tableChldD').bootstrapTable({
    locale: 'en-US',
});

const $tableBndD = $('#tableBndD').bootstrapTable({
    locale: 'en-US',
});

const $tableShippingD = $('#tableShippingD').bootstrapTable({
    locale: 'en-US',
});

const $tableTrash = $('#tableTrash').bootstrapTable({
    locale: 'en-US',
    loadingTemplate: function (loadingMessage) {
        return '<i class="mdi mdi-spin mdi-24px mdi-refresh"></i>';
    },
});
//Fin detalles

function toggleActions() {
    $('.actBtn').removeClass('disabled');
    $('#edita').removeClass('text-dark').addClass('text-warning');
    $('#duplica').removeClass('text-dark').addClass('text-info');
    $('#borrar').removeClass('text-dark').addClass('text-danger');
}

// Función para deshabilitar botones de acción
function disableActions() {
    $('.actBtn').addClass('disabled');
    $('#edita').removeClass('text-warning').addClass('text-dark');
    $('#duplica').removeClass('text-info').addClass('text-dark');
    $('#borrar').removeClass('text-danger').addClass('text-dark');
}

$("#jstree").jstree({
    core: {
        data: [], // Al iniciar, los datos estarán vacíos
        multiple : false,
    },
    plugins: ["sort","types", "checkbox", "search", "wholerow"], // Plugins para íconos personalizados y casillas de verificación
    types: {
        "default": {
            "icon": "fa fa-folder" // Icono por defecto para nodos
        },
        "file": {
            "icon": "fas fa-file" // Icono por defecto para archivos o categorías hijas
        }
    }
});

var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 200,
	height : 200
});

function rowStyle(row, index) {
    // Si no existe 'fila_color', no aplicamos ningún estilo
    if (!row.fila_color) {
        return {};
    }

    // Retornamos la clase que corresponde al color
    return {
        classes: 'table-' + row.fila_color  // Aplicamos la clase de Bootstrap: table-danger, table-warning, etc.
    };
}

function excelFormatter(value,row,index) {
    return 1;
}

function skuFormatter(value, row, index) {
    return `<a href="javascript:void(0)" class="link-primary" onclick="mostrar(${row.id})">${value}</a>`;
}

function imageFormatter(value, row, index) {

    const singleCoverImage = value;

    if (singleCoverImage) {
       return  `<a href="${singleCoverImage}" class="image-popup" title="${row.name}">
                    <img src="${singleCoverImage}" alt="${row.sku}" class="avatar-lg" width="50%">
                </a>`;
    } else {
        return `<span class="badge bg-warning text-dark">No Cover Image</span>`; 
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

function statusFormatter(value, row, index) {
    return `<h5><span class="me-1 badge bg-${row.status_color}">${value}</span></h5>`
}

function customViewFormatter(data) {
    var template = $('#profileTemplate').html()
    var view = ''
    $.each(data, function (i, row) {
        let coverImage = row.cover_image || null;
        let bundle = (row.is_bundle) ? 'is grouped' : '';
        let $sku = `<a href="javascript:void(0)" class="link-primary" onclick="mostrar(${row.id})">${row.sku}</a>`;
        view += template.replace('%NAME%', row.name)
            .replace('%SKU%', $sku)
            .replace('%BRAND%', row.brand)
            .replace('%DESCRIPTION%', row.description)
            .replace('%IMAGE%', coverImage)
            .replace('%STATUS%', row.status)
            .replace('%COLOR%', row.status_color)
            .replace('%BUNDLE%', bundle)
            .replace('%FOLLOWER%', row.price)
            .replace('%FOLLOWING%', row.wholesale_price)
            .replace('%SNIPPETS%', row.product_type)
    })

    return `<div class="row mx-0">${view}</div>`
}

function idFormatter() {
    return 'TOTAL'
}

function additionFormatter(data) {
    var field = this.field;
    var sum = data.map(function (row) {
        return +row[field];
    }).reduce(function (sum, i) {
        return sum + i;
    }, 0);

    // Limitar a 3 decimales
    return parseFloat(sum.toFixed(3));
}

function actionLoadProductFormatter(value, row, index) {
    let botones = `<div class="d-flex gap-2 text-center" style="display: flex; justify-content: center;">
                    <a href="javascript:void(0);" class="btn btn-primary bg-gradient btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                        onclick="showCliente(${row.id})" title="" data-bs-original-title="Ver">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-success bg-gradient btn-sm" data-bs-toggle="tooltip" onclick="editarC(${row.id})"
                        data-bs-placement="top" title="" data-bs-original-title="Editar">
                        <i class="fas fa-pen" aria-hidden="true"></i>
                    </a>`;
    if(row.estado){
        botones += `<a href="javascript:void(0);" class="btn btn-danger bg-gradient btn-sm" onclick="changeStatus(${row.id})" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Activar/Desactivar">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    </div>`;
    }else{
        botones += `<a href="javascript:void(0);" class="btn btn-success bg-gradient btn-sm" onclick="changeStatus(${row.id})" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Activar/Desactivar">
                        <i class="fas fa-check"></i>
                    </a>
                    </div>`;
    }
    return botones;
}

function descriptionFormatter(value, row,index){
    if(!value) return false;
    return `<a role="button" class="description" data-id="${row.id}" data-bs-toggle="popover" data-bs-trigger="hover focus" title="${this.passed.title}" data-bs-content="${value}" data-bs-html="true" id="D-${row.id}">${((value).replace('<br>, ')).substring(0, 20)}...</a>`
}

function shippingActionFormatter(value, row, index) {
    let botones = `<div class="d-flex gap-2 text-center" style="display: flex; justify-content: center;">
                    <a href="javascript:void(0);" class="btn btn-danger bg-gradient btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                        onclick="eliminarItemShip(${row.id})" title="" data-bs-original-title="Delete">
                        <i class="mdi mdi-trash-can" aria-hidden="true"></i>
                    </a>`;
    return botones;
}

function valuesFormatter(value, row, index) {
    // Reemplaza espacios en el nombre por guiones y convierte a minúsculas
    let name = slugify(row.name);

    // Comienza el <select> con clases e identificadores únicos por fila
    let $select = `<select class="form-select selAttr" data-id="${row.id}" id="${name}-sel" name="attrValueSelect${row.id}" >`;

    // Agrega una opción vacía por defecto
    $select += `<option value="">Select...</option>`;

    // Itera sobre los valores para construir opciones
    $.each(value, function (k, v) {
        $select += `<option value="${v.id}" ${v.id == row.value_id ? 'selected' : ''}>${v.name}</option>`;
    });

    $select += `</select>`;
    return $select;
}

function crear() {
    $('#offcanvasRight').offcanvas('show');
        setTimeout(() => {
        $tableMC.bootstrapTable('resetView');
        $tableBnd.bootstrapTable('resetView');
        $('#statusP').val(4).trigger('change');
        $('#dimension_unit').val(6).trigger('change');
        $('#weight_unit').val(2).trigger('change');
        // hopscotch.startTour(tour);
    }, 1000);
}

function verificaTPSKU() {
    let content = $tableTPSKU.bootstrapTable('getSelections');
    let hasit = $('#deleteTPsku').hasClass('disabled');
    if (content.length == 0 && !hasit) {
        $('#deleteTPsku').addClass('disabled');
    }
}

function queryParamsC(params) {
    params.status = true;
    return params
}

function verificaChld() {
    let content = $tableChld.bootstrapTable('getSelections');
    let hasit = $('#deleteChld').hasClass('disabled');
    if (content.length == 0 && !hasit) {
        $('#deleteChld').addClass('disabled');
    }
}

function verificaBnd() {
    let content = $tableBnd.bootstrapTable('getSelections');
    let hasit = $('#deleteBnd').hasClass('disabled');
    if (content.length == 0 && !hasit) {
        $('#deleteBnd').addClass('disabled');
    }
}

function verificaEdit() {
    let content = $table.bootstrapTable('getSelections');
    let hasit = $('#edita').hasClass('disabled');
    if (content.length == 0 && !hasit) {
        $('.actBtn').addClass('disabled');
        $('#edita').removeClass('text-warning').addClass('text-dark');
        $('#duplica').removeClass('text-info').addClass('text-dark');
        $('#borrar').removeClass('text-danger').addClass('text-dark');
    }
}

function verifica() {
    let content = $tableMC.bootstrapTable('getSelections');
    let hasit = $('#deleteMC').hasClass('disabled');
    if (content.length == 0 && !hasit) {
        $('#deleteMC').addClass('disabled');
    }
}

$('.new').select2({
    theme: "bootstrap-5",
    //width: "90%",
    dropdownParent: $('#offcanvasRight'),
    placeholder: "Select...",
});

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

$("#child_products").select2({
    templateResult: formatState,
    theme: "bootstrap-5",
    width: "100%",
    placeholder: "Select...",
    dropdownParent: $("#offcanvasRight"),
    tokenSeparators: [",", " "],
    ajax: {
        url: listChild,
        dataType: "json",
        delay: 250,
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

$("#bundle_products").select2({
    templateResult: formatState,
    theme: "bootstrap-5",
    width: "100%",
    placeholder: "Select...",
    dropdownParent: $("#offcanvasRight"),
    tokenSeparators: [",", " "],
    ajax: {
        url: bundleProducts,
        dataType: "json",
        delay: 250,
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

$('#cover').fileinput({
    showCaption: false,
    dropZoneEnabled: false,
    showUpload: false
});

// Función para cargar imágenes desde archivo o URL
var loadImage = function (src, isLocalFile = true, file = null, imageId = null) {
    // Contenedor donde se agregarán las imágenes
    var outputContainer = document.getElementById('idimage');

    // Crear un contenedor para la imagen y el botón
    let imgWrapper = document.createElement('div');
    imgWrapper.classList.add('img-wrapper'); // Añadir una clase a cada contenedor de imagen
    imgWrapper.classList.add('card'); // Añadir una clase a cada contenedor de imagen
    imgWrapper.classList.add('card-body'); // Añadir una clase a cada contenedor de imagen
    imgWrapper.style.display = 'inline-block';
    imgWrapper.style.margin = '10px';
    imgWrapper.style.textAlign = 'center';  // Centramos el contenido
    imgWrapper.dataset.imageId = imageId;   // Asignamos el ID de la imagen al contenedor (para imágenes de AJAX)

    // Crear un nuevo elemento img para cada archivo
    let img = document.createElement('img');
    img.src = src;
    img.classList.add('uploaded-image');  // Añadir clase personalizada a cada imagen
    img.classList.add('rounded');  // Añadir clase personalizada a cada imagen
    img.style.maxWidth = '150px'; // Ajustar el tamaño de las imágenes
    img.style.display = 'block';  // Aseguramos que la imagen sea un bloque

    // Crear un botón para eliminar la imagen
    let deleteButton = document.createElement('button');
    deleteButton.innerHTML = '<i class="bi-trash"></i> Delete'; // Texto del botón de eliminar
    deleteButton.classList.add('btn', 'btn-block', 'btn-outline-secondary', 'btn-xs', 'waves-effect');  // Usamos clases de estilo de Bootstrap
    deleteButton.style.marginTop = '5px';

    // Añadir evento al botón para eliminar la imagen y su archivo correspondiente
    deleteButton.onclick = function () {
        if (isLocalFile && file) {
            let index = selectedFiles.indexOf(file); // Encontrar el índice del archivo en el array
            if (index > -1) {
                selectedFiles.splice(index, 1); // Eliminar el archivo del array
            }
        } else if (imageId) {
            deletedImageIds.push(imageId); // Encontrar el índice del ID en el array
        }
        imgWrapper.remove(); // Eliminar el contenedor de la imagen de la vista
    };

    // Añadir la imagen y el botón de eliminar al contenedor de la imagen
    imgWrapper.appendChild(img);
    imgWrapper.appendChild(deleteButton);
    outputContainer.appendChild(imgWrapper);

    // Liberar memoria una vez que la imagen ha sido cargada si es un archivo local
    if (isLocalFile && file) {
        img.onload = function () {
            URL.revokeObjectURL(img.src);
        };
    }
};

// Función para cargar imágenes desde el input file
var loadFile = function (event) {
    let files = event.target.files;

    // Verificar si se excede el límite de 9 imágenes
    if (selectedFiles.length + files.length > 9) {
        showToast("You can only upload a maximum of 9 images.",'warning');
        return;
    }
    // Recorremos todos los archivos seleccionados
    for (let i = 0; i < event.target.files.length; i++) {
        let file = event.target.files[i];
        selectedFiles.push(file);  // Guardar el archivo en el array
        loadImage(URL.createObjectURL(file), true, file); // Cargar la imagen desde el archivo local
    }
};

$(document).on('click', '.close', function () {
    let id = $(this).prop('id').split('-')[1];

    let datos = $(`#table${id}`).bootstrapTable('getData');
    $.each(datos, function (k, v) {
        $table.bootstrapTable('updateByUniqueId', {
            id: v.id,
            row: {
                "fila_color": null
            }
        })
    });

    $('#pills-tab' + id).remove();
    $('#pills-list' + id).remove();
    $('#pills-home-tab').trigger('click');
    if (id >= 0 && id < 10) {
        pool.push(id); // Lo regresa a la pool
        // Si hay más de 2 números en la pool, ordenarla en orden ascendente
        if (pool.length > 2) {
            pool.sort((a, b) => a - b); // Orden ascendente
        }
    }
});

$(document).on('click', '.description', function () {
    let ID = $(this).data('id');
    $('#idDesc').val(ID);
    $('#modalDescription').css('z-index', '9999');
    $('#editDescription').val($(this).data('bs-content'))
    $('#modalDescription').modal('show');
});

$(document).on('click', '.remove-filter', function () {
    $(`#${$(this).data('filter')}`).remove();
    $table.bootstrapTable('refresh');
});

function addList() {
    let data = $table.bootstrapTable('getSelections');

    $table.bootstrapTable('uncheckAll');
    if (data.length > 0) {
        let icon_num = pool.shift(); // Toma el primer número disponible y lo remueve de la pool 
        let listNum = parseInt(icon_num) + 1;
        $.each(data, function (k, v) {
            $table.bootstrapTable('updateByUniqueId', {
                id: v.id,
                row: {
                    "fila_color": colors[icon_num]
                }
            })
        });

        if (icon_num <= 9) {
            let contenido = `<li class="nav-item" role="presentation" id="tab${icon_num}">
                                <button class="btn btn-${colors[icon_num]} mb-2 mb-sm-0" id="pills-tab${icon_num}" data-bs-toggle="pill" data-bs-target="#pills-list${icon_num}" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                    View 
                                    <i class="mdi ${iconos[icon_num]}"></i>
                                </button>
                            </li>`;
            let tabla = `<div class="tab-pane fade show active" id="pills-list${icon_num}" role="tabpanel" aria-labelledby="pills-list${icon_num}-tab">
                                <div id="toolbar${icon_num}">
                                    <button class="btn btn-danger close" id="bt-${icon_num}">
                                        <i class="mdi mdi-close"></i>
                                        Close View <i class="mdi ${iconos[icon_num]}"></i>
                                    </button>
                                </div>
                                <table id="table${icon_num}" class="table table-sm table-striped"
                                data-id-field="id"
                                data-unique-id="id"
                                data-click-to-select="true"
                                data-toolbar="#toolbar${icon_num}"

                                data-search="true"
                                data-show-search-clear-button="true"
                                data-search-align="right"

                                data-pagination="true"
                                data-show-jump-to="true"
                                data-row-style="rowStyle"
                                
                                data-show-button-text="true"
                                data-buttons-align="left"
                                data-show-custom-view="true"
                                data-custom-view="customViewFormatter"
                                data-show-custom-view-button="true">
                                    <thead class="table-light">
                                        <tr>
                                            <th data-field="id" data-visible="false" data-align="center">#</th>
                                            <th data-field="fila_color" data-visible="false">Color</th>
                                            <th data-field="state" data-width="10" data-checkbox="true" data-align="center"></th>
                                            <th data-field="cover_image" data-width="100" data-align="center" data-formatter="imageFormatter">Products</th>
                                            <th data-field="sku" data-sortable="true" data-formatter="skuFormatter">SKU</th>
                                            <th data-field="name" data-sortable="true">Name</th>
                                            <th data-field="category" data-sortable="true" >Category</th>
                                            <th data-field="qty" data-align="right" data-sortable="true">Qty.</th>
                                            <th data-field="color" data-sortable="true">Color</th>
                                            <th data-field="status" data-width="100" data-formatter="statusFormatter">Status</th>
                                            <th data-field="status_color"data-visible="false" data-width="100">Status Color</th>
                                        </tr>
                                    </thead>
                            </table>
                        </div>`;
            $('#pills-tab').append(contenido);
            $('#pills-tabContent').append(tabla);

            setTimeout(() => {
                $('#pills-tab' + icon_num).trigger('click');
                initBootstrapTable(`#table${icon_num}`);
                $(`#table${icon_num}`).bootstrapTable('load', data);
            }, 100);

            setTimeout(() => {
                $(`#table${icon_num}`).bootstrapTable('resetView');
            }, 200);
        }
    }
};

function initBootstrapTable(tableSelector) {
    $(tableSelector).bootstrapTable({
        locale: 'en-US',
    });
}

function closeAllCards() {
    $('.card .collapse.show.cont').collapse('hide');
    updateToggleAllBtn('expand'); // Estado futuro tras cerrar
}

// Función que abre todos los collapse
function openAllCards() {
    $('.card .collapse.cont:not(.show)').collapse('show');
    updateToggleAllBtn('collapse'); // Estado futuro tras abrir
}

// Actualiza el texto e ícono del botón global
function updateToggleAllBtn(action) {
    let $btn = $('#toggleAllBtn');
    let icon = action === 'expand' ? 'mdi-chevron-down' : 'mdi-chevron-up';
    let text = action === 'expand' ? ' Expand All' : ' Collapse All';

    $btn.html(`<i class="mdi ${icon}"></i>${text}`);
}

// Detecta automáticamente si debe decir Expand o Collapse
function updateToggleAllBtnByState() {
    let visibles = $('.card .collapse').filter('.show.cont').length;
    let total = $('.card .collapse').filter('.cont').length;

    if (visibles === total) {
        updateToggleAllBtn('collapse'); // Todos abiertos
    } else {
        updateToggleAllBtn('expand'); // Alguno cerrado
    }
}

$(document).ready(function () {

    $(document).initSwitchery();

    fetchCategories();

    $('.toggleCards').on('click', function () {
        updateToggleAllBtnByState();
    });

    $('#offcanvasRight').on('show.bs.offcanvas', function () {
        setTimeout(() => {
            $tableMC.bootstrapTable('resetView');
            $tableBnd.bootstrapTable('resetView');
        }, 500);
    })

    $('.card .collapse.cont').on('shown.bs.collapse hidden.bs.collapse', function () {
        updateToggleAllBtnByState();
    });

    // Al hacer clic en botón global
    $('#toggleAllBtn').on('click', function () {
        let visibles = $('.card .collapse').filter('.show.cont').length;
        if (visibles > 0) {
            closeAllCards();
        } else {
            openAllCards();
        }
    });

    $("input[name=pl_type]").on('click',function() {
        customerSelectType = $(this).val();
        if(customerSelectType == 1){
            $('#divTableCustomer').addClass('d-none');
        }else{
            $('#divTableCustomer').removeClass('d-none');
        }
    });
    
    $("input[name=pl_export]").on('click',function() {
        xlsPdfType = $(this).val();
    });

    $('#cerrarPL').on('click',function(){
        $('#modalPriceList').modal('hide');
    });

    //Input to Uppercase
    $(".input_capital").on('keyup', function (e) {
        $(this).val($(this).val().toUpperCase());
    });

    // Cierra el dropdown completo al hacer clic en cualquier opción
    $('.dropdown-submenu a').on('click', function () {
        if (!$(this).hasClass('dropdown-toggle')) {
            $('.dropdown-menu.show').removeClass('show');
        }
    });

    //Verificar data cuando se cierra en X
    $('#closeProduct').on("click", async function () {
        let validacion = await checkFilledFields('formProducts'); // Llama a la función de validación
        if (validacion && isNew) {
            const shouldProceed = await confirmQuestion('You have unsaved data in the form, do you want to close the window?');
            if (!shouldProceed) return;
        }
        $('#offcanvasRight').offcanvas('hide'); // Cierra el offcanvas
    });

    $('#closeDetail').on("click", async function () {
        $('#offcanvasDetail').offcanvas('hide'); // Cierra el offcanvas
    });

    //Reset formulario Producto
    $('#prodCancel').on('click', async function () {
        let confirm = true;
        if (isNew) {
            confirm = await confirmQuestion('Are you sure to discard this data?');
        }
        if (confirm) {
            $('#offcanvasRight').offcanvas('hide');
            verificaEdit();
        }
    });

    $('#prodSave').on('click', async function () {
        closeWindow = false;
        guardar();
    });

    $('#prodSaveClose').on('click', async function () {
        closeWindow = true;
        guardar();
    });

    $('#offcanvasRight').on('hidden.bs.offcanvas', function () {
        hopscotch.endTour();
        clearFrmProducts();
        $table.bootstrapTable('uncheckAll');
    });

    $('#mapCtrl').on('change', function () {
        $('#lblmapCtrl').toggleText('Yes', 'No');
    });

    //Table MC--------------------------------------------
    $('#agregarMC').on('click', function () {
        const pord_part_id = $('#product_part').val();
        const pord_part = $('#product_part option:selected').text();
        const material_id = $('#material').val();
        const material = $('#material option:selected').text();
        const color_id = $('#color').val();
        const color = $('#color option:selected').text();

        if (!pord_part_id || !material_id || !color_id) {
            showToast('Select furniture part, material and color to continue', 'error');
            return false;
        }

        prevData = $tableMC.bootstrapTable('getData');
        let result = prevData.find(item => item.parts_id == pord_part_id);
        if (result) {
            showToast('This item has already been selected, please check', 'error');
            return false;
        }

        let data = [{
            'id': ULID.ulid(),
            'parts': pord_part,
            'parts_id': pord_part_id,
            'material': material,
            'material_id': material_id,
            'color': color,
            'color_id': color_id,
        }];

        $tableMC.bootstrapTable('append', data);
        $('#product_part, #material, #color').val(null).trigger('change');
    });

    $('#deleteMC').on('click', async function () {
        let confirm = await confirmQuestion('Are you sure to delete this item?');
        if (confirm) {
            let content = $tableMC.bootstrapTable('getSelections');
            $.each(content, function (k, v) {
                $tableMC.bootstrapTable('removeByUniqueId', v.id);
                deletedPMCs.push(v.id);
            });
            verifica();
        }
    });

    //Table Bnd--------------------------------------------
    $('#addBnd').on('click', function () {
        const bnd_products_id = $('#bundle_products').val();
        const bnd_products = $('#bundle_products option:selected').text();
        const bnd_qty = $('#qty').val();

        // Validación de selección de atributos y valores
        if (!bnd_products_id || !bnd_qty) {
            showToast('Select product and quantity to continue', 'error');
            return false;
        }

        // Verificar si ya está el atributo en la tabla
        prevData = $tableBnd.bootstrapTable('getData');
        let result = prevData.find(item => item.id == bnd_products_id);
        if (result) {
            showToast('This product are already listed, please check', 'error');
            return false;
        }

        // Agregar nueva fila a la tabla
        let data = [{
            'id': bnd_products_id,
            'sku': bnd_products.split('|')[0],
            'name': bnd_products.split('|')[1],
            'qty': bnd_qty,
        }];

        $tableBnd.bootstrapTable('append', data);

        // Limpiar los campos del formulario
        $('#bundle_products').val(null).trigger('change');
        $('#qty').val(null);
    });

    $('#deleteBnd').on('click', async function () {
        let confirm = await confirmQuestion('Are you sure to delete this item?');
        if (confirm) {
            let content = $tableBnd.bootstrapTable('getSelections');
            $.each(content, function (k, v) {
                $tableBnd.bootstrapTable('removeByUniqueId', v.id);
                deletedBundleIds.push(v.id);
            });
            verificaBnd();
        }
    });
    //-----------------------------------------------------

    //Table Chld--------------------------------------------
    $('#addChld').on('click', async function () {
        const chld_products_id = $('#child_products').val();
        const chld_products = $('#child_products option:selected').text();

        // Validación de selección de atributos y valores
        if (!chld_products_id) {
            showToast('Select product to continue', 'error');
            return false;
        }

        // Verificar si ya está el atributo en la tabla
        prevData = $tableChld.bootstrapTable('getData');
        let result = prevData.find(item => item.id == chld_products_id);
        if (result) {
            showToast('This product are already listed, please check', 'error');
            return false;
        }

        // Agregar nueva fila a la tabla
        let data = [{
            'id': chld_products_id,
            'sku': chld_products.split('|')[0],
            'name': chld_products.split('|')[1],
        }];

        $tableChld.bootstrapTable('append', data);

        let url = productShow.replace(':id', data[0].id);
        $row = await getProductData(url);

        console.log($row);
        dataShipping = $row.product_shipping_detail.shipping_detail ?? null;
        if (dataShipping) {
            $tableShipping.bootstrapTable('append', dataShipping);
        }
        calculoParcial();

        // Limpiar los campos del formulario
        $('#child_products').val(null).trigger('change');
    });

    $('#deleteChld').on('click', async function () {
        let confirm = await confirmQuestion('Are you sure to delete this item?');
        if (confirm) {
            let content = $tableChld.bootstrapTable('getSelections');
            $.each(content, function (k, v) {
                $tableChld.bootstrapTable('removeByUniqueId', v.id);
                deletedChildIds.push(v.id);
            });
            verificaChld();
        }
    });
    //-----------------------------------------------------

    //Table Third Party SKU--------------------------------------------
    $('#addTPsku').on('click', async function () {
        const customer_id = $('#customer').val();
        const customer = $('#customer option:selected').text();
        const customer_sku = $.trim($('#tpsku').val());

        // Validación de selección de atributos y valores
        if (!customer_id || !customer_sku) {
            showToast('Select Customer and SKU to continue', 'error');
            return false;
        }

        // Verificar si ya está el atributo en la tabla
        prevData = $tableTPSKU.bootstrapTable('getData');
        
        let result = prevData.find(item => item.customer_id == customer_id );
        if (result) {
            showToast('This customer is already on the list, please verify', 'error');
            return false;
        }

        let id = ULID.ulid();

        // Agregar nueva fila a la tabla
        let data = [{
            'id': id,
            'customer_id': customer_id,
            'customer': customer,
            'customer_sku': customer_sku,
        }];

        $tableTPSKU.bootstrapTable('append', data);

        // Limpiar los campos del formulario
        $('#customer').val(null).trigger('change');
        $('#tpsku').val(null);
    });

    $('#deleteTPsku').on('click', async function () {
        let confirm = await confirmQuestion('Are you sure to delete this item?');
        if (confirm) {
            let content = $tableTPSKU.bootstrapTable('getSelections');
            $.each(content, function (k, v) {
                $tableTPSKU.bootstrapTable('removeByUniqueId', v.id);
                deletedTPSKUs.push(v.id);
            });
            verificaTPSKU();
        }
    });
    //-----------------------------------------------------

    //Carga imágenes adicionales
    $('#uploadBtn').on('click', function () {
        $('#otherImage').trigger('click');
    });

    //Generar Descripción IA
    $('#generate').on('click', async function () {
        const LOADING_TEXT = 'Generating...';

        let extraInfo = $tableMC.bootstrapTable('getData');

        let atributos = await getLabelsAndValues();

        let selColor = $('#color-sel option:selected').text() == 'Select...' ? null : $('#color-sel option:selected').text();
        let selWarranty = $('#warranty-sel option:selected').text() == 'Select...' ? null : $('#warranty-sel option:selected').text();
        let selAssembly = $('#assembly-sel option:selected').text() == 'Select...' ? null : $('#assembly-sel option:selected').text();
        let selUse = $('#use-sel option:selected').text() == 'Select...' ? null : $('#use-sel option:selected').text();
        let selProduct = $('#product-care-sel option:selected').text() == 'Select...' ? null : $('#product-care-sel option:selected').text();
        let selProp65 = $('#prop-65-sel option:selected').text() == 'Select...' ? null : $('#prop-65-sel option:selected').text();

        let requestData = {
            name: $('#name').val()?.trim() || null,
            collection: $('#collection').val()?.trim() || null, // Opcional
            brand: $('#brand option:selected').text()?.trim() || null,
            origin: $('#origin option:selected').text()?.trim() || null,
            category: $('#jstree').jstree().get_selected(true)[0]?.text || null,
            weight: $('#weight').val()?.trim() || null,
            width: $('#width').val()?.trim() || null,
            height: $('#height').val()?.trim() || null,
            depth: $('#depth').val()?.trim() || null,
            color: selColor,
            warranty: selWarranty,
            assembly: selAssembly, //opcional
            use: selUse, //opcional
            product_care: selProduct, //opcional
            prop65: selProp65, //opcional
            components: extraInfo || null,
            attributes: atributos
        };
    
        // Validar campos obligatorios
        const requiredFields = ['name', 'brand', 'origin', 'category', 'weight', 'height', 'depth', 'color', 'warranty'];
        const missingFields = requiredFields.filter(field => !requestData[field]);
    
        if (missingFields.length > 0) {
            let msg = `Please complete the following mandatory fields: ${missingFields.join(', ')}`;
            showToast(msg,'error');
            return;
        }
    
        $('#textDescription').val(LOADING_TEXT);

        var $portlet = $('#aiCardDescription').closest(".card");

        $('#generate').prop('disabled', true);
        $portlet.append('<div class="card-disabled"><div class="card-portlets-loader"><div class="spinner-border text-primary m-2" role="status"></div></div></div>');

        $.get(generateAI, requestData)
        .done(function (res) {
            //let DATAres = parseAjaxResponse(res);
            if (!isLock) {
                $('#titleDescription').val(res.title);
            }
            $('#textDescription').val(res.description);
        })
        .fail(function (err) {
            console.error('Error generating description:', err);
            $('#textDescription').val('An error occurred.');
        })
        .always(function () {
            var $pd = $portlet.find('.card-disabled');
            setTimeout(() => {
                $pd.fadeOut('fast', function () {
                    $pd.remove();
                }); 
            }, 500);
            
            $('#generate').prop('disabled', false);
        });
    });

    $('#SKGenerate').on('click', function () {
        const LOADING_TEXT = 'Generating...';
    
        // Obtener valores de los campos
        let requestData = {
            name: $('#name').val()?.trim() || null,
            collection: $('#collection').val()?.trim() || null, // Opcional
            brand: $('#brand option:selected').text()?.trim() || null,
            origin: $('#origin option:selected').text()?.trim() || null,
            category: $('#jstree').jstree().get_selected(true)[0]?.text || null,
            color: $('select[name="attributes[1]"] option:selected').text() || null,
            _token: TOKEN
        };
    
        // Validar campos obligatorios
        const requiredFields = ['name', 'brand', 'origin', 'category'];
        const missingFields = requiredFields.filter(field => !requestData[field]);
    
        if (missingFields.length > 0) {
            let msg = `Please complete the following mandatory fields: ${missingFields.join(', ')}`;
            showToast(msg,'error');
            return;
        }
    
        $('#sku').val(LOADING_TEXT);
        $('#SKGenerate').prop('disabled', true);
        $.post(generateSKU, requestData)
        .done(function (res) {
            $('#sku').val(res.sku);
        })
        .fail(function (err) {
            console.error('Error generating description:', err);
            $('#sku').val('An error occurred.');
        })
        .always(function () {            
            $('#SKGenerate').prop('disabled', false);
        });
    });
    
    //JsTree--------------------------------------------
    $('#jstree').on('changed.jstree', function (e, data) {
        const tree = $('#jstree').jstree(true);
        let r = [];

        // Si no hay selección, salimos
        if (data.selected.length === 0) {
            $('#event_result').html('Selected: ');
            loadProductAttributes(null);
            return;
        }

        const node = data.node;

        // Evitar seleccionar nodos raíz o con hijos
        if (node.parent === '#' || tree.get_children_dom(node).length > 0) {
            setTimeout(() => {
                tree.deselect_node(node);
            }, 1);
            return;
        }

        let selectedNodes = node.id || null;
        loadProductAttributes(selectedNodes);

        // Solo un nodo seleccionado permitido, ya lo controla jsTree con multiple: false
        const content = `<span class="badge badge-outline-dark rounded-pill">${node.text}</span>`;
        r.push(content);

        $('#event_result').html('Selected: ' + r.join(' '));
    }).jstree();

    $('#jstree_q').on('keyup', function () {
        if (to) { clearTimeout(to); }
        $('#jstree').jstree("close_all");
        to = setTimeout(function () {
            var v = $('#jstree_q').val();
            $('#jstree').jstree(true).search(v);
        }, 250);
    });

    $('#searchClear').on('click', function () {
        $('#jstree_q').val(null);
        clearSearch();
    });
    //------------------------------------------------

    //Candado titulo descripción
    $('#candado').on('click', function () {
        $('#imgLock').toggleClass('mdi-lock-open-variant-outline mdi-lock-outline');
        isLock = !isLock;
        $('#titleDescription').prop('readonly', isLock);
    });

    $('#attrName').on('change', function () {
        let id = $(this).val();
        if (id == null || id == '' || id.length == 0 || id == undefined) {
            return false;
        }
        loadValues();
    });

    $('#barcode').on('click', function () {
        let valUPC = $.trim($('#upc').val());
        upcCodeGenerate(valUPC);
    });

    $('#sku').on('blur', function () {
        if ($(this).val() === null || $.trim($(this).val()) === '' || !isNew) {
            return false;
        }

        url = checkSKU.replace(':sku', $(this).val());
        $.get(url)
            .done(function (data) {
                if (data > 0) {
                    showToast('This SKU has already been registered<br>Please check and try again!', 'warning');
                    $('#sku').focus();
                }
            })
    });

    $('#weight, #height, #width, #depth, #dimension_unit, #weight_unit, #ship_via, #package_type').on('blur change', function () {
        getInputData(); // Captura los datos de los inputs
        processShippingData(); // Procesa los datos si son válidos
    });

    $('#btnLoad').on('click', async function () {
        // URL de la imagen que deseas convertir a Base64
        const imageUrl = 'https://storage1.fintruck.cl/muebles/barcodes/131157226200.png';

        // Llamar a la función para obtener la imagen en Base64
        const base64Image = await getImageBase64(imageUrl);

        if (base64Image) {
            // Mostrar o usar la imagen en Base64
            // console.log(base64Image);

            // Ejemplo: Colocar la imagen en un elemento <img> si lo deseas
            $('#imagePreview').attr('src', base64Image);
        } else {
            console.error('Error al cargar la imagen.');
        }
    });

    $('.btnAddOpt').on('click', function () {
        typeSelect = $(this).data('type');
        let url = (typeSelect == 'pal') ? getFormPallets : getFormStandard;
        $.get(url)
            .done(function (data) {
                $('#frmContent').html(data);
                if (typeSelect == 'pal') new Switchery($('#status')[0], $('#status').data());
                $('#modalAddItem').modal('show');
            });
    });

    $('#frmAddOption').on('submit', async function (e) {
        e.preventDefault();
        
        let form = $(this);

        // Comprobar la validez del formulario
        if (!form[0].checkValidity()) return false;

        let url = await getProductUrl();

        // Crear objeto FormData con el formulario
        var formData = new FormData(form[0]);
        if (typeSelect == 'ps') {
            formData.append('color', 'primary');
        } else if (typeSelect == 'pc') {
            formData.append('attribute_id', 1);
        } else if (typeSelect == 'pv') {
            let id = $('#attrName').val();
            if (id == null || id == '' || id.length == 0 || id == undefined) {
                showToast('Select at least one attribute, warning');
                return false;
            }
            formData.append('attribute_id', id);
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
                loadSelects();
                $('#modalAddItem').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                showToast('Error saving product', 'error');
            },
            complete: function () {
                setTimeout(() => {
                    loadingSwal(false);
                }, 300);
            }

        });
    });

    $('#cerrarAddItem').on('click', function () {
        $('#modalAddItem').modal('hide');
    });

    $('#modalAddItem').on('hidden.bs.modal', function () {
        $('#frmAddOption')[0].reset();
        $('#frmAddOption').removeClass('was-validated');
        clearSelects();
    });

    $('#pallet').on('change', function () {
        calculoParcial();
    });
    
    $('.cat').on('click', function(){
        $valor = $(this).data('type');
        let url = frmSub;
        if($valor == 'ppal'){
            url = frmCategory;
        }

        $.get(url).then(async function(data) {
            $('#categorias').html(data);

            // Inicializamos los componentes después de cargar el formulario
            $('.category').select2({
                theme: "bootstrap-5",
                width: "100%",
                dropdownParent: $('#modalCategory'),
                placeholder: "Select...",
            });

            //obtenemos las categorias padres
            await fetchParentCategories();
            
            // Restablecemos los select2 para que no tengan ningún valor por defecto
            $('#parent_category').val(null).trigger('change');

            $('#modalCategory').modal('show');

        });
    });

    $('#modalPriceList').on('hidden.bs.modal',function(){
        $('#pl_type1').prop('checked', false);
        $('#pl_type2').prop('checked', false);
        $('#pl_pdf').prop('checked', true);
        $('#pl_xls').prop('checked', false);
        $('#divTableCustomer').addClass('d-none');
        $tableCustomers.bootstrapTable('uncheckAll');
    });

    $('#processPL').on('click',function(){

        if (customerSelectType !=1 && customerSelectType !=2) {
            showToast('You must select at least one option', 'warning');
            return;
        }

        let param = '';
        if(customerSelectType==2){
            let tableData = $tableCustomers.bootstrapTable('getSelections');

            if (tableData.length < 1) {
                showToast('You must select at least one customer', 'warning');
                return;
            }
            let selectData = tableData.map(item => item.id);
            param += '?ids[]=' + selectData.join('&ids[]=');
        }
        if(xlsPdfType != 'pdf'){
            if(param == ''){
                param += '?';
            }else{
                param += '$';
            }
            param += 'xls=true';
        }
        $('#modalPriceList').modal('hide');
        loadingSwal(true);
        window.location = priceList + param;
        setTimeout(() => {
            loadingSwal(false);
        }, 2000);
    });

    /* Inicio */
    $('#btnExcel').on('click', function(){
        $('#modalExcelCB').modal('show');
        //$('#modalExcel').modal('show');
    });

    $('#excel').fileinput({
        theme: 'fas',
        language: 'en',
        uploadUrl: excelImport,
        //uploadAsync: true,
        uploadExtraData:{'_token':TOKEN},
        allowedFileExtensions: ['xlsx'],
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
        previewFileIconSettings: { // configure your icon file extensions
            'xls': '<i class="fas fa-file-excel text-success"></i>'
        },
        previewFileExtSettings: { // configure the logic for determining icon file extensions
            'xls': function(ext) {
                return ext.match(/(xls|xlsx)$/i);
            }
        }
    }).on('fileuploaded', function(event, response, index, fileId) {
        //console.log(response.response.data);
        cargaData(response.response.data);
    });

    $('#excelCB').fileinput({
        theme: 'fas',
        language: 'en',
        allowedFileExtensions: ['xlsx'],
        preferIconicPreview: true, 
        showUpload: false,
        previewFileIconSettings: { 
            'xls': '<i class="fas fa-file-excel text-success"></i>'
        },
        previewFileExtSettings: {
            'xls': function(ext) {
                return ext.match(/(xls|xlsx)$/i);
            }
        }
    });

    $('#modalExcel').on('hide.bs.modal',function() {
        $('#frmExcel')[0].reset();
    });

    $('#modalCarga').on('show.bs.modal',function() {
        setTimeout(() => {
            $tableCarga.bootstrapTable('resetView');
        }, 1000);
    });

    // Validar sku y colorear celdas inválidas
    $('#validar').on('click', async function() {
        $tableCarga.bootstrapTable('resetSearch');
        $('#mensajes').html('');
        $('#mensajes').addClass('d-none');
        $('#validar').prop('disabled', true);
        $('#cierra').prop('disabled', true);
        $('#proc').addClass('fa-spin');
        let bar = $('#pb');
        bar.removeClass('d-none');
        setTimeout(async () => {
            const $data = $tableCarga.bootstrapTable('getData');
            const skuIndex = $tableCarga.find('th[data-field="sku"]').index();
            const seenSKUs = [];
            let validado = true;
            let maximo = $data.length;
            
            let paso = parseInt(bar.attr('aria-valuenow'));

            for (let v of $data) {
                const $row = $tableCarga.find(`tr[data-uniqueid="${v.id}"]`);
                const $cell1 = $row.find('td').eq(skuIndex);
                
                
                if(!v.sku){
                    await alerta(v.id , ` SKU required`,'danger');
                    validado = false;
                }else{
                   if (seenSKUs.includes(v.sku)) {
                    await alerta(v.id , ` Repeated SKU ${v.sku}`,'warning')
                        validado = false;
                    } else{
                        seenSKUs.push(v.sku)
                    } 
                }
                
                if(!v.product_type_id){
                    await alerta(v.id , ` Product type ID required`,'danger');
                    validado = false;
                }

                if(!v.brand_id){
                    await alerta(v.id , ` Brand ID required`,'danger');
                    validado = false;
                }
                
                if(!v.name){
                    await alerta(v.id , ` Name Product is required`,'danger');
                    validado = false;
                }
                
                if(!v.origin_id){
                    await alerta(v.id , ` Origin ID is required`,'danger');
                    validado = false;
                }
                
                if(!v.status_id){
                    await alerta(v.id , ` Status ID is required`,'danger');
                    validado = false;
                }

                paso++;

                val = parseInt(paso * 100 / maximo);
                bar.css('width', val + '%');
                bar.prop('aria-valuenow', paso);
            }

            if(validado){
                //enviar data a procesar
                let tabla = $tableCarga.bootstrapTable('getData');
                asyncAjax(excelProcesss, 'POST', { tabla: tabla, _token:TOKEN })
                .then(response => {
                    showToast(response.msg,response.success);
                    if(response.success == 'error'){
                        console.error(response.error);
                    }else{
                        setTimeout(() => {
                            $tableCarga.bootstrapTable('removeAll');
                            $('#modalCarga').modal('hide');
                            $table.bootstrapTable('refresh');
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                });
            }

            $('#validar').prop('disabled', false);
            $('#cierra').prop('disabled', false);
            $('#proc').removeClass('fa-spin');
            bar.addClass('d-none')
            bar.css('width', '0%');
            bar.prop('aria-valuenow', 0);
        }, 1000);
    });

    // Detectar cambios en el contenido de las celdas
    $('#tableCarga tbody').on('blur', 'td[contenteditable]', function() {
        const $cell = $(this);
        const newValue = $cell.text();
        const $row = $cell.closest('tr');
        const rowId = $row.data('uniqueid');
        const cellIndex = $cell.index();
        const columnField = $tableCarga.find('th').eq(cellIndex).data('field');

        // Actualizar la celda específica
        $tableCarga.bootstrapTable('updateCellByUniqueId', {
            id: rowId,
            field: columnField,
            value: newValue
        });

        // Mantener las celdas editables después de la actualización
        // makeCellsEditable();
    });

    $('#frmDescription').on('submit',function(e) {
        e.preventDefault();
        let idD = $('#idDesc').val();
        $tableCarga.bootstrapTable('updateCellByUniqueId', {
            id: idD,
            field: 'description',
            value: $('#editDescription').val()
        });
        $('#D-'+idD).data('bs.content', $('#editDescription').val());
        $('#D-'+idD).popover('show'); // Para forzar la actualización
        $('#frmDescription')[0].reset();
        $('#frmDescription').removeClass('was-validated');
        $('#modalDescription').modal('hide');
    })

    $('#frmExcelCB').on('submit',function(e) {
        e.preventDefault();
        let form = $(this);

        // Crear objeto FormData con el formulario
        var formData = new FormData(form[0]);

        // Realizar la solicitud AJAX
        $.ajax({
            url: casabiancaExcel,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (data) {
                loadingSwal(true);
            },
            success: function (data) {
                showToast(data.msg, data.success);
                if (data.success === 'success') {
                    $('#excelCB').fileinput('clear');
                    $('#modalExcelCB').modal('hide');
                    $table.bootstrapTable('refresh');
                }
            },
            error: function (error) {
                console.error('Error:', error);
                showToast('Error saving data', 'error');
            },
            complete: function () {
                setTimeout(() => {
                    loadingSwal(false);
                }, 300);
            }

        });
    });
    /*FIN*/

    //Filtrado --------------------------
    $('#logic-select').on('change',function(){
        let valor = $(this).val();
        $('#filterLogic').val(valor)
    });

    $('#operator-select').change(function() {
        const operator = $(this).val();
        const $valueContainer = $('#value-container');
        
        if (operator === 'empty' || operator === '!empty') {
            $valueContainer.html('<input type="text" class="form-control" id="filter-value" disabled placeholder="It does not apply">');
        } else {
            $valueContainer.html('<input type="text" class="form-control" id="filter-value" placeholder="Value">');
        }
    });

    $('#add-filter').click(function() {
        const column = $('#column-select').val();
        const operator = $('#operator-select').val();
        let value = $('#filter-value').val().trim();
        
        if (!column) {
            showToast('Please select a column, error');
            return;
        }
        
        if ((operator !== 'isEmpty' && operator !== 'isNotEmpty') && !value) {
            showToast('Please enter a value to filter','error');
            return;
        }
        
        const filterId = 'filter-' + Date.now();
        const columnTitle = $(`#column-select option[value="${column}"]`).text();
        const operatorText = $(`#operator-select option[value="${operator}"]`).text();
        let idx = moment().unix();
        const $filterItem = $(`
            <div class="filter-item" id="${filterId}">
                <span class="remove-filter" data-filter="${filterId}">×</span>
                <div class="row">
                    <div class="col-md-4">
                        <strong>${columnTitle}</strong>
                    </div>
                    <div class="col-md-3">
                        ${operatorText}
                    </div>
                    <div class="col-md-5">
                        <span class="filter-value-display" title="${value || 'N/A'}">
                            ${operator === 'isEmpty' || operator === 'isNotEmpty' ? 'N/A' : value}
                        </span>
                    </div>
                </div>
                <input type="hidden" name="filterColumn[${idx}]" value="${column}">
                <input type="hidden" name="filterOperator[${idx}]" value="${operator}">
                <input type="hidden" name="filterValue[${idx}]" value="${value}">
            </div>
        `);
        
        $('#filters-container').append($filterItem);
        $('#filter-value').val('');
        
        $table.bootstrapTable('refresh');
        $('#column-select').val(null).trigger('change');
        $('#operator-select').val(null).trigger('change');
    });

    $('#clear-filters').on('click',function(){
        $('#filters-container').empty();
        $('#column-select').val(null).trigger('change');
        $('#operator-select').val(null).trigger('change');
        $('#show_types').prop('checked', false);
        $('#hide_status').prop('checked', false);
        $('#filters-container').append(`<input type="hidden" name="filterLogic" id="filterLogic" value="and">`);
        $table.bootstrapTable('refresh');
    });

    $('#hide_status').on('click', function () {
        let isChecked = $(this).is(':checked');
        if (isChecked) {
            let contenido1 = `
                <div class="filter-item d-none" id="filter-1750358767828">
                    <input type="hidden" name="filterColumn[1750358767]" value="status">
                    <input type="hidden" name="filterOperator[1750358767]" value="NOT IN">
                    <input type="hidden" name="filterValue[1750358767]" value="archived,hide">
                </div>
            `;
            $('#filters-container').append(contenido1);
        } else {
            $('#filter-1750358767828').remove();
        }
         $table.bootstrapTable('refresh');
    });
    
    $('#show_types').on('click', function () {
        let isChecked = $(this).is(':checked');
        if (isChecked) {
            let contenido2 = `
                <div class="filter-item d-none" id="filter-1750358690736">
                    <input type="hidden" name="filterColumn[1750358690]" value="product_type">
                    <input type="hidden" name="filterOperator[1750358690]" value="IN">
                    <input type="hidden" name="filterValue[1750358690]" value="standard,parent">
                </div>
            `;
            $('#filters-container').append(contenido2);
        } else {
            $('#filter-1750358690736').remove();
        }
         $table.bootstrapTable('refresh');
    });
    //Fin Filtrado-----------------------

    //shipping detail
    $('#addShippingDetails').on('click', function () {
        $('#shippingDetailsButtons').hide('low');
        $('#shippingDetailsCard').show('low');
    });

    $('#cancelShippingDetail').on('click', async function () {
        let confirm = await confirmQuestion('Are you sure you want to close the shipping detail?');
        if (confirm) {
            $('#shippingDetailsButtons').show('low');
            $('#shippingDetailsCard').hide('low');
        }
        
    });

    $('#addShippingDetail').on('click', function () {
        let contentBoxID = $('#contentBoxD').val();
        let contentBoxText = $('#contentBoxD option:selected').text();
        let shipViaDetailID = $('#shipViaDetail').val();
        let shipViaDetailText = $('#shipViaDetail option:selected').text();
        let packingDetailID = $('#packingDetail').val();
        let packingDetailText = $('#packingDetail option:selected').text();
        let shipDlength = $('#shipDlength').val();
        let shipDwidth = $('#shipDwidth').val();
        let shipDheight = $('#shipDheight').val();
        let shipDlbs = $('#shipDlbs').val();
        let shipDcbm = $('#shipDcbm').val();

        if (!contentBoxID || !shipViaDetailID || !packingDetailID || !shipDlength || !shipDwidth || !shipDheight || !shipDlbs || !shipDcbm) {
            showToast('Please fill all fields', 'warning');
            return false;
        }

        // Verificar si ya está el contenido en la tabla
        let prevData = $tableShipping.bootstrapTable('getData');
        let result = prevData.find(item => item.box_content_text == contentBoxText);
        if (result) {
            showToast('This content is already listed, please check', 'error');
            return false;
        }

        let idSD = $tableShipping.bootstrapTable('getData').length + 1;

        // Agregar nueva fila a la tabla
        let data = {
            'id':idSD,
            'content': idSD,
            'large': shipDlength,
            'width': shipDwidth,
            'height': shipDheight,
            'lbs': shipDlbs,
            'shipvia': shipViaDetailText,
            'shipviaID': shipViaDetailID,
            'packing': packingDetailText,
            'packingID': packingDetailID,
            'cbm': shipDcbm,
            'box_content_text': contentBoxText,
            'box_content_id': contentBoxID,
        };

        $tableShipping.bootstrapTable('append', data);

        // Limpiar los campos del formulario
        clearShippingData();
    });

    $('#shipDlength, #shipDwidth, #shipDheight').on('blur', function () {
        let length = parseFloat($('#shipDlength').val());
        let width = parseFloat($('#shipDwidth').val());
        let height = parseFloat($('#shipDheight').val());

        if (length && width && height) {
            let cbm = calculateCBM(length,width,height,'in'); // Convertir a metros cúbicos
            $('#shipDcbm').val(cbm);
        } else {
            $('#shipDcbm').val('');
        }
    });

    //dropsync
    $('#dropbox').on('click', async function () {
        //showToast('Processing... please wait', 'info');
        Swal.fire({
            title: 'Processing...',
            html: 'Please wait while the command is executed.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let comando = await asyncAjax(dropboxSync, 'GET', { _token: TOKEN });

        //showToast(comando.msg, comando.success);
        $table.bootstrapTable('refresh');

        Swal.fire({
            title: comando.msg,
            html: `
                <label for="salidaComando" style="display:block; text-align:left; margin-bottom:0.5em;">
                Commnad Output:
                </label>
                <textarea id="salidaComando" readonly rows="10" style="width:100%; font-family:monospace; font-size:13px; white-space:pre;">${comando.salida}</textarea>
            `,
            icon: comando.success,
            width: '50em',
            confirmButtonText: 'Close'
        });

        
    });
    //-------

    //Trash----------------------------------------
    $('#trash').on('click', function () {
        $('#modalTrash').modal('show');
        $tableTrash.bootstrapTable('refresh');
    });

    $('#restore').on('click', async function () {
        let selectedRows = $tableTrash.bootstrapTable('getSelections');
        if (selectedRows.length === 0) {
            showToast('You must select at least one item', 'warning');
            return;
        }

        let ids = selectedRows.map(row => row.id);
        let res = await confirmQuestion('Are you sure to restore the selected items?');
        if (res) {

            $.ajax({
                url: productRestore, // "/products-restore"
                type: 'POST',
                data: {
                    _token: TOKEN,
                    ids: ids
                },
                beforeSend: function () {
                    loadingSwal(true);
                },
                success: function (data) {
                    showToast(data.msg, data.success);
                    if (data.success === 'success') {
                        $tableTrash.bootstrapTable('remove', { field: 'id', values: ids });
                        $table.bootstrapTable('refresh');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    showToast('Error restoring items', 'error');
                },
                complete: function () {
                    setTimeout(() => {
                        loadingSwal(false);
                    }, 500);
                }
            });
        }
    });

    $('#destroy').on('click', async function () {
        let selectedRows = $tableTrash.bootstrapTable('getSelections');
        if (selectedRows.length === 0) {
            showToast('You must select at least one item', 'warning');
            return;
        }

        let ids = selectedRows.map(row => row.id);
        let res = await confirmQuestion('Are you sure you want to permanently delete the selected items? <br> This action cannot be undone.');

        if (res) {
            $.ajax({
                url: productDelete, // ej: "/products-delete"
                type: 'POST', // o 'DELETE' si tu backend lo permite
                data: {
                    _token: TOKEN,
                    ids: ids
                },
                beforeSend: function () {
                    loadingSwal(true);
                },
                success: function (data) {
                    showToast(data.msg, data.success);
                    if (data.success === 'success') {
                        $tableTrash.bootstrapTable('remove', { field: 'id', values: ids });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    showToast('Error deleting items', 'error');
                },
                complete: function () {
                    setTimeout(() => {
                        loadingSwal(false);
                    }, 500);
                }
            });
        }
    });
    //----------------------------------------------

    $('#product_type').on('change', function () {
        let selectedType = $(this).val();
        if (selectedType == 2) {
            $('#generateChild').show();
            $('#associationsTab').show();
        } else {
            $('#generateChild, #associationsTab').hide();
        }
    });

    $("#generateChild").on('click', function () {
        let id = $('#id').val();

        let $row = $table.bootstrapTable('getRowByUniqueId',id);

        let dataTableShipping = $tableShipping.bootstrapTable('getData');

        if (dataTableShipping.length < 2) {
            showToast('You must add at least two shipping detail', 'warning');
            return false;
        }else{
            let totalChild = $('#countChild').val();
            if (dataTableShipping.length == totalChild) {
                showToast('All children have already been created', 'warning');
                return false;
            }else if(dataTableShipping.length < totalChild){
                showToast("Shipping info doesn't match children count. Please check.",'warning');
                return false;
            }
        }

        if (!id || id === '') {
            guardar();
            return false;
        }

        let datos ={
            "shipping_details": dataTableShipping
        };

        let uri = generateChild.replace(':id', id);

        sendRequest(uri, 'post', datos, function (data) {
            if (data) {
                showToast(data.msg,data.success);
                if(data.success == 'success'){
                    $table.bootstrapTable('refresh');
                    $table.bootstrapTable('resetSearch', $row.sku);
                    setTimeout(() => {
                        $table.bootstrapTable('checkBy', { field: 'id', values: [id] });
                        editar();
                    }, 1000);
                    $('#id').val(id);
                }
            }
        });
    });

    loadAllData();
    $('#shippingDetailsCard').hide();
});

function galeria(){
    $('.image-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function (item) {
                return item.el.attr('title'); // Muestra el título si lo tiene
            }
        },
        zoom: {
            enabled: true,
            duration: 300,
            opener: function (element) {
                return element.find('img');
            }
        }
    });
}

function clearShippingData() {
    $('#contentBoxD').val(null).trigger('change');
    $('#shipViaDetail').val(null).trigger('change');
    $('#packingDetail').val(null).trigger('change');
    $('#shipDlength, #shipDwidth, #shipDheight, #shipDlbs, #shipDcbm').val(null);
}

async function eliminarItemShip(id){
    let confirm = await confirmQuestion('Are you sure to delete this item?');
    if (confirm) {
        $tableShipping.bootstrapTable('removeByUniqueId', id);
        id = id - 1;
        pool2.push(id);
        if (pool2.length > 2) {
            pool2.sort((a, b) => a - b); // Orden ascendente
        }
    }
}

function cargaData(data){
    $tableCarga.bootstrapTable('load', data);
    $('#modalExcel').modal('hide');
    $('#modalCarga').modal('show');
}

// function images_cache() {
    
//     $.ajax({
//         url: cacheImages,
//         type: 'POST',
//         data: { _token: TOKEN },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         timeout: 600000, // 10 minutos (en milisegundos)
//         beforeSend: function() {
//             $('.icono').addClass('d-none');
//             $('.pausa').removeClass('d-none');
//             $('#image_cache').addClass('disabled');
//             showToast('Image cache request was sent','info');
//         },
//         success: function(response) {
//             $('.pausa').addClass('d-none');
//             $('.icono').removeClass('d-none');
//             $('#stock_list').removeClass('disabled');
//             $('#price_list').removeClass('disabled');
//             $('#image_cache').removeClass('disabled');
//             showToast('Image cache request done','success');
//         },
//         error: function(xhr, status, error) {
//             console.error("Error en la petición:", error);
//         }
//     });
// }

// function upload_thumbs() {
//     $.ajax({
//         url: uploadThumbs,
//         type: 'POST',
//         data: { _token: TOKEN },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         timeout: 600000, // 10 minutos (en milisegundos)
//         beforeSend: function() {
//             $('.icono').addClass('d-none');
//             $('.pausa').removeClass('d-none');
//             $('#clear_cache').addClass('disabled');
//             $('#image_cache').addClass('disabled');
//             showToast('Clear cache request was sent','info');
//         },
//         success: function(response) {
//             $('.pausa').addClass('d-none');
//             $('.icono').removeClass('d-none');
//             $('#clear_cache').removeClass('disabled');
//             $('#price_list').addClass('disabled');
//             $('#image_cache').addClass('disabled');
//             showToast('Clear cache request done','success');
//         },
//         error: function(xhr, status, error) {
//             console.error("Error en la petición:", error);
//         }
//     }); 
// }

// function clear_cache() {
//     $.ajax({
//         url: clearCache,
//         type: 'POST',
//         data: { _token: TOKEN },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         timeout: 600000, // 10 minutos (en milisegundos)
//         beforeSend: function() {
//             $('.icono').addClass('d-none');
//             $('.pausa').removeClass('d-none');
//             $('#clear_cache').addClass('disabled');
//             $('#image_cache').addClass('disabled');
//             showToast('Clear cache request was sent','info');
//         },
//         success: function(response) {
//             $('.pausa').addClass('d-none');
//             $('.icono').removeClass('d-none');
//             $('#clear_cache').removeClass('disabled');
//             $('#price_list').addClass('disabled');
//             $('#image_cache').addClass('disabled');
//             showToast('Clear cache request done','success');
//         },
//         error: function(xhr, status, error) {
//             console.error("Error en la petición:", error);
//         }
//     }); 
// }

//Guardar data del producto
async function guardar() {
    var dataCategory = $('#jstree').jstree().get_selected(true);

    // Validar si al menos una categoría ha sido seleccionada
    if (dataCategory.length == 0) {
        showToast('You must select at least one category', 'error');
        return false;
    }

    let form = $('#formProducts');
    form.addClass('was-validated');  // Añadir clase de validación a Bootstrap

    // Comprobar la validez del formulario
    if (form[0].checkValidity()) {

        // Crear objeto FormData con el formulario
        var formData = new FormData(form[0]);

        // Agregar archivos de imágenes--------------

        //adicionales 
        for (let i = 0; i < selectedFiles.length; i++) {
            formData.append('images[]', selectedFiles[i]);  // 'images[]' es el nombre del campo
        }

        //UPC Barcode
        let barcodeSrc = $('#codigobarra').prop('src');
        if (barcodeSrc && barcodeSrc.startsWith('data:image/')) {
            formData.append('barcode', barcodeSrc);
        }
        //-------------------------------------------

        formData.append('categories', dataCategory[0].id); // Solo se toma el primer id de categoría
        //-----------------------------------------------------------

        //Agregar contenido de las tablas Attributes & ExtraInfo & Bundles-----
        let dataTableMC = $tableMC.bootstrapTable('getData');
        if (dataTableMC.length > 0) {
            formData.append('dataTableMC', JSON.stringify(dataTableMC));
        }

        //Atributos------
        let atributos = await getAtributos(false);
        formData.append('attributes', atributos);

        let dataTableChld = $tableChld.bootstrapTable('getData');
        if (dataTableChld.length > 0) {
            formData.append('dataTableChld', JSON.stringify(dataTableChld));
        }

        let dataTableBnd = $tableBnd.bootstrapTable('getData');
        if (dataTableBnd.length > 0) {
            formData.append('dataTableBnd', JSON.stringify(dataTableBnd));
        }
        
        let dataTableTPSKU = $tableTPSKU.bootstrapTable('getData');
        if (dataTableTPSKU.length > 0) {
            formData.append('dataTableTPSKU', JSON.stringify(dataTableTPSKU));
        }

        //Shipping Data-------------------------------------------------------
        let countTableShipping = $tableShipping.bootstrapTable('getData');
        let generalShippingData='';
        if (countTableShipping.length > 0) {

            generalShippingData = {
                'contentBox': dataContentBox,
                'shipping_table': countTableShipping,
                'casepack': 1,
                'totalBoxes':countTableShipping.length,
                'gralShipVia': $('#gralShipVia').val(),
                'pallet': $('#pallet').val(),
                'fclass': parseInt($('#fclass').html()),
                'density': parseFloat($('#density').html()),
                'cbm': parseFloat($('#cbm').html()),
                'pWidth': parseFloat($('#pWidth').html()),
                'pLenght': parseFloat($('#pLenght').html()),
                'pHeight': parseFloat($('#pHeight').html()),
                'pLbs': parseFloat($('#pLbs').html()),
                'cbf': parseFloat($('#cbf').html()),
                'pol': parseFloat($('#pol').html()),
                'requirements': $('#req').html(),
            }
            
        }
        formData.append('generalShippingData', JSON.stringify(generalShippingData));
        //-----------------------------------------------------------

        // Obtener el ID del producto
        let prodID = $('#id').val();
        let url = productSave;

        if ($.trim(prodID) != '') {
            url = productUpdate.replace(':id', prodID);  // skua para el update
            formData.append('_method', 'patch');
            let deleteArray = {
                'delImgs': deletedImageIds,
                'delAttrs': deletedAttrIds,
                'delChlds': deletedChildIds,
                'delBnds': deletedBundleIds,
                'delPMC': deletedPMCs,
                'delTPSKU': deletedTPSKUs
            };
            formData.append('delArray', JSON.stringify(deleteArray));
        }

        // Realizar la solicitud AJAX
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
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
                $table.bootstrapTable('refresh');
                if (closeWindow) {
                    $('#offcanvasRight').offcanvas('hide');
                    verificaEdit();
                } else if (data.success == 'success') {
                    clearFrmProducts();
                    $table.bootstrapTable('resetSearch', data.product.sku);
                    setTimeout(() => {
                        $table.bootstrapTable('checkBy', { field: 'id', values: [data.product.id] });
                        editar();
                    }, 1000);
                    $('#id').val(data.product.id);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                showToast('Error saving product', 'error');
            },
            complete: function () {
                setTimeout(() => {
                    loadingSwal(false);
                }, 300);
            }

        });

    } else {
        for (var i = 0; i < form[0].elements.length; i++) {
            var ele = form[0].elements[i];

            // Verifica si el elemento no es válido
            if (!ele.validity.valid) {
                // Obtiene el ID del elemento inválido
                var fieldId = ele.id;
                // Obtiene el texto del label asociado
                var labelText = $(`label[for="${fieldId}"]`).text().trim();
                showToast(`You still have fields to validate<br>${labelText}`, 'warning');
                return;
            }
        }

    }
}

async function mostrar(id) {
 
        let url = productShow.replace(':id', id);
        $row = await getProductData(url);
        $price = 'N/A';
        //console.log($row);
        $('#p_name_detail').val($row.brand.name);
        $('#pd_name').html(`${$row.name} (${$row.sku})`);
        $('#pd_categoria').html($row.categories.name);
        if($row.price){
            $price = `$ ${$row.price}`;
        }
        $('#pd_type').html($row.type.name);
        $('#pd_price').html($price);
        $('#pd_wholesale_price').html('$ ' + ($row.wholesale_price || 0));
        $('#pd_map_price').html('$ ' + ($row.map || 0));
        $('#pd_msrp_price').html('$ ' + ($row.msrp || 0));
        if($row.description){
            $('#description').html($row.description.replaceAll('\r\n', '<br>'));
        }

        let img = '';
        let olist = '';

        // $.each($row.images, function (k, v) {
        //     // comprobar si el archivo es pdf
        //     if (v.image_url.toLowerCase().endsWith('.pdf')) {
        //         return true; // en jQuery.each, return true = continue
        //     }

        //     let imgActivo = (k == 0) ? 'active' : '';
        //     let olActivo = (k == 0) ? 'class="active"' : '';
            
        //     img += `
        //         <div class="carousel-item ${imgActivo}">
        //             <img src="${v.image_url}" alt="product-img-${k}" class="d-block w-100">
        //         </div>
        //     `;
            
        //     olist += `
        //         <button type="button" data-bs-target="#product-carousel" data-bs-slide-to="${k}" ${olActivo} aria-label="Slide ${k+1}"></button>
        //     `;
        // });

        $.each($row.images, function (k, v) {
            let imgActivo = (k == 0) ? 'active' : '';
            let olActivo = (k == 0) ? 'class="active"' : '';

            if (v.image_url.toLowerCase().endsWith('.pdf')) {
                // Carousel item para PDF
                img += `
                    <div class="carousel-item ${imgActivo}">
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="${v.image_url}" target="_blank" >
                                <img src="assets/images/pdf.jpg" alt="product-img-${k}" height="300px">
                            </a>
                        </div>
                    </div>
                `;
            } else {
                // Carousel item para imagen
                img += `
                    <div class="carousel-item ${imgActivo}">
                        <img src="${v.image_url}" alt="product-img-${k}" class="d-block w-100">
                    </div>
                `;
            }

            // Indicadores del carousel
            olist += `
                <button type="button" data-bs-target="#product-carousel" data-bs-slide-to="${k}" ${olActivo} aria-label="Slide ${k+1}"></button>
            `;
        });



        $('#carousel').html(img);
        $('#imgOL').html(olist);
        $('#p_name_detail').html($row.brand.name);

        if ($row.ship_via) {
            $('#ship_via_d').val($row.ship_via.name);
        }

        if ($row.package) {
            $('#package_type_d').val($row.package.name);
        }

        $('#upc_d').val($row.upc);

        if ($row.upc != null) {
            let valUPC = $.trim($row.upc);
            JsBarcode("#codigobarraD", valUPC, { format: "UPC" });
        }

        $('#textNotesD').val($row.notes);

        $('#casepack_d').val($row.casepack);

        const mappedAttributes = $row.attributes.map(item => ({
            attr_id: item.attribute_id,
            name: item.attribute.name,
            value_id: item.attribute_values_id,
            value: item.values.name
        }));

        $tableAttrD.bootstrapTable('load', mappedAttributes);
        setTimeout(() => {
            $tableAttrD.bootstrapTable('resetView');
        }, 1500);
        

        const mappedPMCD = $row.pmc.map(item => ({
            id: item.id,
            parts: item.part.name,
            parts_id: item.part_id,
            material: item.material.name,
            material_id: item.material_id,
            color_id: item.color_id,
            color: item.color.name,
        }));
        $tableMCD.bootstrapTable('load', mappedPMCD);

        const mappedCHLD = $row.childs.map(item => ({
            id: item.id,
            sku: item.sku,
            name: item.name,
        }));
        $tableChldD.bootstrapTable('load', mappedCHLD);

        let nextId = $tableShippingD.bootstrapTable('getData').length;

        let dataShipping = [];
        if($row.product_shipping_detail){
            $.each($row.product_shipping_detail.shipping_detail, function (k, v) {
                dataShipping.push({
                    "id": v.id,
                    "idFormatter": v.id,
                    "content": v.id,
                    "contenido": v.box_content_text,
                    "box_content_id": v.box_content_id,
                    "large": v.depth,
                    "width": v.width,
                    "height": v.height,
                    "lbs": v.lbs,
                    "shipvia": v.shipvia,
                    "packing": v.packing,
                    "cbm": v.cbm,
                });
            });

            $tableShippingD.bootstrapTable('load', dataShipping);

            $('#gralShipViaD').html($row.product_shipping_detail.ship_via.name);
            $('#palletD').html($row.product_shipping_detail.pallet.name);
            
            $('#pWidthD').html($row.product_shipping_detail.pallet.pallet_w);
            $('#pLenghtD').html($row.product_shipping_detail.pallet.pallet_l);
            $('#pHeightD').html($row.product_shipping_detail.pallet.pallet_h);
            
            var valueLbs = $('#tableShippingD tfoot tr th:nth-child(6) .th-inner').text();
            let totLbsf = parseFloat(valueLbs) + parseFloat($row.product_shipping_detail.pallet.pallet_lbs);

            $('#pLbsD').html(totLbsf);
            $('#polD').html($row.product_shipping_detail.pallet.pallet_lbs);
            $('#fclassD').html($row.product_shipping_detail.freight_class);
            $('#densityD').html($row.product_shipping_detail.density);
            $('#cbmD').html($row.product_shipping_detail.cbm);
            $('#cbfD').html($row.product_shipping_detail.cbf);
            $('#reqD').html($row.product_shipping_detail.requirements);

        }

        $('#offcanvasDetail').offcanvas('show');

}

async function duplica() {
    try {
        let $row = $table.bootstrapTable('getSelections');

        if ($row.length > 1) {
            showToast('Select only one product', 'warning');
            return;
        } else if ($row.length < 1) {
            showToast('You must select a product', 'warning');
            return;
        }

        $row = $row[0];
        let url = productDuplicate.replace(':id', $row.id);

        $.ajax({
            url: url,
            type: 'GET',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': TOKEN,
            },
            beforeSend: function () {
                loadingSwal(true);
            },
            success: function (data) {
                showToast(data.msg, data.success);
                $table.bootstrapTable('refresh');

                if (data.success) {
                    clearFrmProducts();
                    $table.bootstrapTable('resetSearch', data.product.sku);


                    // Escuchar el evento de finalización de la carga de datos
                    $table.one('post-body.bs.table', function () {
                        $table.bootstrapTable('checkBy', { field: 'id', values: [data.product.id] });
                        editar();
                        $('#id').val(data.product.id);
                    });
                    $('#id').val(data.product.id);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                showToast('Error duplicating product', 'error');
            },
            complete: function () {
                setTimeout(() => {
                    loadingSwal(false);
                }, 300);
            }
        });

    } catch (error) {
        console.error(error);
        showToast('Error when querying the product', 'error');
    }
}

async function borrar(){
    let $row = $table.bootstrapTable('getSelections');

    if ($row.length > 1) {
        showToast('Select only one product', 'warning');
        return;
    } else if ($row.length < 1) {
        showToast('You must select a product', 'warning');
        return;
    }

    let res = await confirmQuestion(`Are you sure you want to delete this product?<br>${ $row[0].sku } | ${ $row[0].name }`);

    if( res) {
        let url = productDestroy.replace(':id', $row[0].id);
        let res = await asyncAjax(url, 'delete', { _token: TOKEN })
        showToast(res.msg, res.success);
        if (res.success == 'success') {
            $table.bootstrapTable('remove', { field: 'id', values: [$row[0].id] });
            verificaEdit();
        }
    }
}

async function editar() {

    let $row = $table.bootstrapTable('getSelections');
    
    if ($row.length > 1) {
        showToast('Select only one product', 'warning');
        return;
    } else if ($row.length < 1) {
        showToast('You must select a product', 'warning');
        return;
    }

    data = $row[0];
    let url = productShow.replace(':id', data.id);
    $row = await getProductData(url);

    $('#countChild').val($row.childs.length || 0);

    $('#id').val($row.id);
    $('#product_type').val($row.product_type_id).trigger('change');
    $('#sku').val($row.sku);
    $('#name').val($row.name);
    $('#statusP').val($row.status_id).trigger('change');
    $('#origin').val($row.origin_id).trigger('change');
    $('#brand').val($row.brand_id).trigger('change');
    $('#collection').val($row.collection_name);
    $('#titleDescription').val($row.title);
    $('#textDescription').val($row.description);
    $('#textNotes').val($row.notes);
    $('#price').val(parseFloat($row.price));
    $('#wholesale_price').val(parseFloat($row.wholesale_price));
    $('#msrp').val(parseFloat($row.msrp));
    $('#map').val(parseFloat($row.map));
    $('#weight').val(parseFloat($row.weight));
    $('#weight_unit').val($row.weight_unit).trigger('change');
    $('#height').val(parseFloat($row.height));
    $('#width').val(parseFloat($row.width));
    $('#depth').val(parseFloat($row.depth));
    $('#dimension_unit').val($row.dimension_unit).trigger('change');
    $('#ship_via').val($row.ship_via_id).trigger('change');
    $('#package_type').val($row.package_type_id).trigger('change');
    $('#upc').val($row.upc);
    if ($row.upc != null) {
        let valUPC = $.trim($row.upc);
        upcCodeGenerate(valUPC);
    }
    if ($row.map_enforced) {
        $('#mapCtrl').trigger('click');
        $('#lblmapCtrl').text('Yes');
    }
    // Filtrar la imagen cover
    const coverImage = $row.images.find(image => image.is_cover);

    if (coverImage !== undefined && coverImage !== null) {
        //cargar el fileinput
        $("#cover").fileinput('destroy').fileinput({
            overwriteInitial: false,
            validateInitialCount: true,
            initialPreview: [
                coverImage.image_url // La URL de la imagen
            ],
            initialPreviewAsData: true, // Para mostrar la vista previa como imagen
            initialPreviewConfig: [
                {
                    url: urlDelImg,
                    width: "120px",
                    key: coverImage.id // ID de la imagen
                },
            ],
            initialPreviewFileType: 'image', // Tipo de archivo
            showCaption: false,
            dropZoneEnabled: false,
            showUpload: false
        }).on('filebeforedelete', async function (event, key, data) {
            var aborted = await confirmQuestion('Are you sure you want to delete this cover?');
            if (!aborted) {
                showToast('File deletion was aborted!', 'warning');
            } else {
                deletedImageIds.push(key);
            };
            return !aborted;
        });
    }

    // Filtrar las imágenes no cover
    const nonCoverImages = $row.images.filter(image => !image.is_cover);

    //cargar other Images
    nonCoverImages.forEach(image => {
        loadImage(image.image_url, false, null, image.id); // Cargar la imagen desde una URL con su ID
    });

    //--BT-------
    if ($row.attributes.length > 0) {
        setTimeout(() => {
            const attributesArray = $row.attributes;

            attributesArray.forEach(item => {
                const attributeId = item.attribute_id;
                const attributeValueId = item.attribute_values_id;
                const customValueJson = item.custom_value;

                // 1. Poner valor en input attributes[attributeId]
                let $el = $(`[name="attributes[${attributeId}]"]`);
                $el.val(attributeValueId);
                if ($el.is('select')) {
                    $el.trigger('change');
                }

                // 2. Si custom_value no es null, parsearlo e insertar en inputs extra[attributeId][valueId][key]
                if (customValueJson) {
                    try {
                        const customValues = JSON.parse(customValueJson);

                        Object.entries(customValues).forEach(([key, val]) => {
                            const extraSelector = `input[name="extra[${attributeId}][${attributeValueId}][${key}]"]`;
                            $(extraSelector).val(val);
                        });

                    } catch(e) {
                        console.error('Error parsing custom_value JSON:', e);
                    }
                }
            });
        }, 2000);
    }

    if ($row.bundle.length > 0) {
        let data = [];
        $.each($row.bundle, function (key, value) {
            data.push({
                'id': value.product_id,
                'sku': value.component_product.sku,
                'name': value.component_product.name,
                'qty': value.quantity,
            });
        });
        $tableBnd.bootstrapTable('append', data);
    }

    if ($row.childs.length > 0) {
        let data = [];
        $.each($row.childs, function (key, value) {
            data.push({
                'id': value.id,
                'sku': value.sku,
                'name': value.name,
            });
        });
        $tableChld.bootstrapTable('append', data);
    }
    
     //Pendiente Material & Colors
    if ($row.pmc.length > 0) {
        let data = [];
        $.each($row.pmc, function (key, value) {
            data.push({
                'id': value.product_id,
                'parts': value.part.name,
                'parts_id': value.part_id,
                'material': value.material.name,
                'material_id': value.material_id,
                'color': value.color.name,
                'color_id': value.color_id
            });
        });
        $tableMC.bootstrapTable('append', data);
    }

    //Categories
    if ($row.category_id) {
        $('#jstree').jstree("close_all");
        // Selecciona el nodo
        $('#jstree').jstree('check_node', $row.category_id);

        // Obtiene el nodo completo para saber quién es el padre
        var node = $('#jstree').jstree().get_node($row.category_id);
        if (node && node.parent) {
            $('#jstree').jstree('open_node', node.parent);
        }
    }
    
    //Customers SKU
    if($row.tp_s_k_u.length > 0){
        let data = [];
        $.each($row.tp_s_k_u,function(k,v){
            data.push({
                'id': v.id,
                'customer_id': v.customer.id,
                'customer': v.customer.company,
                'customer_sku': v.customer_sku,
            });
        });
        $tableTPSKU.bootstrapTable('load',data);
    }

    $('#casepack').val($row.casepack);
    if($row.product_shipping_detail){
        $('#pallet').val($row.product_shipping_detail.pallet_id).trigger('change');
        $('#gralShipVia').val($row.product_shipping_detail.ship_via_id).trigger('change');

        $tableShipping.bootstrapTable('load',$row.product_shipping_detail.shipping_detail)
        
    }


    isNew = false;
    let alerta = `  <div class="alert alert-warning d-flex alert-dismissible" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="20" height="20" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        In edit mode, unsaved changes will be lost when you close the window.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`

    $('#alertProduct').append(alerta);
    $('#offcanvasRight').offcanvas('show');
}

function getAtributos( resJson = false) {
    const datos = {};
    $('#attributes-container')
    .find('input, select, textarea')
    .each(function () {
        let key = $(this).attr('name') || $(this).attr('id');
        if (key) {
            datos[key] = $(this).val();
        }
    });
    if(resJson){
        return datos;
    }else{
        const jsonStr = JSON.stringify(datos);
        const base64 = btoa(
            String.fromCharCode(...new TextEncoder().encode(jsonStr))
        );
        return base64;
    }     
}

function getLabelsAndValues() {
    const resultados = [];

    $('#attributes-container .form-group').each(function () {
        const $grupo = $(this);
        const label = $grupo.find('label').first().text().trim();
        const $control = $grupo.find('input, select, textarea').first();

        let value;
        if ($control.is('select')) {
            value = $control.find('option:selected').text().trim();
        } else {
            value = $control.val();
        }

        // Filtrar valores vacíos
        if (value !== '') {
            resultados.push({
                label: label,
                value: value
            });
        }
    });

    return resultados;
}

//obtener datos del producto
function getProductData(url) {
    return new Promise((resolve, reject) => {
        loadingSwal(true);
        $.get(url)
            .done(resolve)
            .fail(reject)
            .always(() => {
                setTimeout(() => {
                    loadingSwal(false);
                }, 300);
            }
        );
    });
}

//mostrar modal para seleccion de clientes Price List
function show_price_list() {
    $('#modalPriceList').modal('show');
}

//descargar imagenes de los productos seleccionados
function downloadImg() {
    let tableData = $table.bootstrapTable('getSelections');

    if (tableData.length < 1) {
        showToast('You must select a product', 'warning');
        return;
    }

    let selectData = tableData.map(item => item.id);
    let param = '?ids[]=' + selectData.join('&ids[]=');
    window.location = imgDown + param;   
}

function calculoParcial() {
    let valor = $('#pallet').val();
    
    if (!valor) return;
    let url = productPallets + `&id=${valor}`;
    $.get(url)
        .done(function (data) {
            if (data.length > 0) data = data[0];

            // Obtiene el valor Lbs (quinta columna)        
            var valueLbs = $('#tableShipping tfoot tr th:nth-child(6) .th-inner').text();

            // Obtiene el valor CBM (octava columna)
            var valueCBM = $('#tableShipping tfoot tr th:nth-child(9) .th-inner').text();

            let totLbs = parseFloat(valueLbs) + parseFloat(data.pallet_lbs);

            // Aquí calculamos la clase de flete
            let freightClass = calculateFreightClass(totLbs, 'lb', data.pallet_l, data.pallet_w, data.pallet_h, 'in');
            $('#fclass').html(freightClass);
            $('#pWidth').html(data.pallet_w);
            $('#pLenght').html(data.pallet_l);
            $('#pHeight').html(data.pallet_h);
            $('#pLbs').html(totLbs);
            $('#pol').html(data.pallet_lbs);
            let $cbm = calculateCBM(data.pallet_l, data.pallet_w, data.pallet_h, 'in');
            $('#cbm').html($cbm);
            $('#cbf').html(convertCBMToCBF($cbm));
        })
        .fail(function (error) {
            console.error(error);
            showToast('Error querying palette', 'error');
        });
}

// Función para capturar los datos de los inputs y select2
function getInputData() {
    peso = $.trim($('#weight').val());
    alto = $.trim($('#height').val());
    ancho = $.trim($('#width').val());
    largo = $.trim($('#depth').val());

    let weightData = $('#weight_unit').select2('data');
    let dimensionData = $('#dimension_unit').select2('data');
    u_peso = weightData.length > 0 ? $.trim(weightData[0].text) : null;
    u_medida = dimensionData.length > 0 ? $.trim(dimensionData[0].text) : null;

    let shipviaData = $('#ship_via').select2('data');
    let packageData = $('#package_type').select2('data');
    enviar_por = shipviaData.length > 0 ? $.trim(shipviaData[0].text) : null;
    empaque = packageData.length > 0 ? $.trim(packageData[0].text) : null;
    // console.log(largo, ancho, alto, peso, u_medida, u_peso, empaque, enviar_por);

}

// Función para verificar si todos los valores están presentes
function areInputsValid() {
    return peso && alto && ancho && largo && u_peso && u_medida;
}

// Función que carga los datos en la tabla y realiza cálculos necesarios
function processShippingData() {
    if (areInputsValid()) {
        let idSV = determineShippingType(largo, ancho, alto, peso);

        if (parseInt($('#ship_via').val(), 10) !== idSV) {
            $('#ship_via').val(idSV).trigger('change');
        }

        if (enviar_por && empaque) {
            loadDataShipingData(largo, ancho, alto, peso, u_medida, u_peso, enviar_por, empaque);
        }
    }
}

//Agregar Item al Shipping Table
async function addChildTableShipping(id) {
    try {
        let url = productShow.replace(':id', id);
        const data = await getProductData(url);
        
        let lbs = parseFloat(convertToLbs(data.weight, data.wunit.symbol)) || 0;
        let lar = parseFloat(convertToInches(data.depth, data.dunit.symbol)) || 0;
        let wid = parseFloat(convertToInches(data.width, data.dunit.symbol)) || 0;
        let hei = parseFloat(convertToInches(data.height, data.dunit.symbol)) || 0;
        let cbm = parseFloat(calculateCBM(lar, wid, hei, 'in')) || 0;

        let dataShipping = {
            "largo": lar,
            "ancho": wid,
            "alto": hei,
            "peso": lbs,
            "u_medida": u_medida,
            "u_peso": 'lbs',
            "shipVia": data.ship_via?.name || null,  // Uso del operador opcional
            "package": data.package?.name || null,    // Uso del operador opcional
            "box_content_id": data.box_content_id || null
        };

        //addItemTableShipping(id, cbm, dataShipping);

    } catch (error) {
        console.error(error);
        showToast('Error when querying the product', 'error');
    }
}

async function loadDataShipingData(largo, ancho, alto, peso, u_medida, u_peso, enviar_por, empaque) {
    let cbm = calculateCBM(largo, ancho, alto, u_medida);
    let id = $('#id').val() || ULID.ulid();

    let data = {
        "largo": largo,
        "ancho": ancho,
        "alto": alto,
        "peso": peso,
        "u_medida": u_medida,
        "u_peso": u_peso,
        "shipVia": enviar_por,
        "package": empaque
    };

    //addItemTableShipping(id, cbm, data);
}

//Export data
function export_data(){
    window.location = exportData;
}


//determina el envió según tamaño de las cajas
function determineLargestShippingType(types) {
    // Definimos la prioridad de cada tipo de envío
    const priority = {
        'ltl': 3,           // Mayor prioridad
        'parcell': 2,       // Medio
        'small parcell': 1  // Menor prioridad
    };

    let largestType = null;
    let highestPriority = 0;

    // Iteramos sobre el array para encontrar el tipo de mayor prioridad
    for (let type of types) {
        let currentPriority = priority[type.toLowerCase()];
        if (currentPriority > highestPriority) {
            highestPriority = currentPriority;
            largestType = type;
        }
    }

    return largestType;
}

function clearSelects() {
    let select;
    switch (typeSelect) {
        case 'pt':
            select = 'product_type';
            break;
        case 'ps':
            select = 'statusP';
            break;
        case 'po':
            select = 'origin';
            break;
        case 'pb':
            select = 'brand';
            break;
        case 'pp':
            select = 'product_part';
            break;
        case 'pm':
            select = 'material';
            break;
        case 'pc':
            select = 'color';
            break;
        case 'pn':
            select = 'attrName';
            break;
        case 'pv':
            select = 'attrValue';
            break;
        case 'ppt':
            select = 'package_type';
            break;
    }
    $('#' + select).val(null).trigger('change');
}

function loadSelects() {
    switch (typeSelect) {
        case 'pt':
            loadProductTypes();
            break;
        case 'ps':
            loadProductStatus();
            break;
        case 'po':
            loadProductOrigins();
            break;
        case 'pb':
            loadProductBrands();
            break;
        case 'pp':
            loadProductParts();
            break;
        case 'pm':
            loadProductMaterials();
            break;
        case 'pc':
            loadProductColors();
            break;
        case 'pa':
            loadProductAttributes();
            break;
        case 'pv':
            loadValues();
            break;
        case 'ppt':
            loadPackageTypes();
            break;
    }
}

function getProductUrl() {
    let url;
    console.log(typeSelect);
    
    switch (typeSelect) {
        case 'pt':
            url = ProductsTypeSave;
            break;
        case 'ps':
            url = ProductStatusSave;
            break;
        case 'po':
            url = ProductOriginSave;
            break;
        case 'pb':
            url = ProductBrandSave;
            break;
        case 'pp':
            url = ProductPartsSave;
            break;
        case 'pm':
            url = ProductMaterialSave;
            break;
        case 'pv':
        case 'pc':
            url = ProductValueSave;
            break;
        case 'pa':
            url = ProductAttributeSave;
            break;
        case 'ppt':
            url = ProductPackageTypeSave;
            break;
    }
    return url;
}

function clearFrmProducts() {
    $('#formProducts')[0].reset();
    $('#formProducts').removeClass('was-validated');
    $('#idimage').empty();
    $('.new').val(null).trigger('change');
    $('#jstree').jstree("uncheck_all");
    $('#gralShipVia').prop('required', false);
    $('#pallet').prop('required', false);
    clearSearch();
    $('#codigobarra').prop('src', 'assets/images/logo-sm.png');
    // $('.selAttr').val(null).trigger('change');
    $tableChld.bootstrapTable('removeAll');
    $tableBnd.bootstrapTable('removeAll');
    $tableMC.bootstrapTable('removeAll');
    $tableShipping.bootstrapTable('removeAll');
    $tableTPSKU.bootstrapTable('removeAll');
    // $tableAttr.bootstrapTable('removeAll');
    $('#cover').fileinput('destroy').fileinput({
        showCaption: false,
        dropZoneEnabled: false,
        showUpload: false
    });
    if ($("#mapCtrl").is(':checked')) {
        $("#mapCtrl").trigger('click');
        $('#lblmapCtrl').text('No');
    }
    $('#id').val(null);
    $('#alertProduct').empty();

    //Inicializar variables
    selectedFiles = [];
    deletedImageIds = [];
    deletedAttrIds = [];
    deletedChildIds = [];
    deletedBundleIds = [];
    deletedTPSKUs = [];
    dataContentBox = [];
    isNew = true;
    boxCount = 0;

    // Mostrar las Card colapsadas
    if (!$('#cardCollpaseInfo').hasClass('show')) {
        $('#cardCollpaseInfo').addClass('show');
    }
    $('a[href="#cardCollpaseInfo"]').removeClass('collapsed');
    $('a[href="#cardCollpaseInfo"]').prop('aria-expanded', true);

    if (!$('#cardCollpaseImg').hasClass('show')) {
        $('#cardCollpaseImg').addClass('show');
    }
    $('a[href="#cardCollpaseImg"]').removeClass('collapsed');
    $('a[href="#cardCollpaseImg"]').prop('aria-expanded', true);

    if (!$('#cardCollpaseInventory').hasClass('show')) {
        $('#cardCollpaseInventory').addClass('show');
    }
    $('a[href="#cardCollpaseInventory"]').removeClass('collapsed');
    $('a[href="#cardCollpaseInventory"]').prop('aria-expanded', true);

    if (!$('#cardCollpase9').hasClass('show')) {
        $('#cardCollpase9').addClass('show');
    }
    $('a[href="#cardCollpase9"]').removeClass('collapsed');
    $('a[href="#cardCollpase9"]').prop('aria-expanded', true);

    if (!$('#cardDescription').hasClass('show')) {
        $('#cardDescription').addClass('show');
    }
    $('a[href="#cardDescription"]').removeClass('collapsed');
    $('a[href="#cardDescription"]').prop('aria-expanded', true);
    
    $('#dimension_unit').val(6).trigger('change');
    $('#weight_unit').val(2).trigger('change');

    //Mover Pagina al top
    setTimeout(() => {
        $('#alertProduct')[0].scrollIntoView({
            behavior: 'smooth'
        });
    }, 500);
}

async function fetchParentCategories(){
    // Realiza la solicitud AJAX para obtener las categorías
    let response = await fetch(categoriesListParents, {
        headers: {
            'Content-Type': 'application/json',
        },
    });
    if (response.ok) {
        let resp = await response.json();
        $.each(resp, function (key, value) {
            $('#parent_category').append(new Option(value.name, value.id));
        });
    } else {
        showToast('An error occurred when processing the application', 'error');
        console.error(await response.json());
    }
}

async function fetchCategories() {
    // Realiza la solicitud AJAX para obtener las categorías
    let response = await fetch(categoriesList, {
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (response.ok) {
        let resp = await response.json();

        // Limpia el array antes de llenarlo
        arrayCollection = [];

        // Recorre la respuesta y construye el arreglo para jsTree
        $.each(resp, function (k, row) {
            if (row.parent_category_id) {
                arrayCollection.push({
                    "id": row.id,
                    "parent": row.parent_category_id,
                    "text": row.name,
                    "icon": "fas fa-file text-primary" // Icono para categorías hijas
                });
            } else {
                arrayCollection.push({
                    "id": row.id,
                    "parent": '#', // Indica que es una categoría principal
                    "text": row.name,
                    "icon": "fa fa-folder text-warning", // Icono para categorías principales
                    "state": {
                        "opened": false  // Se abrirán las categorías principales por defecto
                    }
                });
            }
        });

        // Llamada para refrescar el jsTree con los nuevos datos
        refreshJSTree();
    } else {
        showToast('An error occurred when processing the application', 'error');
        console.error(await response.json());
    }
}

// Función para refrescar el árbol con nuevos datos
function refreshJSTree() {
    // Actualiza los datos y refresca el jsTree
    $('#jstree').jstree(true).settings.core.data = arrayCollection;
    $('#jstree').jstree(true).refresh();
    // setTimeout(() => {
    //     $('#jstree').jstree("close_all");
    // }, 100);
}

// Función para limpiar búsqueda del árbol 
function clearSearch() {
    $('#jstree').jstree("clear_search");
    //$('#jstree').jstree("open_all");
}
//--------------------------------------------------

function generate(n = 11) {
    // Aqui debe buscar en la DB el numero correspondiente al los comprados en GS1.org
    
    
    //Por ahora se genera un numero unico
    counter++;
    let microtime = performance.now().toFixed(8);
    let digits = microtime.replace('.', '');
    let sum = 0;
    for (let char of digits) {
        sum += parseInt(char, 10);
    }
    let sumLength = `${sum}${counter}`.length;
    let bytesNeeded = Math.max(n - sumLength, 0);

    // Genera 'bytesNeeded' bytes aleatorios
    let typedArray = new Uint8Array(bytesNeeded);
    let randomValues = window.crypto.getRandomValues(typedArray);
    let randomString = Array.from(randomValues).join(''); // Convierte a cadena

    // Combina el valor de la suma, el contador y los bytes aleatorios
    const uniqueID = `${sum}${counter}${randomString}`.slice(0, n); // Ajusta longitud a 'n'

    return uniqueID;
}

function calculateCheckDigit(upc) {
    // Convertir la cadena en un array de dígitos
    let digits = upc.split('').map(Number);

    // Calcular la suma ponderada
    let sum = 0;
    digits.forEach((digit, index) => {
        sum += digit * (index % 2 === 0 ? 3 : 1);
    });

    // Calcular el dígito de control
    let checkDigit = (10 - (sum % 10)) % 10;

    return checkDigit;
}

function numValid(evt) {
    var theEvent = evt || window.event;
    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

function determineShippingType(largo, ancho, alto, pesoReal, factorDimensional = 5000) {
    // Convertir los valores a float
    largo = parseFloat(largo);
    ancho = parseFloat(ancho);
    alto = parseFloat(alto);
    pesoReal = parseFloat(pesoReal);

    // Calcular el peso dimensional
    const pesoDimensional = (largo * ancho * alto) / factorDimensional;

    // Determinar el mayor entre peso real y peso dimensional
    const pesoMayor = Math.max(pesoReal, pesoDimensional);

    // Condiciones para envío Small Parcel
    const esSmallParcel = (
        (pesoMayor <= 70) &&            // Peso menor o igual a 70 libras
        (largo <= 84) &&                // Ninguna dimensión mayor a 84 pulgadas
        ((largo + 2 * (ancho + alto)) <= 130)); // Largo + circunferencia (ancho + alto) <= 130 pulgadas

    if (esSmallParcel) {
        return 2; //"Small Parcel"
    }

    // Condiciones para envío Parcel
    const esParcel =
        pesoMayor <= 150 &&            // Peso menor o igual a 150 libras
        largo <= 108 &&                // Ninguna dimensión mayor a 108 pulgadas
        (largo + 2 * (ancho + alto)) <= 165; // Largo + circunferencia (ancho + alto) <= 165 pulgadas

    if (esParcel) {
        return 3; //"Parcel"
    }

    // Si no cumple con las condiciones de Parcel, debe enviarse como LTL
    return 1; //"LTL"
}

function transformTextToJson(texto) {
    // Arreglamos el texto añadiendo las comas faltantes entre los párrafos
    const textoCorregido = texto
        .replace(/\n/g, ' ')  // Eliminar saltos de línea
        .replace(/\"\s\"/g, '", "')  // Añadir las comas que faltan
        .trim();  // Eliminar posibles espacios adicionales

    // Extraer el title y el resto como description
    const title = textoCorregido.match(/\"title\":\s\"(.*?)\"/)[1];
    const description = textoCorregido.split(/\"description\":\s\"/)[1].replace(/\"\s+\"/g, ' ').slice(0, -2);

    // Retornar el JSON con solo title y description
    const json = {
        title: title,
        description: description
    };

    return json;
}

//Verify if exist filled fields
function checkFilledFields(formId) {
    let form = $(`#${formId}`); // Utiliza jQuery para seleccionar el formulario
    let filled = false; // Variable para verificar si hay campos llenos

    // Recorre todos los elementos del formulario
    form.find(':input').each(function () {
        let $field = $(this);

        // Ignorar campos de tipo checkbox con el atributo data-plugin="switchery" o name="btSelectAll"
        if ($field.is(':checkbox') && ($field.data('plugin') === 'switchery' || $field.attr('name') === 'btSelectAll')) {
            return; // Ignora este campo
        }

        // Verifica que el campo no sea de tipo botón y que su valor no sea undefined, null o vacío
        if (!$field.is(':button, :submit') && $field.val() !== undefined && $field.val() !== null && $.trim($field.val()) !== '') {
            // console.log($field); // Muestra el elemento en la consola
            // console.log($field.val()); // Muestra el valor en la consola
            filled = true; // Hay campos llenos
            return false; // Salir del bucle
        }

    });

    //verificamos si existe categoría(s) seleccionadas
    let data = $('#jstree').jstree().get_selected(true);
    if (data.length > 0) {
        filled = true; // Hay campos llenos
    }

    //verificamos los boostraptables
    $totChld = $tableChld.bootstrapTable('getData').length;
    //$totAttr = $tableAttr.bootstrapTable('getData').length;
    $totBnd = $tableBnd.bootstrapTable('getData').length;
    //$totMC = $tableMC.bootstrapTable('getData').length;
    if ($totChld > 0 || $totBnd > 0) {
        filled = true; // Hay campos llenos
    }

    return filled; // Retorna si hay campos llenos
}

//----Carga de Selects----
async function loadProductTypes() {
    try {
        const typesData = await asyncAjax(productTypes, 'GET');
        const $select = $('#product_type');
        $select.empty();
        $.each(typesData, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product types:', error);
        showToast('Error loading product types', 'error', 3000, 'toast-bottom-right');
    }
}

async function loadProductStatus() {
    try {
        const statusData = await asyncAjax(productStatus, 'GET');
        const $select = $('#statusP');
        $select.empty();
        $.each(statusData, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product status:', error);
        showToast('Error loading product status', 'error', 3000, 'toast-bottom-right');
    }
}


async function loadProductOrigins() {
    try {
        const originsData = await asyncAjax(productOrigin, 'GET');
        const $select = $('#origin');
        $select.empty();
        $.each(originsData, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product origin:', error);
        showToast('Error loading product origin', 'error', 3000, 'toast-bottom-right');
    }
}


async function loadProductBrands() {
    try {
        const brandsData = await asyncAjax(productBrands, 'GET');
        const $select = $('#brand');
        $select.empty();
        $.each(brandsData, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product brands:', error);
        showToast('Error loading product brands', 'error', 3000, 'toast-bottom-right');
    }
}


async function loadProductMeasures() {
    try {
        const measureData = await asyncAjax(productMeasures, 'GET');
        const $select1 = $('#dimension_unit');
        const $select2 = $('#weight_unit');
        $select1.empty();
        $select2.empty();
        $.each(measureData, function (key, value) {
            if (value.type == 'dimension') {
                $select1.append(new Option(value.symbol, value.id));
            } else if (value.type == 'weight') {
                $select2.append(new Option(value.symbol, value.id));
            }
        });
        $select1.val(null).trigger('change');
        $select2.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product measures:', error);
        showToast('Error loading product measures', 'error', 3000, 'toast-bottom-right');
    }
}

async function loadProductParts() {
    try {
        const partsData = await asyncAjax(productParts, 'GET');
        const $select = $('#product_part');
        $select.empty();
        $.each(partsData, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product parts:', error);
        showToast('Error loading product parts', 'error', 3000, 'toast-bottom-right');
    }
}

async function loadProductMaterials() {
    try {
        const materialsData = await asyncAjax(productMaterial, 'GET');
        const $select = $('#material');
        $select.empty();
        $.each(materialsData, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product materials:', error);
        showToast('Error loading product materials', 'error', 3000, 'toast-bottom-right');
    }
}


async function loadProductColors() {
    try {
        const colorsData = await asyncAjax(productColors, 'GET');
        $('#color').empty();
        $.each(colorsData, function (key, value) {
            $('#color').append(new Option(value.name, value.id));
        });
        $('#color').val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product colors:', error);
        showToast('Error loading product colors', 'error', 3000, 'toast-bottom-right');
    }
}

async function loadProductAttributes(id) {
    try {
        if (!id || id == null || id == '' || id.length == 0) {
            $('#attributes-container').html('<span class="text-center">Select a category to continue</span>');
            return false;
        }

        let uri = ProductsAttributesCategories;
        uri = uri.replace(':id', id);

        $.get(uri, function(data) {
            const container = $('#attributes-container');
            container.empty();
            let row;
            data.attributes.forEach(function(attr, index) {
                if (index % 3 === 0) {
                    row = $('<div class="row"></div>');
                    container.append(row);
                }

                const nameID = slugify (attr.name)+'-'+attr.type.substring(0,3);
                const col = $('<div class="col-md-4 mb-3"></div>');
                const attrGroup = $('<div class="form-group"></div>');
                const label = $(`<label class="${attr.required ? 'required' : ''}" for="${nameID}">${attr.name}</label>`);
                attrGroup.append(label);

                let input;

                if (attr.is_custom) {
                    if (attr.type === 'textarea') {
                        input = $(`<textarea name="attributes[${attr.id}]" 
                                    class="form-control" ${attr.required ? 'required' : ''} id="${nameID}"></textarea>`);
                    } else {
                        input = $(`<input type="${attr.type}" name="attributes[${attr.id}]" 
                                    class="form-control" ${attr.required ? 'required' : ''}
                                    placeholder="${attr.type === 'text' ? '(MANUAL ENTRY)' : ''}" id="${nameID}">`);
                    }
                } else {
                    input = $(`<select name="attributes[${attr.id}]" class="form-select selcat" ${attr.required ? 'required' : ''} id="${nameID}">
                                <option value="">Select...</option>
                                </select>`);
                    attr.values.forEach(function(item) {
                        const hasExtra = item.extra && Array.isArray(item.extra) && item.extra.length > 0;
                        const option = $(`<option value="${item.id}" ${hasExtra ? 'data-has-extra="1"' : ''}>${item.name}</option>`);
                        input.append(option);
                    });

                    // Añade evento para mostrar/ocultar extra fields
                    input.on('change', function() {
                        const selectedValue = $(this).val();
                        const attrId = attr.id;

                        // Ocultar todos los extras relacionados
                        $(`div[id^="extra_fields_${attrId}_"]`).hide();

                        // Mostrar el correspondiente si existe
                        if (selectedValue) {
                            $(`#extra_fields_${attrId}_${selectedValue}`).show();
                        }
                    });
                }

                attrGroup.append(input);

                // Render extra fields para cada valor que tenga extras
                if (!attr.is_custom && attr.values) {
                    attr.values.forEach(function(item) {
                        if (item.extra && Array.isArray(item.extra) && item.extra.length > 0) {
                            const extraWrapper = $(`<div id="extra_fields_${attr.id}_${item.id}" class="extra-fields mt-2 ps-2 border-start border-secondary-subtle" style="display: none;"></div>`);

                            item.extra.forEach(function(extra) {
                                const extraGroup = $('<div class="form-group mb-2"></div>');
                                let text = extra.name.toLowerCase();
                                let label = text.charAt(0).toUpperCase() + text.slice(1);
                                const extraLabel = $(`<label>${label}</label>`);
                                extraGroup.append(extraLabel);

                                if (extra.input_type === 'select') {
                                    const extraSelect = $(`<select name="extra[${attr.id}][${item.id}][${extra.name}]" class="form-select selcat">
                                                                <option value="">Select...</option>
                                                           </select>`);
                                    extra.values.forEach(function(opt) {
                                        extraSelect.append(`<option value="${opt.id}">${opt.name}</option>`);
                                    });
                                    extraGroup.append(extraSelect);
                                } else if (extra.input_type === 'textarea'){
                                    const extraTextArea = $(`<textarea class="form-control" name="extra[${attr.id}][${item.id}][${extra.name}]" cols="20" rows="2"></textarea>`);                                                            
                                    extraGroup.append(extraTextArea);
                                } else {
                                    const extraInput = $(`<input type="${extra.input_type}" name="extra[${attr.id}][${item.id}][${extra.name}]" 
                                                            class="form-control" placeholder="${extra.name}">`);
                                    extraGroup.append(extraInput);
                                }

                                extraWrapper.append(extraGroup);
                            });

                            attrGroup.append(extraWrapper);
                        }
                    });
                }

                col.append(attrGroup);
                row.append(col);
            });
            $('.selcat').select2({
                theme: "bootstrap-5",
                width: "100%",
                dropdownParent: $('#offcanvasRight'),
            });
        }).fail(function() {
            showToast('Error loading product features', 'error', 3000, 'toast-bottom-right');
        });
        
    } catch (error) {
        console.error('Error loading product features:', error);
        showToast('Error loading product features', 'error', 3000, 'toast-bottom-right');
    }
}

function loadValues() {
    let id = $('#attrName').val();
    
    if (id == null || id == '' || id.length == 0 || id == undefined) {
        return false;
    }
    $('#attrValue').empty();
    $('#attrValue').text('Loading...').prop('disabled', true);
    $.get(attrURL + id)
        .done(function (data) {
            // Añade las nuevas opciones al segundo select
            $.each(data, function (key, value) {
                $('#attrValue').append(new Option(value.name, value.id));
            });
            $('#attrValue').val(null).trigger('change');
        })
        .catch(error => {
            console.error('Error loading product values attributes:', error);
            showToast('Error loading product values attributes', 'error', 3000, 'toast-bottom-right');
        })
        .always(function () {
            setTimeout(() => {
                $('#attrValue').prop('disabled', false);
                $('#esperar').val(null).trigger('change');
            }, 500);
        });
}

async function loadShippingMethods() {
    try {
        const shipViaData = await asyncAjax(productShipVia, 'GET');
        const $shipVia = $('#ship_via');
        const $gralShipVia = $('#gralShipVia');
        const shipViaDetail = $('#shipViaDetail');
        $shipVia.empty();
        $gralShipVia.empty(); // Importante para evitar duplicados
        shipViaDetail.empty(); // Limpiar el detalle de envío
        
        $.each(shipViaData, function (key, value) {
            let id = value.id;
            let name = value.name;
            
            $shipVia.append(new Option(name,id));
            $gralShipVia.append(new Option(name, id));
            shipViaDetail.append(new Option(name, id));
        });

        $shipVia.val(null).trigger('change');
        $gralShipVia.val(null).trigger('change');
        shipViaDetail.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product ship via:', error);
        showToast('Error loading product ship via', 'error', 3000, 'toast-bottom-right');
    }
}

async function loadPackageTypes() {
    try {
        const packageTypeData = await asyncAjax(packageType, 'GET');
        const $select = $('#package_type');
        const $packingDetail = $('#packingDetail');
        $select.empty();
        $.each(packageTypeData, function (key, value) {
            $select.append(new Option(value.name, value.id));
            $packingDetail.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
        $packingDetail.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product package type:', error);
        showToast('Error loading product package type', 'error', 3000, 'toast-bottom-right');
    }
}

function loadCustomers() {
    return $.get(customers).then(customersData => {
        $('#customer').empty();
        $.each(customersData, function (key, value) {
            $('#customer').append(new Option(value.company, value.id));
        });
        $('#customer').val(null).trigger('change');
    }).catch(error => {
        console.error('Error loading product customers:', error);
        showToast('Error loading product customers', 'error', 3000, 'toast-bottom-right');
    });
}

async function loadPallets() {
    try {
        const palletsData = await asyncAjax(productPallets, 'GET');
        const $select = $('#pallet');
        $select.empty();
        $.each(palletsData, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading product pallets:', error);
        showToast('Error loading product pallets', 'error', 3000, 'toast-bottom-right');
    }
}

async function loadBoxContent(boxContentID) {
    try {
        const boxContent = await asyncAjax(productBoxContent, 'GET');
        const $select = $('#contentBoxD');
        $select.empty();
        $.each(boxContent, function (key, value) {
            $select.append(new Option(value.name, value.id));
        });
        $select.val(null).trigger('change');
    } catch (error) {
        console.error('Error loading box content:', error);
        showToast('Error loading box content', 'error', 3000, 'toast-bottom-right');
    }
}

async function cargaFeatures(id){
    let uri = productCatFeatures.replace(':id', id);
    const features = await asyncAjax(uri, 'GET');
    console.log(features);
    
}

// Función para cargar todos los datos de manera simultánea
function loadAllData() {
    loadProductTypes();
    loadProductStatus();
    loadProductOrigins();
    loadProductBrands();
    loadProductMeasures();
    loadProductParts();
    loadProductMaterials();
    loadProductColors();
    loadProductAttributes();
    loadShippingMethods();
    loadPackageTypes();
    loadPallets();
    loadCustomers();
    loadBoxContent();
}

async function upcCodeGenerate(code) {
    let valUPC = code;

    let upc;
    if (valUPC.length === 12) {
        // Si el código es de 12 dígitos, verificamos el dígito de control
        let body = valUPC.slice(0, 11); // Los primeros 11 dígitos
        let providedCheckDigit = parseInt(valUPC.slice(11)); // El dígito de control proporcionado
        let calculatedCheckDigit = calculateCheckDigit(body); // Calculamos el dígito de control

        if (providedCheckDigit === calculatedCheckDigit) {
            upc = valUPC; // Si el dígito de control es correcto, lo usamos tal cual
        } else {
            upc = body + calculatedCheckDigit; // Si no, lo corregimos
        }
    } else if (valUPC.length === 11 || valUPC === '') {
        // Si es de 11 dígitos o vacío, generamos el UPC completo
        let num = (valUPC === '') ? await generate() : valUPC; // Generar los primeros 11 dígitos
        let checkDigit = calculateCheckDigit(num); // Calculamos el dígito de control
        upc = num + checkDigit; // Concatenamos el dígito de control
    } else {
        showToast('The UPC code must be 11 or 12 digits.', 'error');
        return;
    }

    $('#upc').val(upc);
    // Generar el código de barras usando JsBarcode con formato UPC
    JsBarcode("#codigobarra", upc, { format: "UPC" });

    qrcode.makeCode('https://www.casabianca.com/products/il-vetro-vanity-in-white-high-gloss-with-storage');
    setTimeout(() => {
        var base64Image = $('#qrcode img').prop('src');
        $('#codigoQR').prop('src',base64Image);
    }, 1000);
    
}

//cargar imagen desde url en Base64
async function getImageBase64(url) {
    try {
        const proxyUrl = 'https://cors-anywhere.herokuapp.com/';
        // Usamos fetch para obtener la imagen
        const response = await fetch(proxyUrl + url);
        const blob = await response.blob(); // Convertir la respuesta a un Blob (objeto binario)

        return await new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve(reader.result); // Cuando se carga, devolver el resultado Base64
            reader.onerror = reject; // Manejar errores

            reader.readAsDataURL(blob); // Leer el Blob como Data URL (Base64)
        });
    } catch (error) {
        console.error('Error fetching image:', error);
        return null;
    }
}

//Convertir a mts
function convertToMeters(value, unit) {
    let meters;
    switch (unit) {
        case 'mm':
            meters = value / 1000;
            break;
        case 'cm':
            meters = value / 100;
            break;
        case 'in':
            meters = value / 39.3701;
            break;
        default:
            meters = value; // Asume que si no se especifica, ya está en metros
    }
    return parseFloat(meters).toFixed(2); // Redondea a 2 decimales
}

//Convertir a pulgadas
function convertToInches(value, unit) {
    let inch;

    switch (unit) {
        case 'mm':
            inch = value / 25.4; // Convertir de milímetros a pulgadas
            break;
        case 'cm':
            inch = value / 2.54; // Convertir de centímetros a pulgadas
            break;
        case 'm':
            inch = value * 39.3701; // Convertir de metros a pulgadas
            break;
        default:
            inch = value; // Asume que ya está en pulgadas si no se especifica correctamente la unidad
    }

    // Convertir a número flotante y aplicar toFixed(2)
    return parseFloat(inch).toFixed(2);
}

//Convertir a libras
function convertToLbs(weight, unit) {
    let lbs;

    switch (unit) {
        case 'kg':
            lbs = weight * 2.20462; // Convertir de kilogramos a libras
            break;
        case 'oz':
            lbs = weight / 16; // Convertir de onzas a libras
            break;
        case 'lbs':
        case 'lb':
            lbs = weight; // Ya está en libras
            break;
        default:
            lbs = weight; // Asume que ya está en libras si no se especifica correctamente la unidad
    }

    // Convertir a número flotante y aplicar toFixed(2)
    return parseFloat(lbs).toFixed(2);
}

//calculo del CBM
function calculateCBM(length, width, height, uom) {
    // Convertimos todas las medidas a metros
    const lengthInMeters = convertToMeters(length, uom);
    const widthInMeters = convertToMeters(width, uom);
    const heightInMeters = convertToMeters(height, uom);

    // Calculamos el volumen en metros cúbicos (CBM)
    const cbm = lengthInMeters * widthInMeters * heightInMeters;

    return cbm.toFixed(3); // Devolvemos el resultado con 6 decimales
}

//calculo del Freight Class
function calculateFreightClass(weight, weightUnit, length, width, height, uom) {
    // Convertimos el peso a libras
    const weightInLbs = convertToLbs(weight, weightUnit);

    // Convertimos las dimensiones a metros usando tu función convertToMeters
    const lengthInMeters = convertToMeters(length, uom);
    const widthInMeters = convertToMeters(width, uom);
    const heightInMeters = convertToMeters(height, uom);

    // Convertimos el volumen de metros cúbicos a pies cúbicos (1 metro cúbico = 35.3147 pies cúbicos)
    const volumeInCubicFeet = (lengthInMeters * widthInMeters * heightInMeters) * 35.3147;

    // Calculamos la densidad en libras por pie cúbico
    const density = weightInLbs / volumeInCubicFeet;

    $('#density').html(density.toFixed(2));

    // Determinamos la Freight Class basada en la densidad (en libras/pie cúbico)
    if (density >= 30) return 60;
    if (density >= 22.5 && density < 30) return 65;
    if (density >= 15 && density < 22.5) return 70;
    if (density >= 12 && density < 15) return 85;
    if (density >= 10 && density < 12) return 92.5;
    if (density >= 8 && density < 10) return 100;
    if (density >= 6 && density < 8) return 125;
    if (density >= 4 && density < 6) return 175;
    if (density >= 2 && density < 4) return 250;
    if (density >= 1 && density < 2) return 300;
    return 400; // Densidad menor a 1 lb/pie cúbico
}

//convertir CBM to CBF -- metros cúbicos a pies cúbicos
function convertCBMToCBF(cbm) {
    const cbf = cbm * 35.3147;
    return cbf.toFixed(3);
}

//Imprimir Tear Sheet
function makeTear() {
    let productData = $table.bootstrapTable('getSelections');
    if (productData.length < 1) {
        showToast('You must select at least one record', 'error');
        return;
    }

    productData.forEach((val, index) => {

        let url = tearPdf.replace(':id', val.id);  // Reemplazar correctamente ':id' por el ID del producto        

        // Agregar un retraso de 100 ms entre las aperturas
        setTimeout(() => {
            window.open(url, '_blank');
        }, index * 100);  // Multiplica el índice por 100 ms para el retraso
    });

    return true;
}

//Imprimir Tear Sheet
function makeBox() {
    let productData = $table.bootstrapTable('getSelections');
    if (productData.length < 1) {
        showToast('You must select at least one record', 'error');
        return;
    }

    productData.forEach((val, index) => {

        let url = boxPdf.replace(':id', val.id);  // Reemplazar correctamente ':id' por el ID del producto        

        // Agregar un retraso de 100 ms entre las aperturas
        setTimeout(() => {
            window.open(url, '_blank');
        }, index * 100);  // Multiplica el índice por 100 ms para el retraso
    });

    return true;
}

function makeCellsEditable() {
    $('#tableCarga tbody td:not(:nth-child(8))').prop('contenteditable', true);
}

function asyncAjax(url, method, data = null) {
    return new Promise(function(resolve, reject) {
        let ajaxOptions = {
            url: url,
            type: method,
            dataType: "json",
            success: function(response) {
                resolve(response); // Resolve promise when success
            },
            error: function(err) {
                reject(err); // Reject the promise and go to catch()
            }
        };

        if (data !== null) {
            ajaxOptions.contentType = "application/json";
            ajaxOptions.data = JSON.stringify(data);
        }

        $.ajax(ajaxOptions);
    });
}

function alerta(rut, mensaje, tipo) {
    if($('#mensajes').hasClass('d-none')){
        $('#mensajes').removeClass('d-none');
    }

    let aviso = `<div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>ID ${rut}</strong> ${mensaje}
                </div>`

    $('#mensajes').append(aviso);
}

//Esto es parte del filtrado
function queryParams(params = null) {
    //console.log(params);
    
    $('#filters-container').find('input[name]').each(function () {
        params[$(this).attr('name')] = $(this).val()
    })

    return params
}