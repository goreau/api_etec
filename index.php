<?php
    require_once './entidades/usuario.php';

    $user = new usuario();
    $rows = $user->consulta();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>..:: SisOO ::..</title>
        <style>
            table{border: 1px solid; width: 100%;}
            th, td{border: 1px solid;padding:3px;}
            
        </style>
    </head>
    <body>
        <table>
            <tr>
                <th>Id Usuario</th>
                <th>Nome</th>
                <th>Login</th>
                <th>Senha</th>
                <th>E-mail</th>               
                <th>Nivel</th>
                <th>Id Mobile</th>               
            </tr>
            <?php 
            foreach ($rows as $linha){
                echo "<tr>";
                    echo "<td>".$linha['id_usuario']."</td>";
                    echo "<td>".$linha['nome']."</td>";
                    echo "<td>".$linha['login']."</td>";
                    echo "<td>".$linha['senha']."</td>";
                    echo "<td>".$linha['email']."</td>";
                    echo "<td>".$linha['nivel']."</td>";
                    echo "<td>".$linha['id_mobile']."</td>";
                echo "<tr>";
            }
            ?>
        </table>
    </body>
</html>