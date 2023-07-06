<x-app-layout>
    <x-slot name="header"></x-slot>
    <x-auth-card>
        <!-- Validation Errors -->
         <div class="d-flex justify-content-center align-items-center container ">

    <div class="row ">

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <x-label for="first_name" :value="__('First Name')" />

                <x-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')" required autofocus />
            </div>

            <!-- Name -->
            <div class="form-group">
                <x-label for="last_name" :value="__('Last Name')" />

                <x-input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name')" autofocus />
            </div>

            <!-- Email Address -->
           <div class="form-group">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="form-group">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="form-control"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="form-control"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="btn btn-primary">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </div>
    </div>
    </x-auth-card>
</x-guest-layout>
