<?php
print "<h2>BANCO POSTGRES</h2>";
$bdcon = pg_connect("dbname=pareador");
//conecta a um banco de dados chamado "pareador"

$con_string = "host=localhost port=5432 dbname=pareador user=postgres password=postgres";
if(!$dbcon = pg_connect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));
//coneta a um banco de dados chamado "cliente" na máquina "localhost" com um usuário e senha

//$insert = pg_query($dbcon, "INSERT INTO eventos (nome,atividade, local, data_evento) VALUES ('Peras','Truco', st_makepoint(-50.337571,-27.805085), '2018-03-25')");
print "<h2>CONSULTA SQL</h2>";
$result = pg_query($dbcon, "SELECT * FROM eventos");

if (!$result) {
  echo "Erro na consulta.<br>";
  exit;
}

while ($row = pg_fetch_row($result)) {
  echo "Nome $row[0]  Atividade: $row[1] Local: $row[2]";
  echo "<br />\n";
}
?>