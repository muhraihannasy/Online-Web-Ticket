<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
     /**
     * Retrieve the value and format it as Rupiah.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $formattedValue = round(floatval($value) / 100, 2);

        // Format as Rupiah with thousands separators and "Rp" prefix
        // return $value;
        return 'Rp ' . number_format($formattedValue, 2, '.', '.');
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // Remove "Rp", commas, and periods from the input
        $cleanedValue = str_replace(['Rp', '.', '.'], '', $value);

        // Convert the cleaned value to a float and then to an integer for storage
        return round(floatval($cleanedValue) * 100);
    }

}
