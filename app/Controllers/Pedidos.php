<?php

namespace App\Controllers;

use App\Models\{PedidosModel, ClientesModel};
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
        $valor = str_replace(['R$', '.', ','], ['', '', '.'], $this->request->getPost('valor'));
        $valor = (float) $valor;
        $data = $this->request->getPost('data');
        $descricao = $this->request->getPost('descricao');

        $erros = [];
        if ($valor <= 0) {
            $erros[] = 'O valor do pedido deve ser maior que zero.';
        }
        if (empty($data)) {
            $erros[] = 'A data do pedido é obrigatória.';
        }
        if (empty($clienteNome)) {
            $erros[] = 'O nome do cliente é obrigatório.';
        }

        if (!empty($erros)) {
            return redirect()->back()->withInput()->with('errors', $erros);
        }

        $pedidoModel = new PedidosModel();
        $pedidoModel->insert([
            'cliente_id' => $cliente['id'],
            'valor' => $valor,
            'data_compra' => $data,
            'descricao' => $descricao,
        ]);

        $cliente['total_gasto'] += $valor;
        $cliente['data_ultima_compra'] = $data;
        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $cliente['id']);
    }

    public function editar($id)
    {
        $pedidoModel = new PedidosModel();
        $pedido = $pedidoModel->find($id);

        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido não encontrado.');
        }

        $clienteModel = new ClientesModel();
        $cliente = $clienteModel->find($pedido['cliente_id']);

        return view('pedidos/form', [
            'pedido' => $pedido,
            'cliente' => $cliente
        ]);
    }

    public function atualizar($id)
    {
        $pedidoModel = new PedidosModel();
        $pedido = $pedidoModel->find($id);

        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido não encontrado.');
        }

        $valorAntigo = $pedido['valor'];
        $clienteId = $pedido['cliente_id'];

        $valorNovo = (float) $this->request->getPost('valor');
        $data = $this->request->getPost('data');
        $descricao = $this->request->getPost('descricao');

        $erros = [];
        if ($valorNovo <= 0) {
            $erros[] = 'O valor do pedido deve ser maior que zero.';
        }
        if (empty($data)) {
            $erros[] = 'A data do pedido é obrigatória.';
        }

        if (!empty($erros)) {
            return redirect()->back()->withInput()->with('errors', $erros);
        }

        $pedidoModel->update($id, [
            'valor' => $valorNovo,
            'data_compra' => $data,
            'descricao' => $descricao,
        ]);

        $clienteModel = new ClientesModel();
        $cliente = $clienteModel->find($clienteId);

        $cliente['total_gasto'] = ($cliente['total_gasto'] - $valorAntigo) + $valorNovo;
        $cliente['data_ultima_compra'] = $data;
        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $clienteId);
    }

    public function excluir($id)
    {
        $pedidoModel = new PedidosModel();
        $pedido = $pedidoModel->find($id);

        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido não encontrado.');
        }

        $clienteModel = new ClientesModel();
        $cliente = $clienteModel->find($pedido['cliente_id']);

        $cliente['total_gasto'] -= $pedido['valor'];
        $clienteModel->save($cliente);

        $pedidoModel->delete($id);

        return redirect()->to('/clientes/historico/' . $cliente['id']);
    }
}
