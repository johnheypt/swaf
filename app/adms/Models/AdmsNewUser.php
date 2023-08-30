<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Recebe os dados que vem da Controllers cadastrar novo usuario
 */
class AdmsNewUser
{
    /** @var array|null $dados recebe os dados da Controlers */
    private array|null $data;

	/* Recebe verdadeiro ou falso do result*/
	private $result;

    /** @var string $fromEmail recebe o email do remetente  */
    private string $fromEmail;

    /** @var string $firstName Recebe o primeiro nome do usuário */
    private string $firstName;

     /** @var string $url Recebe a url para o usuário confirmar a conta atraves do email que recebe */
     private string $url;

    /** @var string $lastName Recebe o apelido do nome do usuário */
    private string $lastName;

    /** @var string $allName Recebe o nome completo */
    private string $allName;

    /** @var array $emailData Recebe dados do conteúdo do e-mail */
    private array $emailData;

    function getResult()
    {
        return $this->result;
    }

    public function create(array $data = null)
    {
        $this->data = $data;
        
        $valEmptyField = new \App\adms\helpers\AdmsValidationField();
        $valEmptyField->validationField($this->data);
        if ($valEmptyField->getResult()) {
            $this->validateInput();
        } else {
            $this->result = false;
        }
    }

    /**
     * Instancia a classe e verifica se é um email válido
     *
     * @return void
     */
    private function validateInput(): void
    {
        $valEmail = new \App\adms\helpers\AdmsValidationEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\adms\helpers\AdmsValidateEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email']);

        $valPassword = new \App\adms\helpers\AdmsValidationPassword();
        $valPassword->validatePassword($this->data['senha']);

        $valUser = new \App\adms\helpers\AdmsValidateUserSingle();
        $valUser->validateUserSingle($this->data['email']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valPassword->getResult()) and ($valUser->getResult())) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /**
     * Cadastra no banco de dados o novo usuario
     *
     * @return void
     */
    private function add(): void
    {
        /* Criptografa a senha */
        $this->data['senha'] = password_hash($this->data['senha'], PASSWORD_DEFAULT);
        $this->data['user'] = $this->data['email'];
        $this->data['conf_email'] = password_hash($this->data['senha'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
        $this->data['createdAt'] = date("Y-m-d H:i:s");

        $createUser = new \App\adms\helpers\AdmsCreate();
        $createUser->exeCreate("adms_users", $this->data);

        if($createUser->getResult()){
            $this->sendEmailactive();
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
            $this->result = false;
        }            
    }

    /**
     * Chama a classe para enviar o email de ativação
     *
     * @return void
     */
    private function sendEmailactive():void
    {
        $this->contentEmailHtml();
        $this->contentEmailText();

       $activeSendEmail = new \App\adms\helpers\AdmsSendEmail();
       $activeSendEmail->sendEmail($this->emailData, 1);

       if($activeSendEmail->getResult()){
        $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso. Acesse sua caixa de email para activar sua conta!</p>";
       $this->result = true;
       }else{
        $this->fromEmail = $activeSendEmail->getFromEmail();
        $_SESSION['msg'] = "<p style='color: #f00;'>Usuário cadastrado com sucesso. Ocorreu um erro ao enviar o email de activação, por favor entre em contacto com {$this->fromEmail} para mais informações!</p>";
       $this->result = false;
       }
    }

    /** 
     * constrói o email em formato html
     */
    private function contentEmailHtml(): void
    {
        $this->firstName = $this->data['name'];
        $this->lastName = $this->data['apelido'];
        $this->allName = $this->firstName . " " . $this->lastName;

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->data['name'];
        $this->emailData['subject'] = "Confirmar conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->data['conf_email'];

        $this->emailData['contentHtml'] = "Ex.mo(a) Senhor(a) {$this->allName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso Aplicativo!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada pelo Sistema SWAF. <br>Você está recebendo porque está cadastrado no banco de dados do Sistema SWAF. Nenhum e-mail enviado pelo SWAF tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>"; 
    }

    /**
     * constroi o email em formato texto
     *
     * @return void
     */
    private function contentEmailText(): void
    {
        $this->emailData['contentText'] = "Ex.mo(a) Senhor(a) {$this->allName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso Aplicativo!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
        $this->emailData['contentText'] .= $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada pelo Sistema SWAF. <br>Você está recebendo porque está cadastrado no banco de dados do Sistema SWAF. Nenhum e-mail enviado pelo SWAF tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";  
    }
}