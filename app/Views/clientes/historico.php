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

    <form method="get" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="data_inicio">Data Inicial</label>
            <input type="date" id="data_inicio" name="data_inicio" value="<?= esc($filtros['data_inicio'] ?? '') ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="data_fim">Data Final</label>
            <input type="date" id="data_fim" name="data_fim" value="<?= esc($filtros['data_fim'] ?? '') ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="valor_min">Valor Mínimo</label>
            <input type="number" id="valor_min" name="valor_min" step="0.01" value="<?= esc($filtros['valor_min'] ?? '') ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="valor_max">Valor Máximo</label>
            <input type="number" id="valor_max" name="valor_max" step="0.01" value="<?= esc($filtros['valor_max'] ?? '') ?>" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">🔍 Filtrar</button>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <a href="<?= current_url() ?>" class="btn btn-outline-secondary w-100">⟳ Limpar</a>
        </div>
    </form>

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