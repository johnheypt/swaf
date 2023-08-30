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



<h1>Editar Imagem</h1>

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
<form method="POST" action="" id="form-edit-imguser" class="form-edit-imguser" enctype="multipart/form-data">

	<?php
	$id = "";
	if (isset($valorForm['id'])) {
		$id = $valorForm['id'];
	}
	?>

	<!-- Insere o campo id -->
	<input type="hidden" name="id" id="id" value="<?php echo $id ?>" />

	<label for="image">Imagem:<span style="color: #f00;">*</span> </label>

	<!-- Insere o campo nome -->
	<input type="file" name="new_image" id="new_image" onchange="inputFileValImg()"/><br>
	<span>Tamanho recomendado será de 300x300, caso o contrário será redimensionada</span><br>
	<?php
    if ((!empty($valorForm['image'])) and (file_exists("app/adms/assets/images/users/" . $valorForm['id'] . "/" . $valorForm['image']))) {
        $old_image = URLADM . "app/adms/assets/images/users/" . $valorForm['id'] . "/" . $valorForm['image'];
    } else {
        $old_image = URLADM . "app/adms/assets/images/users/default/user.jpg";
    }
    ?>

    <span id="preview-img">
        <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px;">
    </span><br><br>
	
	<span style="color: #f00;">* Campo Obrigatório</span><br><br>
	<!-- Insere o botão entrar -->
	<button type="submit" name="btnEditUserImg" value="Alterar" id="">Alterar</button>

</form>
<!-- Fim do Formulário -->