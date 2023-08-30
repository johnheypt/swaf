<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

use PDO;
use PDOException;

/**
 * Classe genérica para Editar um registro no banco de dados
 *
 * @author John Trindade
 */
class AdmsUpdate extends AdmsConn
{
    /** @var string $table Recebe o nome da tabela */
    private string $table;

    /** @var string|null Recebe os termos */
    private string|null $terms;

    /** @var array $data recebe os dados   */
    private array $data;
    
    /** @var array $values Recebe os valores que deve ser atribuidos nos link da QUERY com bindValue */
    private array $value = [];

    /** @var string|null|bool $result Recebe os registros do banco de dados e retorna para a Models */
    private string|null|bool $result;

    /** @var object $update prepara a query */
    private object $update;
    
    /** @var string $query Recebe a QUERY preparada */
    private string $query;

    /** @var object $conn Recebe a conexao com BD */
    private object $conn;

    /**
     * @return array Retorna o valor verdadeiro ou falso
     */
    function getResult(): string|null|bool
    {
        return $this->result;
    }

    public function exeUpdate(string $table, array $data, string|null $terms = null, string|null $parseString = null): void
    {
        $this->table = $table;
        $this->data = $data;
        $this->terms = $terms;

        parse_str($parseString, $this->value);

        $this->exeReplaceValues();
    }
    /**
     * Substitui o link pelo valor
     *
     * @return void
     */
    private function exeReplaceValues(): void
    {
        foreach ($this->data as $key => $value) {
            $values[] = $key . "=:" . $key;
        }
        $values = implode(', ', $values);

        $this->query = "UPDATE {$this->table} SET {$values} {$this->terms}";

        $this->exeInstruction();
    }

    private function exeInstruction(): void
    {
        $this->connection();
        try{
            $this->update->execute(array_merge($this->data, $this->value));
            $this->result = true;
        }catch(PDOException $err){
            $this->result = null;
        }
    }

    /**
     * Obtem a conexão com o banco de dados da classe pai "Conn".
     * Prepara uma instrução para execução e retorna um objeto de instrução.
     * 
     * @return void
     */
    private function connection(): void
    {
        $this->conn = $this->connectDb();
        $this->update = $this->conn->prepare($this->query);
    }
}
