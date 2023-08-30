<?php

namespace Core;

if (!defined('AP5BL8KES2W0A2F3')) {
    header('Location:/');
    exit('Erro: Página não encontrada');
}

/**
 * Verifica se existe a classe e
 * Carregar a CONTROLLER.
 *
 * @author John Trindade <jht_pt@icloud.com>
 */
class CarregarPgAdm
{
    /** @var string Recebe da URL o nome da controller */
    private string $urlController;
    /** @var string Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string Recebe da URL o parâmetro */
    private string $urlParameter;
    /** @var string Controller que deve ser carregada */
    private string $classLoad;
    /** @var array recebe as pagina para verificar se é publica ou privada */
    private array $listPgPublic;
    private array $listPgPrivate;

    /**
     * Verificar se existe a classe.
     *
     * @param string $urlController Recebe da URL o nome da controller
     * @param string $urlMetodo     Recebe da URL o método
     * @param string $urlParamentro Recebe da URL o parâmetro
     */
    public function loadPage(string|null $urlController, string|null $urlMetodo, string|null $urlParameter): void
    {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParameter = $urlParameter;

        $this->verifyPage();

        $slugcontroler = new \App\adms\helpers\AdmsSlug();

        $prevModule = '\\App\\adms\\Controllers\\' . $this->urlController;
        if (class_exists($this->classLoad)) {
            $this->loadMetodo();
            // se não existir no novo modules, tente no jeito prévio
        } elseif (class_exists($prevModule)) {
            $this->classLoad = $prevModule;
            $this->loadMetodo();
        } else {
            echo '<pre>A class não existe: ';
            print_r('A class não existe: ' . $this->classLoad);
            echo '</pre>';
            $this->urlController = $slugcontroler->slugController(CONTROLLER);
            $this->urlMetodo = $slugcontroler->slugMetodo(METODO);
            $this->urlParameter = '';
            $this->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);
        }
    }

    /**
     * Verificar se existe o método e carregar a página.
     */
    private function loadMetodo(): void
    {
        $classLoad = new $this->classLoad();
        if (method_exists($classLoad, $this->urlMetodo)) {
            $classLoad->{$this->urlMetodo}($this->urlParameter);
        } else {
            exit('Erro - 004: Por favor tente novamente. Caso o problema persista, entre em contato o administrador ' . EMAILADM);
        }
    }

    /**
     * Verifica se a Página é publica ou privada,
     * caso seja privada verifica se o usuário esta logada ou não,
     * se não estiver redireciona para a pagina de login.
     */
    private function verifyPage(): void
    {
        $this->listPgPublic = ['Login', 'Erro', 'Logout', 'NewUser', 'ConfEmail', 'NewConfEmail', 'RecoverPass', 'UpdatePassword'];
        $this->listPgPrivate = [
            'AddUsers',
            'Dashboard',
            'DeleteUsers',
            'Users',
            'Listar',
            'ViewUsers',
            'EditUsers',
            'EditPasswordUsers',
            'EditUsersImg',
            'ViewProfile',
            'EditProfile',
        ];

        if (in_array($this->urlController, $this->listPgPublic)) {
            // $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->classLoad = '\\Modules\\' . $this->urlController . '\\Controllers\\' . $this->urlController;
        } elseif (in_array($this->urlController, $this->listPgPrivate)) {
            $this->verifyLogin();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'> Erro 005: Página não encontrada, por favor verifique</p>";
            $urlRedirect = URLADM . 'login/index';
            header("Location: $urlRedirect");
        }
    }

    private function verifyLogin(): void
    {
        if ((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name'])) and (isset($_SESSION['user_email']))) {
            // $this->classLoad = '\\App\\adms\\Controllers\\' . $this->urlController;
            $this->classLoad = '\\Modules\\' . $this->urlController . '\\Controllers\\' . $this->urlController;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'> Erro 006: Efectue o Login para acessar!</p>";
            $urlRedirect = URLADM . 'login/index';
            header("Location: $urlRedirect");
        }
    }
}
