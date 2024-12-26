@extends('layouts.app')

@section('content')
<div class="container mt-5 p-2">
<h1 class="text-start text-primary mb-4" style="font-size: 2rem; font-weight: bold;">Kalender Tugas</h1>
    <div id="calendar"></div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($tasks),
        eventClick: function (info) {
            alert('Tugas: ' + info.event.title + '\nDeskripsi: ' + info.event.extendedProps.description);
        },
        dayMaxEvents: true,
        aspectRatio: 2.5,  // Menyesuaikan lebar kalender dengan tinggi, nilai lebih besar membuat kalender lebih tinggi
        windowResize: function(view) {
            calendar.render();
        }
    });

    calendar.render();
});
</script>

<style>
   #calendar {
    width: 100%;
    height: 100%;
    margin: 0 auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    backdrop-filter: blur(10px)
   }
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



</style>
@endsection
