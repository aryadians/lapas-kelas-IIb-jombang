# Product Overview

**Si-LAKU (Sistem Layanan Kunjungan Terintegrasi)** adalah platform digital untuk Lembaga Pemasyarakatan Kelas IIB Jombang yang mentransformasi prosedur kunjungan konvensional menjadi layanan berbasis teknologi modern.

## Core Purpose

Sistem ini menjembatani interaksi antara masyarakat (pengunjung) dengan Warga Binaan Pemasyarakatan (WBP) melalui:
- Manajemen pendaftaran kunjungan online
- Verifikasi keamanan otomatis
- Sistem antrian cerdas real-time
- E-ticket dengan QR Code
- Notifikasi WhatsApp dan Email

## Key Features

### Public/Visitor Module
- Self-service online visit registration with NIK validation
- Smart date picker with automatic quota management
- E-ticket with Base64 QR codes stored in database
- Real-time queue display for waiting rooms
- Voice announcer (TTS) in Indonesian
- Digital satisfaction survey (IKM)
- Accessibility features (TTS, high contrast, dyslexia font)

### Admin/Operations Module
- Mini dashboard with daily workload monitoring
- Smart quota manager (morning/afternoon sessions)
- Offline walk-in registration
- Visitor database with loyalty tracking
- WBP (inmate) management with block/cell locations
- Banner/slideshow management (images/videos)
- Queue control system
- Visit restriction system (Mapenaling, Strap Cell, TPP)
- Broadcast notifications for visit cancellations

## User Roles (RBAC)

- **super_admin**: Full system access
- **admin_registrasi**: Visit management, WBP, queue, settings, reports
- **admin_humas**: News, announcements, products, read-only visits
- **admin_umum**: Dashboard and reports only

## Production URL

Live at: https://lapasjombang.id/
