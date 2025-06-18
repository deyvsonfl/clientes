<?php

if (!function_exists('alert')) {
    /**
     * Atalho para setar flashdata com suporte a múltiplas mensagens
     *
     * @param string|array $mensagem
     * @param string $tipo success|error|errors
     * @return void
     */
    function alert($mensagem, string $tipo = 'success')
    {
        $session = session();

        $atual = $session->getFlashdata($tipo);
        $mensagens = [];

        if (is_array($atual)) {
            $mensagens = $atual;
        } elseif (!empty($atual)) {
            $mensagens[] = $atual;
        }

        if (is_array($mensagem)) {
            $mensagens = array_merge($mensagens, $mensagem);
        } else {
            $mensagens[] = $mensagem;
        }

        $session->setFlashdata($tipo, $mensagens);
    }
}
