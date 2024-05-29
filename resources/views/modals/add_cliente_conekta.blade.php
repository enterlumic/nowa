@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista
    function add_cliente_conekta(){}
@endphp

<div class="modal fade" id="modalFormIUclienteConekta" tabindex="-1" aria-labelledby="add_new_cliente_conektaLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_cliente_conekta" id="form_cliente_conekta" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_cliente_conektaLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Ir ================================= --}}
                    @php function set_cliente_conekta(){} @endphp
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <label for="cc-name" class="form-label">Nombre en la tarjeta</label>
                            <input type="text" value="Ari Martinez" class="form-control" placeholder="Ingrese el nombre" name="name" data-conekta="card[name]">
                            <small class="text-muted">Nombre completo como aparece en la tarjeta</small>
                        </div>

                        <div class="col-md-12">
                            <label for="cc-number" class="form-label">Número de tarjeta de crédito</label>
                            <input type="text" value="5256783274081893" class="form-control" placeholder="xxxx xxxx xxxx xxxx" name="number"  data-conekta="card[number]">
                        </div>

                        <div class="col-md-4">
                            <label for="cc-expiration" class="form-label">Mes de Expiración</label>
                            <input type="text" value="08" class="form-control" placeholder="MM"  name="exp_month" data-conekta="card[exp_month]">
                        </div>

                        <div class="col-md-4">
                            <label for="cc-expiration" class="form-label">Año de Expiración</label>
                            <input type="text" value="2025" class="form-control" placeholder="YYYY" name="exp_year" data-conekta="card[exp_year]">
                        </div>

                        <div class="col-md-4">
                            <label for="cc-cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" value="25" placeholder="xxx" name="cvc" data-conekta="card[cvc]">
                        </div>
                    </div>

                    <div class="text-muted mt-2 fst-italic">
                        <i data-feather="lock" class="text-muted icon-xs"></i> Su transacción está asegurada con encriptación SSL
                    </div>
                </div>
                <div class="modal-footer m-t-10">
                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modalFormIUclienteConekta -->