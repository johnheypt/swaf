<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Listar usuários do banco de dados
 */
class AdmsList
{
    /* Recebe verdadeiro ou falso do result*/
    private $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

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
     * retorna os dados do banco de dados
     *
     * @return array|null
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function list(): void
    {
        $listUsers = new \App\adms\helpers\AdmsRead();
        $listUsers->fullRead("SELECT id, name, apelido, email, user FROM adms_users WHERE id<>:id ORDER BY id DESC", "id=1");

        $this->resultBd = $listUsers->getResult();

        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }
}
