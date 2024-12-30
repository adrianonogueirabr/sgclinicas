<?php
session_start(); 

if((!isset ($_SESSION['login_usu']) == true) && (!isset ($_SESSION['tipo_usu']) == true)) 
{ 
	unset($_SESSION['login_usu']); 
	unset($_SESSION['tipo_usu']); 
	header('location:index.php'); 
}

$tipo_usu = $_SESSION['tipo_usu'];

switch ($tipo_usu){

	case 'administrador':
	include "usu-administrador.php";
	break;
	
	case 'financeiro':
	include "usu-financeiro.php";
	break;
	
	case 'agendamento':
	include "usu-agendamento.php";
	break;

	case 'recepcionista':
	include "usu-recepcionista.php";
	break;
	
	default:
	include ("index.php");
	break;
	
}
?>