<?php
    require_once './database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mob_venda
 *
 * @author Henrique
 */
class venda {
    private $id_venda;
    //private $id_mobile;
    private $data_venda, $id_cliente;
   // private $endereco, $telefone, $email;
    
    function __construct($id_venda = 0) {
        $this->id_venda = $id_venda;
    } 

    public function insere() {
        $db = new database();
        $c = $db->getConnection();

        $sql = "INSERT INTO venda(data_venda, id_cliente) "
                . "values(:data, :id_cliente)";
        $st = $c->prepare($sql);
                
    
        $st->bindParam(':data', $this->data_venda, PDO::PARAM_STR);
        $st->bindParam(':id_cliente', $this->id_cliente, PDO::PARAM_INT);

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

        $sql = "SELECT * FROM venda";
        $rows = $db->query($sql);
        return $rows;
    }

    public function consultaCompleto(){
        $db = new database();

        $sql = "SELECT * FROM venda v join det_venda d using(id_venda)";
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
