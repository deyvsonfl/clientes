<?php

namespace App\Controllers;

use App\Models\ConfigModel;

class Configuracoes extends BaseController
{
    public function index()
    {
        $model = new ConfigModel();
        $data['configuracoes'] = $model->getConfiguracoes(); // busca os dados salvos
        return view('configuracoes/configuracoes', $data);
    }

    public function salvar()
    {
        $model = new ConfigModel();
        $data = [
            'nome_sistema'     => $this->request->getPost('nome_sistema'),
            'dias_inatividade' => $this->request->getPost('dias_inatividade'),
            'mostrar_colunas' => implode(',', $this->request->getPost('mostrar_colunas') ?? [])
        ];

        $model->update(1, $data);

        return redirect()->to('/configuracoes')->with('success', 'Configurações atualizadas com sucesso.');
    }
}
