<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Classe generica para validar a extensao da imagem e 
 * redimensionar para o tamanho 300x300
 */
class AdmsValidationImg
{
    /* Recebe a extensao da Imagem */
    private string $mimeType;

    /* Recebe verdadeiro ou falso do result*/
    private bool $result;

    /* Recebe os dados da imagem */
    private array $imageData;

    /** @var string $directory Recebe o endereço de upload do arquivo */
    private string $directory;

    /** @var string Recebe o nome da imagem  */
    private string $name;

    /** @var integer recebe a largura da imagem */
    private int $width;

    /** @var integer Recebe a altura da imagem */
    private int $height;

    /** recebe o nome da nova imagem redimensionada  */
    private $newImage;

    /** Recebe o novo tamanho da imagem  */
    private $imgResize;

    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Valida e extensao da Imagem
     *
     * @param string $mimeType recebe a extensao da imagem
     * @return void
     */
    public function validateImage(string $mimeType): void
    {
        $this->mimeType = $mimeType;
        switch ($this->mimeType) {
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->result = true;
                break;
            case 'image/png':
            case 'image/x-png':
                $this->result = true;
                break;
            default:
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Somente é valido imagens JPEG ou PNG!</p>";
                $this->result = false;
        }
    }

    public function upload(array $imageData, string $directory, string $name, int $width, int $height): void
    {
        $this->imageData = $imageData;
        $this->directory = $directory;
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;

        $this->valDirectory();
    }

    private function valDirectory(): void
    {
        if ((file_exists($this->directory)) and (!is_dir($this->directory))) {
            $this->createDir();
        } elseif (!file_exists($this->directory)) {
            $this->createDir();
        } else {
            $this->uploadFile();
        }
    }

    private function createDir(): void
    {
        mkdir($this->directory, 0755);
        if (!file_exists($this->directory)) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload da imagem não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        } else {
            $this->uploadFile();
        }
    }

    private function uploadFile(): void
    {
        switch ($this->imageData['type']) {
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->uploadFileJpeg();
                break;
            case 'image/png':
            case 'image/x-png':
                $this->uploadFilePng();
                break;
            default:
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar imagem JPEG ou PNG!</p>";
                $this->result = false;
        }
    }

    private function uploadFileJpeg(): void
    {
        $this->newImage = imagecreatefromjpeg($this->imageData['tmp_name']);

        $this->redImg();

        // Enviar a imagem para servidor
        if (imagejpeg($this->imgResize, $this->directory . $this->name, 100)) {
            $_SESSION['msg'] = "<p style='color: green;'>Upload realizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }

    private function uploadFilePng(): void
    {
        $this->newImage = imagecreatefrompng($this->imageData['tmp_name']);

        $this->redImg();

        // Enviar a imagem para servidor
        if (imagepng($this->imgResize, $this->directory . $this->name, 1)) {
            $_SESSION['msg'] = "<p style='color: green;'>Upload realizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }

    private function redImg(): void
    {
        // Obter a largura da image
        $width_original = imagesx($this->newImage);

        // Obter a altura da image
        $height_original = imagesy($this->newImage);

        // Criar uma imagem modelo com as dimensões definidas para nova imagem
        $this->imgResize = imagecreatetruecolor($this->width, $this->height);

        // Copiar e redimensionar parte da imagem enviada pelo usuário e interpola com a imagem tamanho modelo
        imagecopyresampled($this->imgResize, $this->newImage, 0, 0, 0, 0, $this->width, $this->height, $width_original, $height_original);
    }
}