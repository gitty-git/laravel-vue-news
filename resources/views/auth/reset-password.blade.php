<x-guest-layout>
    <div class="h-screen flex justify-center items-center">
        <div class="xl:w-1/4 lg:w-1/3 md:w-2/3 w-full px-4">
            <header class="flex justify-center my-3 items-center">
                <a href="/" class="sm:text-5xl text-3xl uppercase font-logo font-light">News Demo</a>
            </header>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="block">
                    <label class="sans-bold text-sm" for="email" value="{{ __('Email') }}">Email</label>
                    <input id="email" class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                </div>

                <div class="mt-4">
                    <label class="sans-bold text-sm" for="password" value="{{ __('Password') }}">Password</label>
                    <input id="password" class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <label class="sans-bold text-sm" for="password_confirmation" value="{{ __('Confirm Password') }}">Confirm Password</label>
                    <input id="password_confirmation" cclass="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <button class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center">
                    {{ __('Reset Password') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
