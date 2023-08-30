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
class AddUsers
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

        if (!empty($this->dataForm['btnNewUser'])) {
            unset($this->dataForm['btnNewUser']);
            $createUser = new \App\adms\Models\AdmsAddUsers();
            $createUser->create($this->dataForm);
            if ($createUser->getResult()) {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewNewUser();
            }
        } else {
            $this->viewNewUser();
        }
    }

    private function viewNewUser(): void
    {
        $listSelect = new \App\adms\Models\AdmsAddUsers();
        $this->data['select'] = $listSelect->listSelect();
        
        $loadView = new \Core\ConfigView("adms/Views/users/addUser", $this->data);
        $loadView->loadView();
    }
}
