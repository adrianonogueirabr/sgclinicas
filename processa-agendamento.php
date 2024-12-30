<?php
include "verifica.php";

/*
FILTER_SANITIZE_STRING
FILTER_SANITIZE_NUMBER_INT
FILTER_SANITIZE_NUMBER_float	
FILTER_SANITIZE_STRING

*/	
	
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "excluiritem"){

	$codigoAgendamento = base64_decode($_GET['c']);//recebe codigo de agendamento
	$codigoItem = base64_decode($_GET['i']);//recebe codigo de item

	$resAgenda = $con->prepare("DELETE FROM tbl_item_agendamento_itage WHERE num_id_itage = ?");
	$resAgenda->bindParam(1,$codigoItem);	

	if ($resAgenda->execute()) {
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=agendamento-dados.php?acao=excluiritem&codigoagendamento=$codigoAgendamento'><script type=\"text/javascript\">alert(\"Item excluido com sucesso!\");</script>";
 	}else {
		echo "Error: " . $resAgenda . "<br>" . mysqli_error();
  	}	
	
}else if($acao == "excluiritemdetalhes"){

	$codigoAgendamento = base64_decode($_GET['c']);//recebe codigo de agendamento
	$codigoItem = base64_decode($_GET['i']);//recebe codigo de item

	//registra fazendo alteracoes
		$sqlUsuarioAlteracao = $con->prepare("UPDATE `tbl_agendamento_age` SET `num_usuario_alteracao_age`=?,`dth_alteracao_age`=now() WHERE `num_id_age`=?");
		$sqlUsuarioAlteracao->bindParam(1,$_SESSION['id_usu']);
		$sqlUsuarioAlteracao->bindParam(2,$codigoAgendamento);

		if(!$sqlUsuarioAlteracao->execute()){
			echo "Error: " . $sqlUsuarioAlteracao . "<br>" . mysqli_error();
		}

		$resAgenda = $con->prepare("DELETE FROM tbl_item_agendamento_itage WHERE num_id_itage = ?");
		$resAgenda->bindParam(1,$codigoItem);	

		if ($resAgenda->execute()) {
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=agendamento-detalhes.php?acao=excluiritem&codigoagendamento=$codigoAgendamento'><script type=\"text/javascript\">alert(\"Item excluido com sucesso!\");</script>";
		}else {
			echo "Error: " . $resAgenda . "<br>" . mysqli_error();
		}	
	
}else if($acao == "cancelar"){

	$codigoAgendamento = base64_decode($_GET['c']);//recebe codigo de agendamento

	try{

		$con->beginTransaction();

		$sqlExcuirItemAgendamento = $con->prepare("DELETE FROM `tbl_item_agendamento_itage` WHERE `tbl_agendamento_age_num_id_age`= ?");
		$sqlExcuirItemAgendamento->bindParam(1,$codigoAgendamento);

		if(!$sqlExcuirItemAgendamento->execute()){
			$con->rollBack();
			echo "Error: " . $sqlExcuirItemAgendamento . "<br>" . mysqli_error();
		}

		$sqlExcluirAgendamento = $con->prepare("DELETE FROM `tbl_agendamento_age` WHERE `num_id_age`=?");
		$sqlExcluirAgendamento->bindParam(1,$codigoAgendamento);

		if(!$sqlExcluirAgendamento->execute()){
			$con->rollBack();
			echo "Error: " . $sqlExcluirAgendamento . "<br>" . mysqli_error();
		}

		$con->commit();
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-pacientes.php'><script type=\"text/javascript\">alert(\"Agendamento cancelado com sucesso!\");</script>";


	}catch (PDOException $err){
		echo "Erro: ".$err->getMessage();
	}

				
}else if($acao == "dadosgerais"){

	 $codigoAgendamento = base64_decode($_GET['c']);//recebe codigo de agendamento
	 $numerosolicitacao =filter_input(INPUT_POST,"numerosolicitacao", FILTER_SANITIZE_STRING);
	 $observacoes	   =filter_input(INPUT_POST,"observacoes", FILTER_SANITIZE_STRING);

	try{

		$con->beginTransaction();

		$sqlDadosGeraisAgendamento = $con->prepare("UPDATE `tbl_agendamento_age` SET `txt_solicitacao_age`=?,`txt_observacao_age`=? WHERE `num_id_age`=?");
		$sqlDadosGeraisAgendamento->bindParam(1,$numerosolicitacao);
		$sqlDadosGeraisAgendamento->bindParam(2,$observacoes);
		$sqlDadosGeraisAgendamento->bindParam(3,$codigoAgendamento);

		if(!$sqlDadosGeraisAgendamento->execute()){
			$con->rollBack();
			echo "Error: " . $sqlDadosGeraisAgendamento . "<br>" . mysqli_error();
		}

		$con->commit();
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-pacientes.php'><script type=\"text/javascript\">alert(\"Agendamento realizado com sucesso!\");</script>";

	}catch (PDOException $err){
		echo "Erro: ".$err->getMessage();
	}

				
}else if($acao == "dadosgeraisupdate"){

	$codigoAgendamento = base64_decode($_GET['c']);//recebe codigo de agendamento
	$numerosolicitacao =filter_input(INPUT_POST,"numerosolicitacao", FILTER_SANITIZE_STRING);
	$observacoes	   =filter_input(INPUT_POST,"observacoes", FILTER_SANITIZE_STRING);

   try{

	   $con->beginTransaction();

	   $sqlDadosGeraisAgendamento = $con->prepare("UPDATE `tbl_agendamento_age` SET `txt_solicitacao_age`=?,`txt_observacao_age`=? WHERE `num_id_age`=?");
	   $sqlDadosGeraisAgendamento->bindParam(1,$numerosolicitacao);
	   $sqlDadosGeraisAgendamento->bindParam(2,$observacoes);
	   $sqlDadosGeraisAgendamento->bindParam(3,$codigoAgendamento);

	   if(!$sqlDadosGeraisAgendamento->execute()){
		   $con->rollBack();
		   echo "Error: " . $sqlDadosGeraisAgendamento . "<br>" . mysqli_error();
	   }

	   $con->commit();
	   $codigo = base64_encode($codigoAgendamento);
	   echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=agendamento-detalhes.php?acao=detalhes&agendamento=$codigo'><script type=\"text/javascript\">alert(\"Dados atualizados com sucesso!\");</script>";

   }catch (PDOException $err){
	   echo "Erro: ".$err->getMessage();
   }

			   
}else if($acao == "confirmar"){

	$codigoAgendamento = base64_decode($_GET['c']);//recebe codigo de agendamento
	$medicoAgenda = $_GET['m'];	
    $dataAgenda = $_GET['d'];
    $nomeMedico = $_GET['nm'];

   try{

	   $con->beginTransaction();

	   $sqlConfirmarAgendamento = $con->prepare("UPDATE `tbl_agendamento_age` SET `txt_status_age`='confirmado', num_usuario_confirmacao_age = ?, dth_confirmacao_age = now() WHERE `num_id_age`=?");
	   $sqlConfirmarAgendamento->bindParam(1,$_SESSION['id_usu']);
	   $sqlConfirmarAgendamento->bindParam(2,$codigoAgendamento);
	   

	   if(!$sqlConfirmarAgendamento->execute()){
		   $con->rollBack();
		   echo "Error: " . $sqlConfirmarAgendamento . "<br>" . mysqli_error(); 
	   }

	   $con->commit();
	   echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=agendamentos-painel.php?&m=$medicoAgenda&d=$dataAgenda&nm=$nomeMedico'><script type=\"text/javascript\">alert(\"Agendamento confirmado com sucesso!\");</script>";

   }catch (PDOException $err){
	   echo "Erro: ".$err->getMessage();
   }

			   
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-agenda.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
