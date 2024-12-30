<?php
include "verifica.php";

		$medico			=filter_input(INPUT_POST,"medico", FILTER_SANITIZE_NUMBER_INT);
		$diasemana		=filter_input(INPUT_POST,"diasemana", FILTER_SANITIZE_STRING);
		$horainicio		=filter_input(INPUT_POST,"horainicio", FILTER_SANITIZE_STRING);
		$horafinal		=filter_input(INPUT_POST,"horafinal", FILTER_SANITIZE_STRING);
		$quantidade		=filter_input(INPUT_POST,"quantidade", FILTER_SANITIZE_NUMBER_INT);
		$observacao		=filter_input(INPUT_POST,"observacao", FILTER_SANITIZE_STRING);
		
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($medico=="")|| ($diasemana=="") || ($quantidade=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resAgenda = $con->prepare("SELECT * FROM tbl_agenda_agen WHERE tbl_medico_med_num_id_med = ? AND txt_dia_semana_agen = ? AND hor_inicio_agen = ? AND hor_final_agen = ? AND num_quantidade_agen = ?");
		$resAgenda->bindParam(1,$medico);
		$resAgenda->bindParam(2,$diasemana);
		$resAgenda->bindParam(3,$horainicio);
		$resAgenda->bindParam(4,$horafinal);
		$resAgenda->bindParam(5,$quantidade);

		$resAgenda->execute();
		
		if($resAgenda->rowCount() > 0){
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existe uma agenda cadastrada com os dados informados!\");</script>";
			echo "<script language='javascript'>history.back()</script>";
			
		}else{	

				$resRegistroAgenda = $con->prepare("INSERT INTO `tbl_agenda_agen`(`tbl_usuario_usu_num_id_usu`, `tbl_medico_med_num_id_med`, `txt_dia_semana_agen`, `hor_inicio_agen`, `hor_final_agen`, 
				
				`num_quantidade_agen`, `num_duracao_atendimento_agen`, `dth_registro_agen`, `num_usuario_desativacao_agen`, `dth_desativacao_agen`, `txt_observacao_agen`, `txt_status_agen`)
				
				VALUES (?,?,?,?,?,?,?,now(), 0, NULL,?,'ativo');");

				//capturando tempo do procedimento
				$final = Datetime::createFromFormat('H:i',$horafinal);
				$inicio = Datetime::createFromFormat('H:i',$horainicio);

				$total_horas = $inicio->diff($final);

				$total_minutos = ($total_horas->format('%H') * 60) + $total_horas->format('%I');

				$tempo_atendimento = $total_minutos / $quantidade;
				//fim captura tempo do procedimento
				
				$resRegistroAgenda->bindParam(1,$_SESSION['id_usu']);				
				$resRegistroAgenda->bindParam(2,$medico);
				$resRegistroAgenda->bindParam(3,$diasemana);
				$resRegistroAgenda->bindParam(4,$horainicio);
				$resRegistroAgenda->bindParam(5,$horafinal);
				$resRegistroAgenda->bindParam(6,$quantidade);
				$resRegistroAgenda->bindParam(7,$tempo_atendimento);
				$resRegistroAgenda->bindParam(8,$observacao);

					if (!$resRegistroAgenda->execute()) {
						echo "Error: " . $resRegistroAgenda . "<br>" . mysqli_error($con);
					}else{
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-agenda.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>";
					}

		}//FIM DA VERIFICACAO DE CADASTRO JA EXISTENTE 

	}//FIM CAMPOS NOME, TELEFONE E DATA DE NASCIMENTO VAZIOS

}else if($acao == "bloquear"){

	$idAgenda		=filter_input(INPUT_GET,"idAgenda", FILTER_SANITIZE_NUMBER_INT);

	$resAgenda = $con->prepare("UPDATE tbl_agenda_agen SET txt_status_agen = 'bloqueado', num_usuario_desativacao_agen = :usuario, dth_desativacao_agen = now()  WHERE num_id_agen = :idagenda");
	$resAgenda->bindParam(':idagenda',$idAgenda);
	$resAgenda->bindParam(':usuario',$_SESSION['id_usu']);

	try{
		$resAgenda->execute(); 
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-agenda.php'><script type=\"text/javascript\">alert(\"Agenda bloqueada com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else if($acao == "reativar"){

	$idAgenda		=filter_input(INPUT_GET,"idAgenda", FILTER_SANITIZE_NUMBER_INT);

	$resAgenda = $con->prepare("UPDATE tbl_agenda_agen SET txt_status_agen = 'ativo', num_usuario_desativacao_agen = 0, dth_desativacao_agen = ''  WHERE num_id_agen = :idagenda");
	$resAgenda->bindParam(':idagenda',$idAgenda);

	try{
		$resAgenda->execute(); 
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-agenda.php'><script type=\"text/javascript\">alert(\"Agenda Reativada com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-agenda.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
