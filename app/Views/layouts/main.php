<?php
if (!isset($configuracoes)) {
    if (class_exists(\App\Models\ConfigModel::class)) {
        $configuracoes = (new \App\Models\ConfigModel())->getConfiguracoes();
    } else {
        $configuracoes = ['nome_sistema' => 'Sistema'];
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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --cor-primaria: #2563eb;
            --cor-bg: #f8f9fa;
            --cor-branco: #ffffff;
            --cor-borda: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--cor-bg);
        }

        .navbar {
            background-color: var(--cor-branco);
        }

        .sidebar {
            background-color: #fbfbfb;
            border-right: 1px solid var(--cor-borda);
            min-height: 100vh;
        }

        .sidebar .nav-link {
            font-weight: 500;
            padding: 0.75rem 1rem;
            color: #374151;
            border-radius: .5rem;
            transition: background 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: var(--cor-primaria);
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }

        main {
            background-color: var(--cor-branco);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            min-height: 90vh;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .offcanvas-start {
            width: 260px;
        }

        @media (max-width: 767.98px) {
            main {
                padding: 1.5rem 1rem;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-light border-bottom sticky-top shadow-sm px-3 py-2">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <!-- Botão menu mobile -->
                <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                    <i class="bi bi-list"></i>
                </button>

                <span class="navbar-brand m-0"><?= esc($configuracoes['nome_sistema'] ?? 'Sistema') ?></span>
            </div>

            <a href="<?= base_url('/logout') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    <?= view('partials/messages') ?>

    <div class="container-fluid">
        <div class="row g-3">

            <!-- SIDEBAR DESKTOP -->
            <nav class="col-md-2 d-none d-md-block sidebar py-4 px-2">
                <?= view('partials/sidebar') ?>
            </nav>

            <!-- OFFCANVAS MOBILE -->
            <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarMobile">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title"><?= esc($configuracoes['nome_sistema'] ?? 'Sistema') ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <nav class="sidebar px-2 py-3">
                        <?= view('partials/sidebar') ?>
                    </nav>
                </div>
            </div>

            <!-- CONTEÚDO PRINCIPAL -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 px-3">
                <?= $this->renderSection('content') ?>
            </main>

        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>