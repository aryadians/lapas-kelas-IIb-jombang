@component('mail::message')
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ asset('img/logo.png') }}" alt="Logo Lapas" style="width: 100px; height: auto;">
    <h1 style="color: #1e293b; margin-top: 15px;">{{ $appName }}</h1>
</div>

# Lupa Password?

Kami menerima permintaan untuk mereset password akun Anda. Jika Anda tidak merasa melakukan permintaan ini, abaikan pesan ini.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Reset Password
@endcomponent

Jika tombol di atas tidak berfungsi, Anda bisa menyalin tautan berikut ke browser Anda:
[{{ $url }}]({{ $url }})

Salam hangat,<br>
**Admin Sistem {{ $appName }}**
@endcomponent
