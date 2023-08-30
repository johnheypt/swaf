<?php

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

echo "<h2>Detalhes do Usuário</h2>";

echo "<a href='".URLADM."list-users/index/$id'>Listar</a><br>";
if(!empty($this->data['viewUser'])){
echo "<a href='".URLADM."edit-users/index/" . $this->data['viewUser'][0]['id'] . "'>Editar</a><br>";
echo "<a href='".URLADM."edit-password-users/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Senha</a><br>";
echo "<a href='".URLADM."edit-users-img/index/" . $this->data['viewUser'][0]['id'] . "'>Alterar Imagem</a><br>";
echo "<a href='".URLADM."delete-users/index/" . $this->data['viewUser'][0]['id'] . "'>Eliminar</a><br><br>";
}

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if(!empty($this->data['viewUser'])){
    extract($this->data['viewUser'][0]);
    if ((!empty($image)) and (file_exists("app/adms/assets/images/users/$id/$image"))) {
        echo "<img src='" . URLADM . "app/adms/assets/images/users/$id/$image' width='100' height='100'><br><br>";
    } else {
        echo "<img src='" . URLADM . "app/adms/assets/images/users/default/user.jpg' width='100' height='100'><br><br>";
    }
    echo "ID: " . $id. "<br>";
    echo "Nome: " . $name_usr. "<br>";
    echo "Apelido: " . $apelido. "<br>";
    echo "Email: " . $email. "<br>";
    echo "User: " . $user. "<br>";
    echo "Situação: <span style='color:$color';>$name_sit</span><br>";
    echo "Criado em: " . date('d/m/Y H:i:s', strtotime($createdAt)) . "<br>";
    echo "Alterado em: ";
    if(!empty($updatetAt)){
        echo date('d/m/Y H:i:s', strtotime($updatetAt));
    }
    echo "<br>";
}

