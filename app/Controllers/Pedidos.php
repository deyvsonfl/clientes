<?php

namespace App\Controllers;

use App\Models\PedidosModel;
use App\Models\ClientesModel;
use CodeIgniter\Controller;

class Pedidos extends Controller
{
    public function adicionar()
    {
        $clienteNome = $this->request->getGet('cliente');
        $cliente = null;

        if ($clienteNome) {
            $cliente = (new ClientesModel())->where('nome', $clienteNome)->first();
        }

        return view('pedidos/form', ['cliente' => $cliente]);
    }

    public function salvar()
    {
        $clienteNome = $this->request->getPost('cliente');
        $clienteModel = new ClientesModel();
        $cliente = $clienteModel->where('nome', $clienteNome)->first();

        if (!$cliente) {
            return redirect()->to('/clientes/criar')->with('error', 'Cliente não encontrado. Por favor, cadastre-o primeiro.');
        }

        $valor = (float) $this->request->getPost('valor');
        $data = $this->request->getPost('data');
        $descricao = $this->request->getPost('descricao');

        // Salva o pedido
        $pedidoModel = new PedidosModel();
        $pedidoModel->insert([
            'cliente_id' => $cliente['id'],
            'valor' => $valor,
            'data_compra' => $data,
            'descricao' => $descricao,
        ]);

        // Atualiza cliente
        $cliente['total_gasto'] += $valor;
        $cliente['data_ultima_compra'] = $data;
        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $cliente['id']);
    }
}
