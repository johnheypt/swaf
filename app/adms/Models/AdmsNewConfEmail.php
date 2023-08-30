<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

use App\adms\helpers\AdmsConn;

/**
 * Solicita novo link para ativar a conta
 */
class AdmsNewConfEmail extends AdmsConn
{
     /** @var array|null $dados recebe os dados da Controlers */
     private array|null $data;

     /* Recebe verdadeiro ou falso do result*/
	private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

     /** @var string $firstName Recebe o primeiro nome do usuário */
    private string $firstName;

    /** @var string $lastName Recebe o apelido do nome do usuário */
    private string $lastName;

    /** @var string $allName Recebe o nome completo */
    private string $allName;

    /** @var array $emailData Recebe dados do conteúdo do e-mail */
    private array $emailData;
    
    /** @var array $datasave recebe os dados que deverá ser salvo */
    private array $dataSave;

    /** @var string Recebe a url */
    private string $url;

      /** @var string $fromEmail recebe o email do remetente  */
      private string $fromEmail = EMAILADM;

    /**
    * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
    */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Verifica se encontrou um registo no bd
     */
    public function newConfEmail(array $data = null): void
    {
        $this->data = $data;
        $valField = new \App\adms\helpers\AdmsValidationField();
        $valField->validationField($this->data);
        
        if ($valField->getResult()){
            $this->validateUser();
        }else{
            $this->result = false;
        }
       
    }

    private function validateUser(): void
    {
        $newConfEmail = new \App\adms\helpers\AdmsRead();
        $newConfEmail->fullRead(
            "SELECT id, name, apelido, email, conf_email 
                                FROM adms_users
                                WHERE email=:email
                                LIMIT :limit",
            "email={$this->data['email']}&limit=1");
        $this->resultBd = $newConfEmail->getResult();
        if ($this->resultBd) {
            $this->valConfEmail();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não cadastrado!</p>";
            $this->result = false;
        }
    }


    private function valConfEmail(): void
    {
        if ((empty($this->resultBd[0]['conf_email'])) or ($this->resultBd[0]['conf_email'] == NULL)) {
            $this->dataSave['conf_email'] = password_hash(date("Y-m-d H:i:s") . $this->resultBd[0]['id'], PASSWORD_DEFAULT);
            $this->dataSave['updatetAt'] = date("Y-m-d H:i:s");

            $upNewConfEmail = new \App\adms\helpers\AdmsUpdate();
            $upNewConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

            if($upNewConfEmail->getResult()){
                $this->resultBd[0]['conf_email'] = $this->dataSave['conf_email'];
                $this->sendEmail();
            }else{
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link não enviado, tente novamente!</p>";
                $this->result = false;
            }
        } else {
            $this->sendEmail();
        }
    }

    private function sendEmail():void
    {
        $sendEmail = new \App\adms\helpers\AdmsSendEmail();
        $this->emailHTML();
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 1);
        if($sendEmail->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>Novo link enviado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</p>";
            $this->result = true;
        }else{
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</p>";
            $this->result = false;
        }
    }

    private function emailHTML(): void
    {
        $this->firstName = $this->resultBd[0]['name'];
        $this->lastName = $this->resultBd[0]['apelido'];
        $this->allName = $this->firstName . " " . $this->lastName;

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->resultBd[0]['name'];
        $this->emailData['subject'] = "Confirmar conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->resultBd[0]['conf_email'];

        $this->emailData['contentHtml'] = "Ex.mo(a) Senhor(a) {$this->allName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso Aplicativo!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi reenviada pelo Sistema SWAF. <br>Você está recebendo porque solicitou-a novamente e está cadastrado no banco de dados do Sistema SWAF. Nenhum e-mail enviado pelo SWAF tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>"; 
    }

    /**
     * constroi o email em formato texto
     *
     * @return void
     */
    private function emailText(): void
    {
        $this->emailData['contentText'] = "Ex.mo(a) Senhor(a) {$this->allName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso Aplicativo!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
        $this->emailData['contentText'] .= $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi reenviada pelo Sistema SWAF. <br>Você está recebendo porque solicitou-a novamente e está cadastrado no banco de dados do Sistema SWAF. Nenhum e-mail enviado pelo SWAF tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";  
    }
}