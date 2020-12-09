<?php
set_time_limit(0);
/*
 * insert into casosn
select nr_sinan, if(nome is null, 'nulo', nome), cd_sexo, endereco_pac, bairro_pac, (case when lpi is null then (case when municipio_pac is null then municipio_unid else municipio_pac end) else lpi end),
(case resultado when 'Reagente' then 1 when 'nao reagente' then 2 else 3 end), semana, lote, geo_pt, sintomas
from caso;
 * To change this license header, choose License Headers in Project Properties.s template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sisaweb
 *
 * @author Henrique
 */
class database {
    private $hostname, $user, $senha, $banco;
    private $conn;

    function __construct() {
        $this->hostname = 'localhost';
        $this->user = 'root';
        $this->senha = '';
        $this->banco = 'etec_sisoo';
        $this->conecta();
    }

              
    private function conecta(){
        try {
            $this->conn = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->banco.", ".$this->user . ", " . $this->senha);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }

    public function getConnection()
    {
        return $this->conn;
    }
    
    function query($sql){
        $result = array();
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
          
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          $this->conn = null; 

          return $result;
    }
    
    
    
    function last(){
        $sql = "SELECT last_insert_id() as id";
        $rows = $this->query($sql);
        $row  = $rows['0'];
        return $row['id'];
    }
    
    function dataVai($data){
        if (strpos($data,'/')>0){
            $data = implode('-',array_reverse(explode('/',$data)));
        }
        return $data;
    }

    function dataVem($data){
        $data = implode('/',array_reverse(explode('-',$data)));
        return $data;
    }
    
}
