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

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            border-right: 1px solid #dee2e6;
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

    <!-- Flash messages -->
    <?= view('partials/messages') ?>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
                <div class="position-sticky">
                    <ul class="nav flex-column px-2">
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('dashboard') ? 'active' : '' ?>" href="<?= base_url('/dashboard') ?>">
                            <i class="bi bi-graph-up"></i> Dashboard
                            </a>
                        </li>
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
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('configuracoes') ? 'active' : '' ?>" href="<?= base_url('/configuracoes') ?>">
                                ⚙️ Configurações
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Conteúdo principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <?= $this->renderSection('content') ?>
            </main>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
