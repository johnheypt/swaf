<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

use App\adms\helpers\AdmsConn;

/**
 * Confirmar o cadastro do usuário, alterando a situação no banco de dados
 *
 * @author John Trindade
 */
class AdmsConfEmail extends AdmsConn
{

    /** @var string $key Recebe a chave para confirmar o cadastro */
    private string $key;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

      /** @var array $datasave recebe os dados que deverá ser salvo */
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
    public function confEmail(string $key): void
    {
        $this->key = $key;
        if (!empty($this->key)) {
            $viewKeyConfEmail = new \App\adms\helpers\AdmsRead();
            $viewKeyConfEmail->fullRead("SELECT id 
                                        FROM adms_users 
                                        WHERE conf_email =:conf_email 
                                        LIMIT :limit", "conf_email={$this->key}&limit=1");
            $this->resultBd = $viewKeyConfEmail->getResult();
            if ($this->resultBd) {
                $this->updateSitUser();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
                $this->result = false;
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
            $this->result = false;
        }
    }

    private function updateSitUser(): void
    {
        $this->dataSave['conf_email'] = null;
        $this->dataSave['adms_sits_user_id'] = 2;
        $this->dataSave['updatetAt'] = date("Y-m-d H:i:s");

        $upConfEmail = new \App\adms\helpers\AdmsUpdate();
        $upConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if($upConfEmail->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>Conta ativada com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
            $this->result = false;
        }
    }
}
