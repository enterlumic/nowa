var xcore = {

    init: function(){
        xcore.fn_tabs();
        xcore.fn_eventos();
        xcore.fn_crear_xcore();
        xcore.fn_datatable();
        xcore.fn_reiniciar_session();
        xcore.fn_reemplazar_tema();
    },

    fn_datatable: function() {

        let table = $('#xcore-table').DataTable({
            destroy: true,
            ajax: 'getProyectos',
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                        return row.id + ' - ' + row.proyecto + ' - ' + row.titulo ;
                    }
                },
                {
                    targets: -1,
                    render: function (data, type, row) {

                        let sp= row.sp;
                        let mi_sp='<br>';

                        for (let i = 0; i < sp.length; i++) {
                            if (sp[i] !== 'undefined') {
                                mi_sp+= sp[i] + '<br>';
                            }
                        }

                        return row.id + ' - ' + row.proyecto + ' - ' + row.titulo+ ' - ' + mi_sp + `
                            <br>
                            <button class="btn-eliminar-proyecto btn btn-sm btn-danger ">\
                                Eliminar\
                            </button>

                            <button class="btn-estructurar btn btn-sm btn-success" \
                            data-bs-toggle="modal" data-bs-target="#modal_form_reemplazar_tema" style="margin-left:20px">\
                                Estructurar\
                            </button>

                            <button class="btn-web btn btn-sm btn-primary " style="margin-left:20px">Web</button>

                            <button class="btn-limpiar-proyecto btn btn-sm btn-primary float-center" style="margin-left:20px">\
                                Clear\
                            </button>

                            <button class="btn-eliminar-registro btn btn-sm btn-danger float-end">\
                                Eliminar Registro\
                            </button>
                        `;
                    },
                    defaultContent: ''
                }
            ],
            columnDefs: [
                {
                    targets: [0],
                    visible: false
                }
            ]
        });

        $('#xcore-table').on('click', '.btn-estructurar', function() {
            var data = table.row($(this).closest('tr')).data();

            if ( $('#form_reemplazar_tema #id_tema').length ){
                $('#form_reemplazar_tema #id_tema').remove();
            }

            $('#form_reemplazar_tema').append('<input type="hidden" id="id_tema" value="'+data.id+'">');
            $('#form_reemplazar_tema').append('<input type="hidden" id="url_proyecto" value="'+data.titulo+'">');
        });

        $('#xcore-table').on('click', '.btn-eliminar-proyecto', function() {
            var data = table.row($(this).closest('tr')).data();

            $.ajax({
                url: "fn_eliminar_proyecto",
                data: {id: data.id },
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function (response) {
                    xcore.notify("Eliminado", 'inverse');
                },
                error: function (response) {
                    $loading.waitMe('hide');
                    alert(response);
                }
            });
        });

        $('#xcore-table').on('click', '.btn-eliminar-registro', function() {
            var data = table.row($(this).closest('tr')).data();

            $.ajax({
                url: "fn_eliminar_registro",
                data: {id: data.id },
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function (response) {
                    xcore.notify("Eliminado...", 'inverse');
                    $('#xcore-table').DataTable().ajax.reload();
                }
            });
        });

        $('#xcore-table').on('click', '.btn-limpiar-proyecto', function() {
            var data = table.row($(this).closest('tr')).data();

            $.ajax({
                url: "fn_clear_proyecto",
                data: {id: data.id },
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function (response) {
                    console.log("response", response);
                    xcore.notify("Limpio...", 'inverse');
                    $('#xcore-table').DataTable().ajax.reload();
                }
            });
        });

        $('#xcore-table').on('click', '.btn-web', function() {
            var data = table.row($(this).closest('tr')).data();

            $.ajax({
                url:"get_host",
                data: {id: data.id},
                cache: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                success: function(url)
                {
                    window.open(url, '_blank');
                },
                error: function(response)
                {
                    console.log("response", response);
                }
            });

        });
    },

    extraer_columna: function(idTema, texto) {
        $.ajax({
            url: "fn_columna_bd",
            data: {texto: texto, idTema: idTema},
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function (response) {

            },
            error: function (response) {

            }
        });
    },

    agregarColumna: function(proyecto, nombre_tabla) {
        $("#agregar_campo_proyecto").val(proyecto);
        $("#vc_tbl").val(nombre_tabla);

        Agregar_campo.Cat(proyecto, nombre_tabla);
    },

    fn_crear_xcore: function(proyecto, nombre_tabla) {
        $("#form_xcore").validate({
            submitHandler: function(form) {

                var get_form = document.getElementById("form_xcore");
                var postData = new FormData(get_form);

                let element_by_id= 'generar-archivos';
                let message=  'Generando archivos' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "crear_xcore",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function(response) {
                        xcore.notify(response, 'inverse');

                        $("#xcore-table").DataTable().search($("#nombre_proyecto").val()).draw();
                        $("#crear-nuevo").attr("disabled", false);
                        $('#xcore-table').DataTable().ajax.reload();

                        $loading.waitMe('hide');
                    },
                    error: function(response) {
                        if (response['status'] === 419){
                            $("#modalFormIUfn_reiniciar_session").modal("show");
                            $('#modalFormIUfn_reiniciar_session').on('shown.bs.modal', function (e) {
                                $('#email', e.target).focus();
                            });
                        }

                        $loading.waitMe('hide');
                    }
                });
            }
        });
    },

    fn_tabs: function() {

        var tabs = document.querySelectorAll('#myTabs .nav-link');
        var tabContent = document.querySelectorAll('.tab-content .tab-pane');

        // Function to reset all tabs and tab content
        function resetTabs() {
            tabs.forEach(function(tab) {
                tab.classList.remove('active');
            });
            tabContent.forEach(function(content) {
                content.classList.remove('active');
            });
        }

        // Event listener for tab clicks
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                resetTabs();
                var selectedTab = this;
                selectedTab.classList.add('active');
                var contentId = selectedTab.getAttribute('href').substring(1);
                document.getElementById(contentId).classList.add('active');
                localStorage.setItem('selectedTab', contentId);
            });
        });

        // Restore the selected tab on page load
        var savedTab = localStorage.getItem('selectedTab');
        if (savedTab) {
            resetTabs();
            document.querySelector(`#myTabs .nav-link[href="#${savedTab}"]`).classList.add('active');
            document.getElementById(savedTab).classList.add('active');
        }
    },

    notify: function(message, type) {
        $(".alert").remove();

        $.notify({
            message: message
        }
        , {
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 2500,
            offset: {
                x: 30,
                y: 0
            }
        });
    },

    fn_eventos: function() {

        $(document).on("click", ".reset-api", function(){

            $.ajax({
                url:"reset_xcore",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {
                        $('#xcore-table').DataTable().ajax.reload();
                    }
            });
        });

        $(document).on("click", "#git-push", function(){

            $.ajax({
                url:"git_push",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    console.log("response", response);
                }
            });
        });

        $('#modal_form_reemplazar_tema').on('hidden.bs.modal', function (e) {
            document.getElementById("vc_reemplazar_tema").value = "";
        });

        $('#modal_form_reemplazar_tema').on('shown.bs.modal', function (e) {
            $('#vc_reemplazar_tema', e.target).focus();
        });

        $('#seleccionar-todo').click(function() {
            $('input[type="checkbox"]').prop('checked', this.checked)
        });
    },

    fn_reemplazar_tema: function(){

       $(document).on('click', '.cambiar', function() {
            var row = $(this).closest('tr');
            var idValue = row.find('td:eq(0)').text();

            if ( $('#form_reemplazar_tema #id_tema').length ){
                $('#form_reemplazar_tema #id_tema').remove();
            }
            // Form ID
            var formId = "form_reemplazar_tema";

            // Create a hidden input element
            var hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = 'id_tema';
            hiddenInput.id = 'id_tema';
            hiddenInput.value = idValue;

            // Find the form by ID
            var form = document.getElementById(formId);

            // Check if the form exists before appending the hidden input
            if (form) {
                // Append the hidden input to the form
                form.appendChild(hiddenInput);
            }
        });

        $("#form_reemplazar_tema").validate(
        {
            submitHandler:function(form)
            {
                var lines = $('#vc_reemplazar_tema').val().split('\n');
                const idProyecto= $('#id_tema').val();
                const textArea= $('#vc_reemplazar_tema').val();
                const url_proyecto = $('#url_proyecto').val();

                let element_by_id= 'form_reemplazar_tema';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);
                
                $.ajax({
                    url: "fn_columna_bd",
                    data: {textArea: textArea, idProyecto: idProyecto},
                    cache: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {
                        $loading.waitMe('hide');
                        window.open(url_proyecto, '_blank');
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                    }
                });

                $("#modal_form_reemplazar_tema").modal('hide');
            }
            , errorPlacement: function(error, element) {
                error.insertAfter($("#"+element.attr("name")).next("span"));
            }
            , rules: {
                vc_reemplazar_tema: {
                required: true,
            }
          }
        });
    },

    fn_reiniciar_session: function() {

        $("#form_fn_reiniciar_session").validate({

            submitHandler: function (form) {
                var get_form = document.getElementById("form_fn_reiniciar_session");
                var postData = new FormData(get_form);

                let element_by_id= 'form_fn_reiniciar_session';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);
                
                $.ajax({
                    url: "set_fn_reiniciar_session",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {
                        console.log("response", response);
                        $loading.waitMe('hide');
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                        console.log("response", response);
                        alert(response);
                    }
                });
            }
            , rules: {
              email: {
                required: true
              }
            }
            , messages: {
                email: {
                    minlength: "Mensaje personalizado email"
                }
            }

        });
    },
};

$(function() {
    xcore.init();
});
