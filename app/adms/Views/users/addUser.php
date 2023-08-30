<?php

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
if (isset($this->data['form'])) {
	$valorForm = $this->data['form'];
}
?>

<h1>Cadastrar Usuário</h1>

<?php

if (isset($_SESSION['msg'])) {
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<!-- Inicio do Formulário -->
<form method="POST" action="" id="form-add-user" class="form-add-user">
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
	<label for="apelido">Apelido:</label>
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

	<label>Situação:<span style="color: #f00;">*</span> </label>
	<select name="adms_sits_user_id" id="adms_sits_user_id">
		<option value="">Selecione</option>
		<?php
		foreach ($this->data['select']['sit'] as $sit) {
			extract($sit);
			if ((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_sit)) {
				echo "<option value='$id_sit' selected>$name_sit</option>";
			} else {
				echo "<option value='$id_sit'>$name_sit</option>";
			}
		}
		?>
	</select><br><br>

	<label for="senha">Senha:<span style="color: #f00;">*</span> </label>
	<!-- Insere o campo senha -->
	<input type="password" name="senha" id="senha" onkeyup="passwordStrength()" autocomplete="on" placeholder="Digite sua senha" /><br><br>

	<span id="msgViewStrength"><br></span>

	<span style="color: #f00;">* Campo Obrigatório</span><br><br>

	<!-- Insere o botão entrar -->
	<button type="submit" name="btnNewUser" value="Cadastrar" id="">Cadastrar</button>


</form>
<!-- Fim do Formulário -->