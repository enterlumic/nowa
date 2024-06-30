<x-guest-layout>
    <div class="cover-image forgot-page">
        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main py-4 justify-content-center mx-auto">
                    <div class="card-sigin">
                        <!-- Demo content-->
                        <div class="main-card-signin d-md-flex">
                            <div class="wd-100p">
                                <div class="mb-3 d-flex">
                                    <a href="index.html">
                                        <img src="../assets/images/brand-logos/toggle-logo.png" class="sign-favicon ht-40" alt="logo">
                                    </a>
                                </div>
                                <div class="main-card-signin d-md-flex bg-white">
                                    <div class="wd-100p">
                                        <div class="main-signin-header">
                                            <h2>¡Olvidaste tu Contraseña!</h2>
                                            <h4>Por favor, ingresa tu correo electrónico</h4>
                                            <div class="mb-4 text-sm text-gray-600">
                                                {{ __('¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña, que te permitirá elegir una nueva.') }}
                                            </div>
                                            <!-- Session Status -->
                                            <x-auth-session-status class="mb-4" :status="session('status')" />
                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf
                                                <!-- Email Address -->
                                                <div class="form-group">
                                                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                                                    <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>
                                                <div class="flex items-center justify-end mt-4">
                                                    <x-primary-button>
                                                        {{ __('Enviar Enlace de Restablecimiento de Contraseña') }}
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="main-signup-footer mg-t-20 text-center">
                                            <p>Olvídalo, <a href="{{ route('login') }}">envíame de vuelta</a> a la pantalla de inicio de sesión.</p>
                                        </div>
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
