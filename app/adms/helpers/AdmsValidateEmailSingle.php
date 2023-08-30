<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Recebe os dados que vem da Controllers cadastrar novo usuario
 * para validar o campo email já cadastrado ou não
 */
class AdmsValidateEmailSingle
{
    /* Recebe o email do formulário que deve ser validado */
    private string $email;
    /* Recebe verdadeiro ou falso do result*/
	private bool $result;

    /** @var bool|null $edit Recebe a informação que é utilizada para verificar se é para validar e-mail para cadastro ou edição */
    private bool|null $edit;

    /** @var int|null $id Recebe o id do usuário que deve ser ignorado quando estiver validando o e-mail para edição */
    private int|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

     /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */	
    function getResult():bool
    {
        return $this->result;
    }

    /**
     * Verifica se o email é valido
     *
     * @param string $email
     * @return void
     */
    public function validateEmailSingle(string $email, bool|null $edit = null, int|null $id = null): void
    {
       $this->email = $email;
       $this->edit = $edit;
       $this->id = $id;

       $verifyEmailSingle = new \App\adms\helpers\AdmsRead();
       if(($this->edit == true) and (!empty($this->id))){
            $verifyEmailSingle->fullRead("SELECT id FROM adms_users WHERE (email =:email OR user =:user) AND id <>:id LIMIT :limit", "email={$this->email}&user={$this->email}&id={$this->id}&limit=1");
       }else{
            $verifyEmailSingle->fullRead("SELECT id FROM adms_users WHERE email =:email LIMIT :limit", "email={$this->email}&limit=1");
       }

       $this->resultBd = $verifyEmailSingle->getResult();
       if(!$this->resultBd){
        $this->result = true;
       }else{
        $_SESSION['msg'] = "<p style='color:#f00';>Erro: Email já utilizado, por favor verifique!</p>";
        $this->result = false;
       }
    }
}
