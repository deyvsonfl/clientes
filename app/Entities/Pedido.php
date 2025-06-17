<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Pedido extends Entity
{
  protected $dates = ['data_compra'];

  public function getValorFormatado()
  {
    return number_format((float) $this->attributes['valor'], 2, ',', '.');
  }

  public function getDataCompraFormatada()
  {
    if (empty($this->attributes['data_compra'])) {
      return null;
    }

    return date('d/m/Y', strtotime($this->attributes['data_compra']));
  }
}
