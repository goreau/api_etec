<?php
    require_once './database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mob_produto
 *
 * @author Henrique
 */
class produto {
    private $id_produto;
    //private $id_mobile;
    private $nome, $tipo, $preco;
   // private $endereco, $telefone, $email;
    
    function __construct($id_produto = 0) {
        $this->id_produto = $id_produto;
    } 

    public function insere() {
        $db = new database();
        $c = $db->getConnection();

        $sql = "INSERT INTO produto(nome, tipo, preco) "
                . "values(:nome, :tipo, :preco)";
        $st = $c->prepare($sql);
                
    
        $st->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $st->bindParam(':tipo', $this->dt_nascimento, PDO::PARAM_INT);
        $st->bindParam(':preco', $this->preco, PDO::PARAM_STR);

        if (!$st->execute()) {
            $x = $c->errorInfo();
            throw new Exception('Problema registrando a solicitação');
            return 0;
        }

        $id = $c->lastInsertId();
                      
        return $id;
    }
    
    public function consulta(){
        $db = new database();

        $sql = "SELECT * FROM produto";
        $rows = $db->query($sql);
        return $rows;
    }
    
    function __set($name, $value)
    {
        $this->name = $value;
    }

    function __get($name)
    {
        return $this->$name;
    }
}
