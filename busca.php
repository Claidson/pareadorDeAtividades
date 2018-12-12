<?php
    $coordenada = $_POST['cordenada'];
    $atividade = $_POST['atividade'];
    //Criar a conexao
    $bdcon = pg_connect("dbname=pareador");
//conecta a um banco de dados chamado "pareador"
    $con_string = "host=localhost port=5432 dbname=pareador user=postgres password=postgres";
    if(!$dbcon = pg_connect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));
    $query = "SELECT * from eventos WHERE ST_Distance(ST_Transform(eventos.local,900913),ST_Transform(ST_SetSRID(ST_GeometryFromText('POINT('$cordenada')'),4326),900913)) < 5000 AND eventos.atividade = '$atividade'";       
    $result = pg_query($dbcon, $query);

header('Location: resultado.php?busca='.$result); 
?>
