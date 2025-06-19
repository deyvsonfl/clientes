<?php /* app/Views/dashboard/index.php */ ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Fonte personalizada -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@400;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    body {
        font-family: 'Inter', 'Montserrat', 'Roboto', sans-serif;
    }
</style>

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
                    <h6 class="text-muted mb-1"><i class="bi bi-bag-check-fill text-success me-1"></i> Total de Pedidos</h6>
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

    <!-- Gráfico de Vendas -->
    <div class="card border-0 shadow-sm rounded-4 mt-5">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-semibold text-dark"><i class="bi bi-bar-chart-line text-primary me-1"></i> Vendas</h5>
                <form class="d-flex flex-wrap gap-2 align-items-center w-100 w-md-auto">
                    <select class="form-select form-select-sm" id="filtro-vendas">
                        <option value="semana">Últimos 7 dias</option>
                        <option value="mes">Este mês</option>
                        <option value="ano">Este ano</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                    <input type="date" id="inicio" class="form-control form-control-sm" style="display: none">
                    <input type="date" id="fim" class="form-control form-control-sm" style="display: none">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="btnFiltrar">Aplicar</button>
                </form>
            </div>
            <div class="position-relative overflow-hidden">
                <canvas id="graficoVendas" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('graficoVendas').getContext('2d');
    const grafico = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Vendas (R$)',
                data: [120, 90, 150, 100, 200, 180, 130],
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderColor: '#0d6efd',
                tension: 0.4,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'R$ ' + value.toFixed(2).replace('.', ',')
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>