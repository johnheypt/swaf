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
				<span class="">Novo Link</span>	 
			 </div>
			 <!-- fim do cabeçalho do formulário -->

			 <span id="msg"></span>
			 <!-- Inicio do Formulário -->
			 <form method="POST" action="" id="form-new-conf-email" class="form-new-conf-email">
			 	
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
				
				<div class="row button">
					<!-- Insere o botão entrar -->
					<button type="submit" name="btnNewConfEmail" value="Enviar" id="">Enviar</button>
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