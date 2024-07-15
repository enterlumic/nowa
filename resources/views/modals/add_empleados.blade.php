@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_empleados(){}
@endphp

<div class="modal fade" id="modalFormIUempleados" tabindex="-1" aria-labelledby="add_new_empleadosLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_empleados" id="form_empleados" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_empleadosLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        {{-- ======================== --}}
                        {{-- Información del Empleado --}}
                        {{-- ======================== --}}
                        <div class="col-xxl-6">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Información del Empleado
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="titulo" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe Nombre">
                                        </div>
                                        <div class="col-sm-12 d-none tipo-ya-existe">
                                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="direccion" class="form-label">Direccion</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Escribe Direccion">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="telefono" class="form-label">Telefono</label>
                                            <input type="text" class="form-control phone-number" id="telefono" name="telefono" placeholder="MX(+52)">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Escribe Email">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- ======================== --}}
                        {{-- Datos Laborales          --}}
                        {{-- ======================== --}}
                        <div class="col-xxl-6">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Datos Laborales
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Fecha Ingreso</label>
                                                <input type="text" class="form-control" id="fecha_ingreso" name="fecha_ingreso" placeholder="Seleccionar Fecha" >
                                        </div>

                                        <div class="col-md-6 mb-3 d-none">
                                            <label for="puesto" class="form-label">Puesto</label>
                                            <input type="text" class="form-control" id="puesto" name="puesto" placeholder="Escribe Puesto">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="salario" class="form-label">Salario</label>
                                            <input type="text" class="form-control" id="salario" name="salario" placeholder="Escribe Salario">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="jornada" class="form-label">Jornada</label>
                                            <div class="row">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="material-icons">access_time</i></span>
                                                    <select class="form-select" id="jornada" name="jornada">
                                                        <option value="">Seleccione...</option>
                                                        <option value="1">Tiempo completo</option>
                                                        <option value="2">Medio tiempo</option>
                                                        <option value="3">Horas</option>
                                                        <option value="4">Fexible</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="card-footer  border-top-0"></div>
                            </div>
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

<!-- /.modalFormIUempleados -->

@if( 1 == 3)
    <script src="assets/js/core_js/empleados_qa.js?{{ rand() }}"></script>
@endif