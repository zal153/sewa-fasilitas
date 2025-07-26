@extends('admin.layouts.admin')

@section('title', 'Edit Data Mahasiswa')

@section('contentAdmin')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Form Edit Mahasiswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('mahasiswa') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Mahasiswa</li>
                    </ol>
                </div>

                {{-- Flash Session --}}
                <div class="col-12 mt-2">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Form Card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data</h3>
                        </div>

                        <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                {{-- Nama --}}
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $mahasiswa->user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $mahasiswa->user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password (Opsional) --}}
                                <div class="form-group">
                                    <label for="password">Password (Kosongkan jika tidak diganti)</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" autocomplete="off">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- NIM --}}
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="text" id="nim" name="nim"
                                        class="form-control @error('nim') is-invalid @enderror"
                                        value="{{ old('nim', $mahasiswa->nim) }}" required>
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Fakultas --}}
                                <div class="form-group">
                                    <label for="fakultas">Fakultas</label>
                                    <input type="text" id="fakultas" name="fakultas"
                                        class="form-control @error('fakultas') is-invalid @enderror"
                                        value="{{ old('fakultas', $mahasiswa->fakultas) }}" required>
                                    @error('fakultas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jurusan --}}
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                    <input type="text" id="jurusan" name="jurusan"
                                        class="form-control @error('jurusan') is-invalid @enderror"
                                        value="{{ old('jurusan', $mahasiswa->jurusan) }}" required>
                                    @error('jurusan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Angkatan --}}
                                <div class="form-group">
                                    <label for="angkatan">Angkatan</label>
                                    <input type="number" id="angkatan" name="angkatan"
                                        class="form-control @error('angkatan') is-invalid @enderror"
                                        value="{{ old('angkatan', $mahasiswa->angkatan) }}" required>
                                    @error('angkatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kontak --}}
                                <div class="form-group">
                                    <label for="kontak">Kontak</label>
                                    <input type="text" id="kontak" name="kontak"
                                        class="form-control @error('kontak') is-invalid @enderror"
                                        value="{{ old('kontak', $mahasiswa->kontak) }}" required>
                                    @error('kontak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                <a href="{{ route('mahasiswa') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
