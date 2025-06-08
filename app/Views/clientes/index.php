<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<h1>Lista de Clientes</h1>

<form method="get" style="margin-bottom: 20px;">
    <label for="busca">Buscar:</label>
    <input type="text" name="busca" id="busca" value="<?= esc($_GET['busca'] ?? '') ?>">

    <label for="cidade">Cidade:</label>
    <input type="text" name="cidade" id="cidade" value="<?= esc($_GET['cidade'] ?? '') ?>">

    <label for="estado">Estado:</label>
    <input type="text" name="estado" id="estado" value="<?= esc($_GET['estado'] ?? '') ?>">

    <label for="nicho">Nicho:</label>
    <input type="text" name="nicho" id="nicho" value="<?= esc($_GET['nicho'] ?? '') ?>">

    <label for="recorrente">Recorrente:</label>
    <select name="recorrente" id="recorrente">
        <option value="">Todos</option>
        <option value="1" <?= ($_GET['recorrente'] ?? '') === '1' ? 'selected' : '' ?>>Sim</option>
        <option value="0" <?= ($_GET['recorrente'] ?? '') === '0' ? 'selected' : '' ?>>Não</option>
    </select>

    <label for="data_inicio">De:</label>
    <input type="date" name="data_inicio" id="data_inicio" value="<?= esc($_GET['data_inicio'] ?? '') ?>">

    <label for="data_fim">Até:</label>
    <input type="date" name="data_fim" id="data_fim" value="<?= esc($_GET['data_fim'] ?? '') ?>">

    <label for="ordenar">Ordenar por:</label>
    <select name="ordenar" id="ordenar">
        <option value="">Padrão</option>
        <option value="data" <?= ($_GET['ordenar'] ?? '') === 'data' ? 'selected' : '' ?>>Data da última compra</option>
        <option value="gasto" <?= ($_GET['ordenar'] ?? '') === 'gasto' ? 'selected' : '' ?>>Total gasto</option>
    </select>

    <button type="submit">Filtrar</button>
    <a href="<?= base_url('/clientes') ?>">Limpar</a>
</form>

<a href="<?= base_url('/clientes/criar') ?>">Adicionar Cliente</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Instagram</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Nicho</th>
            <th>Última Compra</th>
            <th>Total Gasto</th>
            <th>Status</th>
            <th>Recorrente</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= esc($cliente['nome']) ?></td>
                <td><?= esc($cliente['telefone']) ?></td>
                <td><?= esc($cliente['instagram']) ?></td>
                <td><?= esc($cliente['estado']) ?></td>
                <td><?= esc($cliente['cidade']) ?></td>
                <td><?= esc($cliente['nicho']) ?></td>
                <td><?= esc($cliente['data_ultima_compra']) ?></td>
                <td>R$ <?= number_format($cliente['total_gasto'], 2, ',', '.') ?></td>
                <td><?= esc($cliente['status']) ?></td>
                <td><?= $cliente['recorrente'] ? 'Sim' : 'Não' ?></td>
                <td>
                  <a href="<?= base_url('clientes/editar/' . $cliente['id']) ?>">Editar</a> |
                  <a href="<?= base_url('clientes/excluir/' . $cliente['id']) ?>" onclick="return confirm('Tem certeza?')">Excluir</a> |
                  <a href="<?= base_url('pedidos/adicionar?cliente=' . urlencode($cliente['nome'])) ?>">Adicionar Pedido</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->endSection(); ?>
