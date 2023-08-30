<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

use PDOException;
use PDO;

abstract class AdmsConn
{
    /* Recebe o Host da Constante Host do arquivo Config */
    private string $host = HOST;
    /* Recebe o Usuário da Constante User do arquivo Config */
    private string $user = USER;
    /* Recebe a Senha da Constante Senha do arquivo Config para acessar o BD*/
    private string $pass = PASS;
    /* Recebe a Porta da Constante Port do arquivo Config */
    private string|int $port = PORT;
    /* Recebe o nome da BD da Constante DBname do arquivo Config */
    private string $dbname = DBNAME;
    /* Recebe a conexão da BD */
    private object $connect;

    /**
     * Cria a Conexão com o BD
     *
     * @return object
     */
    protected function connectDb():object
    {
        try{
            //Conexão com a porta
            $this->connect = new PDO("mysql:host={$this->host};port={$this->port};dbname=" . $this->dbname, $this->user, $this->pass);
            return $this->connect;
        }catch(PDOException $err)
        {
            //Envia a mensagem de erro caso não consigo realizar a conexao
            die("Erro 1: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }
}