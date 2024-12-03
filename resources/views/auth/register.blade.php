<x-guest-layout>
    <style>
        .iti {
            width: 100%;
        }
    </style>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="phone" value="{{ __('Phone') }}" />
                <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number"
                    :value="old('phone_number')" required autocomplete="phone_number" />
                <input type="hidden" name="phone" id="phone" :value="old('phone')" />s
            </div>
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
    <div class="mt-4">
        <x-label for="phone_number" value="{{ __('Phone') }}" />

        <!-- Phone input field with country code selector -->
        <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')"
            required autocomplete="phone_number" />

        <!-- Hidden input to store the full phone number (including country code) -->
        <input type="hidden" name="phone" id="phone" :value="old('phone')" />
    </div>

    <!-- Add the JS script to handle phone number input and update hidden field -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone_number");
            var iti = intlTelInput(input, {
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Optional: For validation
            });

            // When the form is submitted, set the hidden input with the full phone number (including country code)
            document.querySelector("form").addEventListener("submit", function() {
                // Get the full phone number including country code and set it to the hidden input
                document.querySelector("#phone").value = iti.getNumber();
            });
        });
    </script>
    <div class="mt-4">
        <x-label for="phone_number" value="{{ __('Phone') }}" />

        <!-- Phone input field with country code selector -->
        <x-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')"
            required autocomplete="phone_number" />

        <!-- Hidden input to store the full phone number (including country code) -->
        <input type="hidden" name="phone" id="phone" :value="old('phone')" />
    </div>

    <!-- Add the JS script to handle phone number input and update hidden field -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone_number");
            var iti = intlTelInput(input, {
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Optional: For validation
            });

            document.querySelector("form").addEventListener("submit", function() {
                document.querySelector("#phone").value = iti.getNumber();
            });
        });
    </script>

</x-guest-layout>
