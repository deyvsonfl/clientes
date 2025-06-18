<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Models\ClienteModel;
use App\Models\PedidoModel;   // modelo novo (Option B)
use App\Models\PedidosModel;  // modelo antigo (para métodos já existentes)

/**
 * Controller unificado para Pedidos
 * — adiciona método index() para listar TODOS os pedidos
 */
class Pedidos extends Controller
{
    /**
     * GET /pedidos
     * Lista todos os pedidos de todos os clientes.
     */
    public function index()
    {
        $pedidoModel = new PedidoModel();

        $perPage = 20; // quantidade por página

        // Usa paginate() em vez de findAll()
        $dados['pedidos'] = $pedidoModel
            ->select('pedidos.*, clientes.nome AS cliente')
            ->join('clientes', 'clientes.id = pedidos.cliente_id')
            ->orderBy('pedidos.created_at', 'DESC')
            ->paginate($perPage);

        // Envia o pager para a view
        $dados['pager'] = $pedidoModel->pager;

        return view('pedidos/index', $dados);
    }

    /**
     * Exibe formulário para adicionar pedido.
     */
    public function adicionar()
    {
        $clienteId     = $this->request->getGet('cliente_id');
        $clienteModel  = new ClienteModel();
        $clientes      = $clienteModel->findAll();
        $cliente       = $clienteId ? $clienteModel->find($clienteId) : null;

        return view('pedidos/form', [
            'cliente'  => $cliente,
            'clientes' => $clientes,
        ]);
    }

    /**
     * Salva novo pedido vindo do formulário.
     */
    public function salvar()
    {
        $clienteId    = $this->request->getPost('cliente_id');
        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($clienteId);

        $valor        = (float) $this->request->getPost('valor');
        $data         = $this->request->getPost('data');
        $descricao    = $this->request->getPost('descricao');
        $status       = $this->request->getPost('status');
        $erros        = [];

        if (! $cliente) {
            $erros[] = 'O cliente selecionado não foi encontrado.';
        }
        if ($valor <= 0) {
            $erros[] = 'Informe um valor maior que zero para o pedido.';
        }
        if (empty($data)) {
            $erros[] = 'A data da compra é obrigatória.';
        }
        if ($erros) {
            return redirect()->back()->withInput()->with('errors', $erros);
        }

        // novo pedido usando PedidoModel
        $pedidoModel = new PedidoModel();
        $pedidoModel->insert([
            'cliente_id'     => $cliente->id,
            'total'          => $valor,
            'data_entrega'   => null,          // opcional
            'descricao'      => $descricao,
            'status'         => $status,
            'forma_pagamento' => 'pix',         // ajuste conforme form
        ]);

        // atualiza totals do cliente (exemplo)
        $cliente->total_gasto        += $valor;
        $cliente->data_ultima_compra  = $data;
        $clienteModel->save($cliente);

        return redirect()->to('/clientes/historico/' . $cliente->id)
            ->with('success', 'Pedido cadastrado com sucesso!');
    }

    // ... (demais métodos editar, atualizar, excluir, show).

    /**
     * Editar, atualizar, excluir e show mantidos como estavam.
     * Se quiser migrar para PedidoModel, basta trocar PedidosModel → PedidoModel
     * e ajustar nomes de campos (valor → total, data_compra → created_at ou manter cast).
     */
}
