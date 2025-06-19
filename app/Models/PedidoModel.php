<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Pedido;

/**
 * Modelo principal de Pedidos
 * Compatível com a nova estrutura (Option B).
 */
class PedidoModel extends Model
{
    /** @var string Nome da tabela */
    protected $table = 'pedidos';

    /** @var string Nome da PK */
    protected $primaryKey = 'id';

    /** Retorna cada registro como Entity */
    protected $returnType = Pedido::class;

    /** @var bool Habilita dates automáticas */
    protected $useTimestamps = true; // created_at & updated_at

    /** @var bool Sem soft‑delete por enquanto */
    protected $useSoftDeletes = false;

    /** @var array Colunas que podem ser gravadas */
    protected $allowedFields = [
        'cliente_id',
        'descricao',
        'status',
        'forma_pagamento',
        'data_entrega',
        'total',
        'data_compra',
    ];

    /** @var array Tipos de cast automáticos */
    protected array $casts = [
        'cliente_id'   => 'integer',
        'total'        => 'float',
        'data_entrega' => '?date',
        'created_at'   => '?datetime',
        'updated_at'   => '?datetime',
    ];

    public const STATUS = [
        'em_aberto'    => 'Em Aberto',
        'em_producao'  => 'Em Produção',
        'entregue'     => 'Entregue',
        'cancelado'    => 'Cancelado',
    ];

    /**
     * Retorna todos os pedidos já com o nome do cliente.
     * Ideal para a listagem /pedidos.
     */
    public function getPedidosComClientes($clienteId): array
    {
        return $this
            ->select('pedidos.*, clientes.nome AS cliente')
            ->join('clientes', 'clientes.id = pedidos.cliente_id')
            ->where('pedidos.cliente_id', $clienteId)
            ->orderBy('pedidos.created_at', 'DESC')
            ->findAll();
    }
}
