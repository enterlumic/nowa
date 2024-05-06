<section>
    <div class="main-content-body tab-pane p-0 border-0" id="edit">
        <div class="card">
            <div class="card-body border-0">
                <div class="mb-4 main-content-label">Actualiza contraseña</div>
                <form method="post" action="{{ route('password.update') }}" class="form-horizontal">
                    @csrf
                    @method('put')

                    <div class="mb-4 main-content-label">Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.</div>
                    <div class="form-group ">
                        <div class="row row-sm">
                            <div class="col-md-3">
                                <label class="form-label">Contraseña actual</label>
                            </div>
                            <div class="col-md-9">
                                <x-text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row row-sm">
                            <div class="col-md-3">
                                <label class="form-label">Nueva contraseña</label>
                            </div>
                            <div class="col-md-9">
                                <x-text-input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="row row-sm">
                            <div class="col-md-3">
                                <label class="form-label">confirmar Contraseña</label>
                            </div>
                            <div class="col-md-9">
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button  class="btn btn-primary btn-wave waves-effect waves-light">{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
