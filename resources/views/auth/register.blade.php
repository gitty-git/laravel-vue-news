<x-guest-layout>
    <div class="h-screen flex justify-center items-center">

        <div class="xl:w-1/4 lg:w-1/3 md:w-2/3 w-full px-4">
            <header class="flex justify-center my-3 items-center">
                <a href="/" class="sm:text-5xl text-3xl uppercase font-logo font-light">News Demo</a>
            </header>

            <div class="mb-4 w-full text-lg text-center">
                Register a new account. Already have one?&nbsp;<a href="login" class="duration-200 hover:text-gray-500 underline">Login</a>
            </div>

            <x-jet-validation-errors class="mb-4"/>

            <form class="w-full" method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label class="sans-bold text-sm" for="name" value="{{ __('Name') }}">Name</label>
                    <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="name" type="text" name="name" :value="old('name')" required
                           autofocus autocomplete="name"/>
                </div>

                <div class="mt-4">
                    <label for="email" value="{{ __('Email') }}">Email</label>
                    <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="email" type="email"
                           name="email" :value="old('email')" required/>
                </div>

                <div class="mt-4">
                    <label for="password" value="{{ __('Password') }}">Password</label>
                    <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="password" type="password"
                           name="password" required autocomplete="new-password"/>
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" value="{{ __('Confirm Password') }}">Confirm Password</label>
                    <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="password_confirmation"
                           type="password" name="password_confirmation" required autocomplete="new-password"/>
                </div>

                <button class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center">
                    {{ __('Register') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
