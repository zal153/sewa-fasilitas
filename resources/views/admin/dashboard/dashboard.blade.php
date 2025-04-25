@extends('admin.layouts.admin')
@section('title', 'Dashboard')
@section('contentAdmin')
    <div
        class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        <div class="grid grid-cols-12 gap-x-4">
            <!-- Start Intro -->
            <div class="col-span-full 2xl:col-span-7 card p-0">
                <div class="grid grid-cols-12 px-5 sm:px-12 py-11 relative overflow-hidden h-full">
                    <div class="col-span-full md:col-span-7 self-center inline-flex flex-col 2xl:block">
                        <p class="!leading-none text-sm lg:text-base text-gray-900 dark:text-dark-text">
                            Today is <span class="today">{{ now()->format('l, d M Y') }}</span>
                        </p>
                        <h1 class="text-heading text-4xl xl:text-[42px] leading-[1.23] font-semibold mt-3">
                            <span class="flex items-center justify-start">
                                <span class="shrink-0">Welcome Back.</span>
                                <span
                                    class="select-none hidden md:inline-block animate-hand-wave origin-[70%_70%]">👋</span><br>
                            </span>
                            {{ auth()->user()->name }}
                        </h1>
                        {{-- <a href="#" class="btn b-solid btn-primary-solid btn-lg mt-6 dk-theme-card-square">
                            <i class="ri-add-line text-inherit"></i>
                            Add new course
                        </a> --}}
                    </div>
                    <div class="col-span-full md:col-span-5 flex-col items-center justify-center 2xl:block hidden md:flex">
                        <img src="{{ asset('') }}assets/images/loti/loti-admin-dashboard.svg" alt="online-workshop"
                            class="group-[.dark]:hidden">
                        <img src="{{ asset('') }}assets/images/loti/loti-admin-dashboard-dark.svg" alt="online-workshop"
                            class="group-[.light]:hidden">
                    </div>
                    <!-- Graphicla Elements -->
                    <ul>
                        <li class="absolute -top-[30px] left-1/2 animate-spin-slow">
                            <img src="{{ asset('') }}assets/images/element/graphical-element-1.svg" alt="element">
                        </li>
                        <li class="absolute -bottom-[24px] left-1/4 animate-spin-slow">
                            <img src="{{ asset('') }}assets/images/element/graphical-element-2.svg" alt="element">
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Intro -->
            <!-- Start Short Progress Card -->
            <div class="col-span-full 2xl:col-span-5 card">
                <div class="grid grid-cols-12 gap-4">
                    <!-- Total Revenue Progress Card -->
                    <div
                        class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Total revenue</h6>
                            <div
                                class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">
                                30 Days</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="card-title">
                                        $<span class="counter-value" data-value="30000">0</span>
                                    </div>
                                    <div class="flex-center text-primary-500 size-5 rounded-50 border border-primary-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                                            viewBox="0 0 6 6" fill="none">
                                            <path
                                                d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z"
                                                fill="currentColor" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="leading-none text-gray-900 dark:text-dark-text font-semibold">
                                    <span class="text-primary-500">09%</span>
                                    Below Target
                                </div>
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="admin-total-revenue-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Enrollments Progress Card -->
                    <div
                        class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Total enrollments</h6>
                            <div
                                class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">
                                30 Days</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="counter-value card-title" data-value="21000">0</div>
                                    <div class="flex-center text-danger size-5 rounded-50 border border-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                                            viewBox="0 0 6 6" fill="none">
                                            <path
                                                d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z"
                                                fill="currentColor" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="leading-none text-gray-900 dark:text-dark-text font-semibold">
                                    <span class="text-danger">05%</span>
                                    Below Target
                                </div>
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="total-enrollment-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Courses Progress Card -->
                    <div
                        class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Total courses</h6>
                            <div
                                class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">
                                30 Days</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="counter-value card-title" data-value="25000">0</div>
                                    <div class="flex-center text-primary-500 size-5 rounded-50 border border-primary-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                                            viewBox="0 0 6 6" fill="none">
                                            <path
                                                d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z"
                                                fill="currentColor" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="leading-none text-gray-900 dark:text-dark-text font-semibold">
                                    <span class="text-primary-500">50%</span>
                                    Below Target
                                </div>
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="total-course-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Average rating Progress Card -->
                    <div
                        class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Average rating</h6>
                            <div
                                class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">
                                30 Days</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="counter-value card-title" data-value="4.5">0</div>
                                    <div class="flex-center text-primary-500 size-5 rounded-50 border border-primary-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                                            viewBox="0 0 6 6" fill="none">
                                            <path
                                                d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z"
                                                fill="currentColor" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="leading-none text-gray-900 dark:text-dark-text font-semibold">
                                    <span class="text-primary-500">05%</span>
                                    Below Target
                                </div>
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="average-rating-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Short Progress Card -->
            <!-- Start Average Enrollment Rate Chart -->
            <div class="col-span-full 2xl:col-span-8 card">
                <div class="flex-center-between">
                    <h6 class="card-title">Average enrollment rate</h6>
                    <select class="form-input form-select">
                        <option value="this-month">This Month</option>
                        <option value="last-year">Last Year</option>
                        <option value="last-month">Last Month</option>
                        <option value="last-week">Last Week</option>
                    </select>
                </div>
                <div id="average-enrollment-chart"></div>
            </div>
            <!-- End Average Enrollment Rate Chart -->
            <!-- Start Top Performing Course -->
            <div class="col-span-full 2xl:col-span-4 card">
                <div class="flex-center-between">
                    <h6 class="card-title">Top performing courses</h6>
                    <a href="#" class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square">See all</a>
                </div>
                <!-- Course Table -->
                <div class="overflow-x-auto scrollbar-table">
                    <table
                        class="table-auto w-full whitespace-nowrap text-left text-xs text-gray-500 dark:text-dark-text font-semibold leading-none">
                        <thead class="border-b border-dashed border-gray-900/60 dark:border-dark-border-three">
                            <tr>
                                <th class="px-3.5 py-4">Course</th>
                                <th class="px-3.5 py-4">Publish on</th>
                                <th class="px-3.5 py-4">Enrolled</th>
                                <th class="px-3.5 py-4">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dashed divide-gray-900/60 dark:divide-dark-border-three">
                            <tr>
                                <td class="flex items-center gap-2 px-3.5 py-4">
                                    <a href="#" class="size-10 rounded-50 overflow-hidden dk-theme-card-square">
                                        <img src="{{ asset('') }}assets/images/admin/top-course/top-course-1.png"
                                            alt="thumb">
                                    </a>
                                    <div>
                                        <h6 class="text-heading font-semibold mb-1.5 line-clamp-1">
                                            <a href="#">Figma - UI/UX Design...</a>
                                        </h6>
                                        <p class="font-normal">Author - Jane Howard</p>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">01 Jan 2024</td>
                                <td class="px-3.5 py-4">5.5k</td>
                                <td class="px-3.5 py-4">$19.00</td>
                            </tr>
                            <tr>
                                <td class="flex items-center gap-2 px-3.5 py-4">
                                    <a href="#" class="size-10 rounded-50 overflow-hidden dk-theme-card-square">
                                        <img src="{{ asset('') }}assets/images/admin/top-course/top-course-2.png"
                                            alt="thumb">
                                    </a>
                                    <div>
                                        <h6 class="text-heading font-semibold mb-1.5 line-clamp-1">
                                            <a href="#">Advance Web Design...</a>
                                        </h6>
                                        <p class="font-normal">Author - Jane Howard</p>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">01 Jan 2024</td>
                                <td class="px-3.5 py-4">5.5k</td>
                                <td class="px-3.5 py-4">$19.00</td>
                            </tr>
                            <tr>
                                <td class="flex items-center gap-2 px-3.5 py-4">
                                    <a href="#" class="size-10 rounded-50 overflow-hidden dk-theme-card-square">
                                        <img src="{{ asset('') }}assets/images/admin/top-course/top-course-3.png"
                                            alt="thumb">
                                    </a>
                                    <div>
                                        <h6 class="text-heading font-semibold mb-1.5 line-clamp-1">
                                            <a href="#">PhP, JavaScript advance...</a>
                                        </h6>
                                        <p class="font-normal">Author - Jane Howard</p>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">01 Jan 2024</td>
                                <td class="px-3.5 py-4">5.5k</td>
                                <td class="px-3.5 py-4">$19.00</td>
                            </tr>
                            <tr>
                                <td class="flex items-center gap-2 px-3.5 py-4">
                                    <a href="#" class="size-10 rounded-50 overflow-hidden dk-theme-card-square">
                                        <img src="{{ asset('') }}assets/images/admin/top-course/top-course-4.png"
                                            alt="thumb">
                                    </a>
                                    <div>
                                        <h6 class="text-heading font-semibold mb-1.5 line-clamp-1">
                                            <a href="#">Digital marketing base...</a>
                                        </h6>
                                        <p class="font-normal">Author - Jane Howard</p>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">01 Jan 2024</td>
                                <td class="px-3.5 py-4">5.5k</td>
                                <td class="px-3.5 py-4">$19.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Top Performing Course -->
            <!-- Start Trending Category -->
            <div class="col-span-full lg:col-span-6 2xl:col-span-4 card px-0 order-2 2xl:order-none">
                <div class="flex-center-between px-6 mb-7">
                    <h6 class="card-title">Trending categories</h6>
                    <div
                        class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">
                        30 Days</div>
                </div>
                <div class="max-h-[350px] smooth-scrollbar" data-scrollbar>
                    <ul
                        class="divide-y divide-gray-200 dark:divide-dark-border-three space-y-5 *:pt-5 overflow-hidden px-6">
                        <li class="flex-center-between first:pt-0">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="size-12 rounded-50 bg-primary-200 dark:bg-dark-icon flex-center flex-shrink-0 dk-theme-card-square">
                                    <img src="{{ asset('') }}assets/images/icons/category/graphic-design.svg"
                                        alt="icon">
                                </div>
                                <div>
                                    <h6 class="leading-none text-heading font-semibold mb-2 line-clamp-1">
                                        <a href="#" class="truncate">Graphic Design</a>
                                    </h6>
                                    <p class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold">90+
                                        Courses</p>
                                </div>
                            </div>
                            <div class="ms-auto mr-5">
                                <div id="category-one"></div>
                            </div>
                            <a href="#"
                                class="flex-center size-6 rounded-md bg-primary-200 dark:bg-dark-icon shrink-0">
                                <i class="ri-arrow-right-line text-gray-500 dark:text-dark-text text-[14px]"></i>
                            </a>
                        </li>
                        <li class="flex-center-between first:pt-0">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="size-12 rounded-50 bg-primary-200 dark:bg-dark-icon flex-center flex-shrink-0 dk-theme-card-square">
                                    <img src="{{ asset('') }}assets/images/icons/category/ui-ux.svg" alt="icon">
                                </div>
                                <div>
                                    <h6 class="leading-none text-heading font-semibold mb-2 line-clamp-1">
                                        <a href="#" class="truncate">UI/UX Design</a>
                                    </h6>
                                    <p class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold">90+
                                        Courses</p>
                                </div>
                            </div>
                            <div class="ms-auto mr-5">
                                <div id="category-two"></div>
                            </div>
                            <a href="#"
                                class="flex-center size-6 rounded-md bg-primary-200 dark:bg-dark-icon shrink-0">
                                <i class="ri-arrow-right-line text-gray-500 dark:text-dark-text text-[14px]"></i>
                            </a>
                        </li>
                        <li class="flex-center-between first:pt-0">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="size-12 rounded-50 bg-primary-200 dark:bg-dark-icon flex-center flex-shrink-0 dk-theme-card-square">
                                    <img src="{{ asset('') }}assets/images/icons/category/web-dev.svg"
                                        alt="icon">
                                </div>
                                <div>
                                    <h6 class="leading-none text-heading font-semibold mb-2 line-clamp-1">
                                        <a href="#" class="truncate">Web Development</a>
                                    </h6>
                                    <p class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold">90+
                                        Courses</p>
                                </div>
                            </div>
                            <div class="ms-auto mr-5">
                                <div id="category-three"></div>
                            </div>
                            <a href="#"
                                class="flex-center size-6 rounded-md bg-primary-200 dark:bg-dark-icon shrink-0">
                                <i class="ri-arrow-right-line text-gray-500 dark:text-dark-text text-[14px]"></i>
                            </a>
                        </li>
                        <li class="flex-center-between first:pt-0">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="size-12 rounded-50 bg-primary-200 dark:bg-dark-icon flex-center flex-shrink-0 dk-theme-card-square">
                                    <img src="{{ asset('') }}assets/images/icons/category/digital-mar.svg"
                                        alt="icon">
                                </div>
                                <div>
                                    <h6 class="leading-none text-heading font-semibold mb-2 line-clamp-1">
                                        <a href="#" class="truncate">Digital Marketing</a>
                                    </h6>
                                    <p class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold">90+
                                        Courses</p>
                                </div>
                            </div>
                            <div class="ms-auto mr-5">
                                <div id="category-four"></div>
                            </div>
                            <a href="#"
                                class="flex-center size-6 rounded-md bg-primary-200 dark:bg-dark-icon shrink-0">
                                <i class="ri-arrow-right-line text-gray-500 dark:text-dark-text text-[14px]"></i>
                            </a>
                        </li>
                        <li class="flex-center-between first:pt-0">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="size-12 rounded-50 bg-primary-200 dark:bg-dark-icon flex-center flex-shrink-0 dk-theme-card-square">
                                    <img src="{{ asset('') }}assets/images/icons/category/bus-dev.svg"
                                        alt="icon">
                                </div>
                                <div>
                                    <h6 class="leading-none text-heading font-semibold mb-2 line-clamp-1">
                                        <a href="#" class="truncate">Business Dev...</a>
                                    </h6>
                                    <p class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold">90+
                                        Courses</p>
                                </div>
                            </div>
                            <div class="ms-auto mr-5">
                                <div id="category-five"></div>
                            </div>
                            <a href="#"
                                class="flex-center size-6 rounded-md bg-primary-200 dark:bg-dark-icon shrink-0">
                                <i class="ri-arrow-right-line text-gray-500 dark:text-dark-text text-[14px]"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Trending Category -->
            <!-- Start Learn Activity Chart -->
            <div class="col-span-full 2xl:col-span-5 card">
                <div class="flex-center-between">
                    <h6 class="card-title">Learn activity</h6>
                    <div
                        class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">
                        30 Days</div>
                </div>
                <div id="learn-activity-chart" class="min-h-80"></div>
            </div>
            <!-- End Learn Activity Chart -->
            <!-- Start Support -->
            <div class="col-span-full lg:col-span-6 2xl:col-span-3 card px-0 order-3 2xl:order-none">
                <div class="flex-center-between px-6 mb-7">
                    <h6 class="card-title">Support requests</h6>
                    <a href="#" class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square">See all</a>
                </div>
                <div class="max-h-[350px] smooth-scrollbar" data-scrollbar>
                    <ul
                        class="divide-y divide-gray-200 dark:divide-dark-border-three space-y-5 *:pt-5 overflow-hidden px-6">
                        <li class="flex items-center gap-2.5 first:pt-0">
                            <a href="#"
                                class="size-12 rounded-50 flex-shrink-0 overflow-hidden dk-theme-card-square">
                                <img src="{{ asset('') }}assets/images/user/user-1.png" alt="user">
                            </a>
                            <div>
                                <div class="leading-none text-xs text-gray-500 dark:text-dark-text-two mb-1">10 : 00 pm
                                </div>
                                <h6 class="leading-none text-lg text-heading font-semibold mb-2">
                                    <a href="#">Jenny Wilson</a>
                                </h6>
                                <p
                                    class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold line-clamp-1">
                                    Duis at consectetur lorem donec massa consectetur lorem donec...</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5 first:pt-0">
                            <a href="#"
                                class="size-12 rounded-50 flex-shrink-0 overflow-hidden dk-theme-card-square">
                                <img src="{{ asset('') }}assets/images/user/user-2.png" alt="user">
                            </a>
                            <div>
                                <div class="leading-none text-xs text-gray-500 dark:text-dark-text-two mb-1">10 : 00 pm
                                </div>
                                <h6 class="leading-none text-lg text-heading font-semibold mb-2">
                                    <a href="#">Robert Fox</a>
                                </h6>
                                <p
                                    class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold line-clamp-1">
                                    Duis at consectetur lorem donec massa consectetur lorem donec...</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5 first:pt-0">
                            <a href="#"
                                class="size-12 rounded-50 flex-shrink-0 overflow-hidden dk-theme-card-square">
                                <img src="{{ asset('') }}assets/images/user/user-3.png" alt="user">
                            </a>
                            <div>
                                <div class="leading-none text-xs text-gray-500 dark:text-dark-text-two mb-1">10 : 00 pm
                                </div>
                                <h6 class="leading-none text-lg text-heading font-semibold mb-2">
                                    <a href="#">Robert Fox</a>
                                </h6>
                                <p
                                    class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold line-clamp-1">
                                    Duis at consectetur lorem donec massa consectetur lorem donec...</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5 first:pt-0">
                            <a href="#"
                                class="size-12 rounded-50 flex-shrink-0 overflow-hidden dk-theme-card-square">
                                <img src="{{ asset('') }}assets/images/user/user-4.png" alt="user">
                            </a>
                            <div>
                                <div class="leading-none text-xs text-gray-500 dark:text-dark-text-two mb-1">10 : 00 pm
                                </div>
                                <h6 class="leading-none text-lg text-heading font-semibold mb-2">
                                    <a href="#">Robert Fox</a>
                                </h6>
                                <p
                                    class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold line-clamp-1">
                                    Duis at consectetur lorem donec massa consectetur lorem donec...</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5 first:pt-0">
                            <a href="#"
                                class="size-12 rounded-50 flex-shrink-0 overflow-hidden dk-theme-card-square">
                                <img src="{{ asset('') }}assets/images/user/user-5.png" alt="user">
                            </a>
                            <div>
                                <div class="leading-none text-xs text-gray-500 dark:text-dark-text-two mb-1">10 : 00 pm
                                </div>
                                <h6 class="leading-none text-lg text-heading font-semibold mb-2">
                                    <a href="#">Robert Fox</a>
                                </h6>
                                <p
                                    class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold line-clamp-1">
                                    Duis at consectetur lorem donec massa consectetur lorem donec...</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5 first:pt-0">
                            <a href="#"
                                class="size-12 rounded-50 flex-shrink-0 overflow-hidden dk-theme-card-square">
                                <img src="{{ asset('') }}assets/images/user/user-6.png" alt="user">
                            </a>
                            <div>
                                <div class="leading-none text-xs text-gray-500 dark:text-dark-text-two mb-1">10 : 00 pm
                                </div>
                                <h6 class="leading-none text-lg text-heading font-semibold mb-2">
                                    <a href="#">Robert Fox</a>
                                </h6>
                                <p
                                    class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold line-clamp-1">
                                    Duis at consectetur lorem donec massa consectetur lorem donec...</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Support -->
        </div>
    </div>
@endsection
