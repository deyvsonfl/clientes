<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>

<h1>Histórico de Pedidos de <?= esc($cliente->nome) ?></h1>

<div class="mb-3">
    <a class="btn btn-primary" href="<?= base_url('pedidos/adicionar?cliente_id=' . $cliente->id) ?>">
        ➕ Adicionar Novo Pedido
    </a>
</div>

<?php if (empty($pedidos)): ?>
    <div class="alert alert-info">Nenhum pedido registrado ainda.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= formatar_data_br($pedido->data_compra) ?></td>
                        <td><?= formatar_real($pedido->valor) ?></td>
                        <td><?= esc($pedido->descricao) ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('pedidos/editar/' . $pedido->id) ?>">Editar</a>
                            <a class="btn btn-sm btn-outline-danger" href="<?= base_url('pedidos/excluir/' . $pedido->id) ?>" onclick="return confirm('Deseja excluir este pedido?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div class="mt-4">
    <a class="btn btn-outline-dark" href="<?= base_url('/clientes') ?>">← Voltar para Clientes</a>
</div>

<?php $this->endSection(); ?>