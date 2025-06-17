<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
  public function login()
  {
    helper(['url', 'form']); // importante para csrf e form helpers
    $session = session();

    // Se já estiver logado, redireciona direto pro dashboard
    if ($session->get('usuario_logado')) {
      return redirect()->to('/dashboard');
    }

    // Se for POST
    if ($this->request->getMethod() === 'post') {
      $usuario = $this->request->getPost('usuario');
      $senha   = $this->request->getPost('senha');

      if ($usuario === 'admin' && $senha === '123456') {
        $session->set('usuario_logado', true);
        return redirect()->to('/dashboard');
      }

      return redirect()->back()->with('erro', 'Usuário ou senha inválidos.');
    }

    // GET (exibe formulário)
    return view('auth/login');
  }

  public function logout()
  {
    session()->destroy();
    return redirect()->to('/login');
  }
}
