<?php
include "verifica.php";

		$medico			=filter_input(INPUT_POST,"medico", FILTER_SANITIZE_NUMBER_INT);
		$datainicial	=filter_input(INPUT_POST,"datainicial", FILTER_SANITIZE_STRING);
		$datafinal		=filter_input(INPUT_POST,"datafinal", FILTER_SANITIZE_STRING);
		$motivo			=filter_input(INPUT_POST,"motivo", FILTER_SANITIZE_STRING);
		
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($medico=="")|| ($datainicial=="") || ($datafinal=="")|| ($motivo=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resBloqueioAgenda = $con->prepare("SELECT `tbl_medico_med_num_id_med`, `tbl_usuario_usu_num_id_usu`, `txt_descricao_blage`, `dta_data_blage`, `dth_registro_blage` 
		
		FROM `tbl_bloqueio_agenda_blage` 
		
		WHERE tbl_medico_med_num_id_med = :medico AND dta_data_blage = :datainicial ");

		$resBloqueioAgenda->bindParam(':medico',$medico);
		$resBloqueioAgenda->bindParam(':datainicial',$datainicial);

		$resBloqueioAgenda->execute();
		
		if($resBloqueioAgenda->rowCount() > 0){
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existe um bloqueioa cadastrado com os dados informados!\");</script>";
			echo "<script language='javascript'>history.back()</script>";
			
		}else{			
			
			$dataInicial1 = new DateTime($datainicial);
			$datafinal1 = new DateTime($datafinal);
			
			
			while($dataInicial1 <= $datafinal1){
				$resRegistroBloqueioAgenda = $con->prepare("INSERT INTO `tbl_bloqueio_agenda_blage`(`tbl_medico_med_num_id_med`, `tbl_usuario_usu_num_id_usu`, `txt_descricao_blage`, `dta_data_blage`, `dth_registro_blage`) 
				
				VALUES (:medico,:usuario,:motivo,:datainicial,now());");

				$resRegistroBloqueioAgenda->bindValue(':medico',$medico);
				$resRegistroBloqueioAgenda->bindValue('usuario',$_SESSION['id_usu']);	
				$resRegistroBloqueioAgenda->bindValue(':motivo',$motivo);
				//convertendo data para padrao do mysql
				$dataBloqueio = $dataInicial1->format('Y-m-d');	
				$resRegistroBloqueioAgenda->bindValue(':datainicial',$dataBloqueio);		
				
					try{
						$resRegistroBloqueioAgenda->execute();
					}catch(Exception $e){
						$e->getMessage();
					}
				
				$dataInicial1->modify('+ 1 day');
			}	

		}//FIM DA VERIFICACAO DE CADASTRO JA EXISTENTE
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-bloqueio-agenda.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>"; 

	}//FIM CAMPOS NOME, TELEFONE E DATA DE NASCIMENTO VAZIOS
	
	

}else if($acao == "excluir"){

	$idAgenda		=filter_input(INPUT_GET,"idBloqueioAgenda", FILTER_SANITIZE_NUMBER_INT);

	$resAgenda = $con->prepare("DELETE FROM `tbl_bloqueio_agenda_blage` WHERE num_id_blage = :idagenda");
	$resAgenda->bindValue(':idagenda',$idAgenda);

	try{
		$resAgenda->execute(); 
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-bloqueio-agenda.php'><script type=\"text/javascript\">alert(\"Bloqueio excluido com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-bloqueio-agenda.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
