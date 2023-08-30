<?php

namespace Modules\Login\Models;

class Login
{/** @var array|null $data recebe as informacoes do formulario  */
    private array|null $data;
    /** @var array|null $resultBd recebe os registos do bd  */
    private array|null $resultBd;
    /** @var bool $result recebe true quando executado com sucesso e ou false quando houver erro */
    private $result;

    public function getResult()
    {
        return $this->result;
    }

    public function login(array $data = null)
    {
        $this->data = $data;

        $viewUser = new \App\adms\helpers\AdmsRead();
        // Retorna somente as colunas indicadas
        $viewUser->fullRead('SELECT id, name, apelido, email, senha, image, adms_sits_user_id FROM adms_users WHERE user =:user OR email =:email LIMIT :limit', "user={$this->data['email']}&email={$this->data['email']}&limit=1");


        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->valpermissaoemail();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result    = false;
        }
    }

    private function valpermissaoemail(): void
    {
        if ($this->resultBd[0]['adms_sits_user_id'] == 5) {
            $this->valPassword();
        } elseif ($this->resultBd[0]['adms_sits_user_id'] == 1) {
            $this->valPassword();
        } elseif ($this->resultBd[0]['adms_sits_user_id'] == 2) {
            $this->valPassword();
        } elseif ($this->resultBd[0]['adms_sits_user_id'] == 3) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário confirmar a conta no email enviado!</p>";
            $this->result    = false;
        } elseif ($this->resultBd[0]['adms_sits_user_id'] == 4) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário Eliminado ou inativo, por favor entre em contacto com o Administrador!</p>";
            $this->result    = false;
        }
    }

    private function valPassword()
    {
        if (password_verify($this->data['senha'], $this->resultBd[0]['senha'])) {
            $_SESSION['user_id']      = $this->resultBd[0]['id'];
            $_SESSION['user_name']    = $this->resultBd[0]['name'];
            $_SESSION['user_apelido'] = $this->resultBd[0]['apelido'];
            $_SESSION['user_email']   = $this->resultBd[0]['email'];
            $_SESSION['user_image']   = $this->resultBd[0]['image'];
            $this->result             = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result    = false;
        }
    }
}
