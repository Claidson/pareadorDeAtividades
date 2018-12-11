<?php

	$nome = $_POST['nome'];
    $atividade = $_POST['atividade'];
    $local = $_POST['local'];
    $data_evento = $_POST['data_evento'];
    $coordenada = "-50.337571,-27.805085";
    //Criar a conexao
    $where =  $atividade;
    $bdcon = pg_connect("dbname=pareador");
//conecta a um banco de dados chamado "pareador"

    $con_string = "host=localhost port=5432 dbname=pareador user=postgres password=postgres";
    if(!$dbcon = pg_connect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));
    $query = "INSERT INTO eventos (nome,atividade, local, data_evento) VALUES ('$nome','$atividade', st_makepoint($local), '$data_evento')";
    $insert = pg_query($dbcon, $query);
    
//voltar
  //  $var = "<script>javascript:history.back(-2)</script>";
 //    echo $var;


header('Location: resultado.php?atividade='.$where); 
?>


