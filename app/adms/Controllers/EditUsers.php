<?php

namespace App\adms\Controllers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
/**
 * Controller da página Editar Usuário ou perfil
 * @author John Trindade <jht_pt@icloud.com>
 */
class EditUsers
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

        if ((!empty($id)) and (empty($this->dataForm['btnEditUser']))) {
            $this->id = (int) $id;
            $editUser = new \App\adms\Models\AdmsEditUsers();
            $editUser->editUser($this->id);
            if ($editUser->getResult()) {
                $this->data['form'] = $editUser->getResultBd();
                $this->viewEditUser();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editUser();
        }
    }

    private function viewEditUser(): void
    {
        $listSelect = new \App\adms\Models\AdmsAddUsers();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new \Core\ConfigView("adms/Views/users/editUser", $this->data);
        $loadView->loadView();
    }

    private function editUser(): void
    {
        if (!empty($this->dataForm['btnEditUser'])) {
            unset($this->dataForm['btnEditUser']);
            $editUser = new \App\adms\Models\AdmsEditUsers();
            $editUser->updateUser($this->dataForm);
            if ($editUser->getResult()) {
                $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditUser();
            }
        } else {
            $_SESSION['msg'] = "<p style ='color: #f00;'>Erro: Usuário não encontrado, tente novamente!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }

    public function indexProfile(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['btnEditProfile'])) {
            $this->editProfile();
        } else {
            $viewProfile = new \App\adms\Models\AdmsEditUsers();
            $viewProfile->viewPerfil();
            if ($viewProfile->getResult()) {
                $this->data['form'] = $viewProfile->getResultBd();
                $this->viewEditProfile();
            } else {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
        }
    }
    private function viewEditProfile():void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/editProfile", $this->data);
        $loadView->loadView();
    }

    private function editProfile(): void
    {
        if (!empty($this->dataForm['btnEditProfile'])) {
            unset($this->dataForm['btnEditProfile']);
            $editProfile = new \App\adms\Models\AdmsEditUsers();
            $editProfile->updateProfile($this->dataForm);
            if ($editProfile->getResult()) {
                $urlRedirect = URLADM . "view-profile/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditProfile();
            }
        } else {
            $_SESSION['msg'] = "<p style ='color: #f00;'>Erro: Perfil não encontrado, tente novamente!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
