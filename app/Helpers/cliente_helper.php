<?php

if (!function_exists('statusCliente')) {
    function statusCliente($cliente)
    {
        $dias = (new DateTime())->diff(new DateTime($cliente['data_ultima_compra'] ?? '2000-01-01'))->days;
        $total = $cliente['total_pedidos'] ?? 1;

        return ($total > 1 && $dias <= 60) ? 'Ativo' : 'Inativo';
    }
}

if (!function_exists('badge_recorrente')) {
    function badge_recorrente($valor)
    {
        return $valor
            ? '<span class="badge bg-success">Sim</span>'
            : '<span class="badge bg-secondary">Não</span>';
    }
}
