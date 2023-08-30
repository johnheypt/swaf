<?php

namespace Modules\Login\Controllers;

use Modules\core\ViewLoader;
use Modules\Login\Models\Login as LoginModel;

if (!defined('AP5BL8KES2W0A2F3')) {
    header('Location:/');
    exit('Erro: Página não encontrada');
}
/**
 * Controller da página login.
 *
 * @author John Trindade <jht_pt@icloud.com>
 */
class Login
{
    /** @var array|string|null Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array|string|null recebe os dados do Formulário */
    private array|string|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['btnentrar'])) {
            $validationLogin = new LoginModel();
            $validationLogin->login($this->dataForm);
            if ($validationLogin->getResult()) {
                $urlRedirect = URLADM.'dashboard/index';
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
            }
        }

        // carrega a view
        (new ViewLoader())->view('Login', 'index');
    }
}
