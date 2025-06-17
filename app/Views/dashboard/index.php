<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<?php $diasInatividade = $configuracoes['dias_inatividade'] ?? 60; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-0">Dashboard</h1>
        <small class="text-muted">Indicadores gerais do sistema</small>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <div class="col">
        <div class="card border-primary shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Total de Clientes</h6>
                <p class="fs-4 fw-bold text-primary mb-0">
                    <i class="bi bi-people-fill me-2"></i><?= esc($totalClientes) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card border-success shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Clientes Recorrentes</h6>
                <p class="fs-4 fw-bold text-success mb-0">
                    <i class="bi bi-repeat me-2"></i><?= esc($clientesRecorrentes) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card border-danger shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Clientes Inativos (&gt;<?= $diasInatividade ?> dias)</h6>
                <p class="fs-4 fw-bold text-danger mb-0">
                    <i class="bi bi-slash-circle me-2"></i><?= esc($clientesInativos) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card border-warning shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Ticket Médio</h6>
                <p class="fs-4 fw-bold text-warning mb-0">
                    <i class="bi bi-cash-coin me-2"></i>R$ <?= number_format($ticketMedio, 2, ',', '.') ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card border-info shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Cidade com mais Clientes</h6>
                <p class="fs-4 fw-bold text-info mb-0">
                    <i class="bi bi-geo-alt-fill me-2"></i><?= esc($cidadeTop) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card border-dark shadow-sm h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Investido</h6>
                <p class="fs-4 fw-bold text-dark mb-0">
                    <i class="bi bi-bar-chart-fill me-2"></i>R$ <?= number_format($totalGasto, 2, ',', '.') ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>