<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('images/walletify-logo.png') }}" alt="logo" style="margin-top:0px">
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h1 style="font-size: 25px;font-weight: 600;">Login</h1><br>

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-1" 
                        style="float: right;" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
                
                <button style="background-color: #5FA7FB;color:black;width: 400px; height:42px" class="rounded-md mt-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Login') }}
                </button>
            </div>
            
            <div style="text-align: center" class="mt-4">
                <p style="font-size: 14px">
                    Don't have an account? 
                    <a class="underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">{{ __('Register') }}</a>
                </p>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
