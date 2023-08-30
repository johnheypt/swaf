<?php

namespace App\adms\Controllers;
if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Controller de recuperação de senha
 * @author John Trindade <jht_pt@icloud.com>
 */
class RecoverPass
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dataForm['btnRecoverPass'])) {
            unset($this->dataForm['btnRecoverPass']);

            $recoverPass = new \App\adms\Models\AdmsRecover();
            $recoverPass->recoverPass($this->dataForm);

            if ($recoverPass->getResult()) {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewRecoverPass();
            }
        } else {
            $this->viewRecoverPass();
        }
    }

    private function viewRecoverPass(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/login/recoverPass", $this->data);
        $loadView->loadViewlogin();
    }
}
