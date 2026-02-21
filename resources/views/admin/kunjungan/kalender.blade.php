@extends('layouts.admin')

@section('title', 'Kalender Kunjungan')

@section('content')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<style>
    .fc .fc-toolbar-title { font-size: 1.1rem; font-weight: 900; color: #1e293b; }
    .fc .fc-button-primary { background: #3b82f6 !important; border-color: #3b82f6 !important; font-weight: 700; border-radius: 0.75rem !important; padding: 0.4rem 0.9rem !important; font-size: 0.8rem !important; }
    .fc .fc-button-primary:hover { background: #2563eb !important; }
    .fc .fc-button-active { background: #1d4ed8 !important; box-shadow: inset 0 2px 4px rgba(0,0,0,0.2) !important; }
    .fc .fc-daygrid-day-number { font-weight: 700; color: #475569; font-size: 0.8rem; }
    .fc .fc-day-today { background: #eff6ff !important; }
    .fc .fc-day-today .fc-daygrid-day-number { color: #2563eb; }
    .fc-event { border-radius: 6px !important; font-size: 0.72rem !important; font-weight: 600 !important; border: none !important; padding: 1px 5px !important; }
    .fc .fc-col-header-cell-cushion { font-weight: 800; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .fc .fc-daygrid-more-link { font-size: 0.7rem; font-weight: 700; color: #3b82f6; }
    #calendar-legend span { display: inline-block; width: 10px; height: 10px; border-radius: 50%; }
</style>

<div class="space-y-6 pb-12">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-500/20">
                <i class="fas fa-calendar-alt text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Kalender Kunjungan</h1>
                <p class="text-slate-400 text-sm font-medium">Tampilan visual semua jadwal kunjungan yang disetujui</p>
            </div>
        </div>
        <div id="calendar-legend" class="flex items-center gap-4 text-sm text-slate-600 font-semibold bg-white border border-slate-200 rounded-2xl px-4 py-2.5 shadow-sm">
            <div class="flex items-center gap-2">
                <span style="background:#22c55e"></span> Sesi Pagi
            </div>
            <div class="flex items-center gap-2">
                <span style="background:#3b82f6"></span> Sesi Siang
            </div>
            <div class="flex items-center gap-2">
                <span style="background:#f59e0b"></span> Hari Ini
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" id="calendar-stats">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 flex-shrink-0"><i class="fas fa-calendar-check"></i></div>
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Bulan Ini</p>
                <p class="text-xl font-black text-slate-800" id="stat-month">—</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 flex-shrink-0"><i class="fas fa-sun"></i></div>
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Sesi Pagi</p>
                <p class="text-xl font-black text-slate-800" id="stat-morning">—</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center text-sky-600 flex-shrink-0"><i class="fas fa-cloud-sun"></i></div>
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Sesi Siang</p>
                <p class="text-xl font-black text-slate-800" id="stat-afternoon">—</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 flex-shrink-0"><i class="fas fa-calendar-day"></i></div>
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Hari Ini</p>
                <p class="text-xl font-black text-slate-800" id="stat-today">—</p>
            </div>
        </div>
    </div>

    {{-- CALENDAR --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 md:p-6">
        <div id="calendar"></div>
    </div>

    {{-- EVENT TOOLTIP (hover detail) --}}
    <div id="event-tooltip"
        class="hidden fixed z-50 bg-white border border-slate-200 rounded-2xl shadow-xl p-4 text-sm max-w-xs pointer-events-none">
    </div>

</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tooltip = document.getElementById('event-tooltip');
    let allEvents = [];

    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '{{ route("admin.api.kunjungan.kalender") }}',
        dayMaxEvents: 4,
        contentHeight: 680,
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: false },
        eventColor: '#3b82f6',

        eventDidMount(info) {
            // Warnai berdasarkan sesi
            const title = info.event.title?.toLowerCase() ?? '';
            if (title.includes('pagi') || title.includes('1')) {
                info.el.style.background = '#22c55e';
            } else if (title.includes('siang') || title.includes('2')) {
                info.el.style.background = '#3b82f6';
            }
        },

        eventMouseEnter(info) {
            const ev = info.event;
            const date = ev.start ? ev.start.toLocaleDateString('id-ID', {weekday:'long', day:'numeric', month:'long', year:'numeric'}) : '';
            tooltip.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                        <i class="fas fa-calendar-check text-xs"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm leading-snug">${ev.title}</p>
                        <p class="text-slate-400 text-xs mt-1">${date}</p>
                    </div>
                </div>
            `;
            tooltip.classList.remove('hidden');
        },
        eventMouseLeave() { tooltip.classList.add('hidden'); },
        eventsSet(events) {
            allEvents = events;
            updateStats(events);
        },
        datesSet() {
            if (allEvents.length) updateStats(allEvents);
        }
    });
    calendar.render();

    // Tooltip position following mouse
    document.addEventListener('mousemove', e => {
        tooltip.style.left = (e.clientX + 16) + 'px';
        tooltip.style.top = (e.clientY - 10) + 'px';
    });

    function updateStats(events) {
        const now = new Date();
        const currentMonth = now.getMonth();
        const currentYear = now.getFullYear();
        const today = now.toDateString();

        let monthCount = 0, morningCount = 0, afternoonCount = 0, todayCount = 0;

        events.forEach(ev => {
            const d = ev.start;
            if (!d) return;
            if (d.getMonth() === currentMonth && d.getFullYear() === currentYear) monthCount++;
            if (d.toDateString() === today) todayCount++;
            const t = ev.title?.toLowerCase() ?? '';
            if (t.includes('pagi') || t.includes('1')) morningCount++;
            else afternoonCount++;
        });

        document.getElementById('stat-month').textContent = monthCount;
        document.getElementById('stat-morning').textContent = morningCount;
        document.getElementById('stat-afternoon').textContent = afternoonCount;
        document.getElementById('stat-today').textContent = todayCount;
    }
});
</script>
@endpush
@endsection
