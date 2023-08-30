<?php

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

if (isset($_SESSION['msg'])) {
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>
<!-- Inicio Container -->
<div class="container-login">
	<div class="wrapper-login">
		<!-- Cabeçalho acima do Formulário -->
		<div class="title-logo">
			<!-- adiciona o logotipo -->
			<span><img src="img/logo/logotipo.png"></span>
		</div>
		<div class="title">
			<!-- Adiciona o Titulo do Cabeçalho -->
			<span class="">Nova Senha</span>
		</div>
		<!-- fim do cabeçalho do formulário -->
		<span id="msg"></span>
		<!-- Inicio do Formulário -->
		<form method="POST" action="" id="form-updatePass" class="form-updatePass">
			<div class="row">
				<!-- Icone da senha -->
				<i class="fa-solid fa-lock" for="senha"></i>
				<!-- Insere o campo senha -->
				<input type="password" name="senha" id="senha" placeholder="Digite a nova senha" />
			</div>
			<div class="row">
				<!-- Icone do usuario -->
				<i class="fa-solid fa-lock" for="confsenha"></i>
				<!-- Insere o campo email -->
				<input type="password" name="confsenha" id="confsenha" placeholder="Repita a senha" />
			</div>
			<div class="row button">
				<!-- Insere o botão entrar -->
				<button type="submit" name="btnupdate" value="actualizar">Actualizar</button>
			</div>
			<div class="signup-link">
				<!-- Insere os links para cadastras e esqueci senha -->
				<a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
			</div>
		</form>
		<!-- Fim do Formulário -->
	</div>
</div>
<!-- Fim do Container -->