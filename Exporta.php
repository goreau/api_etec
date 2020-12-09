<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'database.php';
require_once './entidades/produto.php';
require_once './entidades/cliente.php';
require_once './entidades/venda.php';
require_once './entidades/det_venda.php';

$json = filter_input(INPUT_POST, "dados");
$tipo = filter_input(INPUT_POST, "tipo");
//$nome = filter_input(INPUT_POST, "nome");
//$tipo = "usuario";
//$json =  '[{"nome":"Jose da Silva", "login":"silva", "senha":"silva", "nivel":"1", "id_mobile":"1"}, {"nome":"Pedro Moreira", "login":"moreira", "senha":"moreira", "nivel":"2","id_mobile":"2"}]';
if (get_magic_quotes_gpc()) {
    $json = stripslashes($json);
}
//Decode JSON into an Array
$linha = json_decode($json);
$a = array();
$b = array();
//Loop through an Array and insert data read from JSON into DB
switch ($tipo) {
    case "produto":
        for ($i = 0; $i < count($linha); $i++) {
           // echo $linha[$i]['nome'];
            $tab = new produto(0);
            $tab->__set('nome',$linha[$i]->nome);
            $tab->__set('tipo',$linha[$i]->tipo);
            $tab->__set('preco',$linha[$i]->preco);
            
            $res = $tab->insere();
            //cria a resposta, segundo resultado da inserção
            if ($res>0) {
                $b["id"] = $linha[$i]->id_produto;
                $b["status"] = '1';
                array_push($a, $b);
            } else {
                $b["id"] = $linha[$i]->id_produto;
                $b["status"] = '0';
                array_push($a, $b);
            }
        }
        break;
    case "cliente":
        for ($i = 0; $i < count($linha); $i++) {
            $tab = new cliente(0);
           // echo $linha[$i]['nome'];
           $tab->__set('nome',$linha[$i]->nome);
           $tab->__set('nascimento',$linha[$i]->nascimento);
           
           $res = $tab->insere();
           //cria a resposta, segundo resultado da inserção
           if ($res>0) {
               $b["id"] = $linha[$i]->id_cliente;
               $b["status"] = '1';
               array_push($a, $b);
           } else {
               $b["id"] = $linha[$i]->id_cliente;
               $b["status"] = '0';
               array_push($a, $b);
           }
        }
        break;
    case "venda":
            for ($i = 0; $i < count($linha); $i++) {
                $tab = new venda(0);
               // echo $linha[$i]['nome'];
               $tab->__set('nome',$linha[$i]->nome);
               $tab->__set('nascimento',$linha[$i]->nascimento);
               
               $res = $tab->insere();
               //cria a resposta, segundo resultado da inserção
               if ($res>0) {
                    if ($this->insereDetVenda($linha)){
                        $b["id"] = $linha[$i]->id_cliente;
                        $b["status"] = '1';
                        array_push($a, $b);
                    } else {
                        $b["id"] = $linha[$i]->id_cliente;
                        $b["status"] = '0';
                        array_push($a, $b);
                    } 
               } else {
                   $b["id"] = $linha[$i]->id_cliente;
                   $b["status"] = '0';
                   array_push($a, $b);
               }
            }
            break;
    default :
        echo "ferrou";
        break;
}

function insereDetVenda($linha){
    $dets = $linha->detalhes;
    $idv  = $linha->id_venda;
    $res  = true;
    
    for ($i = 0; $i < count($dets); $i++) {
        $tab = new det_venda(0, $idv);
        // echo $linha[$i]['nome'];
        $tab->__set('nome',$linha[$i]->nome);
        $tab->__set('nascimento',$linha[$i]->nascimento);
       
        $res = $tab->insere();
        //cria a resposta, segundo resultado da inserção
        if ($res>0) {
            $res = true;
        } else {
           $res = false;
           break;
        }
    }
    return $res;
}

//Post JSON response back to Android Application
echo json_encode($a);
?>

