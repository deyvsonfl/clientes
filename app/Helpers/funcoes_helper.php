<?php

if (!function_exists('statusCliente')) {
    function statusCliente(array $cliente, int $diasInatividade = 60): string
    {
        if (empty($cliente['data_ultima_compra'])) return 'Inativo';

        $ultimaCompra = strtotime($cliente['data_ultima_compra']);
        $limite = strtotime("-{$diasInatividade} days");

        return ($ultimaCompra >= $limite) ? 'Ativo' : 'Inativo';
    }
}
