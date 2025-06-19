<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>

<h2 class="mb-3">Histórico de Pedidos — <?= esc($cliente->nome) ?></h2>

<div class="mb-3">
    <a class="btn btn-sm btn-primary" href="<?= base_url('pedidos/adicionar?cliente_id=' . $cliente->id) ?>">
        ➕ Novo Pedido
    </a>
</div>

<?php if (empty($pedidos)): ?>
    <div class="alert alert-light border">Nenhum pedido registrado ainda.</div>
<?php else: ?>

    <!-- Filtros compactos -->
    <form method="get" class="row g-2 align-items-end mb-3">
        <input type="hidden" name="id" value="<?= $cliente->id ?>">

        <div class="col-md-3">
            <label for="data_inicial" class="form-label small mb-1">De:</label>
            <input type="date" name="data_inicial" id="data_inicial" class="form-control form-control-sm"
                value="<?= esc($dataInicial ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label for="data_final" class="form-label small mb-1">Até:</label>
            <input type="date" name="data_final" id="data_final" class="form-control form-control-sm"
                value="<?= esc($dataFinal ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label for="status" class="form-label small mb-1">Status:</label>
            <select name="status" id="status" class="form-select form-select-sm">
                <option value="">Todos</option>
                <?php foreach (['aberto', 'em produção', 'entregue', 'cancelado'] as $opcao): ?>
                    <option value="<?= $opcao ?>" <?= ($statusSelecionado ?? '') === $opcao ? 'selected' : '' ?>>
                        <?= ucfirst($opcao) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-outline-dark w-50">Filtrar</button>
            <a href="<?= base_url('/clientes/historico/' . $cliente->id) ?>" class="btn btn-sm btn-link w-50 text-muted">
                Limpar
            </a>
        </div>
    </form>

    <!-- Tabela limpa -->
    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
                <tr class="text-muted small">
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= isset($pedido->data_compra) ? date('d/m/Y', strtotime($pedido->data_compra)) : '-' ?></td>
                        <td>R$ <?= number_format($pedido->total, 2, ',', '.') ?></td>
                        <td><?= esc($pedido->descricao) ?></td>
                        <td><?= esc($pedido->status) ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-light text-secondary" href="<?= base_url('pedidos/editar/' . $pedido->id) ?>" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a class="btn btn-sm btn-light text-danger" href="<?= base_url('pedidos/excluir/' . $pedido->id) ?>" onclick="return confirm('Deseja excluir este pedido?')" title="Excluir">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div class="mt-4">
    <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('/clientes') ?>">← Voltar para Clientes</a>
</div>

<?php $this->endSection(); ?>