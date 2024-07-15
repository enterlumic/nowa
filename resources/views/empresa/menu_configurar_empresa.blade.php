<!-- Col -->
        <div class="col-lg-4 col-xl-3 col-md-12 col-sm-12">
            <div class="card mg-b-20">
                <div class="main-content-left main-content-left-mail card-body">
                    <a class="btn btn-primary btn-compose" href="" id="btnCompose">Configurar empresa</a>
                    <div class="main-mail-menu">
                       <nav class="nav main-nav-column mg-b-20">
                            <a class="nav-link thumb {{$select == 'empresa' ? 'active': ''}}" href="empresa"><i class="far fa-building"></i> Empresa</a>
                            <a class="nav-link thumb {{$select == 'ubicacion' ? 'active': ''}}" href="empresa_ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación </a>
                            <a class="nav-link thumb {{$select == 'calendario' ? 'active': ''}}" href="empresa_horario"><i class="fas fa-clock"></i> Horario </a>
                            <a class="nav-link thumb {{$select == 'empleados' ? 'active': ''}}" href="empresa_empleados"><i class="fas fa-users"></i> Empleados </a>
                        </nav>
                    </div><!-- main-mail-menu -->
                </div>
            </div>
        </div>
        <!-- /Col -->