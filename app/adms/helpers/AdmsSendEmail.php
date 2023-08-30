<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Classe Generica para enviar email
 */
class AdmsSendEmail
{
    /** @var array $data Recebe as informações do conteudo do email */
    private array $data;
    
    /** @var boolean Recebe verdadeiro ou falso do result */
	private bool $result;

    /** @var array $dataInforEmail recebe as credênciais do email (ex. usuario, email remetente....) */
    private array $dataInfoEmail;

    /** @var array|null $resultBd recebe os registos do bd  */
    private array|null $resultBd;

    /** @var string $fromEmail recebe o email do remetente  */
    private string $fromEmail = EMAILADM;

    /** @var integer $optionConfEmail recebe o id do email que sera utilizado para enviar o email */
    private int $optionConfEmail;

    /**
     * Recebe True ou False no processamento
     *
     * @return boolean
     */
    function getResult():bool
    {
        return $this->result;
    }

    /**
     * Recebe o email do remetente
     *
     * @return string
     */
    function getFromEmail():string
    {
        return $this->fromEmail;
    }

    /**
     * Função para criar o layout do email de activação
     *
     * @return void
     */
    public function sendEmail(array $data, int $optionConfEmail): void
    {
        $this->optionConfEmail = $optionConfEmail;
        $this->data = $data;

        $this->infoPhpMailer();
    }

    private function infoPhpMailer():void
    {
        $confEmail = new \App\adms\helpers\AdmsRead();
        $confEmail->fullRead("SELECT name, email, host, username, password, smtp, port FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id={$this->optionConfEmail}&limit=1");
        $this->resultBd = $confEmail->getResult();
        if($this->resultBd){
            $this->dataInfoEmail['host'] = $this->resultBd[0]['host'];
            $this->dataInfoEmail['fromEmail'] = $this->resultBd[0]['email'];
            $this->fromEmail = $this->dataInfoEmail['fromEmail'];
            $this->dataInfoEmail['fromName'] = $this->resultBd[0]['name'];
            $this->dataInfoEmail['username'] = $this->resultBd[0]['username'];
            $this->dataInfoEmail['password'] = $this->resultBd[0]['password'];
            $this->dataInfoEmail['smtp'] = $this->resultBd[0]['smtp'];
            $this->dataInfoEmail['port'] = $this->resultBd[0]['port'];
            $this->sendEmailPhpMailer();
        }else{
            $this->result = false;
        }
    }

    private function sendEmailPhpMailer(): void
    {

        //Dados do Servidor
        $mail = new PHPMailer(true);

        try{
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            //Envia usando SMTP
            $mail->Host       = $this->dataInfoEmail['host'];           //Servidor
            $mail->SMTPAuth   = true;                                   //Ativa a autenticação SMTP
            $mail->Username   = $this->dataInfoEmail['username'];      //SMTP usuario
            $mail->Password   = $this->dataInfoEmail['password'];       //SMTP password
            $mail->SMTPSecure = $this->dataInfoEmail['smtp'];            //Activa a Incriptação TLS
            $mail->Port       = $this->dataInfoEmail['port'];           //Porta

            //Dados do Remetente
            $mail->setFrom( $this->dataInfoEmail['fromEmail'], $this->dataInfoEmail['fromName']);
            $mail->addAddress( $this->data['toEmail'], $this->data['toName']);  
            
            //Conteudo do Email
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->data['subject'] ;
            $mail->Body    = $this->data['contentHtml'];
            $mail->AltBody = $this->data['contentText'];

            $mail->send();

            $this->result = true;
        }catch (Exception $e){
            $this->result = false;
        }
    }
    
}