<?php

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
if (isset($this->data['form'])) {
	$valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
	$valorForm = $this->data['form'][0];
}
?>

<h1>Editar Perfil</h1>

<?php

/*if (isset($valorForm['id'])) {
	echo "<a href='" . URLADM . "view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br>";
	echo "<a href='" . URLADM . "delete-users/index/" . $valorForm['id'] . "'>Eliminar</a><br><br>";
}*/

if (isset($_SESSION['msg'])) {
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>
<span id="msg"></span>
<form method="POST" action="" id="form-edit-profile" class="form-edit-profile">
	
	<?php
	$name = "";
	if (isset($valorForm['name'])) {
		$name = $valorForm['name'];
	}
	$apelido = "";
	if (isset($valorForm['apelido'])) {
		$apelido = $valorForm['apelido'];
	}
	?>
	<label for="name">Nome:<span style="color: #f00;">*</span> </label>

	<!-- Insere o campo nome -->
	<input type="text" name="name" id="name" placeholder="Digite o seu Nome" value="<?php echo $name ?>" /><br><br>
	<label for="apelido">Apelido:<span style="color: #f00;">*</span> </label>
	<!-- Insere o campo apelido -->
	<input type="text" name="apelido" id="apelido" placeholder="Digite o seu apelido" value="<?php echo $apelido ?>" /><br><br>

	<?php
	$email = "";
	if (isset($valorForm['email'])) {
		$email = $valorForm['email'];
	}
	?>
	<label for="email">E-mail:<span style="color: #f00;">*</span> </label>
	<!-- Insere o campo email -->
	<input type="email" name="email" id="email" placeholder="Informe seu e-mail" value="<?php echo $email ?>" /><br><br>

	<?php
	$user = "";
	if (isset($valorForm['user'])) {
		$user = $valorForm['user'];
	}
	?>
	<label for="user">Usuário:<span style="color: #f00;">*</span> </label>

	<!-- Insere o campo email -->
	<input type="text" name="user" id="user" placeholder="Informe o usuário" value="<?php echo $user ?>" /><br><br>

	<!-- Insere o botão entrar -->
	<button type="submit" name="btnEditProfile" value="Editar" id="">Editar</button>

</form>
<!-- Fim do Formulário -->