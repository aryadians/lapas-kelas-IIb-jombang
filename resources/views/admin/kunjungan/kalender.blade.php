@extends('layouts.admin')

@section('content')
{{-- Load FullCalendar CSS from CDN --}}
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Kalender Jadwal Kunjungan</h2>
            <p class="text-slate-500 mt-1">Tampilan visual semua jadwal kunjungan yang telah disetujui.</p>
        </div>
        <div class="flex items-center mt-4 md:mt-0">
             <div class="flex items-center mr-4">
                <span class="w-3 h-3 rounded-full bg-green-500 inline-block mr-2"></span>
                <span class="text-sm text-slate-600">Disetujui</span>
            </div>
        </div>
    </div>
    
    {{-- Container for the calendar --}}
    <div id='calendar' class="p-4 bg-gray-50 rounded-lg"></div>
</div>

@endsection

@push('scripts')
{{-- Load FullCalendar JS from CDN --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
{{-- Load FullCalendar Indonesian locale --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id', // Set locale to Indonesian
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: '{{ route('admin.api.kunjungan.kalender') }}', // URL to fetch events
        
        // --- Visual Settings ---
        dayMaxEvents: true, // allow "more" link when too many events
        contentHeight: 600,
        
        // --- Event Styling & Interaction ---
        eventTimeFormat: { // 13:00
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },
        eventDidMount: function(info) {
            // Add a tooltip on hover
            info.el.setAttribute('title', info.event.title);
        },
        
        // --- Loading Indicator ---
        loading: function(isLoading) {
            if (isLoading) {
                calendarEl.innerHTML = '<div class="text-center p-8 text-slate-500">Memuat data jadwal...</div>';
            }
        }
    });

    calendar.render();
});
</script>
@endpush
