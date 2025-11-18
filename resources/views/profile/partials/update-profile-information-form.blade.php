<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
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
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="nim" value="NIM" />
                <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', optional($user->mahasiswa)->nim)" />
                <x-input-error class="mt-2" :messages="$errors->get('nim')" />
            </div>
            <div>
                <x-input-label for="angkatan" value="Angkatan" />
                <x-text-input id="angkatan" name="angkatan" type="number" class="mt-1 block w-full" :value="old('angkatan', optional($user->mahasiswa)->angkatan)" />
                <x-input-error class="mt-2" :messages="$errors->get('angkatan')" />
            </div>
        </div>

        <div>
            <x-input-label for="ipk" value="IPK (gunakan titik atau koma)" />
            <x-text-input id="ipk" name="ipk" type="text" class="mt-1 block w-full" :value="old('ipk', optional($user->mahasiswa)->ipk)" />
            <x-input-error class="mt-2" :messages="$errors->get('ipk')" />
        </div>

        <div>
            <x-input-label for="prestasi_akademik" value="Prestasi Akademik" />
            <textarea id="prestasi_akademik" name="prestasi_akademik" rows="3" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('prestasi_akademik', optional($user->mahasiswa)->prestasi_akademik) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('prestasi_akademik')" />
        </div>

        <div>
            <x-input-label for="prestasi_non_akademik" value="Prestasi Non Akademik" />
            <textarea id="prestasi_non_akademik" name="prestasi_non_akademik" rows="3" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('prestasi_non_akademik', optional($user->mahasiswa)->prestasi_non_akademik) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('prestasi_non_akademik')" />
        </div>

        <div>
            <x-input-label for="pengalaman_si" value="Pengalaman di Bidang Sistem Informasi" />
            <textarea id="pengalaman_si" name="pengalaman_si" rows="3" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('pengalaman_si', optional($user->mahasiswa)->pengalaman_si) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('pengalaman_si')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
</section>
