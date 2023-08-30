<?php

namespace Core;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Carregar as páginas da View
 * 
 * @author John Trindade <jht_pt@icloud.com>
 */
class ConfigView
{
    
    /**
     * Receber o endereço da VIEW e os dados.
     * @param string $nameView Endereço da VIEW que deve ser carregada
     * @param array|string|null $data Dados que a VIEW deve receber.
     */
    public function __construct(private string $nameView, private array|string|null $data)
    {
    }

    /**
     * Carregar a VIEW.
     * Verificar se o arquivo existe, e carregar caso exista, não existindo apresenta a mensagem de erro
     * 
     * @return void
     */
    public function loadView():void
    {
        if(file_exists('app/' .$this->nameView . '.php')){
            include 'app/adms/Views/include/head.php';
            include 'app/adms/Views/include/menu.php';
            include 'app/' .$this->nameView . '.php';
            include 'app/adms/Views/include/footer.php';
        }else{
            die("Erro 2: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }

    /**
     * Carregar a VIEWlogin sem menus.
     * Verificar se o arquivo existe, e carregar caso exista, não existindo apresenta a mensagem de erro
     * 
     * @return void
     */
    public function loadViewlogin():void
    {
        if(file_exists('app/' .$this->nameView . '.php')){
            include 'app/adms/Views/include/head.php';
            include 'app/' .$this->nameView . '.php';
            include 'app/adms/Views/include/footer.php';
        }else{
            die("Erro 8: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }
}
