<?php
error_reporting(E_ALL);
session_start();
// ob_start();

define('AP5BL8KES2W0A2F3', true);


//Carregar o Composer
require './vendor/autoload.php';
echo '<pre>teste: ';
print_r('teste 2');
echo '</pre>';

echo Nada;
(new Modules\Login\Login())->index();
die(__FILE__ . ' at line: ' . __LINE__);
$login->index();

echo '<pre>$login: ';
print_r($login);
echo '</pre>';




//Instanciar a classe ConfigController, responsável em tratar a URL
$home = new Core\ConfigController();

//Instanciar o método para carregar a página/controller
$home->loadPage();
