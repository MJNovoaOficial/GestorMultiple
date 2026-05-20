<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" >
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- FOTO PERFIL --}}

        <div class="mb-6">

            <x-input-label
                for="profile_photo"
                value="Foto de perfil"
                class="
                    text-slate-700
                    dark:text-slate-300
                "
            />

            <div class="
                mt-3 flex items-center gap-4
            ">

                {{-- Preview actual --}}
                @if(auth()->user()->profile_photo)

                    <img
                        src="/storage/{{ auth()->user()->profile_photo }}"
                        alt="Foto perfil"

                        class="
                            w-16 h-16
                            rounded-full
                            object-cover
                            border border-slate-700
                        "
                    >

                @else

                    <div class="
                        w-16 h-16
                        rounded-full

                        bg-blue-600

                        flex items-center
                        justify-center

                        text-white
                        text-xl
                        font-bold
                    ">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>

                @endif

                {{-- Input --}}
                <input
                    type="file"
                    name="profile_photo"
                    id="profile_photo"

                    class="
                        block w-full text-sm
                        text-slate-400

                        file:mr-4
                        file:py-2
                        file:px-4

                        file:rounded-xl
                        file:border-0

                        file:text-sm
                        file:font-semibold

                        file:bg-blue-600
                        file:text-white

                        hover:file:bg-blue-700
                    "
                >

            </div>

        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="block mt-1 w-full md:w-2/3" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full md:w-2/3" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-600 dark:text-slate-400">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600 dark:text-slate-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
