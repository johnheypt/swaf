<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Recebe os dados que vem da Controllers cadastrar novo usuario
 * para validar os campos
 */
class AdmsValidationField
{
    /** @var array|null $dados recebe os dados da Controlers*/
    private array|null $data;
	/* Recebe verdadeiro ou falso do result*/
	private bool $result;
	
    function getResult()
    {
        return $this->result;
    }

    public function validationField(array $data = null)
    {
        $this->data = $data;

        //Verifica se existe alguma tag no campo e retira
        $this->data = array_map('strip_tags', $this->data);
        //Eliminar espaços em branco
        $this->data = array_map('trim', $this->data);

        if(in_array('', $this->data)){
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro: É necessário preencher todos os campos!</p>";
            $this->result = false;
        }else{
            $this->result = true;
        }
    }
}
