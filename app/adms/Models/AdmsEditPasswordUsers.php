<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Editar a senha do usuario no banco de dados
 */
class AdmsEditPasswordUsers
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

    public function editUser(int $id): void
    {
        $this->id = $id;
        $viewUsers = new \App\adms\helpers\AdmsRead();
        $viewUsers->fullRead(
            "SELECT id
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

    public function updatePassUser(array $data = null): void
    {
        $this->data = $data;

        $this->dataExitVal['confsenha'] = $this->data['confsenha'];
        unset($this->data['confsenha']);

        $valEmptyField = new \App\adms\helpers\AdmsValidationField();
        $valEmptyField->validationField($this->data);
        if ($valEmptyField->getResult()) {
            if (($this->data['senha']) == ($this->dataExitVal['confsenha'])) {
                $this->validateInput();
            } else {
                $_SESSION['msg'] = "<p style='color:#f00';>Erro: As senhas não são iguais, por favor verifique!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Instancia a classe e valida a senha
     *
     * @return void
     */
    private function validateInput(): void
    {
        $valPassword = new \App\adms\helpers\AdmsValidationPassword();
        $valPassword->validatePassword($this->data['senha']);

        if (($valPassword->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        /* Criptografa a senha */
        $this->data['senha'] = password_hash($this->data['senha'], PASSWORD_DEFAULT);
        $this->data['updatetAt'] = date("Y-m-d H:i:s");
    
        $upUser = new \App\adms\helpers\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Senha alterada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha não alterada, verifique!</p>";
            $this->result = false;
        }
    }
}
