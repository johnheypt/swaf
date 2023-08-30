<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * confirma a chave actualizar senha e cadastrar nova senha no banco de dados
 *
 * @author John Trindade
 */
class AdmsUpdatePassword
{

    /** @var string $key Recebe a chave para atualizar a senha */
    private string $key;

    /** @var array|null $dados recebe os dados da Controlers */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array $dataSave recebe os dados que serao salvos */
    private array $dataSave;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * 
     * @return void
     */
    public function valKey(string $key): bool
    {
        $this->key = $key;
        $viewKeyUpPass = new \App\adms\helpers\AdmsRead();
        $viewKeyUpPass->fullRead(
            "SELECT id
                                FROM adms_users
                                WHERE recover_password=:recover_password
                                LIMIT :limit",
            "recover_password={$this->key}&limit=1"
        );
        $this->resultBd = $viewKeyUpPass->getResult();
        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
            $this->result = false;
            return false;
        }
    }

    public function editPassword(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\helpers\AdmsValidationField();
        $valEmptyField->validationField($this->data);
        if ($valEmptyField->getResult()) {
            if (($this->data['senha']) == ($this->data['confsenha'])) {
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p style='color:#f00';>Erro: As senhas não são iguais, por favor verifique!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    private function valInput(): void
    {
        $valPassword = new \App\adms\helpers\AdmsValidationPassword();
        $valPassword->validatePassword($this->data['senha']);
        if ($valPassword->getResult()) {
            if ($this->valKey($this->data['key'])) {
                $this->savePassword();
            } else {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Salva os novos dados no banco de dados
     *
     * @return void
     */
    private function savePassword():void
    {
        $this->dataSave['recover_password'] = null;
        $this->dataSave['senha'] = password_hash($this->data['senha'], PASSWORD_DEFAULT);
        $this->dataSave['updatetAt'] = date("Y-m-d H:i:s");

        $saveData = new \App\adms\helpers\AdmsUpdate();
        $saveData->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");
        if($saveData->getResult()){
            $_SESSION['msg'] = "<p style='color:green';>Senha alterada com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color:#f00';>Erro: Senha não alterada, por favor verifique!</p>";
            $this->result = false;
        }
    }
}
