@include('admin.layouts.style')

<div id="loader" class="w-screen h-screen flex-center bg-white dark:bg-dark-card fixed inset-0 z-[9999]">
    <img src="{{ asset('assets/pre-loader/bar-loader.gif') }}" alt="loader">
</div>

<div class="main-content m-4">
    <div
        class="grid grid-cols-12 gap-y-7 sm:gap-7 card px-4 sm:px-10 2xl:px-[70px] py-15 lg:items-center lg:min-h-[calc(100vh_-_32px)]">
        <!-- Left Overview -->
        <div class="col-span-full lg:col-span-6">
            <div class="flex flex-col items-center justify-center gap-10 text-center">
                <div class="hidden sm:block">
                    <img src="{{ asset('assets/images/loti/loti-auth.svg') }}" alt="loti"
                        class="group-[.dark]:hidden">
                    <img src="{{ asset('assets/images/loti/loti-auth-dark.svg') }}" alt="loti"
                        class="group-[.light]:hidden">
                </div>
                <div>
                    <h3 class="text-xl md:text-[28px] font-semibold text-heading">Welcome back!</h3>
                    <p class="font-medium text-gray-500 dark:text-dark-text mt-4 px-[10%]">
                        Whether you're launching a stunning online store or optimizing your experience.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Form -->
        <div class="col-span-full lg:col-span-6 w-full lg:max-w-[600px]">
            <div
                class="border border-form dark:border-dark-border p-5 md:p-10 rounded-20 md:rounded-30 dk-theme-card-square">
                <h3 class="text-xl md:text-[28px] font-semibold text-heading">Sign In</h3>
                <p class="font-medium text-gray-500 dark:text-dark-text mt-4">Welcome Back! Log in to your account</p>

                @if ($errors->any())
                    <div class="mt-4 text-red-600">
                        <ul class="text-sm">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}" class="leading-none mt-8">
                    @csrf
                    <div class="mb-2.5">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" placeholder="debra.holt@example.com"
                            required class="form-input px-4 py-3.5 rounded-lg" value="{{ old('email') }}">
                    </div>

                    <div class="mt-5">
                        <label for="password" class="form-label">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Password" required
                                class="form-input px-4 py-3.5 rounded-lg">
                            <label for="toggleInputType"
                                class="size-8 rounded-md flex-center hover:bg-gray-200 dark:hover:bg-dark-icon position-center !left-auto -right-2.5">
                                <input type="checkbox" id="toggleInputType" class="inputTypeToggle peer/it" hidden>
                                <i
                                    class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-3 mb-7">
                        <div class="flex items-center gap-1 select-none">
                            <input type="checkbox" name="remember" id="rememberMe">
                            <label for="rememberMe"
                                class="text-sm leading-none text-gray-900 dark:text-dark-text cursor-pointer">Remember
                                Me</label>
                        </div>
                        {{-- Tambahkan route jika nanti punya halaman lupa password --}}
                        <a href="#" class="text-xs text-primary-500 font-semibold">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn b-solid btn-primary-solid w-full dk-theme-card-square">Sign
                        In</button>
                </form>
                <div class="text-gray-900 dark:text-dark-text font-medium mt-5">
                    Don’t have an account yet?
                    <a href="#" class="text-primary-500 font-semibold">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.layouts.script')
