<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidosModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'cliente_id',
        'data_compra',
        'valor',
        'descricao',
    ];

    protected array $casts = [
        'cliente_id' => 'integer',
        'valor' => 'float',
        // 'data_compra' removido
    ];
}
