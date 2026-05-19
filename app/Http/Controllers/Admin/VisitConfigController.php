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
            'schedules.*.allowed_kode_tahanan' => 'nullable|array',
            'schedules.*.allowed_kode_tahanan.*' => 'string',
            'limit_nik_per_week' => 'required|integer|min:1',
            'limit_wbp_per_week' => 'required|integer|min:1',
            'limit_wbp_per_day' => 'required|integer|min:0',
            'registration_lead_time' => 'required|integer|min:0',
            'edit_lead_time' => 'required|integer|min:0',
            'max_followers_allowed' => 'required|integer|min:0',
            'visit_duration_minutes' => 'required|integer|min:1',
            'arrival_tolerance_minutes' => 'required|integer|min:0',
            'announcement_guest_page' => 'nullable|string',
            'general_announcement' => 'nullable|string',
            'is_general_announcement_active' => 'nullable|boolean',
            'info_terkini' => 'nullable|string',
            // VALIDASI CUSTOM TAHAP II
            'terms_conditions' => 'required|string',
            'helpdesk_whatsapp' => 'required|string',
            'api_token_fonnte' => 'nullable|string',
            'jam_buka_pagi' => 'required',
            'jam_tutup_pagi' => 'required',
            'jam_buka_siang' => 'required',
            'jam_tutup_siang' => 'required',
            // VALIDASI KONFIGURASI EMAIL
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'admin_email' => 'nullable|email',
            'monday_registration_special' => 'nullable|boolean',
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
                'allowed_kode_tahanan' => isset($data['allowed_kode_tahanan']) && is_array($data['allowed_kode_tahanan']) && count($data['allowed_kode_tahanan']) > 0 ? $data['allowed_kode_tahanan'] : null,
            ]);
        }

        // 3. Update Settings
        $settingsToUpdate = [
            'limit_nik_per_week' => ['value' => $request->limit_nik_per_week, 'type' => 'number'],
            'limit_wbp_per_week' => ['value' => $request->limit_wbp_per_week, 'type' => 'number'],
            'limit_wbp_per_day' => ['value' => $request->limit_wbp_per_day, 'type' => 'number'],
            'registration_lead_time' => ['value' => $request->registration_lead_time, 'type' => 'number'],
            'enable_guest_edit' => ['value' => $request->has('enable_guest_edit') ? '1' : '0', 'type' => 'boolean'],
            'edit_lead_time' => ['value' => $request->edit_lead_time, 'type' => 'number'],
            'max_followers_allowed' => ['value' => $request->max_followers_allowed, 'type' => 'number'],
            'visit_duration_minutes' => ['value' => $request->visit_duration_minutes, 'type' => 'number'],
            'arrival_tolerance_minutes' => ['value' => $request->arrival_tolerance_minutes, 'type' => 'number'],
            'is_emergency_closed' => ['value' => $request->has('is_emergency_closed') ? '1' : '0', 'type' => 'boolean'],
            'announcement_guest_page' => ['value' => $request->announcement_guest_page ?? '', 'type' => 'string'],
            'general_announcement' => ['value' => $request->general_announcement ?? '', 'type' => 'string'],
            'is_general_announcement_active' => ['value' => $request->has('is_general_announcement_active') ? '1' : '0', 'type' => 'boolean'],
            'info_terkini' => ['value' => $request->info_terkini ?? '', 'type' => 'string'],
            'terms_conditions' => ['value' => $request->terms_conditions, 'type' => 'string'],
            'helpdesk_whatsapp' => ['value' => preg_replace('/[^0-9]/', '', $request->helpdesk_whatsapp), 'type' => 'string'],
            'api_token_fonnte' => ['value' => $request->api_token_fonnte ?? '', 'type' => 'string'],
            'jam_buka_pagi' => ['value' => $request->jam_buka_pagi, 'type' => 'string'],
            'jam_tutup_pagi' => ['value' => $request->jam_tutup_pagi, 'type' => 'string'],
            'jam_buka_siang' => ['value' => $request->jam_buka_siang, 'type' => 'string'],
            'jam_tutup_siang' => ['value' => $request->jam_tutup_siang, 'type' => 'string'],
            'mail_host' => ['value' => $request->mail_host ?? '', 'type' => 'string'],
            'mail_port' => ['value' => $request->mail_port ?? '587', 'type' => 'string'],
            'mail_username' => ['value' => $request->mail_username ?? '', 'type' => 'string'],
            'mail_password' => ['value' => $request->mail_password ?? '', 'type' => 'string'],
            'mail_encryption' => ['value' => $request->mail_encryption ?? 'tls', 'type' => 'string'],
            'mail_from_address' => ['value' => $request->mail_from_address ?? '', 'type' => 'string'],
            'admin_email' => ['value' => $request->admin_email ?? '', 'type' => 'string'],
            'monday_registration_special' => ['value' => $request->has('monday_registration_special') ? '1' : '0', 'type' => 'boolean'],
        ];

        foreach ($settingsToUpdate as $key => $data) {
            if ($data['value'] !== null) {
                VisitSetting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $data['value'],
                        'type' => $data['type'],
                        'display_name' => ucwords(str_replace('_', ' ', $key))
                    ]
                );
            }
        }

        // Bersihkan cache agar perubahan langsung terasa
        Artisan::call('cache:clear');

        return redirect()->back()->with('success', 'Konfigurasi kunjungan berhasil diperbarui.');
    }
}
