<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreKunjunganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public access allowed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_pengunjung'               => 'required|string|max:255',
            'nik_ktp'                       => 'required|numeric|digits:16',
            'nomor_hp'                      => 'required|string',
            'email_pengunjung'              => 'required|email',
            'alamat_lengkap'                => 'required|string',
            'barang_bawaan'                 => 'nullable|string',
            'jenis_kelamin'                 => 'required|in:Laki-laki,Perempuan',
            'foto_ktp'                      => 'required|image|max:2048', 
            'wbp_id'                        => 'required|exists:wbps,id',
            'hubungan'                      => 'required|string',
            'tanggal_kunjungan'             => 'required|date',
            'sesi'                          => 'nullable',
            
            // Pengikut
            'pengikut_nama'                 => 'nullable|array|max:4',
            'pengikut_nik'                  => 'nullable|array|max:4',
            'pengikut_nik.*'                => 'nullable|numeric|digits:16', 
            'pengikut_hubungan'             => 'nullable|array|max:4',
            'pengikut_foto'                 => 'nullable|array|max:4',
            'pengikut_foto.*'               => 'nullable|image|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'pengikut_nama.max'       => 'Jumlah pengikut tidak boleh lebih dari 4 orang.',
            'pengikut_nik.*.digits'   => 'NIK Pengikut harus berjumlah tepat 16 digit.',
            'pengikut_nik.*.numeric'  => 'NIK Pengikut harus berupa angka.',
            'nik_ktp.digits'          => 'NIK Pengunjung Utama harus berjumlah 16 digit.',
            'foto_ktp.max'            => 'Ukuran foto KTP maksimal 2MB.',
            'pengikut_foto.*.max'     => 'Ukuran foto pengikut maksimal 2MB per file.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $tanggalInput = $this->input('tanggal_kunjungan');
            if ($tanggalInput) {
                try {
                    $tanggal = Carbon::parse($tanggalInput);
                    
                    // Logic: Jika Senin, Sesi Wajib Diisi
                    if ($tanggal->isMonday() && empty($this->input('sesi'))) {
                        $validator->errors()->add('sesi', 'Sesi wajib dipilih pada hari Senin.');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('tanggal_kunjungan', 'Format tanggal tidak valid.');
                }
            }
        });
    }
}