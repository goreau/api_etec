<?php
    require_once './database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mob_cliente
 *
 * @author Henrique
 */
class cliente {
    private $id_cliente;
    //private $id_mobile;
    private $nome, $dt_nascimento;
   // private $endereco, $telefone, $email;
    
    function __construct($id_cliente = 0) {
        $this->id_cliente = $id_cliente;
    } 

    public function insere() {
        $db = new database();
        $c = $db->getConnection();

        $sql = "INSERT INTO cliente(nome,nascimento) "
                . "values(:nome, :nascimento)";
        $st = $c->prepare($sql);
                
    
        $st->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $st->bindParam(':nascimento', $this->dt_nascimento, PDO::PARAM_STR);

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

        $sql = "SELECT * FROM cliente";
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
