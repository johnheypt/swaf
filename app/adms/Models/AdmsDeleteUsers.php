<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Elimina usuarios do banco de dados
 */
class AdmsDeleteUsers
{
    /* Recebe verdadeiro ou falso do result*/
    private $result = false;

    /** @var int|string|null $id Recebe o ID do registo */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var string $delDirectory Recebe o endereço para apagar o diretorio */
    private string $delDirectory;

    /** @var string $delImg Recebe o nome para apagar a imagem */
    private string $delImg;

    /**
     * retorna verdadeiro ou falso
     *
     * @return void
     */
    function getResult()
    {
        return $this->result;
    }

    public function deleteUser(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewUser()) {
            $deleteUser = new \App\adms\helpers\AdmsDelete();
            $deleteUser->exeDelete("adms_users", "WHERE id =:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $this->deleteImg();
                $_SESSION['msg'] = "<p style ='color: green;'>Usuário eliminado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style ='color: #f00;'>Erro: Usuário não eliminado, tente novamente!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }


    private function viewUser(): bool
    {
        $viewUsers = new \App\adms\helpers\AdmsRead();
        $viewUsers->fullRead("SELECT id, image FROM adms_users WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewUsers->getResult();

        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
            return false;
        }
    }

    /**
     * Apaga a imagem e o diretorio
     *
     * @return void
     */
    private function deleteImg(): void
    {
        if ((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) {
            $this->delDirectory = "app/adms/assets/images/users/" . $this->resultBd[0]['id'] . "/";
            $this->delImg = $this->delDirectory . "/" . $this->resultBd[0]['image'];

            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
            if (file_exists($this->delDirectory)) {
                rmdir($this->delDirectory);
            }
        }
    }
}
