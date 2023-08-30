<?php

namespace App\adms\Controllers;
if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Controller da página Cadastrar Novo Usuário
 * @author John Trindade <jht_pt@icloud.com>
 */
class NewUser
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

        if(!empty($this->dataForm['btnNewUser'])){
            unset($this->dataForm['btnNewUser']);
            $createNewUser = new \App\adms\Models\AdmsNewUser();
            $createNewUser->create($this->dataForm);
            if($createNewUser->getResult()){
                $urlRedirect = URLADM;
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewNewUser();
            }           
        }else{
            $this->viewNewUser();
        }        
    }

    private function viewNewUser(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/login/newUser", $this->data);
        $loadView->loadViewlogin();
    }
}

