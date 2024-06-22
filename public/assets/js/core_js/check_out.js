let checkOut = {

    init: function () {

        const urlParams = new URLSearchParams(window.location.search);

        // Obtener el valor del parámetro 'id'
        const id = urlParams.get('id');            

        // Agregar el id del producto
        $('#id_producto').val(id);

        // Funciones principales
        checkOut.fn_calendario();
        checkOut.fn_customerConnekta();
        checkOut.fn_fnCreateOrder();
        checkOut.fn_eventos_clicks();
        checkOut.fn_modalAgregarEfecto();
    },

    fn_calendario: function () {
        flatpickr("#appointmentDateTime", {
            inline: true,
            minDate: new Date().fp_incr(3), // 3 días desde la fecha actual
            maxDate: new Date().fp_incr(60), // 60 días desde la fecha actual
            dateFormat: "Y-m-d H:i",
            locale: "es", // Esto establece el calendario en español
            defaultDate: localStorage.getItem('selectedDate') || null, // Fecha predeterminada desde el caché
            onChange: function(selectedDates, dateStr, instance) {
                // Guardar la fecha seleccionada en caché
                localStorage.setItem('selectedDate', dateStr);
                
                // Validar el formulario cuando se selecciona una fecha
                $("#form_check_out").valid();
            }
        });
    },

    fn_customerConnekta: function () {

        $.ajax({
            url: "fn_getCustomerConekta",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            success: function(data) {
                let cardsHTML = '';
                
                if (!data){
                    return;
                }

                data.forEach(function(card) {
                    cardsHTML += `
                        <li class="badge-type-selection__list-item ui-list__item">
                            <div>
                                <label tabindex="0" class="ui-radio__label">
                                    <div class="ui-radio-element">
                                        <input type="radio" name="selected_card[]" id="card_${card.payment_source_id}" value="${card.payment_source_id}" data-customer-id="${card.customer_id}" class="ui-radio__input d-none">
                                        <div class="ui-radio__background">
                                            <div class="ui-radio__outer-circle"></div>
                                            <div class="ui-radio__inner-circle"></div>
                                        </div>
                                    </div>
                                    <div class="ui-radio__text">
                                        <span class="avatar me-2 avatar-rounded">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="${card.brand} logo" width="30">
                                        </span>
                                        <div class="badge-type__metadata">
                                            <span class="badge-type-selection__list-title">${card.name}</span>
                                            <p class="badge-type-selection__list-text">
                                                <span class="phone">********${card.number.slice(-4)}</span>
                                                <span>${card.card_type.charAt(0).toUpperCase() + card.card_type.slice(1)} - ${card.brand.charAt(0).toUpperCase() + card.brand.slice(1)}</span>
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </li>`;
                });

                // Assuming you have a container element to append this card HTML
                $('#DivCustomerConekta').html(cardsHTML);

                $(document).on('click', '.ui-list__item', function() {

                    let selectedRadio = $(this).find('input[type="radio"]').first();
                    selectedRadio.prop('checked', true); // Selecciona el radio button

                    let value = selectedRadio.val();
                    let customerId = selectedRadio.data('customer-id');
                    
                    $('#customer_id').val(customerId);
                    $('#card_id').val(value);

                });
            }
        });
    },

    fn_fnCreateOrder: function () {

        // https://techlaboratory.net/jquery-smartwizard

        $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'dots',
            justified: true,
            toolbar: {
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                position: 'bottom', // none|top|bottom|both
                extraHtml: `<button type="submit" class="btn btn-success sw-btn d-none" id="comprar-checkout" >Comprar</button>`
            },
            lang: { // Language variables for button
                next: 'Siguiente',
                previous: 'Atras'
            },
            keyboard: {
                keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                keyLeft: [37], // Left key code
                keyRight: [39] // Right key code
            }
        });

        $("#form_check_out").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_check_out");
                let postData = new FormData(get_form);

                let element_by_id= 'form_check_out';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "fnCreateOrder",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {

                        let json ='';
                        try {
                            json = JSON.parse(response);
                        } catch (e) {
                            console.log("response", response);
                            return;
                        }

                        if (json["b_status"]) {
                            window.location.href = 'completado';                            
                        } else {

                            Swal.fire({
                                title: json["vc_message"],
                                confirmButtonText: 'Aceptar',
                                showClass: {
                                    popup: 'animate__animated animate__bounceIn'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__bounceOut'
                                }
                            });

                            $loading.waitMe('hide');
                        }
                    },
                    error: function (response) {
                        console.log("response", response);
                        $loading.waitMe('hide');
                    }
                });

            }
            , rules: {
                appointmentTime: {
                    required: true
                },
                "horario_dispobible[]": {
                    required: true
                }
            }
            , messages: {
                appointmentDateTime: {
                    required: "Por favor seleccione una fecha disponible"
                },
                appointmentTime: {
                    required: "Por favor seleccione una hora de cita"
                },
               "horario_dispobible[]": {
                    required: "Por favor seleccione un horario disponible" // Asegúrate de que el nombre del campo esté entre comillas
                }
            },
            ignore: "", // Esta línea asegura que los campos ocultos también se validen
            errorPlacement: function(error, element) {
                // Personaliza dónde y cómo se colocan los mensajes de error
                if (element.attr("name") == "appointmentDateTime" ) {
                    error.appendTo("#errorSeleccionarFecha");
                }
                if (element.attr("name") == "horario_dispobible[]" ) {
                    error.appendTo("#errorSeleccionarHorario");
                }else {
                    error.insertAfter(element);
                }
            }
        });

        // Set event to validate before moving to the next step
        $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {

            if (stepDirection === 1) {
                return $("#form_check_out").valid();
            }else{
                $(".sw-toolbar-elm .sw-btn-next").removeClass('d-none');
            }

            if (stepDirection === 2) {
                $(".sw-toolbar-elm .sw-btn-next").addClass('d-none');
                $(".sw-toolbar-elm #comprar-checkout").removeClass('d-none');
            }else{
                $(".sw-toolbar-elm #comprar-checkout").addClass('d-none');
            }

            return true;
        });

        // Handle navigation button clicks
        $('.nexttab').on('click', function() {
            $('#smartwizard').smartWizard("next");
        });

        $('.previestab').on('click', function() {
            $('#smartwizard').smartWizard("prev");
        });
    },

    fn_eventos_clicks: function(){

        $('.main-contact-item').on('click touch', function () {
            $(this).addClass('selected');
            $(this).siblings().removeClass('selected');
            $('body').addClass('main-content-body-show');
        });        
    },

    fn_modalAgregarEfecto: function(){

        var exampleModal = document.getElementById('modalFormIUclienteConekta')
        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-whatever')
            var modalTitle = exampleModal.querySelector('.modal-title')
            var modalBodyInput = exampleModal.querySelector('.modal-body input')
            modalTitle.textContent = 'New message to ' + recipient
            modalBodyInput.value = recipient
        });

        document.querySelectorAll(".modal-effect").forEach(e => {
            e.addEventListener('click', function (e) {
                e.preventDefault();
                let effect = this.getAttribute('data-bs-effect');
                document.querySelector("#modalFormIUclienteConekta").classList.add(effect);
            });
        })
        /* hide modal effects */
        document.getElementById("modalFormIUclienteConekta").addEventListener('hidden.bs.modal', function (e) {
            let removeClass = this.classList.value.match(/(^|\s)effect-\S+/g);
            removeClass = removeClass[0].trim();
            this.classList.remove(removeClass);
        });
    },

    fn_eventos_extra_check_out: function(){
    },

};

checkOut.init();