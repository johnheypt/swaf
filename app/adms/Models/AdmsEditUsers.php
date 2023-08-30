<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Editar usuarios e perfil do usuário no banco de dados
 */
class AdmsEditUsers
{
    /* Recebe verdadeiro ou falso do result*/
    private $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o ID do registo */
    private int|string|null $id;

    /** @var array|null $dados recebe os dados da Controlers */
    private array|null $data;

     /** @var array|null $dataExitVal recebe os campos que não serão validados */
     private array|null $dataExitVal;

    /**
     * retorna verdadeiro ou falso
     *
     * @return void
     */
    function getResult()
    {
        return $this->result;
    }

    /**
     * retorna os dados com detalhes do banco de dados
     *
     * @return array|null
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * CRUD do usuário
     *
     * @param integer $id
     * @return void
     */
    public function editUser(int $id): void
    {
        $this->id = $id;
        $viewUsers = new \App\adms\helpers\AdmsRead();
        $viewUsers->fullRead(
            "SELECT id, name, apelido, email, user, adms_sits_user_id
                            FROM adms_users 
                            WHERE id=:id 
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }
    }

    public function updateUser(array $data = null): void
    {
        $this->data = $data;

        $this->dataExitVal['apelido'] = $this->data['apelido'];
        unset($this->data['apelido']);

        $valEmptyField = new \App\adms\helpers\AdmsValidationField();
        $valEmptyField->validationField($this->data);
        if ($valEmptyField->getResult()) {
            $this->validateInput();
        } else {
            $this->result = false;
        }
    }

    /**
     * Instancia a classe e verifica se é um email válido
     *
     * @return void
     */
    private function validateInput(): void
    {
        $valEmail = new \App\adms\helpers\AdmsValidationEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\adms\helpers\AdmsValidateEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $this->data['id']);

        $valUserSingle = new \App\adms\helpers\AdmsValidateUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $this->data['id']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['updatetAt'] = date("Y-m-d H:i:s");
        $this->data['apelido'] = $this->dataExitVal['apelido'];

        $upUser = new \App\adms\helpers\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Usuário editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            $this->result = false;
        }
    }

     /**
     * CRUD do Perfil
     *
     * @param integer $id
     * @return void
     */
    public function viewPerfil(): void
    {
        $viewUsers = new \App\adms\helpers\AdmsRead();
        $viewUsers->fullRead(
            "SELECT id, name, apelido, email, user
                            FROM adms_users 
                            WHERE id=:id 
                            LIMIT :limit",
            "id=". $_SESSION['user_id']."&limit=1"
        );

        $this->resultBd = $viewUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
        }
    }

    public function updateProfile(array $data = null): void
    {
        $this->data = $data;

        $this->dataExitVal['apelido'] = $this->data['apelido'];
        unset($this->data['apelido']);

        $valEmptyField = new \App\adms\helpers\AdmsValidationField();
        $valEmptyField->validationField($this->data);
        if ($valEmptyField->getResult()) {
            $this->validateInputProfile();
        } else {
            $this->result = false;
        }
    }

    private function validateInputProfile(): void
    {
        $valEmail = new \App\adms\helpers\AdmsValidationEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\adms\helpers\AdmsValidateEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $_SESSION['user_id']);

        $valUserSingle = new \App\adms\helpers\AdmsValidateUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $_SESSION['user_id']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
            $this->editProfile();
        } else {
            $this->result = false;
        }
    }

    private function editProfile(): void
    {
        $this->data['updatetAt'] = date("Y-m-d H:i:s");
        $this->data['apelido'] = $this->dataExitVal['apelido'];

        $upUser = new \App\adms\helpers\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id=" . $_SESSION['user_id']);

        if ($upUser->getResult()) {
            $_SESSION['user_name'] = $this->data['name'];
            $_SESSION['user_apelido'] = $this->data['apelido'];
            $_SESSION['user_email'] = $this->data['email'];
            $_SESSION['msg'] = "<p style='color: green;'>Perfil editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Perfil não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
