<?php

if (!function_exists('format_real_to_float')) {
  function format_real_to_float(string $valor): float
  {
    $valor = preg_replace('/[^\d,]/', '', $valor);  // remove símbolos
    return floatval(str_replace(',', '.', $valor));
  }
}
