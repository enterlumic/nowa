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

        @php $select= 'empresa' @endphp

        @include('empresa.menu_configurar_empresa')

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
                                    <div class="custom-card" >
                                        <input type="file" name="files" class="d-none" data-fileuploader-default="{{ !empty($empresa->logo) ? asset('uploads/empresa/logos/' . $empresa->logo) : 'https://innostudio.de/fileuploader/images/default-avatar.png' }}" data-fileuploader-files=''>
                                    </div>
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
                                    <label class="form-label">Teléfono</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" maxlength="15" id="telefono" name="telefono" placeholder="Escribe Teléfono" value="{{ $empresa->telefono ?? '' }}">
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
                                    <label class="form-label">Descripción</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Escribe Descripción">{{ $empresa->descripcion ?? '' }}</textarea>
                                </div>
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

{{-- Empresa lo necesario  --}}
<script src="assets/js/core_js/empresa.js?{{ rand() }}"></script>
