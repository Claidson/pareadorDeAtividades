<?php

/*
 * Script adaptado a partir deste:
 * http://forum.imasters.uol.com.br/index.php?showtopic=202215
*/

//evita acesso direto ao init.php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__))
    exit('Este arquivo não pode ser acessado diretamente.');

    
if (!(version_compare(phpversion(), "5.0", ">=")))
   exit("O sistema requer PHP versão 5.0 ou superior.");
    

$prefix = (PHP_SHLIB_SUFFIX == 'dll') ? 'php_' : '';

if (!extension_loaded('mysqli'))
{
     if (function_exists('dl'))
	 {
         if (!dl($prefix . 'mysqli.' . PHP_SHLIB_SUFFIX))
             exit("Não foi possível carregar a extensão MySQLi.");
         
    }
}


if (!(defined('BARRA')))
	    define('BARRA', DIRECTORY_SEPARATOR);   


if(function_exists('ini_set'))
{
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', '1');
}

@set_magic_quotes_runtime(FALSE);


$constantes = array(
                    //dados para conexão ao servidor MySQL
					"BD_SERVIDOR" => "localhost",
					"BD_USUARIO" => "user",
					"BD_SENHA" => "pass",
					"BD_NOME" => "bd"
					);
   
$nome_const = array_keys($constantes);
$valor_const = array_values($constantes);
 
for($i = 0; $i < count($nome_const); $i++)
{
    if (!(defined($nome_const[$i])))
        define($nome_const[$i], $valor_const[$i]);
}

?>