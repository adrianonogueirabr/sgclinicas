<?php
include "verifica.php";

/*
FILTER_SANITIZE_STRING
FILTER_SANITIZE_NUMBER_INT
FILTER_SANITIZE_NUMBER_float	
FILTER_SANITIZE_STRING

*/

		$especialidade	=filter_input(INPUT_POST,"especialidade", FILTER_SANITIZE_NUMBER_INT);
		$registro		=filter_input(INPUT_POST,"registro", FILTER_SANITIZE_STRING);
		$nome			=filter_input(INPUT_POST,"nome", FILTER_SANITIZE_STRING);
		$cpf			=filter_input(INPUT_POST,"cpf", FILTER_SANITIZE_STRING);
		$telefone		=filter_input(INPUT_POST,"telefone", FILTER_SANITIZE_STRING);
		$idsistema		=filter_input(INPUT_POST,"idsistema", FILTER_SANITIZE_NUMBER_INT);
		$sexo			=filter_input(INPUT_POST,"sexo", FILTER_SANITIZE_STRING);
		$observacao		=filter_input(INPUT_POST,"observacao", FILTER_SANITIZE_STRING);
		$exameparticular			=filter_input(INPUT_POST,"exameparticular", FILTER_SANITIZE_NUMBER_INT);
	    $consultaparticular		=filter_input(INPUT_POST,"consultaparticular", FILTER_SANITIZE_NUMBER_INT);
		$exameconvenio		=filter_input(INPUT_POST,"exameconvenio", FILTER_SANITIZE_NUMBER_INT);
		$consultaconvenio		=filter_input(INPUT_POST,"consultaconvenio", FILTER_SANITIZE_NUMBER_INT);
		
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($especialidade=="")|| ($nome=="") || ($cpf=="") || ($registro=="") || ($telefone=="") || ($idsistema=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resMedico = $con->prepare("SELECT * FROM tbl_medico_med WHERE tbl_especialidade_esp_num_id_esp = ? AND txt_registro_med = ? AND txt_nome_med = ? AND txt_cpf_med = ?");
		$resMedico->bindParam(1,$especialidade);
		$resMedico->bindParam(2,$registro);
		$resMedico->bindParam(3,$nome);
		$resMedico->bindParam(4,$cpf);

		$resMedico->execute();
		
		if($resMedico->rowCount() > 0){
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existe um medico cadastrado com os dados informados!\");</script>";
			echo "<script language='javascript'>history.back()</script>";
			
		}else{
				
			$resIdSistema = $con->prepare("SELECT * FROM tbl_medico_med WHERE num_idsistema_med = ?");
			$resIdSistema->bindParam(1,$idsistema);

			$resIdSistema->execute();
			
			if($resIdSistema->rowCount() > 0){
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"ID de sistema ja atribuido a outro medico!\");</script>";
				echo "<script language='javascript'>history.back()</script>";
				
			}else{	

					$resRegistroMedico = $con->prepare("INSERT INTO `tbl_medico_med`( `tbl_especialidade_esp_num_id_esp`, `tbl_usuario_usu_num_id_usu`, `txt_registro_med`, `txt_nome_med`, `txt_cpf_med`, 
					
					`txt_telefone_med`, `txt_sexo_med`, `txt_observacao_med`, `dth_registro_med`, `num_repasse_exame_particular_med`, `num_repasse_consulta_particular_med`, `num_repasse_exame_convenio_med`, 
					
					`num_repasse_consulta_convenio_med`, `num_idsistema_med`, `txt_ativo_med`) 
					
					VALUES (?,?,?,?,?,?,?,?,now(),?,?,?,?,?,'SIM')");
												
					$resRegistroMedico->bindParam(1,$especialidade);	
					$resRegistroMedico->bindParam(2,$_SESSION['id_usu']);
					$resRegistroMedico->bindParam(3,$registro);
					$resRegistroMedico->bindParam(4,$nome);	
					$resRegistroMedico->bindParam(5,$cpf);
					$resRegistroMedico->bindParam(6,$telefone);
					$resRegistroMedico->bindParam(7,$sexo);	
					$resRegistroMedico->bindParam(8,$observacao);
					$resRegistroMedico->bindParam(9,$exameparticular);
					$resRegistroMedico->bindParam(10,$consultaparticular);
					$resRegistroMedico->bindParam(11,$exameconvenio);
					$resRegistroMedico->bindParam(12,$consultaconvenio);
					$resRegistroMedico->bindParam(13,$idsistema);

						if (!$resRegistroMedico->execute()) {
							echo "Error: " . $resRegistroMedico . "<br>" . mysqli_error($con);
						}else{
							echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-medico.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>";
						}

			}//FIM VERIFICACAO ID DE SISTEMA JA ATRIBUIDO

		}//FIM DA VERIFICACAO DE CADASTRO JA EXISTENTE 

	}//FIM CAMPOS NOME, TELEFONE E DATA DE NASCIMENTO VAZIOS

}else if($acao == "salvar"){

	if(($especialidade=="")|| ($nome=="") || ($cpf=="") || ($registro=="") || ($telefone=="") || ($idsistema=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{

				$ativo		=filter_input(INPUT_POST,"ativo", FILTER_SANITIZE_STRING);
				$idMedico =filter_input(INPUT_POST,"idmedico", FILTER_SANITIZE_NUMBER_INT);	
				//echo $observacao		=filter_input(INPUT_POST,"observacao", FILTER_SANITIZE_STRING);			

				$resMedico = $con->prepare("UPDATE tbl_medico_med SET tbl_especialidade_esp_num_id_esp=?,txt_registro_med=?,txt_nome_med=?,txt_cpf_med=?,txt_telefone_med=?,
				
				txt_sexo_med=?,txt_observacao_med=?, num_repasse_exame_particular_med=?,num_repasse_consulta_particular_med=?,num_repasse_exame_convenio_med=?,num_repasse_consulta_convenio_med=?,
				
				num_idsistema_med=?, txt_ativo_med=? WHERE num_id_med=?");

					$resMedico->bindParam(1,$especialidade);
					$resMedico->bindParam(2,$registro);
					$resMedico->bindParam(3,$nome);
					$resMedico->bindParam(4,$cpf);
					$resMedico->bindParam(5,$telefone);
					$resMedico->bindParam(6,$sexo);
					$resMedico->bindParam(7,$observacao);
					$resMedico->bindParam(8,$exameparticular);
					$resMedico->bindParam(9,$consultaparticular);
					$resMedico->bindParam(10,$exameconvenio);
					$resMedico->bindParam(11,$consultaconvenio);
					$resMedico->bindParam(12,$idsistema);
					$resMedico->bindParam(13,$ativo);
					$resMedico->bindParam(14,$idMedico);

					if ($resMedico->execute()) {
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-medico.php'><script type=\"text/javascript\">alert(\"Registro atualizado com sucesso!\");</script>";						
					} else {
						echo "Error: " . $resMedico . "<br>" . mysqli_error();
					}	
	}
				
	
}else if($acao == "ativar"){

	$idMedico		=filter_input(INPUT_GET,"idMedico", FILTER_SANITIZE_NUMBER_INT);

	$resMedico = $con->prepare("UPDATE tbl_medico_med SET txt_ativo_med = 'SIM'  WHERE num_id_med = ?");
	$resMedico->bindParam(1,$idMedico);

	if ($resMedico->execute()) {
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-medico.php'><script type=\"text/javascript\">alert(\"Medico ativado com sucesso!\");</script>";
 	}else {
		echo "Error: " . $resMedico . "<br>" . mysqli_error();
  	}	
	
}else if($acao == "inativar"){

	$idMedico		=filter_input(INPUT_GET,"idMedico", FILTER_SANITIZE_NUMBER_INT);

	$resMedico = $con->prepare("UPDATE tbl_medico_med SET txt_ativo_med = 'NAO'  WHERE num_id_med = ?");
	$resMedico->bindParam(1,$idMedico);

	if ($resMedico->execute()) {
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-medico.php'><script type=\"text/javascript\">alert(\"Medico inativado com sucesso!\");</script>";
 	}else {
		echo "Error: " . $resMedico . "<br>" . mysqli_error();
  	}	
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-medico.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
