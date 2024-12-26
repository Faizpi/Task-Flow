@extends('layouts.app')

@section('content')
<div class="container mt-5 p-6">
    <h1 class="text-left mb-2 p-2" style="font-size: 2rem; font-weight: bold;">Profil</h1>
    <form action="{{ route('profile.update') }}" method="POST" class="p-4 border rounded shadow-lgform-container"style="backdrop-filter: blur(5px); background-color: rgba(255, 255, 255, 0.5); border-radius: 8px">
        @csrf
        @method('PUT')

        <!-- Input untuk Nama -->
        <div class="row mb-4 align-items-center">
            <label for="name" class="col-md-2 col-form-label fw-bold text-dark">Nama:</label>
            <div class="col-md-10">
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control form-control-lg rounded-pill form-input @error('name') is-invalid @enderror" placeholder="Masukkan nama" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Input untuk Email -->
        <div class="row mb-4 align-items-center">
            <label for="email" class="col-md-2 col-form-label fw-bold text-dark">Email:</label>
            <div class="col-md-10">
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control form-control-lg rounded-pill form-input @error('email') is-invalid @enderror" placeholder="Masukkan email" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Input untuk Password -->
        <div class="row mb-4 align-items-center">
            <label for="password" class="col-md-2 col-form-label fw-bold text-dark">Password:</label>
            <div class="col-md-10">
                <input type="password" id="password" name="password" class="form-control form-control-lg rounded-pill form-input @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin mengganti">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Input untuk Konfirmasi Password -->
        <div class="row mb-4 align-items-center">
            <label for="password_confirmation" class="col-md-2 col-form-label fw-bold text-dark">Konfirmasi Password:</label>
            <div class="col-md-10">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg rounded-pill form-input" placeholder="Konfirmasi password baru">
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('tasks.dashboard') }}" class="btn-custom-secondary">Batal</a>
            <button type="submit" class="btn-custom">Update</button>
        </div>
    </form>
</div>

{{-- Tambahkan CSS --}}
<style>

body {
    position: relative;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

/* Gambar background dengan efek blur */
body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset('images/background.png') }}'); /* Ganti dengan path gambar Anda */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: blur(8px);  /* Efek blur pada gambar */
    z-index: -1;  /* Menempatkan gambar di bawah konten */
}

/* Konten yang ada di atas gambar */
.container {
    position: relative;
    z-index: 1;
}

    .form-container {
        width: 100%;
        max-width: 100%;
    }

    .form-input {
        width: 100%;
        border-radius: 50px;
        padding: 12px 20px;
    }

    .btn-custom {
        display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: auto;
    padding: 10px 20px;
    margin-top: 10px;
    background: linear-gradient(90deg, #ff9a9e, #fad0c4);
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-custom:hover {
        background: linear-gradient(90deg, #fbc2eb, #a6c1ee);
    transform: scale(1.02);
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-custom-secondary {
        display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: auto;
    padding: 10px 20px;
    margin-top: 10px;
    background: linear-gradient(90deg, #a1c4fd, #c2e9fb);
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-custom-secondary:hover {
        background: linear-gradient(90deg, #d4fc79, #96e6a1);
    transform: scale(1.02);
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }

    .form-control-lg {
        font-size: 16px;
        padding: 12px 20px;
    }

    .rounded-pill {
        border-radius: 50px;
    }
</style>
@endsection
