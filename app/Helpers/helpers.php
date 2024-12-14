<?php

if (! function_exists('formatRupiah')) {
    function formatRupiah($nominal)
    {
        return number_format($nominal, 0, ',', '.');
    }
}
