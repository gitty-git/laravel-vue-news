<x-guest-layout>
    <div class="h-screen flex justify-center items-center">
        <div class="xl:w-1/4 lg:w-1/3 md:w-2/3 w-full px-4">
            <header class="flex justify-center my-3 items-center">
                <a href="/" class="sm:text-5xl text-3xl uppercase font-logo font-light">News Demo</a>
            </header>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="block">
                    <label class="sans-bold text-sm" for="email" value="{{ __('Email') }}">Email</label>
                    <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>
                <button class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center">
                    {{ __('Email Password Reset Link') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
