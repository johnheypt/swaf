<?php 

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}
if(isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

/* Atribui vazio a variavel */
$email = "";

/* Verifica se a variavel existe, caso exista atribui o valor da mesma a variavel $email */
if(isset($valorForm['email'])){
    $email = $valorForm['email'];
}

if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset ($_SESSION['msg']);
}
?>
 <!-- Inicio Container -->
 <div class="container-login">
		 <div class="wrapper-login">
			 <!-- Cabeçalho acima do Formulário -->
			 <div class="title">
				 <!-- Adiciona o Titulo do Cabeçalho -->
				<span class="">Novo Usuário</span>	 
			 </div>
			 <!-- fim do cabeçalho do formulário -->

			 <span id="msg"></span>
			 <!-- Inicio do Formulário -->
			 <form method="POST" action="" id="form-new-user" class="form-new-user">
			 	<div class="row">
					<?php	
						$name = "";
						if (isset($valorForm['name'])){
							$name = $valorForm['name'];
						}
						$apelido = "";
						if (isset($valorForm['apelido'])){
							$apelido = $valorForm['apelido'];
						}
					?>
					 <!-- Icone do usuario -->
					 <i class="fa-solid fa-user" for="name" ></i>
					 <!-- Insere o campo nome -->
					 <input type="text" name="name" id="name" placeholder="Digite o seu Nome" value="<?php echo $name ?>" />
					 <!-- Insere o campo apelido -->
					 <input type="text" name="apelido" id="apelido" placeholder="Digite o seu apelido" value="<?php echo $apelido ?>"/>
				 </div> 
			 	<div class="row">
				 <?php	
						$email = "";
						if (isset($valorForm['email'])){
							$email = $valorForm['email'];
						}
					?>
					 <!-- Icone do usuario -->
					 <i class="fa-solid fa-user" for="email" ></i>
					 <!-- Insere o campo email -->
					 <input type="email" name="email" id="email" placeholder="Informe seu e-mail" value="<?php echo $email ?>" />
				 </div>
				<div class="row">
					<!-- Icone da senha -->
					<i class="fa-solid fa-lock" for="senha"></i>
					<!-- Insere o campo senha -->
					<input type="password" name="senha" id="senha" onkeyup="passwordStrength()" autocomplete="on" placeholder="Digite sua senha" />
				</div>
				<span id="msgViewStrength"><br></span>
				<div class="row button">
					<!-- Insere o botão entrar -->
					<button type="submit" name="btnNewUser" value="Cadastrar" id="">Cadastrar</button>
				</div>
				<div class="signup-link">
					<!-- Insere os links para cadastras e esqueci senha -->
					<a href="<?php echo URLADM;?>">Clique aqui</a> para acessar -  <a href="<?php echo URLADM;?>recover-pass/index">Esqueci a Senha</a>
				</div>
			 </form>
			 <!-- Fim do Formulário -->
		 </div>
	 </div>
	 <!-- Fim do Container -->