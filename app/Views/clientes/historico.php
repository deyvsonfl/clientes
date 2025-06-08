<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>

<h1>Histórico de Compras - <?= esc($cliente['nome']) ?></h1>

<p><strong>Telefone:</strong> <?= esc($cliente['telefone']) ?></p>
<p><strong>Instagram:</strong> <?= esc($cliente['instagram']) ?></p>
<p><strong>Total Gasto:</strong> R$ <?= number_format($cliente['total_gasto'], 2, ',', '.') ?></p>
<p><strong>Última Compra:</strong> <?= esc($cliente['data_ultima_compra']) ?></p>

<hr>

<h3>Pedidos</h3>

<?php if (empty($pedidos)): ?>
    <p>Este cliente ainda não possui pedidos registrados.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Data</th>
                <th>Valor</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= esc($pedido['data_compra']) ?></td>
                    <td>R$ <?= number_format($pedido['valor'], 2, ',', '.') ?></td>
                    <td><?= esc($pedido['descricao']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a href="<?= base_url('clientes') ?>">← Voltar para a lista de clientes</a></p>

<?php $this->endSection(); ?>
