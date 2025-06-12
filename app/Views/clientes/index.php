<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<?php
$colunasRaw = $configuracoes['mostrar_colunas'] ?? '';
$colunasString = is_array($colunasRaw) ? implode(',', $colunasRaw) : $colunasRaw;
$mostrarColunas = explode(',', $colunasString);
?>

<h1>Lista de Clientes</h1>

<a href="<?= base_url('/clientes/criar') ?>" class="btn btn-primary mb-3">➕ Adicionar Cliente</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <?php if (in_array('instagram', $mostrarColunas)): ?>
                <th>Instagram</th>
            <?php endif; ?>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Nicho</th>
            <?php if (in_array('data_ultima_compra', $mostrarColunas)): ?>
                <th>Última Compra</th>
            <?php endif; ?>
            <?php if (in_array('total_gasto', $mostrarColunas)): ?>
                <th>Total Gasto</th>
            <?php endif; ?>
            <?php if (in_array('status', $mostrarColunas)): ?>
                <th>Status</th>
            <?php endif; ?>
            <?php if (in_array('recorrente', $mostrarColunas)): ?>
                <th>Recorrente</th>
            <?php endif; ?>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <form method="get" class="mb-3 row g-2">
            <div class="col-auto">
                <input type="text" name="q" class="form-control" placeholder="Buscar cliente..." value="<?= esc($buscar) ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= esc($cliente->nome) ?></td>
                <td><?= esc($cliente->telefone) ?></td>
                <?php if (in_array('instagram', $mostrarColunas)): ?>
                    <td><?= esc($cliente->instagram) ?></td>
                <?php endif; ?>
                <td><?= esc($cliente->estado) ?></td>
                <td><?= esc($cliente->cidade) ?></td>
                <td><?= esc($cliente->nicho) ?></td>
                <?php if (in_array('data_ultima_compra', $mostrarColunas)): ?>
                    <td><?= formatar_data_br($cliente->data_ultima_compra) ?></td>
                <?php endif; ?>
                <?php if (in_array('total_gasto', $mostrarColunas)): ?>
                    <td><?= formatar_real($cliente->total_gasto) ?></td>
                <?php endif; ?>
                <?php if (in_array('status', $mostrarColunas)): ?>
                    <td><?= statusCliente($cliente) ?></td>
                <?php endif; ?>
                <?php if (in_array('recorrente', $mostrarColunas)): ?>
                    <td><?= badge_recorrente($cliente->recorrente) ?></td>
                <?php endif; ?>
                <td>
                    <a href="<?= base_url('clientes/editar/' . $cliente->id) ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="<?= base_url('clientes/excluir/' . $cliente->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    <a href="<?= base_url("/clientes/{$cliente->id}/painel") ?>" class="btn btn-sm btn-info">Painel</a>
                    <a href="<?= base_url('pedidos/adicionar?cliente_id=' . $cliente->id) ?>" class="btn btn-sm btn-success">Novo Pedido</a>
                </td>
                <?= $pager->links('grupoClientes', 'default_full') ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->endSection(); ?>