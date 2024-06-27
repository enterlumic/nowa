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
        
        @php $select= 'calendario' @endphp

        @include('empresa.menu_configurar_empresa')

        <!-- Col -->
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-body">

                    <form class="form-material form-action-post" action="set_empresa_horarios" id="form_empresa" method="POST">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Abre a las</th>
                                    <th>Cierra a las</th>
                                    <th>Cerrada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                                    @php
                                        $horario = $horarios[$dia] ?? null;
                                    @endphp
                                    <tr>
                                        <td>{{ $dia }}</td>
                                        <td>
                                            <input type="time" name="abre_a[{{ $dia }}]" class="form-control" value="{{ $horario->abre_a ?? '09:00' }}">
                                        </td>
                                        <td>
                                            <input type="time" name="cierra_a[{{ $dia }}]" class="form-control" value="{{ $horario->cierra_a ?? '18:00' }}">
                                        </td>
                                        <td>
                                            <input type="checkbox" name="cerrada[{{ $dia }}]" {{ isset($horario->cerrada) && $horario->cerrada ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>

                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- /row -->
</x-app-layout>

<script src="assets/js/core_js/empresa.js?{{ rand() }}"></script>

    <script>

    // Lógica para manejar el cambio de estado del checkbox
    $('input[type="checkbox"]').change(function() {
        let $row = $(this).closest('tr');
        if ($(this).is(':checked')) {
            $row.css('background-color', '#f8d7da');
            $row.find('input[type="time"]').prop('disabled', true);
        } else {
            $row.css('background-color', '');
            $row.find('input[type="time"]').prop('disabled', false);
        }
    });

    // Inicializar los checkbox al cargar la página
    $('input[type="checkbox"]').each(function() {
        let $row = $(this).closest('tr');
        if ($(this).is(':checked')) {
            $row.css('background-color', '#f8d7da');
            $row.find('input[type="time"]').prop('disabled', true);
        }
    });
    </script>