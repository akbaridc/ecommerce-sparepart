<?php

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
