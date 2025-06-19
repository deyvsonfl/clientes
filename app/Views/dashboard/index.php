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
                    <h6 class="text-muted mb-1"><i class="bi bi-people-fill text-primary me-1"></i> Total de Clientes</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($totalClientes) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted mb-1"><i class="bi bi-bag-check-fill text-success me-1"></i>Total de Pedidos</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($totalPedidos) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted mb-1"><i class="bi bi-wallet2 text-dark me-1"></i> Total Investido</h6>
                    <h4 class="fw-bold mb-0 text-dark">R$ <?= number_format($totalInvestido, 2, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted mb-1"><i class="bi bi-graph-up-arrow text-warning me-1"></i> Ticket Médio</h6>
                    <h4 class="fw-bold mb-0 text-dark">R$ <?= number_format($ticketMedio, 2, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted mb-1"><i class="bi bi-person-dash-fill text-danger me-1"></i> Clientes Inativos (<?= $diasInatividade ?>+ dias)</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($clientesInativos) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted mb-1"><i class="bi bi-repeat text-info me-1"></i> Clientes Recorrentes</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($clientesRecorrentes) ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h6 class="text-muted mb-1"><i class="bi bi-geo-alt-fill text-secondary me-1"></i> Cidade com Mais Clientes</h6>
                    <h4 class="fw-bold mb-0 text-dark"><?= esc($cidadeTop ?? '-') ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>