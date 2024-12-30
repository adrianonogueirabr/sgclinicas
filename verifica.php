<?php 
require_once 'conexao.php';

if(!isset ($_SESSION)){ 
	session_start(); 
} 



if(!isset ($_SESSION['login_usu'])){ 	
	die("Para acessar esta pagina precisa estar logado! <p> <a href='index.php'>Clique para entrar!</p>");
	
} 

require_once 'usuario.class.php';

$u = new usuario();

if(!$usulogged = $u->logged($_SESSION['login_usu'])){

	session_destroy();

	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=index.php'><script type=\"text/javascript\">alert(\"Favor realizar login novamente!\");</script>";	
}

