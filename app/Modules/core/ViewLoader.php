<?php

namespace Modules\core;

class ViewLoader
{
    public $data;

    public function view(string $module, string $view, $data=[], string $layout = 'blank'): void
    {
        $this->data = $data;
        $viewFile = 'app/Modules/'.$module.'/views/'.$view.'.php';

        if (is_file($viewFile)) {
            $view = $viewFile;
            require 'app/Modules/layouts/'.$layout.'.php';
        } else {
            exit('Erro 8: Por favor tente novamente. Caso o problema persista, entre em contato o administrador '.EMAILADM);
        }
    }
}
