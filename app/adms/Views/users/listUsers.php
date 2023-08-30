<?php

echo "<h2>Listar Usuários</h2>";

echo "<a href='".URLADM."add-users/index'>Cadastrar</a><br><br>";

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach($this->data['list'] as $user){
    extract($user);
    echo "ID: " . $id. "<br>";
    echo "Nome: " . $name. "<br>";
    echo "Email: " . $email. "<br>";
    echo "<a href='".URLADM."view-users/index/$id'>Visualizar</a><br>";
    echo "<a href='".URLADM."edit-users/index/$id'>Editar</a><br>";
    echo "<a href='".URLADM."delete-users/index/$id'>Eliminar</a><br>";
    echo "<hr>";
}