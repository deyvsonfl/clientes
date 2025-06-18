<?php

if (!function_exists('formatar_real')) {
    function formatar_real($valor)
    {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }
}
