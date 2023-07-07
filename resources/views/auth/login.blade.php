<x-app-layout>
    <x-slot name="header"></x-slot>
    <x-auth-card>
        <div class="d-flex justify-content-center align-items-center container ">

    <div class="row ">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="form-group">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="form-control"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="form-group">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="btn btn-primary">
                    {{ __('Log in') }}
                </x-button>
                
            </div>
            <div class="flex items-center justify-end mt-4">
                No Account ? <a href="{{ route('register') }}">Register</a>
            </div>
        </form>
    </div>
    </div>
    </div>
    </x-auth-card>
</x-guest-layout>
