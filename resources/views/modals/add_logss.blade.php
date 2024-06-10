@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_logss(){}
@endphp

<div class="modal fade" id="modalFormIUlogss" tabindex="-1" aria-labelledby="add_new_logssLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_logss" id="form_logss" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_logssLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="user_id" class="form-label">User_Id</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Escribe User_Id">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="event_type" class="form-label">Event_Type</label>
                            <input type="text" class="form-control" id="event_type" name="event_type" placeholder="Escribe Event_Type">
                        </div>
                        <div class="col-sm-12">
                            <label for="context" class="form-label">Context</label>
                            <input type="text" class="form-control" id="context" name="context" placeholder="Escribe Context">
                        </div>
                        <div class="col-12">
                            <label for="event_data" class="form-label">Event_Data</label>
                            <input type="text" class="form-control" id="event_data" name="event_data" placeholder="Escribe Event_Data">
                        </div>
                        <div class="col-12">
                            <label for="event_data" class="form-label">execution_time</label>
                            <input type="text" class="form-control" id="execution_time" name="execution_time" placeholder="Escribe execution_time">
                        </div>
                        <div class="col-12">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="Escribe Status">
                        </div>
                        <div class="col-12">
                            <label for="severity" class="form-label">Severity</label>
                            <input type="text" class="form-control" id="severity" name="severity" placeholder="Escribe Severity">
                        </div>
                        <div class="col-md-4">
                            <label for="source" class="form-label">Source</label>
                            <select class="form-select" id="source" name="source">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="ip_address" class="form-label">Ip_Address</label>
                            <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Escribe ip_address">
                        </div>
                        <div class="col-md-3">
                            <label for="user_agent" class="form-label">User_Agent</label>
                            <input type="text" class="form-control" id="user_agent" name="user_agent" placeholder="Escribe user_agent">
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
<!-- /.modalFormIUlogss -->