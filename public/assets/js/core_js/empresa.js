let empresa = {

    init: function () {
        // Inicializa las funciones principales
        empresa.fn_set_empresa();
    },

    fn_set_empresa: function () {
        $("#form_empresa").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_empresa");
                let postData = new FormData(get_form);

                let element_by_id= 'form_empresa';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: $(form).attr('action'),
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

                        } else {
                            alert(json);
                        }
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                        alert('Error al guardar los datos.');
                    }
                });
            },
            rules: {
                nombre: {
                    required: true,
                    minlength: 3
                },
                telefono: {
                    required: true,
                    digits: true
                },
                // Agrega reglas adicionales aquí
            },
            messages: {
                nombre: {
                    required: "El nombre es requerido",
                    minlength: "El nombre debe tener al menos 3 caracteres"
                },
                telefono: {
                    required: "El teléfono es requerido",
                    digits: "El teléfono debe contener solo números"
                },
                // Agrega mensajes adicionales aquí
            }
        });
    },

};

empresa.init();
