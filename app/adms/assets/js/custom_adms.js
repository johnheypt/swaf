//permitir retorno no navegador
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Calcular a forca da senha
function passwordStrength() {
    var password = document.getElementById("senha").value;
    var strength = 0;

    if ((password.length >= 6) && (password.length <= 8)) {
        strength += 10;
    } else if (password.length > 8) {
        strength += 25;
    }

    if ((password.length >= 8) && (password.match(/[a-z]+/))) {
        strength += 10;
    }

    if ((password.length >= 8) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }

    if ((password.length >= 9) && (password.match(/[@#$%!?*]+/))) {
        strength += 25;
    }

    if (password.match(/([1-9]+)\1{1,}/)) {
        strength -= 25;
    }
    viewStrength(strength);
}

function viewStrength(strength) {
    // Imprimir a força da senha 
    if (strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #f00;'>Senha Fraca</p>";
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #ff8c00;'>Senha Moderada</p>";
    } else if ((strength >= 50) && (strength < 69)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #7cfc00;'>Senha Boa</p>";
    } else if (strength >= 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #008000;'>Senha Forte</p>";
    } else {
        document.getElementById("msgViewStrength").innerHTML = "";
    }
}

const formNewUser = document.getElementById("form-new-user");
if (formNewUser) {
    formNewUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var apelido = document.querySelector("#apelido").value;
        // Verificar se o campo esta vazio
        if (apelido === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo apelido!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var senha = document.querySelector("#senha").value;
        // Verificar se o campo esta vazio
        if (senha === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        // Verificar se o campo senha tem no minino 8 caracter
        if (senha.length < 8) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: O campo senha tem que ter no mínimo 8 caracter!</p>";
            return;
        }

        // Verificar se o campo senha tem numero repetido
        if (senha.match(/([0-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: O campo senha não pode conter dois números iguais seguidos!</p>";
            return;
        }

        // Verificar se o campo senha tem uma letra maiuscula
        if (!senha.match(/[A-Z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: É Necessário conter pelo menos uma letra maíuscula!</p>";
            return;
        }

        // Verificar se o campo senha tem uma letra minuscula
        if (!senha.match(/[a-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: É Necessário conter pelo menos uma minuscula!</p>";
            return;
        }
        // Verifica se o campo senha tem caracteres especiais
        if (!senha.match(/[@#$%!?*]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve conter letras maiusculas, minusculas, Números e os seguintes caracteres ( @ # $ % ! ? * )</p>";
            return;
        }else{
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditPassUser = document.getElementById("form-edit-pass-user");
if (formEditPassUser) {
    formEditPassUser.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var senha = document.querySelector("#senha").value;
        // Verificar se o campo esta vazio
        if (senha === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        // Verificar se o campo senha tem no minino 8 caracter
        if (senha.length < 8) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: O campo senha tem que ter no mínimo 8 caracter!</p>";
            return;
        }

        // Verificar se o campo senha tem numero repetido
        if (senha.match(/([0-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: O campo senha não pode conter dois números iguais seguidos!</p>";
            return;
        }

        // Verificar se o campo senha tem uma letra maiuscula
        if (!senha.match(/[A-Z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: É Necessário conter pelo menos uma letra maíuscula!</p>";
            return;
        }

        // Verificar se o campo senha tem uma letra minuscula
        if (!senha.match(/[a-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: É Necessário conter pelo menos uma minuscula!</p>";
            return;
        }
        // Verifica se o campo senha tem caracteres especiais
        if (!senha.match(/[@#$%!?*]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve conter letras maiusculas, minusculas, Números e os seguintes caracteres ( @ # $ % ! ? * )</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formAddUser = document.getElementById("form-add-user");
if (formAddUser) {
    formAddUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var apelido = document.querySelector("#apelido").value;
        // Verificar se o campo esta vazio
        if (apelido === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo apelido!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }
        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }
        //Receber o valor do campo
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        // Verificar se o campo esta vazio
        if (adms_sits_user_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo situação!</p>";
            return;
        }

        //Receber o valor do campo
        var senha = document.querySelector("#senha").value;
        // Verificar se o campo esta vazio
        if (senha === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        // Verificar se o campo senha tem no minino 8 caracter
        if (senha.length < 8) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: O campo senha tem que ter no mínimo 8 caracter!</p>";
            return;
        }

        // Verificar se o campo senha tem numero repetido
        if (senha.match(/([0-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: O campo senha não pode conter dois números iguais seguidos!</p>";
            return;
        }

        // Verificar se o campo senha tem uma letra maiuscula
        if (!senha.match(/[A-Z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: É Necessário conter pelo menos uma letra maíuscula!</p>";
            return;
        }

        // Verificar se o campo senha tem uma letra minuscula
        if (!senha.match(/[a-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: É Necessário conter pelo menos uma minuscula!</p>";
            return;
        }
        // Verifica se o campo senha tem caracteres especiais
        if (!senha.match(/[@#$%!?*]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve conter letras maiusculas, minusculas, Números e os seguintes caracteres ( @ # $ % ! ? * )</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditUser = document.getElementById("form-edit-user");
if (formEditUser) {
    formEditUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }
        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }
        //Receber o valor do campo
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        // Verificar se o campo esta vazio
        if (adms_sits_user_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo situação!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditProfile = document.getElementById("form-edit-profile");
if (formEditProfile) {
    formEditProfile.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }
        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formLogin = document.getElementById("form-login");
if (formLogin) {
    formLogin.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var senha = document.querySelector("#senha").value;
        // Verificar se o campo senha esta vazio
        if (senha === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formNewConfEmail = document.getElementById("form-new-conf-email");
if (formNewConfEmail) {
    formNewConfEmail.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formRecover = document.getElementById("form-recover");
if (formRecover) {
    formRecover.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formUpdatePass = document.getElementById("form-updatePass");
if (formUpdatePass) {
    formUpdatePass.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var senha = document.querySelector("#senha").value;
        // Verificar se o campo esta vazio
        if (senha === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditImgUser = document.getElementById("form-edit-imguser");
if (formEditImgUser) {
    formEditImgUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo esta vazio
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

function inputFileValImg() {
    //Receber o valor do campo
    var new_image = document.querySelector("#new_image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImage(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewImage(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function(e) {
            document.getElementById('preview-img').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 100px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}