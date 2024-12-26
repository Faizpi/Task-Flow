@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-left mb-2 p-2" style="font-size: 2rem; font-weight: bold;">Edit Tugas</h1>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="p-4 border rounded shadow-lgform-container"style="backdrop-filter: blur(5px); background-color: rgba(255, 255, 255, 0.5); border-radius: 8px">
        @csrf
        @method('PUT')

        <div class="row mb-4 align-items-center">
            <label for="title" class="col-md-2 col-form-label fw-bold text-dark">Judul:</label>
            <div class="col-md-10">
                <input type="text" id="title" name="title" value="{{ $task->title }}" class="form-control form-control-lg rounded-pill form-input" placeholder="Masukkan judul tugas" required>
            </div>
        </div>

        <div class="row mb-4 align-items-center">
            <label for="category" class="col-md-2 col-form-label fw-bold text-dark">Kategori:</label>
            <div class="col-md-10">
                <input type="text" id="category" name="category" value="{{ $task->category }}" class="form-control form-control-lg rounded-pill form-input" placeholder="Masukkan kategori" required>
            </div>
        </div>

        <div class="row mb-4 align-items-center">
            <label for="description" class="col-md-2 col-form-label fw-bold text-dark">Deskripsi:</label>
            <div class="col-md-10">
                <textarea id="description" name="description" class="form-control form-control-lg rounded form-input" rows="5" placeholder="Masukkan deskripsi tugas">{{ $task->description }}</textarea>
            </div>
        </div>

        <div class="row mb-4 align-items-center">
            <label for="deadline" class="col-md-2 col-form-label fw-bold text-dark">Deadline:</label>
            <div class="col-md-10">
                <input type="datetime-local" id="deadline" name="deadline" value="{{ $task->deadline }}" class="form-control form-control-lg rounded-pill form-input" required>
            </div>
        </div>

        <div class="form-group">
    <label for="notification_minutes">Notifikasi</label>
    <input type="number" name="notification_minutes" id="notification_minutes" class="form-control" placeholder="Menit sebelum deadline" value="{{ old('notification_minutes', $task->notification_minutes) }}">
</div>


        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('tasks.index') }}" class="btn-custom-secondary">Batal</a>

            <button type="submit" class="btn-custom">Update Tugas</button>
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
        width: 100%;  /* Membuat form memenuhi lebar penuh */
        max-width: 100%;  /* Menjamin form tetap melebar di berbagai ukuran layar */
    }

    .form-input {
        width: 100%;  /* Membuat input mengisi lebar form */
        border-radius: 50px;  /* Membuat input lonjong */
        padding: 12px 20px;  /* Padding lebih besar agar input terlihat lebih panjang */
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
        padding: 12px 20px;  /* Membuat padding input lebih besar */
    }

    .rounded-pill {
        border-radius: 50px;
    }
</style>
@endsection
