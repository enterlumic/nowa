@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_python(){}
@endphp

<div class="modal fade" id="modalFormIUpython" tabindex="-1" aria-labelledby="add_new_pythonLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#" id="form_python" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_pythonLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control" id="url" value="https://articulo.mercadolibre.com.mx/MLM-2000922259-jeans-dama-stretch-pantalones-mujer-levanta-pompa-jean-_JM#polycard_client=recommendations_vip-pads-up&reco_backend=vip_pads_up_ranker_retrieval_system_odin_marketplace&reco_client=vip-pads-up&reco_item_pos=1&reco_backend_type=low_level&reco_id=7ccb2e8e-b15b-4458-8c27-72a20373f93c&is_advertising=true&ad_domain=VIPDESKTOP_UP&ad_position=2&ad_click_id=OTNmZDQ3MzUtMzJlMC00NmQ2LWEzZjQtY2FmYTgzNDM3MzE2" name="url" placeholder="Escribe URL">
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

<!-- /.modalFormIUpython -->