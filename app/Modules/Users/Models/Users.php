<?php

namespace Modules\Users\Models;

if (!defined('AP5BL8KES2W0A2F3')) {
    header('Location:/');
    exit('Erro: Página não encontrada');
}

class Users
{
    private $result;

    /** @var array|null Recebe os registros do banco de dados */
    private array|null $resultBd;

    /**
     * retorna verdadeiro ou falso.
     *
     * @return void
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * retorna os dados do banco de dados.
     */
    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function list(): void
    {
        $listUsers = new \App\adms\helpers\AdmsRead();
        $listUsers->fullRead('SELECT id, name, apelido, email, user FROM adms_users WHERE id<>:id ORDER BY id DESC', 'id=1');

        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: nenhum usuário encontrado!</p>";
            $this->result = false;
        }
    }
}
