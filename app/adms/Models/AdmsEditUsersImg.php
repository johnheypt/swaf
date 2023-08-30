<?php

namespace App\adms\Models;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

/**
 * Editar Imagem do usuario do banco de dados
 */
class AdmsEditUsersImg
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $dataImagem Recebe os dados da imagem */
    private array|null $dataImagem;

    /** @var string $directory Recebe o endereço de upload da imagem */
    private string $directory;

    /** @var string $delImg Recebe o endereço da imagem que deve ser excluida */
    private string $delImg;

    /** @var string $nameImg Recebe o nome convertido da imagem sem caracteres especiais */
    private string $nameImg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewUser(int $id): bool
    {
        $this->id = $id;

        $viewUser = new \App\adms\helpers\AdmsRead();
        $viewUser->fullRead(
            "SELECT id, image
                            FROM adms_users
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
            return false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataImagem = $this->data['new_image'];
        unset($this->data['new_image']);

        $valEmptyField = new \App\adms\helpers\AdmsValidationField();
        $valEmptyField->validationField($this->data);
        if ($valEmptyField->getResult()) {
            if (!empty($this->dataImagem['name'])) {
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /** 
     * Verificar se existe o usuário com o ID recebido
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valExtImg = new \App\adms\helpers\AdmsValidationImg();
        $valExtImg->validateImage($this->dataImagem['type']);
        if (($this->viewUser($this->data['id'])) and ($valExtImg->getResult())) {
            $this->result = false;
            $this->upload();
        } else {
            $this->result = false;
        }
    }

    private function upload(): void
    {
        $this->slugImg = new \App\adms\helpers\AdmsSlug();
        $this->nameImg = $this->slugImg->slug($this->dataImagem['name']);

        $this->directory = "app/adms/assets/images/users/" . $this->data['id'] . "/";
         
        $uploadImg = new \App\adms\helpers\AdmsValidationImg();
        $uploadImg->upload($this->dataImagem, $this->directory, $this->nameImg, 300, 300);

        if($uploadImg->getResult()){
            $this->edit();
        }else{
            $this->result = false;
        }

    }

    private function edit(): void
    {
        $this->data['image'] = $this->nameImg;
        $this->data['updatetAt'] = date("Y-m-d H:i:s");

        $upUser = new \App\adms\helpers\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upUser->getResult()) {
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    private function deleteImage(): void
    {
        if (((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) and ($this->resultBd[0]['image'] != $this->nameImg)) {
            $this->delImg = "app/adms/assets/images/users/" . $this->data['id'] . "/" . $this->resultBd[0]['image'];
            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
        }


        $_SESSION['msg'] = "<p style='color: green;'>Imagem editada com sucesso!</p>";
        $this->result = true;
    }
}
