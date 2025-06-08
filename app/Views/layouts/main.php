<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Clientes</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            padding: 20px 10px;
            box-sizing: border-box;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 15px;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('clientes') ?>">Clientes</a>
    </div>
    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>
