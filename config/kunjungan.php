<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kunjungan (Visit) Settings
    |--------------------------------------------------------------------------
    |
    | This file is for storing the settings for the Kunjungan feature.
    |
    */

    'quota_hari_biasa' => env('KUOTA_HARI_BIASA', 150),

    'quota_senin_pagi' => env('KUOTA_SENIN_PAGI', 120),

    'quota_senin_siang' => env('KUOTA_SENIN_SIANG', 40),

    'quota_offline_hari_biasa' => env('KUOTA_OFFLINE_HARI_BIASA', 20),

    'quota_offline_senin_pagi' => env('KUOTA_OFFLINE_SENIN_PAGI', 15),

    'quota_offline_senin_siang' => env('KUOTA_OFFLINE_SENIN_SIANG', 5),
];
