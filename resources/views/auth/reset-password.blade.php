<x-guest-layout>
    <div class="cover-image forgot-page">
        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main py-4 justify-content-center mx-auto">
                    <div class="card-sigin">
                        <!-- Demo content-->
                        <div class="main-card-signin d-md-flex">
                            <div class="wd-100p">
                                <div class="d-flex mb-3">
                                    <a href="index.html"><img src="../assets/images/brand-logos/toggle-logo.png" class="sign-favicon ht-40" alt="logo"></a>
                                </div>
                                <div class="mb-1">
                                    <div class="main-signin-header">
                                        <div class="">
                                            <h2>¡Bienvenido de nuevo!</h2>
                                            <h4 class="text-start">Restablece tu contraseña</h4>
                                            <form method="POST" action="{{ route('password.store') }}">
                                                @csrf

                                                <!-- Password Reset Token -->
                                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                                <!-- Email Address -->
                                                <div class="form-group text-start">
                                                    <label for="email">Correo Electrónico</label>
                                                    <input id="email" class="form-control" placeholder="Ingresa tu correo electrónico" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username">
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>

                                                <!-- Password -->
                                                <div class="form-group text-start mt-4">
                                                    <label for="password">Nueva Contraseña</label>
                                                    <input id="password" class="form-control" placeholder="Ingresa tu nueva contraseña" type="password" name="password" required autocomplete="new-password">
                                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                </div>

                                                <!-- Confirm Password -->
                                                <div class="form-group text-start mt-4">
                                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                                    <input id="password_confirmation" class="form-control" placeholder="Confirma tu nueva contraseña" type="password" name="password_confirmation" required autocomplete="new-password">
                                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                                </div>

                                                <div class="flex items-center justify-end mt-4">
                                                    <button type="submit" class="btn ripple btn-primary btn-block">
                                                        Restablecer Contraseña
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="mt-4 d-flex text-center justify-content-center">
                                                <a href="javascript:void(0);" class="btn btn-icon me-2">
                                                    <span class="btn-inner--icon"> <i class="bx bxl-facebook tx-18 tx-prime"></i> </span>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-icon me-2">
                                                    <span class="btn-inner--icon"> <i class="bx bxl-twitter tx-18 tx-prime"></i> </span>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-icon me-2">
                                                    <span class="btn-inner--icon"> <i class="bx bxl-linkedin tx-18 tx-prime"></i> </span>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-icon me-2">
                                                    <span class="btn-inner--icon"> <i class="bx bxl-instagram tx-18 tx-prime"></i> </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-signup-footer mt-3 text-center">
                                        <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
