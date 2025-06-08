<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<h1>Histórico de Pedidos de <?= esc($cliente['nome']) ?></h1>

<a href="<?= base_url('pedidos/adicionar?cliente=' . urlencode($cliente['nome'])) ?>">Adicionar Novo Pedido</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Data</th>
            <th>Valor</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pedidos as $pedido): ?>
        <tr>
            <td><?= esc(date('d/m/Y', strtotime($pedido['data_compra']))) ?></td>
            <td>R$ <?= number_format($pedido['valor'], 2, ',', '.') ?></td>
            <td><?= esc($pedido['descricao']) ?></td>
            <td>
                <a href="<?= base_url('pedidos/editar/' . $pedido['id']) ?>">Editar</a> |
                <a href="<?= base_url('pedidos/excluir/' . $pedido['id']) ?>" onclick="return confirm('Deseja excluir este pedido?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= base_url('/clientes') ?>">← Voltar para Clientes</a>
<?php $this->endSection(); ?>
