<x-guest-layout>
    <div class="h-screen flex justify-center items-center">
        <div class="xl:w-1/4 lg:w-1/3 md:w-2/3 w-full px-4">
            <header class="flex justify-center my-3 items-center">
                <a href="/" class="sm:text-5xl text-3xl uppercase font-logo font-light">News Demo</a>
            </header>

            <div x-data="{ recovery: false }">
                <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                </div>

                <div class="mb-4 text-sm text-gray-600" x-show="recovery">
                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                </div>

                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="/two-factor-challenge">
                    @csrf

                    <div class="mt-4" x-show="! recovery">
                        <label class="sans-bold text-sm" for="code" value="{{ __('Code') }}">Code</label>
                        <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="code" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                    </div>

                    <div class="mt-4" x-show="recovery">
                        <label class="sans-bold text-sm" for="recovery_code" value="{{ __('Recovery Code') }}">Recovery Code</label>
                        <input class="px-2 bg-gray-100 py-2 sans outline-none w-full mt-1" id="recovery_code" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                    </div>

                    <div class="flex justify-between mt-4">
                        <button type="button" class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center"
                                x-show="! recovery"
                                x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                            {{ __('Use a recovery code') }}
                        </button>

                        <button type="button" class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center"
                                x-show="recovery"
                                x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                            {{ __('Use an authentication code') }}
                        </button>

                        <button class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
