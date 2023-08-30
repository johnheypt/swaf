<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**Classe generica para validar a senha
 */
class AdmsValidationPassword
{
    /* Recebe o email do formulário */
    private string $password;
    /* Recebe verdadeiro ou falso do result*/
	private bool $result;
	
    function getResult():bool
    {
        return $this->result;
    }

     /**
     * Verifica se a senha tem (') ou espaço em branco
     *
     * @param string $email
     * @return void
     */
    public function validatePassword(string $password): void
    {
        $this->password = $password;
        if (stristr($this->password, "'")){
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro: O Caracter ' não é permitido!</p>";
            $this->result = false;
        }else{
            if(stristr($this->password, " ")){
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro: Não é possivel utilizar espaço em branco na senha!</p>";
            $this->result = false;
            }else{
                $this->sizePassword();
            }
        }
    }

    /**
     * Verifica se a senha possui menos de 8 caracter
     *
     * @return void
     */
    private function sizePassword():void
    {
        if (strlen($this->password) < 8){
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro: A senha deve conter no mínimo 8 caracter!</p>";
            $this->result = false;
        }else{
            $this->valuePassword();
        }
    }

    /**
     * Verifica se tem letras maiuscula, minusculas, números e caracteres especiais
     *
     * @return void
     */
    private function valuePassword():void
    {
        if (preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9-@#$%!?*]{8,}$/', $this->password)){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro: A senha deve conter letras maiusculas, minusculas, Números e os seguintes caracteres ( @ # $ % ! ? * )</p>";
            $this->result = false;
        }
    }
}
