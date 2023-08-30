<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Recebe os dados que vem da Controllers cadastrar novo usuario
 */
class AdmsAddUsers
{
    /** @var array|null $dados recebe os dados da Controlers */
    private array|null $data;

    /** @var array Recebe a lista das situacoes da tabela adms_users_sit */
    private array $listRegistryAdd;

	/* Recebe verdadeiro ou falso do result*/
	private $result;
 
    function getResult()
    {
        return $this->result;
    }

    /**
     * Instancia o helper para verificar se os campos estão preenchidos
     *
     * @param array|null $data
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;
        
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
        $valEmailSingle->validateEmailSingle($this->data['email']);

        $valPassword = new \App\adms\helpers\AdmsValidationPassword();
        $valPassword->validatePassword($this->data['senha']);

        $valUser = new \App\adms\helpers\AdmsValidateAddUserSingle();
        $valUser->validateUserSingle($this->data['user']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valPassword->getResult()) and ($valUser->getResult())) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /**
     * Cadastra no banco de dados o novo usuario
     *
     * @return void
     */
    private function add(): void
    {
        /* Criptografa a senha */
        $this->data['senha'] = password_hash($this->data['senha'], PASSWORD_DEFAULT);
        $this->data['conf_email'] = password_hash($this->data['senha'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
        $this->data['createdAt'] = date("Y-m-d H:i:s");
       
        $createUser = new \App\adms\helpers\AdmsCreate();
        $createUser->exeCreate("adms_users", $this->data);

        if($createUser->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
            $this->result = false;
        }            
    }
    public function listSelect(): array
    {
        $list = new \App\adms\helpers\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_users WHERE id<>:id ORDER BY name ASC", "id=5");
        $registry['sit'] = $list->getResult();

        $this->listRegistryAdd = ['sit' => $registry['sit']];

        return $this->listRegistryAdd;
    }
}