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
        'descricao'
    ];
    protected $useTimestamps = false;

    public function getPedidosByClienteId($clienteId)
    {
        return $this->where('cliente_id', $clienteId)
                    ->orderBy('data_compra', 'DESC')
                    ->findAll();
    }
}
