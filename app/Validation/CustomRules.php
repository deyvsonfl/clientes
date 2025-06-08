<?php

namespace App\Validation;

class CustomRules
{
   public function valid_cep(string $str): bool
{
    // Permite com ou sem hífen, contanto que tenha 8 dígitos
    return (bool) preg_match('/^\d{5}-?\d{3}$/', $str);
}

    public function valid_phone(string $str): bool
{
    $str = preg_replace('/\D/', '', $str); // remove tudo que não for número
    return preg_match('/^\d{10,11}$/', $str); // 10 ou 11 dígitos
}

}
