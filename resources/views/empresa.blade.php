<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Empresa</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-15"><a href="javascript:void(0);">Pages</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        <!-- Col -->
        <div class="col-lg-4 col-xl-3 col-md-12 col-sm-12">
            <div class="card mg-b-20">
                <div class="main-content-left main-content-left-mail card-body">
                    <a class="btn btn-primary btn-compose" href="" id="btnCompose">Configurar empresa</a>
                    <div class="main-mail-menu">
                       <nav class="nav main-nav-column mg-b-20">
                            <a class="nav-link thumb active" href="javascript:void(0);"><i class="far fa-building"></i> Empresa</a>
                            <a class="nav-link thumb" href="javascript:void(0);"><i class="fas fa-map-marker-alt"></i> Ubicación </a>
                        </nav>
                    </div><!-- main-mail-menu -->
                </div>
            </div>
        </div>
        <!-- /Col -->

        <!-- Col -->
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-body">
                    <form class="form-material form-action-post" action="set_empresa" id="form_empresa" method="post" enctype="multipart/form-data">
                        <div class="mb-4 main-content-label">Información de la Empresa</div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Logo</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="file" class="form-control-file" id="logo" name="logo">
                                    @if($empresa && $empresa->logo)
                                        <img src="{{ asset('uploads/logos/' . $empresa->logo) }}" alt="Logo de la empresa" style="max-width: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Nombre</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe Nombre" value="{{ $empresa->nombre ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Descripción</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escribe Descripción" value="{{ $empresa->descripcion ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Teléfono</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Escribe Teléfono" value="{{ $empresa->telefono ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Whatsapp</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Escribe Whatsapp" value="{{ $empresa->whatsapp ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Ubicación</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Escribe Ubicación" value="{{ $empresa->ubicacion ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Longitud</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="longitud" name="longitud" placeholder="Escribe Longitud" value="{{ $empresa->longitud ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Latitud</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="latitud" name="latitud" placeholder="Escribe Latitud" value="{{ $empresa->latitud ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer justify-content-end">
                            <div><button type="submit" class="btn btn-success">Guardar</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- /row -->
</x-app-layout>

<script src="assets/js/core_js/empresa.js?{{ rand() }}"></script>
