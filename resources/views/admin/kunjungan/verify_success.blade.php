@extends('layouts.admin')

@section('title', 'Verifikasi Kunjungan Berhasil')

@section('content-header')
@endsection

@push('styles')
<style>
    .success-page-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background-color: #f4f6f9;
        min-height: 80vh;
    }

    .success-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.08);
        padding: 45px;
        width: 100%;
        max-width: 580px;
        text-align: center;
        background-image: linear-gradient(to top, #fff, #fff), linear-gradient(to right, #28a745, #20c997);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        border: 4px solid transparent;
    }

    /* Animation */
    .success-checkmark {
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;
    }
    .success-checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke: #28a745;
        fill: rgba(40, 167, 69, 0.07);
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .success-checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke-width: 4;
        stroke: #fff;
        stroke-linecap: round;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    /* Typography */
    .success-card h1 {
        font-size: 1.9rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #343a40;
    }
    .success-card p.lead {
        font-size: 1.05rem;
        color: #6c757d;
        margin-bottom: 35px;
    }
    
    /* Details Section */
    .visit-details {
        background-color: #f9fafb; 
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 35px;
        text-align: left;
    }
    .visit-details table {
        width: 100%;
        border-collapse: collapse;
    }
    .visit-details tr:not(:last-child) {
        border-bottom: 1px solid #f0f2f5;
    }
    .visit-details th, .visit-details td {
        padding: 12px 5px;
        border: none;
        font-size: 0.95rem;
        vertical-align: middle;
    }
    .visit-details th {
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .visit-details td {
        color: #343a40;
        font-weight: 600;
        text-align: right;
    }
    .visit-details .antrian-badge {
        font-size: 1.1rem;
        font-weight: 700;
        padding: 0.4em 0.8em;
        background-color: #007bff;
        color: #fff;
        border-radius: 8px;
    }

    /* Buttons */
    .action-buttons-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    .action-buttons-grid .btn {
        font-size: 0.95rem;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .action-buttons-grid .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
    }
    .action-buttons-grid .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.2);
    }
    .action-buttons-grid .btn-outline-secondary {
        border-width: 2px;
        color: #6c757d;
    }
     .action-buttons-grid .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="success-page-container">
    <div class="success-card">
        
        <div class="success-checkmark">
            <svg viewBox="0 0 52 52">
                <circle class="success-checkmark__circle" cx="26" cy="26" r="25"/>
                <path class="success-checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>

        <h1>Verifikasi Berhasil</h1>
        <p class="lead">{{ $message }}</p>

        <div class="visit-details">
            <table>
                <tr>
                    <th>Kode Kunjungan</th>
                    <td>{{ $kunjungan->kode_kunjungan }}</td>
                </tr>
                <tr>
                    <th>WBP Tujuan</th>
                    <td><strong>{{ optional($kunjungan->wbp)->nama ?? 'N/A' }}</strong></td>
                </tr>
                <tr>
                    <th>Pengunjung</th>
                    <td>{{ $kunjungan->nama_pengunjung }}</td>
                </tr>
                <tr>
                    <th>Jadwal Kunjungan</th>
                    <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }} (Sesi {{ ucfirst($kunjungan->sesi) }})</td>
                </tr>
                <tr>
                    <th>Nomor Antrian</th>
                    <td><span class="antrian-badge">{{ $kunjungan->nomor_antrian_harian ?? 'N/A' }}</span></td>
                </tr>
            </table>
        </div>

        <div class="action-buttons-grid">
            <a href="{{ route('admin.kunjungan.verifikasi') }}" class="btn btn-outline-secondary">
                <i class="fas fa-qrcode"></i>
                Scan Lagi
            </a>
            <a href="{{ route('kunjungan.print', $kunjungan->id) }}" target="_blank" class="btn btn-primary">
                <i class="fas fa-print"></i>
                Cetak Struk
            </a>
        </div>
    </div>
</div>
@endsection
