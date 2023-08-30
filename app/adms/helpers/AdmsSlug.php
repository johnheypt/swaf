<?php

namespace App\adms\helpers;

if (!defined('AP5BL8KES2W0A2F3')) {
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Classe generica para converter o SLUG
 */
class AdmsSlug
{

    /** @var string $urlSlugController Recebe o controller tratada */
    private string $urlSlugController;

    /** @var string $urlSlugMetodo Recebe o metodo tratado */
    private string $urlSlugMetodo;

    /** @var string $text Recebe o nome da imagem para converter os caracteres */
    private string $text;

    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;

    /**
     * Converter o valor obtido da URL "view-users" e converter no formato da classe "ViewUsers".
     * Utilizado as funções para converter tudo para minúsculo, converter o traço pelo espaço, converter cada letra da primeira palavra para maiúsculo, retirar os espaços em branco
     *
     * @param string $slugController Nome da classe
     * @return string Retorna a controller "view-users" convertido para o nome da Classe "ViewUsers"
     */
    public function slugController(string $slugController): string
    {
        $this->urlSlugController = $slugController;
        // Converter para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);
        // Converter o traco para espaco em braco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        // Converter a primeira letra de cada palavra para maiusculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        // Retirar espaco em branco        
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);
        return $this->urlSlugController;
    }

    /**
     * Tratar o método
     * Instanciar o método que trata a controller
     * Converter a primeira letra para minusculo
     *
     * @param string $urlSlugMetodo
     * @return string
     */
    public function slugMetodo(string $urlSlugMetodo): string
    {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        //Converter para minusculo a primeira letra
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);
        return $this->urlSlugMetodo;
    }

    /**
     * Recebe o nome da imagem e converte os caracteres
     *
     * @param string $text
     * @return string|null
     */
    public function slug(string $text): string|null
    {
        $this->text = $text;

        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:,\\\'<>°ºª';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-----------------------------------------------------------------------------------------------';
        $this->text = strtr(mb_convert_encoding($this->text, 'ISO-8859-1', 'UTF-8'), mb_convert_encoding($this->format['a'], 'ISO-8859-1', 'UTF-8'), $this->format['b']);
        $this->text = str_replace(" ", "-", $this->text);
        $this->text = str_replace(array('-----', '----', '---', '--'), '-', $this->text);
        $this->text = strtolower($this->text);

        return $this->text;
    }

    /**
     * Método privado não pode ser instanciado fora da classe
     * Limpara a URL, elimando as TAG, os espaços em brancos, retirar a barra no final da URL e retirar os caracteres especiais
     *
     * @return string
     */
    public function clearUrl(string $url): string
    {
        //Eliminar as tag
        $url = strip_tags($url);
        //Eliminar espaços em branco
        $url = trim($url);
        //Eliminar a barra no final da URL
        $url = rtrim($url, "/");
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------------------------------------------------------------------------';
        $url = strtr(mb_convert_encoding($url, 'ISO-8859-1', 'UTF-8'), mb_convert_encoding($this->format['a'], 'ISO-8859-1', 'UTF-8'), $this->format['b']);
        return $url;
    }
}
