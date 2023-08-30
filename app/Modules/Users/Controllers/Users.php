<?php

namespace Modules\Users\Controllers;

use Modules\core\ViewLoader;
use Modules\Users\Models\Users as ModelsUsers;

if (!defined('AP5BL8KES2W0A2F3')) {
    header('Location:/');
    exit('Erro: Página não encontrada');
}
/**
 * Controller da página listar usuarios.
 *
 * @author John Trindade <jht_pt@icloud.com>
 */
class Users
{
    /** @var array|string|null Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    public function list()
    {
        $list = new ModelsUsers();
        $list->list();

        if ($list->getResult()) {
            $this->data['list'] = $list->getResultBd();
        } else {
            $this->data['list'] = [];
        }

        // $loadView = new \Core\ConfigView('adms/Views/users/listusers', $this->data);

        (new ViewLoader())->view('Users', 'index', $this->data, 'admin');
    }
}
