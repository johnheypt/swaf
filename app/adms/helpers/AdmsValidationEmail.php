<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Recebe os dados que vem da Controllers cadastrar novo usuario
 * para validar se o email é valido 
 */
class AdmsValidationEmail
{
    /* Recebe o email do formulário */
    private string $email;
    /* Recebe verdadeiro ou falso do result*/
	private bool $result;
	
    function getResult():bool
    {
        return $this->result;
    }

     /**
     * Verifica se o email é valido
     *
     * @param string $email
     * @return void
     */
    public function validateEmail(string $email): void
    {
        $this->email = $email;
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro: o e-mail é inválido, por favor verifique!</p>";
            $this->result = false;
        }
    }
}
