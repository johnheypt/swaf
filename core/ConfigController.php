<?php

namespace Core;

if (!defined('AP5BL8KES2W0A2F3')) {
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Recebe a URL e manipula
 * Carregar a CONTROLLER
 * @author John Trindade <jht_pt@icloud.com>
 */
class ConfigController extends Config
{

    /** @var string $url Recebe a URL do .htaccess */
    private string $url;
    /** @var array $urlArray Recebe a URL convertida para array */
    private array $urlArray;
    /** @var string $urlController Recebe da URL o nome da controller */
    private string $urlController;
    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string $urlParamentro Recebe da URL o parâmetro */
    private string $urlParameter;
    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;
    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;
    /** @var string $urlSlugController Recebe o controller tratada */
    private string $urlSlugController;
    /** @var string $urlSlugMetodo Recebe o metodo tratado */
    private string $urlSlugMetodo;

    /**
     * Recebe a URL do .htaccess
     * Validar a URL
     */
    public function __construct()
    {
        $this->configAdm();

        $urlController = new \App\adms\helpers\AdmsSlug();

        $this->urlController = $urlController->slugController(CONTROLLERERRO);
        $this->urlMetodo = $urlController->slugMetodo(METODO);
        $this->urlParameter = "";

        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            //$this->clearUrl();
            $this->url = $urlController->clearUrl($this->url);
            $this->urlArray = explode("/", $this->url);

            // set default controller, method and parameters
            $this->urlController = $urlController->slugController(CONTROLLER);
            $this->urlMetodo = $urlController->slugMetodo(METODO);
            $this->urlParameter = "";

            echo '<pre>$this->urlArray: ';
            print_r($this->urlArray);
            echo '</pre>';

            if (isset($this->urlArray[0])) {
                $this->urlController = $urlController->slugController($this->urlArray[0]);
            }

            if (isset($this->urlArray[1])) {
                $this->urlMetodo = $urlController->slugMetodo($this->urlArray[1]);
            }

            if (isset($this->urlArray[2])) {
                $this->urlParameter = $this->urlArray[2];
            }
        }
    }

    /**
     * Carregar as Controllers
     * Instanciar as classes da controller e carregar o método 
     *
     * @return void
     */
    public function loadPage(): void
    {
        $loadPgAdm = new \Core\CarregarPgAdm();
        $loadPgAdm->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);
    }
}
