<?php

namespace App\adms\Controllers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
/**
 * Controller da página erro
 * @author John Trindade <jht_pt@icloud.com>
 */
class Erro
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index():void
    {
        $this->data = "<p style='color: #f00;'>Página não encontrada!</p>";

        $loadView = new \Core\ConfigView("adms/Views/erro/erro", $this->data);
        $loadView->loadViewlogin();
    }
}