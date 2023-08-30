<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Classe genérica para realizar upload de arquivos
 *
 * @author John Trindade
 */
class AdmsUpload
{
    /** @var string $directory Recebe o endereço de upload do arquivo */
    private string $directory;

    /** @var string $tmpName recebe o endereço temporario do arquivo     */
    private string $tmpName;

    /** @var string $tmpName recebe o nome do arquivo     */
    private string $name;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Recebe os dados do arquivo
     *
     * @param string $directory recebe o caminho
     * @param string $tmpName recebe o local temporario do arquivo
     * @param string $name recebe o nome do arquivo
     * @return void
     */
    public function upload(string $directory, string $tmpName, string $name): void
    {
        $this->directory = $directory;
        $this->tmpName = $tmpName;
        $this->name = $name;

        if($this->valDirectory()){
            $this->uploadFile();
        }else{
            $this->result = false;
        }
    }

    private function valDirectory():bool
    {
        if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
            mkdir($this->directory, 0755);
            if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    private function uploadFile(){
        if (move_uploaded_file($this->tmpName, $this->directory . $this->name)) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }

}
