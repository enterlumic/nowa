<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Empresa</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-15"><a href="javascript:void(0);">Admin</a></li>
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
                            <a class="nav-link thumb" href="empresa"><i class="far fa-building"></i> Empresa</a>
                            <a class="nav-link thumb active" href="empresa_ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación </a>
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
                        
                    <form class="form-material form-action-post" action="set_empresa_ubicacion" method="post" id="form_empresa">

                        <div class="mb-4 main-content-label">Ubicación de la Empresa</div>

                        <div class="col-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input id="ubicacion" name="ubicacion" value="{{ $ubicacion ?? '' }}" class="form-control inputs" type="text">
                                </div>
                            </div>
                            <input type="hidden" name="longitud" value="{{ $longitud ?? '' }}" id="longitud">
                            <input type="hidden" name="latitud" value="{{ $latitud ?? '' }}" id="latitud">
                            <div class="location-map" id="location-map">
                                <div style="width: 100%; height: 400px;" id="map_canvas"></div>
                            </div>
                        </div>

                        <div class="card-footer justify-content-end">
                            <div><button type="submit" class="btn btn-success btn-action-form">Guardar</button></div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- /row -->
</x-app-layout>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdSvVepDl30nFw15uaj_BaWQeDOR5Hfj8&libraries=places"></script>
<script src="assets/js/core_js/empresa.js?{{ rand() }}"></script>

