<?php

namespace App\adms\Controllers;
if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
/**
 * Controller da página listar usuarios
 * @author John Trindade <jht_pt@icloud.com>
 */
class Listar
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    public function index()
    {

        $list = new \App\adms\Models\AdmsList();
        $list->list();
        
        if ($list->getResult()) {
            $this->data['list'] = $list->getResultBd();
        } else {
            $this->data['list'] = [];
        }

        $loadView = new \Core\ConfigView("adms/Views/users/listusers", $this->data);
        $loadView->loadView();
    }
}
