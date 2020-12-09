<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'database.php';
require_once './entidades/usuario.php';
require_once './entidades/cliente.php';

$json = filter_input(INPUT_GET, "dados");
$tipo = filter_input(INPUT_GET, "tipo");
//$nome = filter_input(INPUT_POST, "nome");
//$tipo = "usuario";
//$json =  '[{"nome":"Jose da Silva", "login":"silva", "senha":"silva", "nivel":"1", "id_mobile":"1"}, {"nome":"Pedro Moreira", "login":"moreira", "senha":"moreira", "nivel":"2","id_mobile":"2"}]';
if (get_magic_quotes_gpc()) {
    $json = stripslashes($json);
}
//Decode JSON into an Array
$linha = json_decode($json);
//var_dump($json);
//var_dump($linha);
//print_r($linha);
//arrays de retorno
$a = array();
$b = array();
//Loop through an Array and insert data read from JSON into DB
switch ($tipo) {
    case "usuario":
        for ($i = 0; $i < count($linha); $i++) {
           // echo $linha[$i]['nome'];
            $tab = new usuario(0);
            $tab->setNome($linha[$i]->nome);
            $tab->setLogin($linha[$i]->login);
            $tab->setSenha($linha[$i]->senha);
            $tab->setNivel($linha[$i]->nivel);
            $tab->setEmail($linha[$i]->email);
            $tab->setId_mobile($linha[$i]->id_usuario);
            
            $res = $tab->insere();
            //cria a resposta, segundo resultado da inserção
            if ($res>0) {
                $b["id"] = $linha[$i]->id_usuario;
                $b["status"] = '1';
                array_push($a, $b);
            } else {
                $b["id"] = $linha[$i]->id_usuario;
                $b["status"] = '0';
                array_push($a, $b);
            }
        }
        break;
    case "cliente":
        for ($i = 0; $i < count($linha); $i++) {
           // echo $linha[$i]['nome'];
            $tab = new cliente(0);
            $tab->setNome($linha[$i]->nome);
            $tab->setEmail($linha[$i]->email);
            $tab->setEndereco($linha[$i]->endereco);
            $tab->setDt_nascimento($linha[$i]->dt_nascimento);
            $tab->setTelefone($linha[$i]->telefone);
            $tab->setId_mobile($linha[$i]->id_cliente);
            
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
    default :
        echo "ferrou";
        break;
}

//Post JSON response back to Android Application
echo json_encode($a);
?>

