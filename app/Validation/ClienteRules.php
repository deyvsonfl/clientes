<?php

namespace App\Validation;

class ClienteRules
{
  public static function regrasCadastro(): array
  {
    return [
      'nome'     => 'required|min_length[3]',
      'telefone' => 'required|valid_phone',
      'cep'      => 'permit_empty|valid_cep',
      'estado'   => 'required',
      'cidade'   => 'required',
      'bairro'   => 'required',
      'endereco' => 'required',
    ];
  }
  public static function regrasAtualizacao(): array
  {
    return [
      'nome'     => 'required|min_length[3]',
      'telefone' => 'required|valid_phone',
      'instagram' => 'permit_empty',
      'cep'      => 'permit_empty|valid_cep',
      'estado'   => 'permit_empty',
      'cidade'   => 'permit_empty',
      'bairro'   => 'permit_empty',
      'endereco' => 'permit_empty',
      'data_ultima_compra' => 'permit_empty|valid_date',
      'total_gasto'        => 'permit_empty|decimal',
      'status'             => 'permit_empty|in_list[ativo,inativo]',
      'recorrente'         => 'permit_empty|in_list[0,1]',
      'nicho'              => 'permit_empty',
    ];
  }
}
