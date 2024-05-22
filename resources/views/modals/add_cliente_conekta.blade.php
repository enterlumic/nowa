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
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="Gustavo Martinez" size="20" name="name" data-conekta="card[name]"/>
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" class="form-control" value="4242424242424242" size="20" name="number" data-conekta="card[number]"/>
                        </div>
                        <div class="col-sm-12">
                            <label for="cvc" class="form-label">Cvc</label>
                            <input type="text" class="form-control" value="530" size="4" name="cvc" data-conekta="card[cvc]"/>
                        </div>
                        <div class="col-12">
                            <label for="exp_month" class="form-label">Exp_Month</label>
                            <input type="text" class="form-control" value="08" size="2" name="exp_month" data-conekta="card[exp_month]"/>
                        </div>
                        <div class="col-12">
                            <label for="exp_month" class="form-label">Exp_Year</label>
                            <input type="text" class="form-control" value="25" size="2" name="exp_year" data-conekta="card[exp_year]"/>
                        </div>
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