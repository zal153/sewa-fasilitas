@extends('user.layouts.template')

@section('title', 'Dashboard')
@section('contentUser')
    <div class="pb-20">
        <div class="bg-indigo-600 px-8 pt-8 pb-24 flex justify-between items-center mb-4">
            <h1 class="text-xl text-white">Selamat Datang <span> User</span></h1>
        </div>
        <div class="-mt-24 mx-6 mb-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 xl:grid-cols-4">
            <!-- card -->
            <div class="card shadow">
                <!-- card body -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex justify-between items-center">
                        <h4>Tersedia</h4>
                        <div
                            class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                            <i data-feather="briefcase" class="h-5 w-5"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0">
                        <h2 class="text-xl font-bold">18</h2>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card shadow">
                <!-- card boduy -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex justify-between items-center">
                        <h4>Sedang Digunakan</h4>
                        <div
                            class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                            <i data-feather="list" class="h-5 w-5"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0">
                        <h2 class="text-xl font-bold">132</h2>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card shadow">
                <!-- card body -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex justify-between items-center">
                        <h4>Teams</h4>
                        <div
                            class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                            <i data-feather="users" class="h-5 w-5"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0">
                        <h2 class="text-xl font-bold">12</h2>
                        <div>
                            <span>1</span>
                            <span class="text-gray-500">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card shadow">
                <!-- card body -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex justify-between items-center">
                        <h4>Productivity</h4>
                        <div
                            class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-center text-indigo-600">
                            <i data-feather="target" class="h-5 w-5"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0">
                        <h2 class="text-xl font-bold">76%</h2>
                        <div>
                            <span class="text-green-600">5%</span>
                            <span class="text-gray-500">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-6 my-6 grid grid-cols-1 xl:grid-cols-1 grid-rows-1 grid-flow-row-dense gap-6">
            <div>
                <div class="card h-full shadow">
                    <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                        <!-- title -->
                        <div>
                            <h4>My Task</h4>
                        </div>
                        <div>
                            <!-- button -->
                            <div class="dropdown leading-4">
                                <button
                                    class="dropdown-toggle btn btn-sm gap-x-2 bg-white text-gray-800 border-gray-300 border disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-gray-700 hover:border-gray-700 active:bg-gray-700 active:border-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Task
                                </button>
                                <!-- list -->
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto">
                        <!-- table -->
                        <table class="text-left w-full whitespace-nowrap">
                            <thead class="text-gray-700">
                                <tr>
                                    <th class="border-b bg-gray-100 px-6 py-3">Name</th>
                                    <th class="border-b bg-gray-100 px-6 py-3">Deadline</th>
                                    <th class="border-b bg-gray-100 px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                                type="checkbox" id="checkboxOne" />
                                            <label for="checkboxOne" class="ml-2 text-slate-600">Design a
                                                Dashui Home page</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        Today</td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <span
                                            class="bg-green-100 px-2 py-1 text-green-700 text-sm font-medium rounded-md">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                                type="checkbox" id="checkboxTwo" />
                                            <label for="checkboxTwo" class="ml-2 text-slate-600">Dash UI
                                                Dark Version Design</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        Yesterday</td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <span
                                            class="bg-red-100 px-2 py-1 text-red-700 text-sm font-medium rounded-md">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                                type="checkbox" id="checkboxThree" />
                                            <label for="checkboxThree" class="ml-2 text-slate-600">Dash UI
                                                landing page design</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">16
                                        Sept, 2023</td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <span
                                            class="bg-yellow-100 px-2 py-1 text-yellow-700 text-sm font-medium rounded-md">In
                                            Progress</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded-md focus:ring-indigo-400 focus:outline-none focus:ring-3 focus:outline-indigo-600"
                                                type="checkbox" id="checkboxFour" />
                                            <label for="checkboxFour" class="ml-2 text-slate-600">Next.js
                                                Dash UI version</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">23
                                        Sept, 2023</td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <span
                                            class="bg-green-100 px-2 py-1 text-green-700 text-sm font-medium rounded-md">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                                type="checkbox" id="checkboxFive" />
                                            <label for="checkboxFive" class="ml-2 text-slate-600">Develop
                                                a Dash UI Laravel</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">20
                                        Sept, 2023</td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <span
                                            class="bg-red-100 px-2 py-1 text-red-700 text-sm font-medium rounded-md">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                                type="checkbox" id="checkboxSix" />
                                            <label for="checkboxSix" class="ml-2 text-slate-600">Coach
                                                home page design</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">12
                                        Sept, 2023</td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <span
                                            class="bg-green-100 px-2 py-1 text-green-700 text-sm font-medium rounded-md">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-600 focus:outline-none focus:ring-2"
                                                type="checkbox" id="checkboxSeven" />
                                            <label for="checkboxSeven" class="ml-2 text-slate-600">Develop
                                                a Dash UI Laravel</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">11
                                        Sept, 2023</td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <span
                                            class="bg-red-100 px-2 py-1 text-red-700 text-sm font-medium rounded-md">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
