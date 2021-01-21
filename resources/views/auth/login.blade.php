<x-guest-layout>
    <div class="h-screen flex justify-center items-center">

        <div class="xl:w-1/4 lg:w-1/3 md:w-2/3 w-full px-4">
            <header class="flex justify-center my-3 items-center">
                <a href="/" class="sm:text-5xl text-3xl uppercase font-logo font-light">News Demo</a>
            </header>

            <div class="mb-4 w-full text-lg text-center">
                Login to your asdfasdfsadfasdf account. Don’t have one?&nbsp;<a href="register" class="duration-200 hover:text-gray-500 underline">Register</a>
            </div>

            <x-jet-validation-errors class="mb-4"/>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label class="sans-bold text-sm" for="email" value="{{ __('Email') }}">Email</label>
                    <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-4">
                    <label class="sans text-sm" for="password" value="{{ __('Password') }}">Password</label>
                    <input class="px-2 bg-gray-100 py-2 outline-none w-full mt-1" id="password" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex my-8 items-center justify-between">
                    <div class="block">
                        <label for="remember_me" class="flex hover:text-gray-500 duration-200 items-start">
                            <input id="remember_me" type="checkbox" class="bg-gray-100 form-checkbox" name="remember">
                            <span class="ml-2 outline-none sans text-sm">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="underline text-right text-sm text-gray-600 duration-200 hover:text-gray-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <button class="py-2 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
