<?php

#############################################
#                                           #
# Autor: Roberto Beraldo Chaiben (Beraldo)  #
#    E-Mail: rbchaiben@yahoo.com.br         #
#                                           #
#############################################



if (file_exists('init.php'))
{
	require_once 'init.php';
}
else
{
	exit('Não foi possível encontrar o arquivo de inicialização');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="funcoes.js"></script>
<title>Cidades | Estados</title>
</head>
<body onload="buscaEstados()">

<form method="post" action="">
  <p>
    <select name="uf" id="uf" onchange="buscaCidades(this.value)">
    </select>
  </p>
  <p>
    <select name="cidade" id="cidade">
      <option value="">Primeiramente, selecione o estado</option>
    </select>
  </p>
</form>

</body>
</html>