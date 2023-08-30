<?php

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
echo "VIEW - Página Dashboard!<br>";
echo $this->data . " " . $_SESSION['user_name'] . " " . $_SESSION['user_apelido'] . "!<br>";
