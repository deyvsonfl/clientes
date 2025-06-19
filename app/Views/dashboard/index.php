<?php // app/Views/dashboard/index.php 
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3 class="mb-4">Dashboard - Mais Cartões</h3>
<p class="text-muted">Bem-vindo ao painel de controle. Aqui estão os principais indicadores do seu sistema de clientes.</p>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-primary shadow-sm">
            <div class="card-body">
                <h6 class="text-primary">Total de Clientes</h6>
                <h4 class="fw-bold mb-0"><?= esc($totalClientes) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success shadow-sm">
            <div class="card-body">
                <h6 class="text-success">Total de Pedidos</h6>
                <h4 class="fw-bold mb-0"><?= esc($totalPedidos) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-dark shadow-sm">
            <div class="card-body">
                <h6 class="text-dark">Total Investido</h6>
                <h4 class="fw-bold mb-0">R$ <?= number_format($totalInvestido, 2, ',', '.') ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning shadow-sm">
            <div class="card-body">
                <h6 class="text-warning">Ticket Médio</h6>
                <h4 class="fw-bold mb-0">R$ <?= number_format($ticketMedio, 2, ',', '.') ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-danger shadow-sm">
            <div class="card-body">
                <h6 class="text-danger">Clientes Inativos (<?= $diasInatividade ?>+ dias)</h6>
                <h4 class="fw-bold mb-0"><?= esc($clientesInativos) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-info shadow-sm">
            <div class="card-body">
                <h6 class="text-info">Clientes Recorrentes</h6>
                <h4 class="fw-bold mb-0"><?= esc($clientesRecorrentes) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-secondary shadow-sm">
            <div class="card-body">
                <h6 class="text-secondary">Cidade com Mais Clientes</h6>
                <h4 class="fw-bold mb-0"><?= esc($cidadeTop ?? '-') ?></h4>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>