@include('user.layouts.style')
@section('title', 'Login')

<div class="flex flex-col items-center justify-center h-screen px-4">
    <!-- Card -->
    <div class="w-full max-w-md bg-white rounded-md shadow p-6 sm:p-8">
        <!-- Logo dan Info -->
        <div class="mb-4 text-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('asset/images/brand/logo/logo_unibamadura.png') }}" class="mb-1 mx-auto" alt="Logo" />
            </a>
            <p class="text-gray-600">Silahkan Login Terlebih Dahulu</p>
        </div>

        <!-- Form -->
      <form method="POST" action="{{ route('user.login') }}">

            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-800 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full p-2 px-3 border border-gray-300 text-gray-900 rounded-md focus:ring-indigo-600 focus:border-indigo-600"
                    placeholder="Email" required autofocus>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-800 font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full p-2 px-3 border border-gray-300 text-gray-900 rounded-md focus:ring-indigo-600 focus:border-indigo-600"
                    placeholder="Password" required>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input type="checkbox" name="remember" id="remember"
                    class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600">
                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    Sign in
                </button>
            </div>

            <!-- Links -->
            <div class="flex justify-between text-sm">
                <a href="#" class="text-indigo-600 hover:underline">Create an account</a>
                <a href="#" class="text-indigo-600 hover:underline">Forgot password?</a>
            </div>
        </form>
    </div>
</div>

@include('user.layouts.script')
