<?php

namespace Core;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Configurações básicas do site.
 *
 * @author John Trindade <jht_pt@icloud.com>
 */

abstract class Config
{
    /**
     * Possui as constantes com as configurações.
     * Configurações de endereço do projeto.
     * Página principal do projeto.
     * Credenciais de acesso ao banco de dados
     * E-mail do administrador.
     * 
     * @return void
     */
    protected function configAdm(): void
    {
        define('URL', 'http://localhost/adm/');
        define('URLADM', 'http://localhost/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Login');

        define('EMAILADM', 'jht_pt@icloud.com');

        //credenciais para o banco de dados
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            define('URL', (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', trim(dirname($_SERVER['SCRIPT_NAME']), '\\')) . '/');
            define('URLADM', URL . 'adm/');

            define('HOST', 'localhost');
            define('USER', 'root');
            define('PASS', '');
            define('DBNAME', 'bdswaf');
            define('PORT', 3308);
        } else {
            define('URL', 'https://www.santosetristao.pt/');
            define('URLADM', 'https://www.santosetristao.pt/adm/');

            define('HOST', 'lhcp3331.webapps.net');
            define('USER', 'ap5bl8ke_johnhey');
            define('PASS', 'S@ntos&Trist@o23');
            define('DBNAME', 'ap5bl8ke_bdswaf');
            define('PORT', 3306);
        }
    }
}
