<?php /* app/Views/dashboard/index.php */ ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <h2 class="mb-4 fw-semibold text-dark">Dashboard - Mais Cartões</h2>
    <p class="text-muted mb-4">Acompanhe os principais indicadores de desempenho do seu sistema de clientes.</p>

    <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-primary mb-1">Total de Clientes</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($totalClientes) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-success mb-1">Total de Pedidos</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($totalPedidos) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-dark mb-1">Total Investido</h6>
                    <h4 class="fw-bold mb-0 text-dark">R$ <?= number_format($totalInvestido, 2, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-warning mb-1">Ticket Médio</h6>
                    <h4 class="fw-bold mb-0 text-dark">R$ <?= number_format($ticketMedio, 2, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-danger mb-1">Clientes Inativos (<?= $diasInatividade ?>+ dias)</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($clientesInativos) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-info mb-1">Clientes Recorrentes</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($clientesRecorrentes) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-secondary mb-1">Cidade com Mais Clientes</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($cidadeTop ?? '-') ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>