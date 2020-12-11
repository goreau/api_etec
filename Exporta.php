<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'database.php';
require_once './modelos/produto.php';
require_once './modelos/cliente.php';
require_once './modelos/venda.php';
require_once './modelos/det_venda.php';

$json = filter_input(INPUT_POST, "dados");
//$json = filter_input(INPUT_GET, "dados");
//echo $json;
$linha = json_decode($json, true);

$tipo = $linha['tipo'];
$dados = json_decode(json_encode($linha['col']), FALSE);
//$tipo = 'cliente';
//$dados =  '{"tipo":"cliente","col":[{"nascimento":"10-11-2020","nome":"Dududu de Dadada","_id":"1"}]}';
if (get_magic_quotes_gpc()) {
    $json = stripslashes($json);
}

$a = array();
$b = array();
//Loop through an Array and insert data read from JSON into DB
switch ($tipo) {
    case "produto":
        $tab = new produto(0);
        foreach ($dados as $row){          
            $tab->__set('nome',$row->nome);
            $tab->__set('tipo',$row->tipo);
            $tab->__set('preco',$row->preco);
            
            $res = $tab->insere();
            //cria a resposta, segundo resultado da inserção
            if ($res>0) {
                $b["id"] = $row->_id;
                $b["status"] = '1';
                array_push($a, $b);
            } else {
                $b["id"] = $row->_id;
                $b["status"] = '0';
                array_push($a, $b);
            }
        }
        break;
    case "cliente":
        $tab = new cliente(0);
        foreach ($dados as $row){
            $tab->__set('nome',$row->nome);
            $tab->__set('dt_nascimento',$row->nascimento);

            $res = $tab->insere();
            //cria a resposta, segundo resultado da inserção
            if ($res>0) {
                $b["id"] = $row->_id;
                $b["status"] = '1';
                array_push($a, $b);
           } else {
                $b["id"] = $row->_id;
                $b["status"] = '0';
                array_push($a, $b);
           }
        }
        break;
    case "venda":
        foreach ($dados as $row){
            $tab = new venda(0);
               // echo $linha[$i]['nome'];
               $tab->__set('id_cliente',$row->id_cliente);
               $tab->__set('data_venda',$row->data_venda);
               
               $res = $tab->insere();
               //cria a resposta, segundo resultado da inserção
               if ($res>0) {
                    if (insereDetVenda($row)){
                        $b["id"] = $row->id_cliente;
                        $b["status"] = '1';
                        array_push($a, $b);
                    } else {
                        $b["id"] = $row->id_cliente;
                        $b["status"] = '0';
                        array_push($a, $b);
                    } 
               } else {
                   $b["id"] = $row->id_cliente;
                   $b["status"] = '0';
                   array_push($a, $b);
               }
            }
            break;
    default :
        echo "ferrou $tipo";
        break;
}

function insereDetVenda($linha){
    
    if ($linha->detalhes=="[]"){
        return true;
    }
    $dados = json_decode($linha->detalhes, FALSE);

    $idv  = $linha->_id;
    $res  = true;
    $tab = new det_venda(0, $idv);
    foreach ($dados as $row){
        $tab->__set('id_produto',$row->id_produto);
        $tab->__set('quantidade',$row->quantidade);
        $tab->__set('subtotal',$row->subtotal);

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

