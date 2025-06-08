<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<h1>Adicionar Pedido</h1>

<?php if (session()->getFlashdata('error')) : ?>
    <div style="color: red;"> <?= session()->getFlashdata('error') ?> </div>
<?php endif; ?>

<form action="<?= base_url('pedidos/salvar') ?>" method="post">
    <label for="cliente">Nome do Cliente:</label>
    <input type="text" name="cliente" id="cliente" value="<?= esc($cliente['nome'] ?? '') ?>" required>

    <label for="data">Data do Pedido:</label>
    <input type="date" name="data" id="data" value="<?= date('Y-m-d') ?>" required>

    <label for="valor">Valor do Pedido (R$):</label>
    <input type="number" step="0.01" name="valor" id="valor" required>

    <label for="descricao">Descrição (opcional):</label>
    <textarea name="descricao" id="descricao"></textarea>

    <button type="submit">Salvar Pedido</button>
</form>

<a href="<?= base_url('clientes') ?>">&larr; Voltar para lista de clientes</a>
<?php $this->endSection(); ?>
