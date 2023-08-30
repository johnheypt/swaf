<?php

namespace App\adms\Controllers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
/**
 * Controller da página Editar Senha do Usuário
 * @author John Trindade <jht_pt@icloud.com>
 */
class EditPasswordUsers
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;
    
    /** @var int|string|null $id Recebe o ID do registo */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['btnEditPassUser']))) {
            $this->id = (int) $id;
            $editPassUser = new \App\adms\Models\AdmsEditPasswordUsers();
            $editPassUser->editUser($this->id);
            if ($editPassUser->getResult()) {
                $this->data['form'] = $editPassUser->getResultBd();
                $this->viewEditPassUser();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editPassUser();
        }
    }

    private function viewEditPassUser(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/editPassUser", $this->data);
        $loadView->loadView();
    }

    private function editPassUser(): void
    {
        if (!empty($this->dataForm['btnEditPassUser'])) {
            unset($this->dataForm['btnEditPassUser']);
            $editPassUser = new \App\adms\Models\AdmsEditPasswordUsers();
            $editPassUser->updatePassUser($this->dataForm);
            if ($editPassUser->getResult()) {
                $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditPassUser();
            }
        } else {
            $_SESSION['msg'] = "<p style ='color: #f00;'>Erro: Usuário não encontrado, tente novamente!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
