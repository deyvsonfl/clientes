<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

  <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
    <div class="card-body">
      <h4 class="text-center mb-4">Acesso ao Sistema</h4>

      <?php if (session()->getFlashdata('erro')): ?>
        <div class="alert alert-danger">
          <?= esc(session('erro')) ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= base_url('login') ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label for="usuario" class="form-label">Usuário</label>
          <input type="text" name="usuario" id="usuario" class="form-control" required autofocus autocomplete="username">
        </div>

        <div class="mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" name="senha" id="senha" class="form-control" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>
    </div>
  </div>

</body>

</html>