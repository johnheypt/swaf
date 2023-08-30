<?php

namespace App\adms\Controllers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
/**
 * Controller da página Editar Imagem do Usuário
 * @author John Trindade <jht_pt@icloud.com>
 */
class EditUsersImg
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['btnEditUserImg']))) {
            $this->id = (int) $id;
            $viewUser = new \App\adms\Models\AdmsEditUsersImg();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResult()) {
                $this->data['form'] = $viewUser->getResultBd();
                $this->viewEditUserImage();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editUserImage();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditUserImage(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/editUserImg", $this->data);
        $loadView->loadView();
    }

    private function editUserImage(): void
    {
        if (!empty($this->dataForm['btnEditUserImg'])) {
            unset($this->dataForm['btnEditUserImg']);
            $this->dataForm['new_image'] = $_FILES['new_image'] ? $_FILES['new_image'] : null;
            $editUserImage = new \App\adms\Models\AdmsEditUsersImg();
            $editUserImage->update($this->dataForm);
            if ($editUserImage->getResult()) {
                $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditUserImage();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
