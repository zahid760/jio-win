<x-guest-layout>
@section('title')
    {!! 'Create New Account' !!}
@endsection
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <!-- <x-input-label for="name" :value="__('Name')" /> -->
            <x-text-input id="name" class="block mt-1 p-2 w-full bg-gray-100 shadow-md border-transparent" type="text" name="name" :value="old('name')" placeholder="Enter Name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <!-- <x-input-label for="email" :value="__('Email')" /> -->
            <x-text-input id="mobile" class="block mt-1 p-2 w-full bg-gray-100 shadow-md border-transparent" type="tel" name="mobile" :value="old('mobile')" placeholder="Enter Mobile No." required autocomplete="username" />
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <!-- <x-input-label for="password" :value="__('Password')" /> -->

            <x-text-input id="password" class="block mt-1 p-2 w-full bg-gray-100 shadow-md border-transparent"
                            type="password"
                            name="password"
                            placeholder="Enter Password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <!-- <x-input-label for="password_confirmation" :value="__('Confirm Password')" /> -->

            <x-text-input id="password_confirmation" class="block mt-1 p-2 w-full bg-gray-100 shadow-md border-transparent"
                            type="password"
                            name="password_confirmation" placeholder="Enter Confirm Password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <input type="text" name="source" class="hidden" value="customer">
        <input type="hidden" name="referral_code" value="{{ $referralCode ?? '' }}">

        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="bg-red-600">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <div class="flex items-center justify-center mt-4">
            <a class="text-sm text-blue-500 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered Sign In') }}
            </a>
        </div>
    </form>
</x-guest-layout>
