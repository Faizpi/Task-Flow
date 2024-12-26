@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center mb-2 p-2 content-background">
    <h1 class="fw-bold text-primary">Daftar Tugas</h1>

    @if (session('notification'))
    <div class="alert alert-info">
        {{ session('notification') }}
    </div>
    @endif
</div>

{{-- Filter --}}
<div class="row justify-content-center mb-2 p-1">
    <div class="col-md-10">
        <form method="GET" action="{{ route('tasks.index') }}" class="row align-items-center g-3 shadow-sm p-3 rounded" style="backdrop-filter: blur(5px); background-color: rgba(255, 255, 255, 0.5); border-radius: 8px">
            <div class="col-md-4 d-flex gap-2 align-items-center p-2">
                <label for="category" class="form-label fw-bold text-dark mb-0">Kategori:</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2 align-items-center p-2">
                <label for="status" class="form-label fw-bold text-dark mb-0">Status:</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Selesai</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum Selesai</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-custom w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Tugas --}}
<div class="task-list">
    @php
        // Generate warna unik secara konsisten berdasarkan nama kategori
        function getCategoryColor($category) {
            $hash = md5($category);
            $r = hexdec(substr($hash, 0, 2));
            $g = hexdec(substr($hash, 2, 2));
            $b = hexdec(substr($hash, 4, 2));
            return "rgb($r, $g, $b)";
        }
    @endphp

    @foreach ($tasks as $task)
    <div class="task-item p-6">
        <div class="task-header">
            <input 
                type="checkbox" 
                class="task-checkbox" 
                onchange="toggleTaskStatus({{ $task->id }})" 
                {{ $task->completed ? 'checked' : '' }}
            >
            <div class="task-info">
                <h5 class="task-title {{ $task->completed ? 'completed' : '' }}">
                    {{ $task->title }}
                </h5>
                {{-- Kategori Tugas --}}
                <div class="task-category-box">
                    @foreach (explode(',', $task->category) as $category)
                        <span class="category-label" style="background-color: {{ getCategoryColor($category) }};">
                            {{ $category }}
                        </span>
                    @endforeach
                </div>
                {{-- Deskripsi Tugas --}}
                <p class="task-description">{{ $task->description }}</p>
            </div>
            {{-- Menampilkan Deadline Tugas dengan Waktu --}}
            <span class="task-deadline">
            @php
        $isOverdue = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($task->deadline));
    @endphp
    {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}
    @if ($isOverdue)
        <span class="text-danger fw-bold">(Overdue)</span>
    @endif
            </span>
            {{-- Tombol Edit dan Hapus --}}
            <div class="task-actions">
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">
                    <!-- Ikon Edit dengan SVG -->
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                        <!-- Ikon Hapus dengan SVG -->
                        <svg width="24px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 9L11 15M11 9L17 15M2.72 12.96L7.04 18.72C7.392 19.1893 7.568 19.424 7.79105 19.5932C7.9886 19.7432 8.21232 19.855 8.45077 19.9231C8.72 20 9.01334 20 9.6 20H17.2C18.8802 20 19.7202 20 20.362 19.673C20.9265 19.3854 21.3854 18.9265 21.673 18.362C22 17.7202 22 16.8802 22 15.2V8.8C22 7.11984 22 6.27976 21.673 5.63803C21.3854 5.07354 20.9265 4.6146 20.362 4.32698C19.7202 4 18.8802 4 17.2 4H9.6C9.01334 4 8.72 4 8.45077 4.07689C8.21232 4.14499 7.9886 4.25685 7.79105 4.40675C7.568 4.576 7.392 4.81067 7.04 5.28L2.72 11.04C2.46181 11.3843 2.33271 11.5564 2.28294 11.7454C2.23902 11.9123 2.23902 12.0877 2.28294 12.2546C2.33271 12.4436 2.46181 12.6157 2.72 12.96Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
            </div>
            </div>
            @endforeach

    @if ($tasks->count() === 0)
    <p class="text-center text-muted mt-4">Tidak ada tugas yang tersedia dalam kategori ini.</p>
@endif
</div>

{{-- Jika Tidak Ada Tugas --}}
@if ($tasks->count() === 0)
    <p class="text-center text-muted mt-4">Tidak ada tugas yang tersedia.</p>
@endif

{{-- Tombol Tambah Tugas Baru --}}
<div style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
    <a href="{{ route('tasks.create') }}" class="btn-custom">
        <i class="fas fa-plus-circle"></i> Tambah Tugas Baru
    </a>
</div>

{{-- Tombol Tambah Kategori --}}
<div style="position: fixed; top: 70px; right: 20px; z-index: 1000;">
    <a href="{{ route('categories.create') }}" class="btn-custom-secondary">
        <i class="fas fa-folder-plus"></i> Tambah Kategori
    </a>
</div>
{{-- Script untuk AJAX --}}
<script>
function toggleTaskStatus(taskId) {
    fetch(`/tasks/${taskId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload halaman untuk memperbarui tampilan
        }
    });
}

setInterval(function() {
        const tasks = @json($tasks); // Ambil data tugas dari backend
        const now = new Date();
        
        tasks.forEach(task => {
            const deadline = new Date(task.deadline);
            const notificationTime = new Date(deadline.getTime() - task.notification_minutes * 60000); // Kurangi dengan pengaturan menit

            if (now >= notificationTime && now < deadline) {
                // Tampilkan notifikasi
                alert('Tugas "' + task.title + '" mendekati deadline!');
            }
        });
    }, 60000); // Setiap 1 menit, cek deadline
</script>

{{-- Tambahkan CSS --}}
<style>


/* Menambahkan background gambar dengan blur */
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
    /* Container untuk daftar tugas */
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        overflow-y: scroll; /* Aktifkan scroll secara vertikal */
        max-height: 63vh; /* Batasi tinggi maksimal untuk daftar tugas */
        scrollbar-width: thin; /* Scrollbar lebih tipis untuk Firefox */
        scrollbar-color:rgb(255, 165, ) #f1f1f1; /* Warna scrollbar untuk Firefox */
        
    }

    /* Webkit (Chrome, Edge, Safari) Scrollbar */
    .task-list::-webkit-scrollbar {
        width: 8px; /* Lebar scrollbar */
    }

    .text-danger {
        color: #ff0000;
    }
    .fw-bold {
        font-weight: bold;
    }

    .task-list::-webkit-scrollbar-thumb {
        background-color: #007bff; /* Warna thumb scrollbar */
        border-radius: 10px; /* Membuat ujungnya melengkung */
    }

    .task-list::-webkit-scrollbar-thumb:hover {
        background-color: #0056b3; /* Warna thumb saat di-hover */
    }

    .task-list::-webkit-scrollbar-track {
        background: #f1f1f1; /* Warna track (area di belakang scrollbar) */
        border-radius: 10px;
    }

    /* Filter box styling */
    ..form-label {
        font-size: 14px;
        margin-bottom: 0;
    }

    .form-select {
        font-size: 14px;
        border-radius: 8px;
    }

    .shadow-sm {
        padding: 10px 15px;
        margin-bottom: 15px;
    }

    .gap-3 {
        gap: 15px; /* Menambah jarak antar elemen */
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    /* Item tugas individual */
    .task-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(255, 255, 255, 0.5);
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        backdrop-filter: blur(10px)
    }

    /* Header tugas */
    .task-header {
        display: flex;
        align-items: center;
        gap: 15px;
        width: 100%;
    }

    /* Checkbox untuk tugas selesai */
    .task-checkbox {
        width: 20px;
        height: 20px;
    }

    /* Informasi tugas */
    .task-info {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    /* Judul tugas */
    .task-title {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }

    /* Judul tugas yang sudah selesai */
    .task-title.completed {
        text-decoration: line-through;
        color: #aaa;
    }

    /* Kategori tugas dalam bentuk label */
    .task-category-box {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }

    /* Label kategori */
    .category-label {
        color: #fff;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: bold;
    }

    /* Deskripsi tugas */
    .task-description {
        margin: 5px 0 0;
        font-size: 14px;
        color: #555;
    }

    /* Deadline tugas */
    .task-deadline {
        font-size: 14px;
        color: #333;
        white-space: nowrap;
    }

    /* Aksi tugas: Edit dan Hapus */
    .task-actions {
        display: flex;
        gap: 5px;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }

    h1 {
        font-size: 2rem;
        font-weight: bold;
    }

    .fw-bold {
        margin-bottom: 0;
    }

    /* Animasi dan Transisi Scroll */
    .task-list {
        transition: all 0.3s ease-in-out; /* Efek transisi saat scroll */
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
    /* Tombol Custom Secondary */
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

    /* Ikon dalam Tombol */
    .btn-custom i,
.btn-custom-secondary i {
    font-size: 20px;
    margin-right: 10px;
}

</style>

@endsection
