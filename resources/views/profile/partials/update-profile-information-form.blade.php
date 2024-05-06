<section>
    <div class="main-content-body tab-pane p-0 border-0" id="edit">
        <div class="card">
            <div class="card-body border-0">
                <div class="mb-4 main-content-label">INFORMACION PERSONAL</div>
                <form method="post" action="{{ route('profile.update') }}" class="form-horizontal">
                    @csrf
                    @method('patch')

                    <div class="form-group ">
                        <div class="row row-sm">
                            <div class="col-md-3">
                                <label class="form-label">User Name</label>
                            </div>
                            <div class="col-md-9">
                                <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">

                        <div class="row row-sm">
                            <div class="col-md-3">
                                <label class="form-label">Email</label>
                            </div>
                            <div class="col-md-9">

                                <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />

                            </div>
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        <div class="flex items-center gap-4">
                            <x-primary-button class="btn btn-primary btn-wave waves-effect waves-light">{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

</section>
