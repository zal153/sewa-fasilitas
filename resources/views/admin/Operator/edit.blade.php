@extends('admin.layouts.admin')
@section('title', 'Edit Data Operator')

@section('contentAdmin')
    <div
        class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full">
                <div class="card p-0">
                    <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                        <h3 class="text-lg card-title leading-none">Edit Data Operator</h3>
                    </div>
                    <form method="POST" action="{{ route('operator.update', $user->id) }}" class="p-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex lg:flex-row flex-col gap-x-4">
                            <div class="w-full mb-4">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" class="form-input"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>
                        <div class="flex lg:flex-row flex-col gap-x-4">
                            <div class="w-full mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-input"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        <div class="flex lg:flex-row flex-col gap-x-4">
                            <div class="w-full mb-4">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="kondisi" class="form-input" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin"
                                        {{ old('kondisi', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Dosen"
                                        {{ old('role', $user->role) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                    <option value="mahasiswa"
                                        {{ old('role', $user->role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="non_mahasiswa"
                                        {{ old('role', $user->role) == 'non_mahasiswa' ? 'selected' : '' }}>Non Mahasiswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex lg:flex-row flex-col gap-x-4 mb-4">
                            <div class="w-full mb-4">
                                <label for="password" class="form-label">Ubah Password</label>
                                <input type="password" id="password" name="password" class="form-input" autocomplete="off" value="{{ old('password', $user->password) }}" required>
                            </div>
                        </div>
                        <div class="flex lg:flex-row flex-col gap-x-4 mb-4">
                            <div class="w-full mb-4">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-input" autocomplete="off" value="{{ old('confirm_password', $user->confirm_password) }}" required>
                            </div>
                        </div>
                        <button type="submit"
                            class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">Update</button>
                        <a href="{{ route('operator') }}"
                            class="btn b-outline-static btn-disable-outline w-100 mt-2 dk-theme-card-square">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection