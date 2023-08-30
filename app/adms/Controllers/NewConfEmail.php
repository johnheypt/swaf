<?php

namespace App\adms\Controllers;
if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Controller para enviar novo link para confirmar o email de activação de conta
 * @author John Trindade <jht_pt@icloud.com>
 */
class NewConfEmail
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    public function index():void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(!empty($this->dataForm['btnNewConfEmail'])){
            unset($this->dataForm['btnNewConfEmail']);
            $newConfEmail = new \App\adms\Models\AdmsNewConfEmail();
            $newConfEmail->newConfEmail($this->dataForm);
            if($newConfEmail->getResult()){
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewNewConfEmail();
            }
        }else{
            $this->viewNewConfEmail();
        }
    }

    private function viewNewConfEmail(): void
    {
       $loadView = new \Core\ConfigView("adms/Views/login/newConfEmail", $this->data);
       $loadView->loadViewlogin();
    }
}