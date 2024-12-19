<?php

use App\Models\Order;
use App\Models\Site;

if (! function_exists('formatRupiah')) {
    function formatRupiah($nominal): string
    {
        return number_format($nominal, 0, ',', '.');
    }
}

if (! function_exists('alertResponse')) {
    function alertResponse(string $type = "success", string $message = "Data saved successfully"): array
    {
        return ['alert-toast' => true, 'type' => $type, 'message' => $message];
    }
}

if (! function_exists('codeTransaction')) {
    function codeTransaction()
    {
        $code = "TR" . date('Ymd') . rand(1000, 9999);
        while (Order::where('code', $code)->exists()) {
            $code = "TR" . date('Ymd') . rand(1000, 9999);
        }

        return $code;
    }
}

if (! function_exists('site')) {
    function site()
    {
        return Site::first(['name_application as name', 'phone', 'logo', 'favicon']);
    }
}

if (! function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($phoneNumber)
    {
        // Periksa apakah nomor dimulai dengan '0'
        if (strpos($phoneNumber, '0') === 0) {
            // Ganti '0' di awal dengan '+62'
            return '+62' . substr($phoneNumber, 1);
        }

        // Jika sudah berawalan '+62', kembalikan seperti semula
        if (strpos($phoneNumber, '+62') === 0) {
            return $phoneNumber;
        }

        // Jika format tidak dikenali, kembalikan tanpa perubahan
        return $phoneNumber;
    }
}
