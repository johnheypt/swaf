<?php

namespace App\adms\helpers;

if(!defined('AP5BL8KES2W0A2F3')){
    header("Location:/");
    die("Erro: Página não encontrada");
}

use PDO;
use PDOException;

/**
 * Classe genérica para eliminar um registro no banco de dados
 *
 * @author John Trindade
 */
class AdmsDelete extends AdmsConn
{
    /** @var string $table Recebe o nome da tabela */
    private string $table;

    /** @var string|null Recebe os termos */
    private string|null $terms;

    /** @var array $values Recebe os valores que deve ser atribuidos nos link da QUERY com bindValue */
    private array $value = [];

    /** @var string|null|bool $result Recebe os registros do banco de dados e retorna para a Models */
    private string|null|bool $result;

    /** @var object $delete prepara a query */
    private object $delete;
    
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

    public function exeDelete(string $table, string|null $terms = null, string|null $parseString = null): void
    {
        $this->table = $table;
        $this->terms = $terms;

        parse_str($parseString, $this->value);

        $this->query = "DELETE FROM {$this->table} {$this->terms}";
        $this->exeInstruction();
    }
    
    private function exeInstruction(): void
    {
        $this->connection();
        try{
            $this->delete->execute($this->value);
            $this->result = true;
        }catch(PDOException $err){
            $this->result = false;
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
        $this->delete = $this->conn->prepare($this->query);
    }
}
