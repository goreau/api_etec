<?php
  require_once "RestServer.php";
  require_once './database.php';
  
  
  class Recebe {
     /* example: http://200.144.1.24/etec/importa.php?tipo=cliente"
      * 
      */
      public function produto(){
         $ret_arr = array(); 
        
         $db = new database();
         $sql = "SELECT id_produto, nome, tipo, preco FROM produto"; 
         // $bd->setSql($sql);
         //  return $bd->query();
         $rows = $db->query($sql);

         

         // check if more than 0 record found
         if ($rows) {

            // products array
            $vez = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               array_push($vez, $row);
            }
    
            $ret_arr["produto"] = $vez;
         }    
    
         if (count($ret_arr)>0){
            // set response code - 200 OK
            http_response_code(200);

            // show products data in json format
            echo json_encode($ret_arr);
         } else {
            // set response code - 404 Not found
            http_response_code(404);

            // tell the user no products found
            echo json_encode(
                     array("message" => "Nenhum registro encontrado.")
            );
         }
      }
     
     public function cliente(){
         $ret_arr = array();  
        
         $db = new database();
         $sql = "SELECT id_cliente, nome, dt_nascimento, sk_cliente, 1 as status FROM cliente"; 

         $rows = $db->query($sql);

         

         // check if more than 0 record found
         if ($rows) {

            // products array
            $vez = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               array_push($vez, $row);
            }
    
            $ret_arr["cliente"] = $vez;
         }    
    
         if (count($ret_arr)>0){
            // set response code - 200 OK
            http_response_code(200);

            // show products data in json format
            echo json_encode($ret_arr);
         } else {
            // set response code - 404 Not found
            http_response_code(404);

            // tell the user no products found
            echo json_encode(
                     array("message" => "Nenhum registro encontrado.")
            );
         }
     }
  }
  
  
  $rest = new RestServer();
  $rest->addServiceClass('Recebe');
  $rest->handle();
