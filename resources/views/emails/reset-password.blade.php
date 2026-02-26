@component('mail::message')

{{-- Header with Logo and Badges --}}
<div style="text-align: center; margin-bottom: 30px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 20px; border-radius: 12px; border: 2px solid #fbbf24;">
    <div style="margin-bottom: 15px;">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Lapas Kelas IIB Jombang" style="height: 70px; width: auto; display: inline-block; border-radius: 50%; border: 4px solid #fbbf24; padding: 5px; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
    </div>
    <div style="display: inline-flex; align-items: center; gap: 10px; margin-bottom: 10px;">
        <span style="background: #dc2626; color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px;">
            🛡️ LAPAS KELAS IIB JOMBANG
        </span>
        <span style="background: #2563eb; color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px;">
            ⚖️ KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN RI
        </span>
    </div>
    <h1 style="color: #fbbf24; text-align: center; margin: 10px 0 5px 0; font-size: 24px; font-weight: bold; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Reset Password Akun</h1>
    <p style="color: #e2e8f0; text-align: center; font-size: 14px; margin: 0;">Sistem Informasi Pemasyarakatan - Lembaga Pemasyarakatan Kelas IIB Jombang</p>
</div>

<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 20px 0;">
    <div style="text-align: center; margin-bottom: 20px;">
        <div style="display: inline-flex; align-items: center; gap: 8px;">
            <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 8px 16px; border-radius: 25px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);">
                🔐 RESET PASSWORD
            </span>
            <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 8px 16px; border-radius: 25px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);">
                ⏰ {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60) }} MENIT
            </span>
        </div>
    </div>

    <p style="color: #374151; margin-bottom: 15px;">
        Halo <strong>{{ $request->email }}</strong>,
    </p>

    <p style="color: #374151; margin-bottom: 15px;">
        Kami menerima permintaan untuk mereset password akun Anda di Sistem Informasi Pemasyarakatan Lapas Kelas IIB Jombang.
    </p>

    <p style="color: #374151; margin-bottom: 20px;">
        Jika Anda yang meminta reset password, klik tombol di bawah ini untuk membuat password baru:
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $request->url }}"
           style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #92400e; padding: 14px 35px; text-decoration: none; border-radius: 12px; font-weight: bold; display: inline-block; box-shadow: 0 6px 12px rgba(251, 191, 36, 0.4); border: 2px solid #f59e0b; transition: all 0.3s ease;">
            🔑 Reset Password Sekarang
        </a>
    </div>

    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #fbbf24; border-radius: 10px; padding: 18px; margin: 20px 0; position: relative;">
        <div style="position: absolute; top: -10px; left: 20px; background: #f59e0b; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: bold;">
            ⚠️ PENTING
        </div>
        <p style="color: #92400e; margin: 0; font-size: 14px; font-weight: 500;">
            Link reset password ini bersifat rahasia dan hanya berlaku selama <strong>{{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60) }} menit</strong>.
            Jika Anda tidak meminta reset password, segera hubungi administrator dan abaikan email ini.
        </p>
    </div>

    <p style="color: #6b7280; font-size: 12px; margin-top: 20px;">
        Jika tombol tidak berfungsi, salin dan tempel link berikut ke browser Anda:<br>
        <span style="word-break: break-all; color: #3b82f6;">{{ $request->url }}</span>
    </p>
</div>

<div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 2px solid #10b981; border-radius: 10px; padding: 18px; margin: 20px 0; position: relative;">
    <div style="position: absolute; top: -10px; left: 20px; background: #059669; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: bold;">
        📞 BANTUAN
    </div>
    <h3 style="color: #065f46; margin: 0 0 12px 0; font-size: 16px; font-weight: bold;">Butuh Bantuan?</h3>
    <p style="color: #065f46; margin: 0; font-size: 14px; line-height: 1.5;">
        Hubungi Administrator Sistem Lapas Kelas IIB Jombang:<br>
        📧 <strong>Email:</strong> admin@lapasjombang.go.id<br>
        📱 <strong>WhatsApp:</strong> +62 812-3456-7890<br>
        🏢 <strong>Alamat:</strong> Jl. Raya Jombang No. 123, Jombang
    </p>
</div>

<div style="text-align: center; margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 10px; border: 1px solid #cbd5e1;">
    <div style="display: inline-flex; align-items: center; gap: 10px; margin-bottom: 10px;">
        <span style="background: #1e293b; color: white; padding: 6px 12px; border-radius: 15px; font-size: 10px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
            🏛️ PEMASYARAKATAN
        </span>
        <span style="background: #2563eb; color: white; padding: 6px 12px; border-radius: 15px; font-size: 10px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
            🔒 KEAMANAN
        </span>
        <span style="background: #16a34a; color: white; padding: 6px 12px; border-radius: 15px; font-size: 10px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
            🤝 KEMANUSIAAN
        </span>
    </div>
    <p style="color: #475569; font-size: 12px; margin: 0; line-height: 1.5;">
        Email ini dikirim secara otomatis oleh Sistem Informasi Pemasyarakatan<br>
        <strong>Lembaga Pemasyarakatan Kelas IIB Jombang</strong><br>
        &copy; {{ date('Y') }} Kementerian Imigrasi dan Pemasyarakatan Republik Indonesia<br>
        <em>"Mewujudkan Pemasyarakatan yang Bermartabat"</em>
    </p>
</div>

@slot('subcopy')
<div style="text-align: center; color: #9ca3af; font-size: 11px;">
    Jika Anda mengalami kesulitan, jangan ragu untuk menghubungi administrator sistem.
</div>
@endslot

</component>