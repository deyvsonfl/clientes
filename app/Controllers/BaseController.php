<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Helpers a serem carregados automaticamente em todos os controllers.
     *
     * @var list<string>
     */
    protected $helpers = ['clientes', 'form', 'funcoes'];

    /**
     * Inicializa o controller base.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Não remova esta linha
        parent::initController($request, $response, $logger);
        $this->configModel = new \App\Models\ConfigModel();
        $this->configuracoes = $this->configModel->getConfiguracoes();

        // Carregamentos adicionais (ex: serviços globais)
        // Exemplo: $this->session = service('session');
    }
}
