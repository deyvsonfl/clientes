<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\PedidosModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Pedidos extends Controller
{
    public function adicionar()
    {
        $clienteId = $this->request->getGet('cliente_id');
        $clienteModel = new ClienteModel();
        $clientes = $clienteModel->findAll();

        $cliente = $clienteId ? $clienteModel->find($clienteId) : null;

        return view('pedidos/form', [
            'cliente'  => $cliente,
            'clientes' => $clientes
        ]);
    }

    public function salvar()
    {
        $clienteId = $this->request->getPost('cliente_id');
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($clienteId);

        $valor     = (float) $this->request->getPost('valor');
        $data      = $this->request->getPost('data');
        $descricao = $this->request->getPost('descricao');

        $erros = [];

        if (! $cliente) {
            $erros[] = 'O cliente selecionado não foi encontrado.';
        }
        if ($valor <= 0) {
            $erros[] = 'Informe um valor maior que zero para o pedido.';
        }
        if (empty($data)) {
            $erros[] = 'A data da compra é obrigatória.';
        }

        if (!empty($erros)) {
            return redirect()->back()->withInput()->with('errors', $erros);
        }

        $pedidoModel = new PedidosModel();
        $pedidoModel->insert([
            'cliente_id'  => $cliente->id,
            'valor'       => $valor,
            'data_compra' => $data,
            'descricao'   => $descricao,
        ]);

        // Atualiza os dados do cliente usando a Entity
        $cliente->total_gasto += $valor;
        $cliente->data_ultima_compra = $data;

        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $cliente->id)->with('success', 'Pedido cadastrado com sucesso!');
    }

    public function editar($id)
    {
        $pedidoModel = new PedidosModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Não foi possível localizar este pedido.');
        }

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($pedido->cliente_id);
        $clientes = $clienteModel->findAll();

        $pedido->valor = number_format((float) $pedido->valor, 2, '.', '');

        return view('pedidos/form', [
            'pedido'   => $pedido,
            'cliente'  => $cliente,
            'clientes' => $clientes
        ]);
    }

    public function atualizar($id)
    {
        $pedidoModel = new PedidosModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Este pedido não está disponível ou já foi removido.');
        }

        $valorAntigo = $pedido->valor;
        $clienteId   = $pedido->cliente_id;

        $valorNovo   = (float) $this->request->getPost('valor');
        $data        = $this->request->getPost('data');
        $descricao   = $this->request->getPost('descricao');

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
            'valor'       => $valorNovo,
            'data_compra' => Time::createFromFormat('Y-m-d H:i:s', $data . ' 00:00:00'),
            'descricao'   => $descricao,
        ]);

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($clienteId);

        $cliente->total_gasto = ($cliente->total_gasto - $valorAntigo) + $valorNovo;
        $cliente->data_ultima_compra = $data;

        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $cliente->id)->with('success', 'Pedido atualizado com sucesso!');
    }

    public function excluir($id)
    {
        $pedidoModel = new PedidosModel();
        $pedido = $pedidoModel->find($id);

        if (! $pedido) {
            return redirect()->back()->with('error', 'Não encontramos esse pedido para excluir.');
        }

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($pedido->cliente_id);

        $cliente->total_gasto -= $pedido->valor;
        $clienteModel->save($cliente);

        $pedidoModel->delete($id);

        return redirect()->to('/clientes/historico/' . $cliente->id)->with('success', 'Pedido excluído com sucesso!');
    }
}
