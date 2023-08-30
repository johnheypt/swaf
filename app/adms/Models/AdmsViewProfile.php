<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Visualizar o perfil do usuario
 *
 * @author John Trindade
 */
class AdmsViewProfile
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewProfile(): void
    {

        $viewUser = new \App\adms\helpers\AdmsRead();
        $viewUser->fullRead(
            "SELECT name, apelido, email, image 
                            FROM adms_users
                            WHERE id=:id
                            LIMIT :limit",
            "id=" . $_SESSION['user_id'] . "&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
        }
    }
}
