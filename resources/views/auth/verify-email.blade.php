<x-guest-layout>
    <div class="h-screen flex justify-center items-center">
        <div class="xl:w-1/4 lg:w-1/3 md:w-2/3 w-full px-4">
            <header class="flex justify-center my-3 items-center">
                <a href="/" class="sm:text-5xl text-3xl uppercase font-logo font-light">News Demo</a>
            </header>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center" type="submit">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="py-2 mt-4 border hover:text-gray-900 text-gray-50 bg-gray-800 rounded border-gray-600 font-bold hover:bg-gray-50 duration-200 flex w-full justify-center">
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
