<?php
    require_once './database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mob_det_venda
 *
 * @author Henrique
 */
class det_venda {
    private $id_det_venda, $id_venda;
    //private $id_mobile;
    private $nome, $tipo, $subtotal;
   // private $endereco, $telefone, $email;
    
    function __construct($id_det_venda = 0, $id_venda = 0) {
        $this->id_det_venda = $id_det_venda;
        $this->id_venda = $id_venda;
    } 

    public function insere() {
        $db = new database();
        $c = $db->getConnection();

        $sql = "INSERT INTO det_venda(id_venda, id_produto, quantidade, subtotal) "
                . "values(:id_venda, :id_produto, :quantidade, :unitario)";
        $st = $c->prepare($sql);
                
        $st->bindParam(':id_venda', $this->id_venda, PDO::PARAM_INT);
        $st->bindParam(':id_produto', $this->id_produto, PDO::PARAM_INT);
        $st->bindParam(':quantidade', $this->quantidade, PDO::PARAM_INT);
        $st->bindParam(':unitario', $this->subtotal, PDO::PARAM_STR);

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

        $sql = "SELECT * FROM det_venda";
        $rows = $db->query($sql);
        return $rows;
    }
    
    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __get($name)
    {
        return $this->$name;
    }
}
