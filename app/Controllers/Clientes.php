<?php

namespace App\Controllers;

use App\Models\ClientesModel;
use App\Models\ComprasModel;
use CodeIgniter\Controller;

class Clientes extends Controller
{
    public function index()
    {
        $model = new ClientesModel();
        $dados['clientes'] = $model->findAll();
        return view('clientes/index', $dados);
    }

    public function criar()
    {
        return view('clientes/form');
    }

    public function salvar()
    {
        helper(['form']);

        $validationRules = [
            'nome'     => 'required|min_length[3]',
            'telefone' => 'required|valid_phone',
            'cep'      => 'permit_empty|valid_cep'
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ClientesModel();

        $data = [
            'nome' => $this->request->getPost('nome'),
            'telefone' => $this->request->getPost('telefone'),
            'instagram' => $this->request->getPost('instagram'),
            'cep' => $this->request->getPost('cep'),
            'estado' => $this->request->getPost('estado'),
            'cidade' => $this->request->getPost('cidade'),
            'bairro' => $this->request->getPost('bairro'),
            'endereco' => $this->request->getPost('endereco'),
            'data_ultima_compra' => $this->request->getPost('data_ultima_compra'),
            'total_gasto' => $this->request->getPost('total_gasto'),
            'status' => $this->request->getPost('status'),
            'recorrente' => $this->request->getPost('recorrente'),
            'nicho' => $this->request->getPost('nicho')
        ];

        $model->save($data);
        return redirect()->to('/clientes');
    }

    public function editar($id)
    {
        $model = new ClientesModel();
        $dados['cliente'] = $model->find($id);

        if (!$dados['cliente']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cliente com ID $id não encontrado.");
        }

        return view('clientes/form', $dados);
    }

    public function atualizar($id)
    {
        helper(['form']);

        $validationRules = [
            'nome'     => 'required|min_length[3]',
            'telefone' => 'required|valid_phone',
            'cep'      => 'permit_empty|valid_cep'
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ClientesModel();

        $data = [
            'id' => $id,
            'nome' => $this->request->getPost('nome'),
            'telefone' => $this->request->getPost('telefone'),
            'instagram' => $this->request->getPost('instagram'),
            'cep' => $this->request->getPost('cep'),
            'estado' => $this->request->getPost('estado'),
            'cidade' => $this->request->getPost('cidade'),
            'bairro' => $this->request->getPost('bairro'),
            'endereco' => $this->request->getPost('endereco'),
            'data_ultima_compra' => $this->request->getPost('data_ultima_compra'),
            'total_gasto' => $this->request->getPost('total_gasto'),
            'status' => $this->request->getPost('status'),
            'recorrente' => $this->request->getPost('recorrente'),
            'nicho' => $this->request->getPost('nicho')
        ];

        $model->save($data);
        return redirect()->to('/clientes');
    }

    public function excluir($id)
    {
        $model = new ClientesModel();
        $model->delete($id);
        return redirect()->to('/clientes');
    }

    public function historico($id)
{
    $clienteModel = new ClientesModel();
    $pedidoModel = new \App\Models\PedidosModel();

    $cliente = $clienteModel->find($id);
    $pedidos = $pedidoModel->where('cliente_id', $id)->findAll();

    return view('clientes/historico', [
        'cliente' => $cliente,
        'pedidos' => $pedidos
    ]);
}
}
