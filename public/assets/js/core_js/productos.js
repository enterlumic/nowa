let productos = {

    init: function () {

        // Funciones principales

        productos.fn_set_productos();
        productos.fn_set_python();
        productos.fn_datatable_productos(rango_fecha='');
        productos.fn_scroll_productos();
        productos.deleteProduct();

        // Funciones para eventos
        productos.fn_modalShowproductos();
        productos.fn_modalHideproductos();
        productos.fn_AgregarNuevoproductos();
        productos.fn_actualizarTablaproductos();
        productos.fn_set_validar_existencia_productos();
    },

    fn_datatable_productos: function (rango_fecha) {

        let table = $('#get_productos_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_productos_datatable",
                "type": "GET",
                "data": function(d) {
                    d.buscar_titulo = $('#buscar_titulo').val();
                    d.buscar_descripcion = $('#buscar_descripcion').val();
                    d.buscar_precio = $('#buscar_precio').val();
                    d.buscar_marca = $('#buscar_marca').val();
                    d.buscar_review = $('#buscar_review').val();
                    d.buscar_cantidad = $('#buscar_cantidad').val();
                    d.buscar_color = $('#buscar_color').val();
                    d.buscar_precio_anterior = $('#buscar_precio_anterior').val();
                    d.buscar_target = $('#buscar_target').val();
                    // Añade aquí más datos de búsqueda si es necesario
                },
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            "processing": true,
            "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span>',
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": '<div class="text-center">\
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:75px;height:75px">\
                                                    </lord-icon>\
                                                    <h5 class="mt-2">Sin resultados</h5>\
                                                    <p class="text-muted mb-0">Hemos buscado en más de 50 Registros No encontramos ningún registro para su búsqueda.</p>\
                                                </div>',
                "sEmptyTable": "Ningún registro disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": '<div class="spinner-border text-primary avatar-sm" role="status">\
                                        <span class="visually-hidden">Loading...</span>\
                                    </div>',
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
            // guarda el estado de la tabla (paginación, filtrado, etc.)
            ,
            stateSaveCallback: function (settings, data) {
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
            },
            stateLoadCallback: function (settings) {
                return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
            },
            fnDrawCallback: function( oSettings ) {
                $('[data-toggle="tooltip"]').tooltip();
            },

            "order": [[0, "desc"]],

            "columns": [
                { "data": "id", visible: true},
                { "data": "titulo", class: "titulo", visible: true },
                { "data": "descripcion", class: "descripcion", visible: false },
                { "data": "precio", class: "precio", visible: false },
                { "data": "marca", class: "marca", visible: false },
                { "data": "review", class: "review", visible: false },
                { "data": "cantidad", class: "cantidad", visible: false },
                { "data": "color", class: "color", visible: false },
                { "data": "precio_anterior", class: "precio_anterior", visible: false },
                { "data": "target", class: "target", visible: false },
            ],

            "columnDefs": [
                {
                    "targets": 1,
                    "render": function (data, type, row, meta) {

                        return '<div class="media">\
                                    <div class="card-aside-img">\
                                                                <img src="assets/libs/slick-slider/slick/ajax-loader.gif" data-src="uploads/productos/'+row.foto+'" alt="Imagen de Producto" class="lazyload" style="max-width: 100%; height: auto;">\
                                    </div>\
                                    <div class="media-body">\
                                        <div class="card-item-desc mt-0">\
                                            <h6 class="fw-semibold mt-0 text-uppercase">'+row.titulo+'</h6>\
                                            <dl class="card-item-desc-1">\
                                              <dt>Precio: </dt>\
                                              <dd>'+row.precio+'</dd>\
                                            </dl>\
                                        </div>\
                                    </div>\
                                </div>\
                        ';
                    }
                },
                {
                    "targets": 10,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-productos"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-productos"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

       // Aplicar la búsqueda
        $("#get_productos_datatable thead tr:eq(1) th").each(function (i) {
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        if ( $("#btn-personalizados").length && $(".btn-personalizado-xlxs").length ){
            $('#btn-personalizados').html('');
            table.buttons().container().appendTo( '#btn-personalizados' );
            $('.btn-personalizado-xlxs').html('<i class="mdi mdi-microsoft-excel text-success"></i>');
            $('.btn-personalizado-xlxs').removeClass('btn-secondary header-item');
            $('.btn-personalizado-xlxs').addClass('header-item noti-icon');
        }

        if ( $('#vc-buscador').length ){
            $('#vc-buscador').keyup(function(){
                table.search($(this).val()).draw() ;
            });
        }

        // setInterval( function () {
        //     table.ajax.reload( null, false );
        // }, 5000 );

        productos.fn_update_productos();
        productos.fn_delete_productos();
    },

    fn_scroll_productos: function() {
        let AppScroll = angular.module('app-scroll-productos', ['infinite-scroll']);
        AppScroll.controller('ControllerScroll', function($scope, Reddit) {
            $scope.reddit = new Reddit();
            $scope.noMoreItems = false;  // Flag to indicate no more items
        });

        AppScroll.factory('Reddit', function($http) {
            let Reddit = function() {
                this.items = [];
                this.busy = false;
                this.after = '';  // Inicializa this.after como una cadena vacía
                this.allItemsLoaded = false;  // Flag to indicate all items are loaded
        };

        Reddit.prototype.nextPage = function() {
            if (this.busy || this.allItemsLoaded) {
                if (this.allItemsLoaded) {
                    // Mostrar mensaje de no más elementos
                    document.getElementById('no-more-items').style.display = 'block';
                }
                return;
            }

            this.busy = true;

            let url = "get_productos_diez?id_productos=" + encodeURIComponent(this.after || '') + "&callback=JSON_CALLBACK&X-CSRF-TOKEN=" + encodeURIComponent($('meta[name="csrf-token"]').attr('content'));

            $http.jsonp(url).success(function(data) {
                let items = data;

                if (Array.isArray(items) && items.length > 0) {
                    console.log("items fetched:", items);
                    let newItems = [];
                    for (let i = 0; i < items.length; i++) {
                        // Check if the item already exists in the list to avoid duplicates
                        if (!this.items.some(item => item.id === items[i].id)) {
                            newItems.push(items[i]);
                        }
                    }
                    this.items = this.items.concat(newItems);
                    console.log("Updated items list:", this.items);
                    // Ensure after is set correctly
                    if (newItems.length > 0) {
                        this.after = newItems[newItems.length - 1].id;
                    }
                    console.log("Updated after value:", this.after);
                    this.busy = false;
                } else {
                    // No more items to load, set the flag
                    this.allItemsLoaded = true;
                    this.busy = false;
                    // Mostrar mensaje de no más elementos
                    document.getElementById('no-more-items').style.display = 'block';
                }
            }.bind(this)).error(function(data, status, headers, config) {
                this.busy = false;
            }.bind(this));
        };

        // Function to validate and display item by id
        Reddit.prototype.validateAndDisplayById = function(id) {
            let foundItem = this.items.find(item => item.id === id);
            if (foundItem) {
                console.log("Found item:", foundItem);
                // Display the item information as needed
                alert("Item found: " + JSON.stringify(foundItem));
            } else {
                console.log("Item not found with id:", id);
            }
        };

        return Reddit;
    });
    },

    fn_copyToClipboardproductos: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_set_productos: function () {
        $("#form_productos").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_productos");
                let postData = new FormData(get_form);

                let element_by_id= 'form_productos';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_productos",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {

                        $loading.waitMe('hide');

                        let json ='';
                        try {
                            json = JSON.parse(response);
                        } catch (e) {
                            alert(response);
                            return;
                        }

                        if (json["b_status"]) {
                            $('#get_productos_datatable').DataTable().ajax.reload();
                            document.getElementById("form_productos").reset();
                            $('#modalFormIUproductos').modal('hide');
                        } else {
                            alert(json);
                        }
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                    }
                });
            }
            , rules: {
              titulo: {
                required: true
              },
              fotos: {
                required: true
              }
            }
            , messages: {
                fotos: {
                    minlength: "El fotos es requerido"
                }
              }
        });
    },

    fn_set_python: function () {
        $("#form_python").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_python");
                let postData = new FormData(get_form);

                let element_by_id= 'form_python';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_python",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {

                        $loading.waitMe('hide');

                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                    }
                });
            }
            , rules: {
              fotos: {
                required: true
              }
            }
            , messages: {
                fotos: {
                    minlength: "El fotos es requerido"
                }
              }
        });
    },

    fnShowbyIDPromocion: function(){
        let element_by_id= 'form_productos';
        let message=  'Cargando...' ;
        let $loading= LibreriaGeneral.f_cargando(element_by_id, message);
        let id= 0;

        if ( $('#form_productos #id').length ){
            id= $('#form_productos #id').val();
        }

        $.ajax({
            url:"get_productos_by_id",
            data: {id: id},
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                $loading.waitMe('hide');

                let json='';
                try {
                    json = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                }

                if (json["b_status"]) {
                    let p = json['data'];
                    let preloadedFiles = json['preloadedFiles'];

                    // Inicializar de nuevo el fileuploader con archivos pre-cargados
                    productos.initializeFileUploader(preloadedFiles);

                    for (let keyIni in p) {
                        for (let key in p[0]) {
                            if (p[0].hasOwnProperty(key)) {
                                if (p[0][key] !== "") {
                                    $("#" + key).addClass("fill");

                                    if ($("#" + key).prop('type') == "text" ||
                                        $("#" + key).prop('type') == "textarea" ||
                                        $("#" + key).prop('type') == "email" ||
                                        $("#" + key).prop('type') == "number" ||
                                        $("#" + key).prop('type') == "url" ||
                                        $("#" + key).prop('type') == "tel") {
                                        $("#" + key).val(p[0][key]);
                                    }

                                    if ($("#" + key).prop('type') == "file") {
                                        if (p[0][key] !== "") {
                                            $("#" + key).attr("required", false);
                                        }

                                        if (p[0][key] !== null) {
                                            let filename = p[0][key].replace(/^.*[\\\/]/, '')
                                                $("#" + key).after("<a href=\"" + p[0][key] + "\" target=\"_blank\" class=\"external_link  abrir-" + key + " \"> " + filename.substr(0, 15) + " </a>");
                                        }
                                    }

                                    if ($("#" + key).prop('nodeName') == "SELECT") {
                                        $('#' + key + ' option[value="' + p[0][key] + '"]').prop('selected', true);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    alert("Revisar console para mas detalle");
                    console.log(json);
                }
            },
            error: function(response)
            {
                $loading.waitMe('hide');
            }
        });
    },

    fn_modalShowproductos: function () {
        $('#modalFormIUproductos').on('shown.bs.modal', function (e) {
            $('#titulo', e.target).focus();

            if (!$('#form_productos #id').length) {
                productos.initializeFileUploader('');
            } else {
                productos.fnShowbyIDPromocion();
            }

        });

        $('#modalImportFormproductos').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHideproductos: function () {

        $('#modalFormIUproductos').on('hidden.bs.modal', function (e) {

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_productos").length ){
                $("#form_productos input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_productos").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_productos").length){
                document.getElementById("form_productos").reset();
            }

            if ($("#form_import_productos").length){
                document.getElementById("form_import_productos").reset();
            }
        });
    },

    fn_AgregarNuevoproductos: function () {
        $(document).on("click", "#add_new_productos", function () {
            document.getElementById("form_productos").reset();            
            $("#modalFormIUproductos .modal-title").html("Agregar Un Nuevo Producto");
        });
    },

    fn_actualizarTablaproductos: function () {
        $(document).on("click", "#refresh_productos", function () {

            if ($("#get_productos_datatable").length){
                $('#get_productos_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_truncateproductos: function () {
        $.ajax({
            url:"truncate_productos",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                if ($("#get_productos_datatable").length){
                    $('#get_productos_datatable').DataTable().ajax.reload();
                }
            }
        });
    },

    fn_set_validar_existencia_productos: function(){

        $( "#fotos" ).keyup(function( event ) {

            var id=0;
            // Si se esta editando return
            if ( $("#modalFormIUproductos #id").length ){
                id= $("#modalFormIUproductos #id").val();
            }

            let fotos= this.value;

            if(fotos ==""){
                $("#modalFormIUproductos .btn-action-form").attr("disabled",false);
                $("#fotos").removeClass("border-danger").removeClass("text-danger");
                $(".tipo-ya-existe").addClass("d-none");
                return;
            }

            $.ajax({
                url: "validar_existencia_productos",
                data: { fotos: fotos, id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                contentType: "application/json",
                success: function (response) {

                    var json = JSON.parse(response);

                    if (json['b_status']) {
                        $("#modalFormIUproductos .btn-action-form").attr("disabled",true);
                        $("#fotos").addClass("border-danger").addClass("text-danger");
                        $(".tipo-ya-existe").removeClass("d-none");
                    } else {
                        $("#modalFormIUproductos .btn-action-form").attr("disabled",false);
                        $("#fotos").removeClass("border-danger").removeClass("text-danger");
                        $(".tipo-ya-existe").addClass("d-none");
                    }
                },
            });

        });
    },

    fn_update_productos: function(){

        $('#get_productos_datatable tbody').on('click', '.update-productos', function () {
            // Abrir modal!
            $('#modalFormIUproductos').modal('show');

            let id = this.id;
            document.getElementById("form_productos").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_productos").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUproductos .modal-title").html("Editar Producto");

        });
    },

    initializeFileUploader: function(preloadedFiles) {
        // Destruir la instancia anterior del fileuploader si existe
        if (window.api && typeof window.api.destroy === 'function') {
            window.api.destroy();
            window.api = null; // Asegurarse de limpiar la referencia
            console.log("FileUploader destruido");
        } else {
            console.log("No se encontró una instancia previa de FileUploader para destruir");
        }

        // Limpiar el contenedor del fileuploader
        $('#fileUploaderContainer').html('<input type="file" name="fotosUpload">');

        var preloadedFilesParsed = [];

        try {
            if (preloadedFiles) {
                preloadedFilesParsed = JSON.parse(preloadedFiles);
            }
        } catch (e) {
            console.error("Invalid JSON: ", preloadedFiles);
        }

        var input = $('input[name="fotosUpload"]').fileuploader({
            extensions: null,
            changeInput: ' ',
            theme: 'thumbnails',
            enableApi: true,
            addMore: true,
            files: preloadedFilesParsed,
            thumbnails: {
                onItemShow: function(item) {
                    item.html.find('.fileuploader-action-remove').before('<button type="button" class="fileuploader-action fileuploader-action-sort" title="Sort"><i class="fileuploader-icon-sort"></i></button>');
                },
                box: '<div class="fileuploader-items">' +
                          '<ul class="fileuploader-items-list">' +
                              '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
                          '</ul>' +
                      '</div>',
                item: '<li class="fileuploader-item">' +
                           '<div class="fileuploader-item-inner">' +
                               '<div class="type-holder">${extension}</div>' +
                               '<div class="actions-holder">' +
                                   '<button type="button" class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fileuploader-icon-remove"></i></button>' +
                               '</div>' +
                               '<div class="thumbnail-holder">' +
                                   '${image}' +
                                   '<span class="fileuploader-action-popup"></span>' +
                               '</div>' +
                               '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                               '<div class="progress-holder">${progressBar}</div>' +
                           '</div>' +
                      '</li>',
                item2: '<li class="fileuploader-item">' +
                           '<div class="fileuploader-item-inner">' +
                               '<div class="type-holder">${extension}</div>' +
                               '<div class="actions-holder">' +
                                   '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="${captions.download}" download><i class="fileuploader-icon-download"></i></a>' +
                                   '<button type="button" class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i class="fileuploader-icon-sort"></i></button>' +
                                   '<button type="button" class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fileuploader-icon-remove"></i></button>' +
                               '</div>' +
                               '<div class="thumbnail-holder">' +
                                   '<img src="${data.url}" alt="${name}" class="fileuploader-thumbnail-preview">' +
                                   '<span class="fileuploader-action-popup"></span>' +
                               '</div>' +
                               '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                               '<div class="progress-holder">${progressBar}</div>' +
                           '</div>' +
                       '</li>',
                startImageRenderer: true,
                canvasImage: true,
                _selectors: {
                    list: '.fileuploader-items-list',
                    item: '.fileuploader-item',
                    start: '.fileuploader-action-start',
                    retry: '.fileuploader-action-retry',
                    remove: '.fileuploader-action-remove',
                    sorter: '.fileuploader-action-sort',
                    popup: '.fileuploader-popup-preview',
                    popup_open: '.fileuploader-action-popup'
                },
                onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));

                    if (item.format == 'image') {
                        item.html.find('.fileuploader-item-icon').hide();
                    }
                },
                onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));

                    html.children().animate({'opacity': 0}, 200, function() {
                        html.remove();

                        if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
                            plusInput.show();
                    });
                }
            },

            sorter: {
                selectorExclude: null,
                placeholder: null,
                scrollContainer: window,
                onSort: function(list, listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl.get(0)),
                        fileList = api.getFileList(),
                        _list = [];
                    
                    $.each(fileList, function(i, item) {
                        _list.push({
                            name: item.name,
                            index: item.index
                        });
                    });
                    
                    $.ajax({
                        url: "ajax_sort_files",
                        data: {_list: JSON.stringify(_list)},
                        cache: false,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'POST',
                        success: function (response) {
                            console.log("response", response);
                        },
                        error: function (response) {
                            $loading.waitMe('hide');
                        }
                    });
                }
            },
            onRemove: function(item) {
                $.ajax({
                    url: "ajax_remove_file",
                    data: {file: item.name },
                    cache: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {
                        console.log("response", response);


                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                    }
                });
            },
            dragDrop: {
                container: '.fileuploader-thumbnails-input'
            },
            afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                plusInput.on('click', function() {
                    api.open();
                });

                api.getOptions().dragDrop.container = plusInput;
            }
        });

        // Guardar la nueva instancia del fileuploader en window.api
        window.api = $.fileuploader.getInstance(input);
        console.log("api", window.api);
    },

    fn_delete_productos: function(){
        $('#get_productos_datatable tbody').on('click', '.delete-productos', function () {

            document.getElementById("form_productos").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            let id = this.id;
            let element_by_id= 'form_productos';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_productos",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_productos_datatable').DataTable().ajax.reload();
                        $('#modalFormIUproductos').modal('hide');
                        $loading.waitMe('hide');

                        let n = new Noty({
                            type: "warning",
                            close: false,
                            text: "<b>Se movio a la papelera<b>" ,
                            layout: 'topCenter',
                            timeout: 20e3,
                                buttons: [
                                  Noty.button('Deshacer', 'btn btn-success btn-sm', function () {
                                        $.ajax({
                                            url:"undo_delete_productos",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#get_productos_datatable').DataTable().ajax.reload();

                                                    new Noty({
                                                        text: 'Se ha deshecho la acción.',
                                                        type: "warning",
                                                        layout: 'topCenter',
                                                        timeout: 1e3,
                                                    }).show();


                                                },
                                                error: function(response)
                                                {
                                                    alert("Ocurrio un error");
                                                }
                                        });
                                  }
                                  ,{
                                      'id'         : 'id-'+id
                                    , 'data-status': 'ok'
                                  }
                                  )
                                  , Noty.button('Cerrar', 'btn btn-error', function () {
                                        n.close();
                                    })
                                ]
                        });
                        n.show();
                    },
                    error: function(response)
                    {
                        $loading.waitMe('hide');
                    }
            });
        });  
    },

    deleteProduct: function(){
        $(document).on('click', '.eliminarProducto', function () {

            var productId = $(this).data('id'); 

            $.ajax({
                url:"delete_productos",
                data: {"id": productId},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                    },
                    error: function(response)
                    {
                        $loading.waitMe('hide');
                    }
            });


        }); 
    },

};

productos.init();