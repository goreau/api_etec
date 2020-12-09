<?php
  require_once "RestServer.php";
  require_once './database.php';
  
  
  class Recebe {
     /* example: http://200.144.1.24/etec/importa.php?tipo=cliente"
      * 
      */
     public function produto(){
        $dados = array(); 
        
        $bd = new database();
        $sql = "SELECT nome, login, senha, nivel, email, 1 as status FROM usuario"; 
       // $bd->setSql($sql);
      //  return $bd->query();
     }
     
     public function cliente(){
        $dados = array(); 
        
        $bd = new database();
        $sql = "SELECT nome, email, endereco, dt_nascimento, telefone, id_mobile as id_cliente, 1 as status FROM cliente"; 
      //  $bd->setSql($sql);
      //  $dados["cliente"] = $bd->query();
            //    print_r($dados);
     //   return array("dados"=>$dados);
      //  return $bd->query();
     }
  }
  
  
  $rest = new RestServer();
  $rest->addServiceClass('Recebe');
  $rest->handle();
