<?php

namespace App\adms\Controllers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Controller da página Eliminar Usuário
 * @author John Trindade <jht_pt@icloud.com>
 */
class DeleteUsers
{

    /** @var int|string|null $id Recebe o ID do registo */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;
            $deleteUser = new \App\adms\Models\AdmsDeleteUsers();
            $deleteUser->deleteUser($this->id);
        } else {
            $_SESSION['msg'] = "<p style ='color: #f00;'>Erro: Necessário selecionar um usuário, tente novamente!</p>";
        }

        $urlRedirect = URLADM . "list-users/index";
        header("Location: $urlRedirect");
    }
}
