<?php

if (file_exists('init.php'))
{
	require_once 'init.php';
}
else
{
	exit('Não foi possível encontrar o arquivo de inicialização');
}


$acao = isset($_GET['acao']) ? $_GET['acao'] : FALSE;

header('Content-Type: application/xml');

$xml = "<?xml version='1.0' encoding='iso-8859-1'?>\r\n";


switch ($acao)
{
	case 'buscaEstados':
	    buscaEstados();
	    break;
	case 'buscaCidades':
	    buscaCidades();
	    break;
}


function buscaEstados()
{
	global $xml;
	
	$xml .= '<estados>';
	
	$MySQLi = new MySQLi(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_NOME);
	
	$sql = $MySQLi->query('Select * From estados Order By nome ASC');
	
	while ($f = $sql->fetch_object())
	{
		$xml .= '  <estado>';
		$xml .= '    <id>' . $f->id . '</id>';
		$xml .= '    <sigla>' . $f->sigla . '</sigla>';
		$xml .= '    <nome>' . $f->nome . '</nome>';
		$xml .= '  </estado>';
	}
	
	$sql->close();
	$MySQLi->close();
	
	$xml .= '</estados>';
	echo $xml;
}



function buscaCidades()
{
	$uf = isset($_GET['uf']) ? (int)$_GET['uf'] : 1;
	
	global $xml;
	
	$xml .= '<cidades>';
	
	$MySQLi = new MySQLi(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_NOME);
	
	$sql = $MySQLi->query('Select id, nome From cidades Where id_uf = ' . $uf . ' Order By nome ASC');
	
	while ($f = $sql->fetch_object())
	{
		$xml .= '  <cidade>';
		$xml .= '    <id>' . $f->id . '</id>';
		$xml .= '    <nome>' . $f->nome . '</nome>';
		$xml .= '  </cidade>';
	}
	
	$sql->close();
	$MySQLi->close();
	
	$xml .= '</cidades>';
	echo $xml;
}


?>