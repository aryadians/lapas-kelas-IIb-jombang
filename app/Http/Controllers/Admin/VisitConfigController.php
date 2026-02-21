<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitSchedule;
use App\Models\VisitSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class VisitConfigController extends Controller
{
    public function index()
    {
        $schedules = VisitSchedule::orderByRaw('FIELD(day_of_week, 1, 2, 3, 4, 5, 6, 0)')->get();
        $settings = VisitSetting::all()->pluck('value', 'key');
        
        return view('admin.settings.visit_config', compact('schedules', 'settings'));
    }

    public function update(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.is_open' => 'nullable|boolean',
            'schedules.*.online_morning' => 'required|integer|min:0',
            'schedules.*.online_afternoon' => 'required|integer|min:0',
            'schedules.*.offline_morning' => 'required|integer|min:0',
            'schedules.*.offline_afternoon' => 'required|integer|min:0',
            'limit_nik_per_week' => 'required|integer|min:1',
            'limit_wbp_per_week' => 'required|integer|min:1',
            'registration_lead_time' => 'required|integer|min:0',
            'edit_lead_time' => 'required|integer|min:0',
            'max_followers_allowed' => 'required|integer|min:0',
            'visit_duration_minutes' => 'required|integer|min:1',
            'arrival_tolerance_minutes' => 'required|integer|min:0',
            'announcement_guest_page' => 'nullable|string',
            // VALIDASI CUSTOM TAHAP II
            'terms_conditions' => 'required|string',
            'helpdesk_whatsapp' => 'required|string',
            'api_token_fonnte' => 'nullable|string',
            'jam_buka_pagi' => 'required',
            'jam_tutup_pagi' => 'required',
            'jam_buka_siang' => 'required',
            'jam_tutup_siang' => 'required',
        ]);

        // 2. Update Schedules
        foreach ($request->schedules as $id => $data) {
            $schedule = VisitSchedule::findOrFail($id);
            $schedule->update([
                'is_open' => isset($data['is_open']),
                'quota_online_morning' => $data['online_morning'],
                'quota_online_afternoon' => $data['online_afternoon'],
                'quota_offline_morning' => $data['offline_morning'],
                'quota_offline_afternoon' => $data['offline_afternoon'],
            ]);
        }

        // 3. Update Settings
        $settingsToUpdate = [
            'limit_nik_per_week' => $request->limit_nik_per_week,
            'limit_wbp_per_week' => $request->limit_wbp_per_week,
            'registration_lead_time' => $request->registration_lead_time,
            'enable_guest_edit' => $request->has('enable_guest_edit') ? '1' : '0',
            'edit_lead_time' => $request->edit_lead_time,
            'max_followers_allowed' => $request->max_followers_allowed,
            'visit_duration_minutes' => $request->visit_duration_minutes,
            'arrival_tolerance_minutes' => $request->arrival_tolerance_minutes,
            'is_emergency_closed' => $request->has('is_emergency_closed') ? '1' : '0',
            'announcement_guest_page' => $request->announcement_guest_page ?? '',
            // DATA TAMBAHAN FITUR MANAJEMEN LAPAS TAHAP II
            'terms_conditions' => $request->terms_conditions,
            'helpdesk_whatsapp' => $request->helpdesk_whatsapp,
            'api_token_fonnte' => $request->api_token_fonnte ?? '',
            'jam_buka_pagi' => $request->jam_buka_pagi,
            'jam_tutup_pagi' => $request->jam_tutup_pagi,
            'jam_buka_siang' => $request->jam_buka_siang,
            'jam_tutup_siang' => $request->jam_tutup_siang,
        ];

        foreach ($settingsToUpdate as $key => $value) {
            if ($value !== null) {
                VisitSetting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        // Bersihkan cache agar perubahan langsung terasa
        Artisan::call('cache:clear');

        return redirect()->back()->with('success', 'Konfigurasi kunjungan berhasil diperbarui.');
    }
}
