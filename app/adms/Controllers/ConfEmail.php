<?php

namespace App\adms\Controllers;
if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Controller para confirmar o email de activação de conta
 * @author John Trindade <jht_pt@icloud.com>
 */
class ConfEmail
{

    /** @var string $key recebe a chave que esta na url após a palavra key para confirmar a conta */
    private string $key; 

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index():void
    {
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);
        
        /** Verifica se a chave existe */
        if(!empty($this->key))
        {
            $this->validateKey();
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
            $urlRedirect = URLADM . "ConfEmail/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Se encontrar um registo com a chave e o mesmo for alterado redireciona para a pagina de login
     *
     * @return void
     */
    private function validateKey(): void
    {
        $confEmail = new \App\adms\Models\AdmsConfEmail();
        $confEmail->confEmail($this->key);

        if($confEmail->getResult()){
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }else{
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}