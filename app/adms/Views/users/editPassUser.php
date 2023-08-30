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

<h1>Editar Senha</h1>

<?php

echo "<a href='" . URLADM . "list-users/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
	echo "<a href='" . URLADM . "view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<!-- Inicio do Formulário -->
<form method="POST" action="" id="form-edit-pass-user" class="form-edit-pass-user">

	<?php
	$id = "";
	if (isset($valorForm['id'])) {
		$id = $valorForm['id'];
	}
	?>

	<!-- Insere o campo id -->
	<input type="hidden" name="id" id="id" value="<?php echo $id ?>" />

	<label for="senha">Senha:<span style="color: #f00;">*</span> </label>

	<!-- Insere o campo senha -->
	<input type="password" name="senha" id="senha" onkeyup="passwordStrength()" autocomplete="on" placeholder="Digite a nova senha" /><br><br>

	<label for="confsenha">Confirmar Senha:<span style="color: #f00;">*</span> </label>

	<!-- Insere o campo email -->
	<input type="password" name="confsenha" id="confsenha" placeholder="Repita a senha" />

	<span id="msgViewStrength"><br><br></span>

	<span style="color: #f00;">* Campo Obrigatório</span><br><br>

	<!-- Insere o botão entrar -->
	<button type="submit" name="btnEditPassUser" value="Editar" id="">Editar</button>


</form>
<!-- Fim do Formulário -->