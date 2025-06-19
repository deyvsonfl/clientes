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

    @media (max-width: 768px) {

        .form-select,
        .form-control,
        .btn {
            width: 100%;
        }
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

    <!-- Gráfico de Vendas e Últimos Pedidos -->
    <div class="row mt-5 g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
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
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-semibold text-dark mb-3"><i class="bi bi-clock-history text-secondary me-1"></i> Últimos Pedidos</h5>
                    <ul class="list-group list-group-flush">
                        <?php if (isset($ultimosPedidos) && is_array($ultimosPedidos)): ?>
                            <?php foreach ($ultimosPedidos as $pedido): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-semibold"><?= esc($pedido->cliente_nome) ?></div>
                                        <small class="text-muted"><?= esc($pedido->descricao) ?> — <?= date('d/m/Y', strtotime($pedido->data_compra)) ?></small>
                                    </div>
                                    <span class="fw-bold">R$ <?= number_format($pedido->total, 2, ',', '.') ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">Nenhum pedido recente encontrado.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let grafico;

    function carregarGrafico(tipo = 'semana', inicio = '', fim = '') {
        fetch(`/dashboard/dados-grafico?tipo=${tipo}&inicio=${inicio}&fim=${fim}`)
            .then(response => response.json())
            .then(dados => {
                const labels = dados.map(item => item.dia.split('-').reverse().join('/'));
                const valores = dados.map(item => parseFloat(item.total));

                if (grafico) grafico.destroy();

                const ctx = document.getElementById('graficoVendas').getContext('2d');
                grafico = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Vendas (R$)',
                            data: valores,
                            fill: true,
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderColor: '#0d6efd',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
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
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const filtro = document.getElementById('filtro-vendas');
        const inicio = document.getElementById('inicio');
        const fim = document.getElementById('fim');
        const btn = document.getElementById('btnFiltrar');

        const toggleDatas = () => {
            const show = filtro.value === 'personalizado';
            inicio.style.display = show ? 'block' : 'none';
            fim.style.display = show ? 'block' : 'none';
        };

        filtro.addEventListener('change', toggleDatas);
        btn.addEventListener('click', () => {
            carregarGrafico(filtro.value, inicio.value, fim.value);
        });

        carregarGrafico(); // inicial
    });
</script>

<?= $this->endSection() ?>