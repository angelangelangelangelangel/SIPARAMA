<?php

use App\Models\ActivityLog;

if (!function_exists('logActivity')) {

    function logActivity($modul, $aktivitas)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'modul' => $modul,
            'aktivitas' => $aktivitas,
        ]);
    }
}