<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Visualizar usuarios do banco de dados
 */
class AdmsViewUsers
{
    /* Recebe verdadeiro ou falso do result*/
    private $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o ID do registo */
    private int|string|null $id;

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

    public function viewUser(int $id): void
    {
        $this->id = $id;
        $viewUsers = new \App\adms\helpers\AdmsRead();
        $viewUsers->fullRead("SELECT usr.id, usr.name AS name_usr, usr.apelido, usr.email, usr.user, usr.image,  usr.createdAt, usr.updatetAt, 
                            sit.name AS name_sit,
                            col.color
                            FROM adms_users AS usr 
                            INNER JOIN adms_sits_users AS sit ON sit.id=usr.adms_sits_user_id 
                            INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
                            WHERE usr.id=:id 
                            LIMIT :limit", 
                            "id={$this->id}&limit=1");

        $this->resultBd = $viewUsers->getResult();

        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }
    }
}
