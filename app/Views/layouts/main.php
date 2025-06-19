<?php
// Tenta carregar as configurações se o model existir
if (!isset($configuracoes)) {
    if (class_exists(\App\Models\ConfigModel::class)) {
        $configuracoes = (new \App\Models\ConfigModel())->getConfiguracoes();
    } else {
        $configuracoes = [
            'nome_sistema' => 'Sistema',
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= esc($configuracoes['nome_sistema'] ?? 'Sistema') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fontes Google (Inter, Montserrat, Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@400;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', 'Montserrat', 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            border-right: 1px solid #dee2e6;
            background-color: #fdfdfd;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.05);
        }


        .nav-link {
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #e9ecef;
            border-radius: .375rem;
        }
    </style>
</head>

<body>

    <!-- Cabeçalho fixo -->
    <nav class="navbar navbar-light bg-white border-bottom px-4 py-2 sticky-top shadow-sm">
        <span class="navbar-brand mb-0 h5"><?= esc($configuracoes['nome_sistema'] ?? 'Sistema') ?></span>
        <div class="d-flex">
            <a href="<?= base_url('/logout') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </nav>

    <!-- Flash messages -->
    <?= view('partials/messages') ?>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar py-4">
                <div class="position-sticky">
                    <ul class="nav flex-column px-2">
                        <!-- Menu principal -->
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('dashboard') ? 'active' : '' ?>" href="<?= base_url('/dashboard') ?>">
                                <i class="bi bi-graph-up"></i> Dashboard
                            </a>
                        </li>

                        <!-- Clientes e Pedidos -->
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('clientes*') ? 'active' : '' ?>" href="<?= base_url('/clientes') ?>">
                                <i class="bi bi-people-fill"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('pedidos/adicionar') ? 'active' : '' ?>" href="<?= base_url('/pedidos/adicionar') ?>">
                                <i class="bi bi-plus-circle"></i> Novo Pedido
                            </a>
                        </li>
                        <?php $uri = service('uri'); ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $uri->getSegment(1) == 'pedidos' ? 'active' : '' ?>" href="<?= base_url('pedidos') ?>">
                                <i class="bi bi-receipt-cutoff me-2"></i> Pedidos
                            </a>
                        </li>

                        <hr>

                        <!-- Outras opções -->
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('configuracoes') ? 'active' : '' ?>" href="<?= base_url('/configuracoes') ?>">
                                <i class="bi bi-gear"></i> Configurações
                            </a>
                        </li>
                    </ul>

                </div>
            </nav>

            <!-- Conteúdo principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 p-4">
                <?= $this->renderSection('content') ?>
            </main>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>