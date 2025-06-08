<?php

namespace App\Validation;

class CustomRules
{
    public function valid_cep(string $str): bool
    {
        return (bool) preg_match('/^\d{5}-\d{3}$/', $str);
    }

    public function valid_phone(string $str): bool
    {
        return (bool) preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $str);
    }
}
