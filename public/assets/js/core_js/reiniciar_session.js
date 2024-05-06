var reiniciarSession = {

    init: function () {

        // Funciones principales
        reiniciarSession.set_reiniciar_session();
    },

    
    set_reiniciar_session: function () {
        $("#form_reiniciar_session").validate({
            submitHandler: function (form) {
                var get_form = document.getElementById("form_reiniciar_session");
                var postData = new FormData(get_form);

                let element_by_id= 'form_reiniciar_session';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_reiniciar_session",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {
                        console.log("response", response);

                        $loading.waitMe('hide');

                        try {
                            var json = JSON.parse(response);
                        } catch (e) {
                            alert(response);
                            return;
                        }

                        if (json["b_status"]) {
                            $('#tb-datatable-reiniciar_session').DataTable().ajax.reload();
                            document.getElementById("form_reiniciar_session").reset();
                            $('#modalFormIUReiniciar_session').modal('hide');
                        } else {
                            alert(json);
                        }
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                        alert(response);
                    }
                });
            }
            , rules: {
              vCampo1_reiniciar_session: {
                required: true
              }
            }
            , messages: {
                vCampo1_reiniciar_session: {
                    minlength: "Mensaje personalizado vCampo1_reiniciar_session"
                }
              }
        });
    },


};

reiniciarSession.init();