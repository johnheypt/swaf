<?php

namespace App\adms\Controllers;
if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Controller da página Logout
 * @author John Trindade <jht_pt@icloud.com>
 */
class Logout
{
    /**
     * Destrui as sessões do usuário logado
     * @return void
     */
    public function index():void
    {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_apelido'],$_SESSION['user_email'], $_SESSION['user_image']);
		$_SESSION['msg'] = "<p style ='color: green;'>Logout realizado com sucesso!</p>";
		$urlRedirect = URLADM . "login/index";
		header("Location: $urlRedirect");
    }
}