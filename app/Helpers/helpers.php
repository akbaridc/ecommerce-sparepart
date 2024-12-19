<?php

use App\Models\Order;

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
