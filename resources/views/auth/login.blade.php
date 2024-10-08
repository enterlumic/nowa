<!DOCTYPE html>
<html lang="es" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
    <head>
        <!-- Meta Data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> NOWA </title>
        <meta name="Description" content="Plantilla HTML5 de panel de administración web responsive Bootstrap">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="administración, panel de administración, plantilla de administración, bootstrap, limpio, panel, moderno, responsive, plantillas de administración premium, responsive, kit de interfaz de usuario.">
        <!-- Favicon -->
        <link rel="icon" href="../assets/images/brand-logos/favicon.ico" type="image/x-icon">
        <!-- Main Theme Js -->
        <script src="../assets/js/authentication-main.js"></script>
        <!-- Bootstrap Css -->
        <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
        <!-- Style Css -->
        <link href="../assets/css/styles.min.css" rel="stylesheet" >
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" >
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="error-page1 bg-primary">
        <!-- Start Switcher -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <nav class="border-bottom border-block-end-dashed">
                    <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                        <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab" data-bs-target="#switcher-home"
                            type="button" role="tab" aria-controls="switcher-home" aria-selected="true">Estilos de Tema</button>
                        <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab" data-bs-target="#switcher-profile"
                            type="button" role="tab" aria-controls="switcher-profile" aria-selected="false">Colores de Tema</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel" aria-labelledby="switcher-home-tab"
                        tabindex="0">
                        <div class="">
                            <p class="switcher-style-head">Modo de Color del Tema:</p>
                            <div class="row switcher-style">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-light-theme">
                                        Claro
                                        </label>
                                        <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme"
                                            checked>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-dark-theme">
                                        Oscuro
                                        </label>
                                        <input class="form-check-input" type="radio" name="theme-style" id="switcher-dark-theme">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Direcciones:</p>
                            <div class="row switcher-style">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-ltr">
                                        LTR
                                        </label>
                                        <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-rtl">
                                        RTL
                                        </label>
                                        <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Estilos de Navegación:</p>
                            <div class="row switcher-style">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-vertical">
                                        Vertical
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-style" id="switcher-vertical"
                                            checked>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-horizontal">
                                        Horizontal
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-style"
                                            id="switcher-horizontal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-menu-styles">
                            <p class="switcher-style-head">Estilo del Menú de Navegación:</p>
                            <div class="row switcher-style pb-2">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-click">
                                        Clic en el Menú
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-menu-click">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-hover">
                                        Menú Hover
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-menu-hover">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-click">
                                        Clic en el Icono
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-icon-click">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-hover">
                                        Hover en el Icono
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-icon-hover">
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-secondary fs-11"><span class="fw-semibold fs-12 text-dark me-2 d-inline-block">Nota:</span>Funciona igual para Vertical y Horizontal</div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Estilos de Página:</p>
                            <div class="row switcher-style">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-regular">
                                        Regular
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-regular"
                                            checked>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-classic">
                                        Clásico
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-classic">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-modern">
                                        Moderno
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-modern">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Estilos de Ancho de Diseño:</p>
                            <div class="row switcher-style">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-full-width">
                                        Ancho Completo
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width" id="switcher-full-width"
                                            checked>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-boxed">
                                        Enmarcado
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width" id="switcher-boxed">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Posiciones del Menú:</p>
                            <div class="row switcher-style">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-fixed">
                                        Fijo
                                        </label>
                                        <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-fixed"
                                            checked>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-scroll">
                                        Desplazable
                                        </label>
                                        <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-scroll">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Cargador:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-loader-enable">
                                        Habilitar
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-loader"
                                            id="switcher-loader-enable">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-loader-disable">
                                        Deshabilitar
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-loader"
                                            id="switcher-loader-disable" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Posiciones del Encabezado:</p>
                            <div class="row switcher-style">
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-fixed">
                                        Fijo
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                            id="switcher-header-fixed" checked>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-scroll">
                                        Desplazable
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                            id="switcher-header-scroll">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidemenu-layout-styles">
                            <p class="switcher-style-head">Estilos de Disposición del Menú Lateral:</p>
                            <div class="row switcher-style pb-2">
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-default-menu">
                                        Menú Predeterminado
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-default-menu" checked>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-closed-menu">
                                        Menú Cerrado
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-closed-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icontext-menu">
                                        Texto del Icono
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-icontext-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-overlay">
                                        Superposición de Iconos
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-icon-overlay">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-detached">
                                        Separado
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-detached">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-double-menu">
                                        Menú Doble
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-double-menu">
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-secondary fs-11"><span class="fw-semibold fs-12 text-dark me-2 d-inline-block">Nota:</span>Los estilos del menú de navegación no funcionan aquí.</div>
                        </div>
                    </div>
                    <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel" aria-labelledby="switcher-profile-tab" tabindex="0">
                        <div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Colores del Menú:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Menú Claro" type="radio" name="menu-colors"
                                            id="switcher-menu-light" checked>
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Menú Oscuro" type="radio" name="menu-colors"
                                            id="switcher-menu-dark">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Menú de Color" type="radio" name="menu-colors"
                                            id="switcher-menu-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Menú Degradado" type="radio" name="menu-colors"
                                            id="switcher-menu-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Menú Transparente"
                                            type="radio" name="menu-colors" id="switcher-menu-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Nota: Si desea cambiar el color del menú dinámicamente, cámbielo con el selector de color primario del tema a continuación</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Colores del Encabezado:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Encabezado Claro" type="radio" name="header-colors"
                                            id="switcher-header-light" checked>
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Encabezado Oscuro" type="radio" name="header-colors"
                                            id="switcher-header-dark">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Encabezado de Color" type="radio" name="header-colors"
                                            id="switcher-header-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Encabezado Degradado" type="radio" name="header-colors"
                                            id="switcher-header-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Encabezado Transparente" type="radio" name="header-colors"
                                            id="switcher-header-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Nota: Si desea cambiar el color del encabezado dinámicamente, cámbielo con el selector de color primario del tema a continuación</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Color Primario del Tema:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-1" type="radio"
                                            name="theme-primary" id="switcher-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-2" type="radio"
                                            name="theme-primary" id="switcher-primary1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary"
                                            id="switcher-primary2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary"
                                            id="switcher-primary3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary"
                                            id="switcher-primary4">
                                    </div>
                                    <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                        <div class="theme-container-primary"></div>
                                        <div class="pickr-container-primary"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Fondo del Tema:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-1" type="radio"
                                            name="theme-background" id="switcher-background" checked>
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-2" type="radio"
                                            name="theme-background" id="switcher-background1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-3" type="radio" name="theme-background"
                                            id="switcher-background2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-4" type="radio"
                                            name="theme-background" id="switcher-background3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-5" type="radio"
                                            name="theme-background" id="switcher-background4">
                                    </div>
                                    <div class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                        <div class="theme-container-background"></div>
                                        <div class="pickr-container-background"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-image mb-3">
                                <p class="switcher-style-head">Menú con Imagen de Fondo:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img1" type="radio"
                                            name="theme-background" id="switcher-bg-img" checked>
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img2" type="radio"
                                            name="theme-background" id="switcher-bg-img1">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img3" type="radio" name="theme-background"
                                            id="switcher-bg-img2">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img4" type="radio"
                                            name="theme-background" id="switcher-bg-img3">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img5" type="radio"
                                            name="theme-background" id="switcher-bg-img4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between canvas-footer">
                        <a href="#" class="btn btn-primary">Comprar Ahora</a>
                        <a href="https://themeforest.net/user/spruko/portfolio" class="btn btn-secondary">Nuestro Portafolio</a>
                        <a href="javascript:void(0);" id="reset-all" class="btn btn-danger">Restablecer</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Switcher -->
        <div class="square-box">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
                    <div class="card-sigin">
                        <!-- Contenido de Demostración-->
                        <div class="main-card-signin d-md-flex">
                            <div class="wd-100p">
                                <div class="d-flex mb-4"><a href="index.html"><img src="../assets/images/brand-logos/toggle-logo.png" class="sign-favicon ht-40" alt="logo"></a></div>
                                <div class="">
                                    <div class="main-signup-header">
                                        <h2>¡Bienvenido de nuevo!</h2>
                                        <h6 class="font-weight-semibold mb-4">Por favor, inicia sesión para continuar.</h6>
                                        <div class="panel panel-primary">
                                            <div class=" tab-menu-heading mb-2 border-bottom-0">
                                                <div class="tabs-menu1">
                                                    <ul class="nav panel-tabs">
                                                        <li class="me-2"><a href="#tab5" class="active" data-bs-toggle="tab">Correo Electrónico</a></li>
                                                        <li><a href="#tab6" data-bs-toggle="tab" class="">Número de Móvil</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body border-0 p-3">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab5">
                                                        <form method="POST" action="{{ route('login') }}">
                                                            @csrf


                                                            <div class="form-group">
                                                                <label>Correo Electrónico</label> 
                                                                <input class="form-control" 
                                                                            placeholder="Ingresa tu correo electrónico" 
                                                                            type="email" 
                                                                            name="email" :value="old('email')" 
                                                                            required autofocus autocomplete="username">
                                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Contraseña</label> 
                                                                {{-- <input class="form-control" placeholder="Ingresa tu contraseña" type="password"> --}}
                                                                <input class="form-control"
                                                                        type="password"
                                                                        name="password"
                                                                        id="password"
                                                                        placeholder="Ingresa tu contraseña"
                                                                        required autocomplete="current-password">
                                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />                                                                        
                                                            </div>
                                                            <x-primary-button class="btn btn-primary btn-block">
                                                                {{ __('Iniciar sesión') }}
                                                            </x-primary-button>                                                            
                                                            <div class="mt-4 d-flex text-center justify-content-center mb-2">
                                                                <a href="javascript:void(0);" class="btn btn-icon me-3">
                                                                <span class="btn-inner--icon"> <i class="bx bxl-facebook fs-18 tx-prime"></i> </span>
                                                                </a>
                                                                <a href="javascript:void(0);" class="btn btn-icon me-3">
                                                                <span class="btn-inner--icon"> <i class="bx bxl-twitter fs-18 tx-prime"></i> </span>
                                                                </a>
                                                                <a href="javascript:void(0);" class="btn btn-icon me-3">
                                                                <span class="btn-inner--icon"> <i class="bx bxl-linkedin fs-18 tx-prime"></i> </span>
                                                                </a>
                                                                <a href="javascript:void(0);" class="btn  btn-icon me-3">
                                                                <span class="btn-inner--icon"> <i class="bx bxl-instagram fs-18 tx-prime"></i> </span>
                                                                </a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane" id="tab6">
                                                        <div id="mobile-num" class="wrap-input100 validate-input input-group mb-2">
                                                            <a href="javascript:void(0);" class="input-group-text bg-white text-muted">
                                                            <span>+91</span>
                                                            </a>
                                                            <input class="input100 form-control" type="number" placeholder="número">
                                                        </div>
                                                        <span>Nota: Inicia sesión con el número de móvil registrado para generar el OTP.</span>
                                                        <div class="container-login100-form-btn mt-3">
                                                            <a href="javascript:void(0);" class="btn login100-form-btn btn-primary" id="generate-otp">
                                                            Proceder
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="main-signin-footer text-center mt-3">
                                            <p>
                                                @if (Route::has('password.request'))
                                                    <a class="mb-3" href="{{ route('password.request') }}">
                                                        {{ __('¿Olvidaste tu contraseña?') }}
                                                    </a>
                                                @endif
                                            </p>
                                            <p>¿No tienes una cuenta? <a href="register">Crear una cuenta</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap JS -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Mostrar Contraseña JS -->
        <script src="../assets/js/show-password.js"></script>
        <!-- Custom-Switcher JS -->
        <script src="../assets/js/custom-switcher.min.js"></script>
    </body>
</html>
