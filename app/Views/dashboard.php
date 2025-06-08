<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<h1>Dashboard</h1>
<p>Bem-vindo ao painel de controle. Aqui você poderá ver estatísticas e indicadores dos seus clientes.</p>

<ul>
    <li>Total de clientes: <?= esc($totalClientes) ?></li>
    <li>Clientes recorrentes: <?= esc($clientesRecorrentes) ?></li>
    <li>Ticket médio: R$ <?= number_format($ticketMedio, 2, ',', '.') ?></li>
    <li>Cidade com mais clientes: <?= esc($cidadeTop) ?></li>
    <li>Total investido pelos clientes: R$ <?= number_format($totalGasto, 2, ',', '.') ?></li>
</ul>

<?php $this->endSection(); ?>
