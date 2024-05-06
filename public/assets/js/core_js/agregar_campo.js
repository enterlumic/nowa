var Agregar_campo = {

    init: function () {
        // Funciones principales
        Agregar_campo.set_agregar_campo();

        // Funciones para eventos
        Agregar_campo.modalShow();
        Agregar_campo.modalHide();
        Agregar_campo.AgregarNuevo();
    },


    set_agregar_campo: function () {
        $("#form_agregar_campo").validate({
            submitHandler: function (form) {
                var get_form = document.getElementById("form_agregar_campo");
                var postData = new FormData(get_form);

                let element_by_id= 'form_agregar_campo';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_agregar_campo",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {
                        document.getElementById("form_agregar_campo").reset();
                        $('.close').click();
                        $loading.waitMe('hide');
                    },
                    error: function (response) {
                        alert(response);
                        $loading.waitMe('hide');
                    }
                });
            }
            , rules: {
              vCampo1_agregar_campo: {
                required: true
              }
            }
            , messages: {
                vCampo1_agregar_campo: {
                    minlength: "Mensaje personalizado vCampo1_agregar_campo"
                }
              }
        });
    },

    modalShow: function () {
        $('#modalFormIUAgregar_campo').on('shown.bs.modal', function (e) {
            $('#vCampo1_agregar_campo', e.target).focus();
            // Agregar_campo.Cat();
        });

    },

    modalHide: function () {
        $('#modalFormIUAgregar_campo').on('hidden.bs.modal', function (e) {
            var validator = $("#form_agregar_campo").validate();
            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            document.getElementById("form_agregar_campo").reset();
        });
    },

    AgregarNuevo: function () {
        $(document).on("click", "#add_new_agregar_campo", function () {
            document.getElementById("form_agregar_campo").reset();            
            $("#modalFormIUAgregar_campo .modal-title").html("Nuevo Agregar campo");
        });
    },

    Cat: function(proyecto, nombre_tabla){
        $.ajax({
            url:"get_cat_agregar_campo",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: {"db": proyecto, "tbl": nombre_tabla},
            success: function(response)
            {                    
                try {
                    var result = JSON.stringify(result);
                    var json   = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                }
                
                if (json["b_status"])
                {
                    $("#agregar_despues_de").html('<option selected=""> --Select-- </option>');

                    $(json['data']).each(function(i, j){
                        $("#agregar_despues_de").append("<option value="+j+"> "+j+" </option>");
                    });
                }

            }
        });

        $('#agregar_despues_de').change(function(){
            $("#vc_agregar_campo").focus();
        });
    },
};

Agregar_campo.init();