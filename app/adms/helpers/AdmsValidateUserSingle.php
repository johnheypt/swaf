<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
/**
 * Recebe os dados que vem da Controllers cadastrar novo usuario
 * para validar o campo email já cadastrado ou não no campo user
 */
class AdmsValidateUserSingle
{
    /* Recebe o email do formulário que deve ser validado no campo user*/
    private string $user;

    /* Recebe verdadeiro ou falso do result*/
	private bool $result;

    /** @var bool|null $edit Recebe a informação que é utilizada para verificar se é para validar o usuario para cadastro ou edição */
    private bool|null $edit;

    /** @var int|null $id Recebe o id do usuário que deve ser ignorado quando estiver validando o usuario para edição */
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
    public function validateUserSingle(string $user, bool|null $edit = null, int|null $id = null): void
    {
       $this->user = $user;
       $this->edit = $edit;
       $this->id = $id;

       $verifyUserSingle = new \App\adms\helpers\AdmsRead();
       if(($this->edit == true) and (!empty($this->id))){
            $verifyUserSingle->fullRead("SELECT id FROM adms_users WHERE (user =:user OR email =:email) AND id <>:id LIMIT :limit", "user={$this->user}&email={$this->user}&id={$this->id}&limit=1");
       }else{
            $verifyUserSingle->fullRead("SELECT id FROM adms_users WHERE user =:user LIMIT :limit", "user={$this->user}&limit=1");
       }

       $this->resultBd = $verifyUserSingle->getResult();
       if(!$this->resultBd){
        $this->result = true;
       }else{
        $_SESSION['msg'] = "<p style='color:#f00';>Erro: Email já utilizado, por favor verifique!</p>";
        $this->result = false;
       }
    }
}
