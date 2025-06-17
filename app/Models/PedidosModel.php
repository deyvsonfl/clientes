<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Pedido;

class PedidosModel extends Model
{
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $returnType       = Pedido::class; // Corrigido para usar Entity
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'cliente_id',
        'data_compra',
        'valor',
        'descricao',
        'status',
    ];

    protected array $casts = [
        'cliente_id' => 'integer',
        'valor'      => 'float',
    ];
}
