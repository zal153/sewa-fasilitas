<header
    class="header px-4 sm:px-6 h-[calc(theme('spacing.header')_-_10px)] sm:h-header bg-white dark:bg-dark-card rounded-none xl:rounded-15 flex items-center mb-4 xl:m-4 group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_32px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_32px)] group-data-[sidebar-size=sm]:group-data-[theme-width=box]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[theme-width=box]:xl:mr-0 dk-theme-card-square z-10 ac-transition">
    <div class="flex-center-between grow">
        <!-- Header Left -->
        <div class="flex items-center gap-4">
            <div class="menu-hamburger-container flex-center">
                <button type="button" id="app-menu-hamburger" class="menu-hamburger hidden xl:block"></button>
                <button type="button" class="menu-hamburger block xl:hidden" data-drawer-target="app-menu-drawer"
                    data-drawer-show="app-menu-drawer" aria-controls="app-menu-drawer"></button>
            </div>
            <div class="w-56 md:w-72 leading-none text-sm relative text-gray-900 dark:text-dark-text hidden sm:block">
                <span class="absolute top-1/2 -translate-y-[40%] left-3.5">
                    <i class="ri-search-line text-gray-900 dark:text-dark-text text-[14px]"></i>
                </span>
                <input type="text" name="header-search" placeholder="Search..."
                    class="bg-transparent pl-[36px] pr-12 py-4 dk-border-one rounded-full w-full font-spline_sans focus:outline-none focus:border-primary-500 dk-theme-card-square dk-theme-card-square">
                <span
                    class="absolute top-1/2 -translate-y-[40%] right-4 hidden lg:flex lg:items-center lg:gap-0.5 select-none">
                    <i class="ri-command-line text-[12px]"></i><span>+</span><span>k</span>
                </span>
            </div>
        </div>
        <!-- Header Right -->
        <div class="flex items-center gap-1 sm:gap-3">
            <!-- Dark Light Button -->
            <button type="button"
                class="themeMode size-8 flex-center hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md"
                onclick="toggleThemeMode()">
                <i class="ri-contrast-2-line text-[22px] dark:text-dark-text-two dark:before:!content-['\f1bf']"></i>
            </button>
            <!-- Settings Button -->
            <button type="button" class="size-8 flex-center hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md"
                data-drawer-target="app-setting-drawer" data-drawer-show="app-setting-drawer"
                data-drawer-placement="right" aria-controls="app-setting-drawer">
                <i class="ri-settings-3-line text-[22px] dark:text-dark-text-two animate-spin-slow"></i>
            </button>
            <!-- Notification Button -->
            <div class="relative">
                <button type="button" data-popover-target="dropdownNotification" data-popover-trigger="click"
                    data-popover-placement="bottom-end"
                    class="relative size-8 flex-center hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md">
                    <i class="ri-notification-3-line text-[22px] dark:text-dark-text-two"></i>
                    <span
                        class="absolute -top-1 -right-1 size-4 rounded-50 flex-center bg-primary-500 leading-none text-xs text-white">0</span>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNotification"
                    class="!-right-full sm:!right-0 z-backdrop invisible w-[250px] sm:w-[320px] bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-dark-card-two dark:divide-dark-border-four">
                    <div
                        class="block px-4 py-2 font-medium text-center text-heading rounded-t-lg bg-gray-50 dark:bg-dark-card-shade dark:text-white">
                        Notifications
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-dark-border-four">
                        <a href="notification.html" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-dark-icon">
                            <div class="flex-shrink-0">
                                <img class="size-10 rounded-50" src="{{ asset('') }}assets/images/user/user-1.png"
                                    alt="user">
                            </div>
                            <div class="w-full ps-3">
                                <div class="text-gray-500 dark:text-gray-400 text-sm mb-1.5">New message from <span
                                        class="font-semibold text-gray-900 dark:text-white">Jese Leos</span>: "Hey,
                                    what's up? All set for the presentation?"</div>
                                <div class="text-xs text-blue-600 dark:text-blue-500">a few moments ago</div>
                            </div>
                        </a>
                        <a href="notification.html" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-dark-icon">
                            <div class="flex-shrink-0">
                                <img class="size-10 rounded-50" src="{{ asset('') }}assets/images/user/user-2.png"
                                    alt="user">
                            </div>
                            <div class="w-full ps-3">
                                <div class="text-gray-500 dark:text-gray-400 text-sm mb-1.5">New message from <span
                                        class="font-semibold text-gray-900 dark:text-white">Jese Leos</span>: "Hey,
                                    what's up? All set for the presentation?"</div>
                                <div class="text-xs text-blue-600 dark:text-blue-500">10 min ago</div>
                            </div>
                        </a>
                    </div>
                    <a href="notification.html"
                        class="flex-center py-2 text-sm font-medium text-center text-heading rounded-b-lg bg-gray-50 dark:bg-dark-card-shade dark:text-white">
                        View all
                    </a>
                </div>
            </div>
            <!-- Border -->
            <div
                class="w-[1px] h-[calc(theme('spacing.header')_-_10px)] sm:h-header bg-[#EEE] dark:bg-dark-border hidden sm:block">
            </div>
            <!-- User Profile Button -->
            <div class="relative">
                <button type="button" data-popover-target="dropdownProfile" data-popover-trigger="click"
                    data-popover-placement="bottom-end"
                    class="text-gray-500 dark:text-dark-text flex items-center gap-2 sm:pr-4 relative after:absolute after:right-0 after:font-remix after:content-['\ea4e'] after:text-[18px] after:hidden sm:after:block">
                    <img src="{{ asset('') }}assets/images/user/profile-img.png" alt="user-img"
                        class="size-7 sm:size-9 rounded-50 dk-theme-card-square">
                    <span
                        class="font-semibold leading-none text-lg capitalize hidden sm:block">#</span>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownProfile"
                    class="invisible z-backdrop bg-white text-left divide-y divide-gray-100 rounded-lg shadow w-48 dark:bg-dark-card-shade dark:divide-dark-border-four">
                    <div class="px-4 py-3 text-sm text-gray-500 dark:text-white">
                        <div class="font-medium ">#</div>
                        <div class="truncate">
                            <a href="mailto:#">
                                {{-- {{ auth()->user()->email }} --}}
                            </a>
                        </div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li>
                            <a href="index.html"
                                class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <a href="account-setting.html"
                                class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">Settings</a>
                        </li>
                    </ul>
                    <div class="py-2">
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="flex font-medium px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-dark-icon dark:text-gray-200 dark:hover:text-white">
                            Sign out
                        </a>

                        <form id="logout-form" action="#" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
