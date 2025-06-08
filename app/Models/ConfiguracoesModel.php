<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracoesModel extends Model
{
    protected $table = 'configuracoes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome_sistema', 'dias_inatividade', 'mostrar_colunas'];
    protected $useTimestamps = false;

    public function getConfiguracoes()
    {
        return $this->first(); // Como só haverá um registro
    }

    public function salvarConfiguracoes(array $dados)
    {
        if ($this->countAll() == 0) {
            return $this->insert($dados); // Inserção inicial
        }

        return $this->update(1, $dados); // Atualização do registro único
    }
}
