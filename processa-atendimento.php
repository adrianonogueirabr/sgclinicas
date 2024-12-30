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
$procedimento = filter_input(INPUT_POST,"procedimento",FILTER_SANITIZE_NUMBER_INT);
$categoria = filter_input(INPUT_POST,"categoria",FILTER_SANITIZE_NUMBER_INT);
$codigoPaciente = filter_input(INPUT_POST,"codigoPaciente",FILTER_SANITIZE_NUMBER_INT);
$medico = filter_input(INPUT_POST,"medico",FILTER_SANITIZE_NUMBER_INT);
$guia = filter_input(INPUT_POST,"guia",FILTER_SANITIZE_STRING);
$autorizado = filter_input(INPUT_POST,"autorizado",FILTER_SANITIZE_STRING);
$dataautorizacao = filter_input(INPUT_POST,"dataautorizacao",FILTER_SANITIZE_STRING);
$valorpago = filter_input(INPUT_POST,"valorpago",FILTER_SANITIZE_NUMBER_FLOAT);
$observacao = filter_input(INPUT_POST,"observacao",FILTER_SANITIZE_STRING);
$tipoprioridade = filter_input(INPUT_POST,"tipoprioridade",FILTER_SANITIZE_STRING);
$tipodesconto = filter_input(INPUT_POST,"tipodesconto",FILTER_SANITIZE_STRING);
$idpagamento = filter_input(INPUT_POST,"idpagamento",FILTER_SANITIZE_NUMBER_INT);


if($acao == "novoag"){

	//funcao capturar valor do procedimento na categoria selecionada
		function capturaValor ($procedimento , $categoria){

			include "conexao.php";

			$sqlConsultarValor = $con->prepare("SELECT val_valor_cat_pro FROM tbl_cat_pro WHERE tbl_procedimentos_pro_num_id_pro  = ? and tbl_categoria_cat_num_id_cat = ? and txt_ativo_cat_pro = 'sim'");
			$sqlConsultarValor->bindParam(1,$procedimento);
			$sqlConsultarValor->bindParam(2,$categoria);

			if(!$sqlConsultarValor->execute()){
				echo "Error: " . $sqlConsultarValor . "<br>" . mysqli_error();
			}else{
				$valorProcedimentoCategoria = $sqlConsultarValor->fetchColumn();
				if($valorProcedimentoCategoria == ""){
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Nao existe valor para o Procedimento X Categoria cadastrado, favor verificar!\");</script>";
					echo "<script language='javascript'>history.back()</script>";
				}else{
					return $valorProcedimentoCategoria;
				}
			}
		}		
	//fim funcao capturar valor do procedimento na categoria selecionada

	//funcao para calcular valor do medico e da clinica
		function calcularValorMedico($valorPercentualMedico, $valorProcedimento){
			$valorMedico = ($valorPercentualMedico * $valorProcedimento)/100;
			return $valorMedico;
		}
	//fim funcao para calcular valor do medico e da clinica

	//verificar qual categoria e procedimento
		//consulta particular
			if($categoria==1 && $procedimento==1){
				$valorProcedimento = capturaValor($procedimento, $categoria);

				//verificar se particular com desconto
					if($tipodesconto > 0){
						$sqlConsultaDesconto = $con->prepare("SELECT val_percentual_td FROM tbl_tipo_desconto_td WHERE num_id_td = ?");
						$sqlConsultaDesconto->bindParam(1, $tipodesconto);
						$sqlConsultaDesconto->execute();
						$percentualDesconto = $sqlConsultaDesconto->fetchColumn();					
						$valorDesconto = (($percentualDesconto * $valorProcedimento)/100);
						$valorProcedimento = $valorProcedimento - $valorDesconto;
					}
				//fim verificar se particular com desconto

				//verificar percentual de repasse (percentual * valor) /100
					$sqlConsultaPercentual = $con->prepare("SELECT `num_repasse_consulta_particular_med` FROM `tbl_medico_med` WHERE num_id_med = ?");
					$sqlConsultaPercentual->bindParam(1, $medico);
					$sqlConsultaPercentual->execute();
					$valorPercentualMedico = $sqlConsultaPercentual->fetchColumn();
				//fim verificar percentual de repasse (percentual * valor) /100

				//informar valor do medico subtraindo valor da clinica
					$valorHonorarioMedico = calcularValorMedico($valorPercentualMedico, $valorProcedimento);
					$valorClinica = $valorProcedimento - $valorHonorarioMedico;
				//fim informar valor do medico subtraindo valor da clinica

				//verifica valor pago pelo paciente
					if($valorpago != $valorProcedimento){
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Valor pago pelo paciente R$$valorpago, diferente ao indicado na tabela R$$valorProcedimento!\");</script>";
						echo "<script language='javascript'>history.back()</script>";
					}
				//fim verifica valor pago pelo paciente

				//verifica campo id de pagamento
					if($idpagamento == ""){
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Para procedimento particular, necessario informar o ID de pagamento!\");</script>";
						echo "<script language='javascript'>history.back()</script>";
					}else{
						//verificar se pagamento existe
							$sqlVerificaPagamento = $con->prepare("SELECT * FROM tbl_recebimento_rec WHERE num_id_rec = ?");
							$sqlVerificaPagamento->bindParam(1, $idpagamento);
							$sqlVerificaPagamento->execute();
							if($sqlVerificaPagamento->rowCount()<=0){
								echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"ID de Pagamento nao encontrado, favor informar novamente!\");</script>";
								echo "<script language='javascript'>history.back()</script>";
							}
						//fim verificar se pagamento existe

						//retirar valor do saldo do paciente
						//fim retirar valor do saldo do paciente
					}
				//fim verificar campo id de pagamento
		//fim consulta particular
		//exame particular
			}else if($categoria==1 && $procedimento > 1){
				$valorProcedimento = capturaValor($procedimento, $categoria);
				
				//verificar se particular com desconto
					if($tipodesconto > 0){
						$sqlConsultaDesconto = $con->prepare("SELECT val_percentual_td FROM tbl_tipo_desconto_td WHERE num_id_td = ?");
						$sqlConsultaDesconto->bindParam(1, $tipodesconto);
						$sqlConsultaDesconto->execute();
						$percentualDesconto = $sqlConsultaDesconto->fetchColumn();					
						$valorDesconto = (($percentualDesconto * $valorProcedimento)/100);
						$valorProcedimento = $valorProcedimento - $valorDesconto;
					}
				//fim verificar se particular com desconto

				//verificar percentual de repasse (percentual * valor) /100
					$sqlConsultaPercentual = $con->prepare("SELECT `num_repasse_consulta_particular_med` FROM `tbl_medico_med` WHERE num_id_med = ?");
					$sqlConsultaPercentual->bindParam(1, $medico);
					$sqlConsultaPercentual->execute();
					$valorPercentualMedico = $sqlConsultaPercentual->fetchColumn();
				//fim verificar percentual de repasse (percentual * valor) /100

				//informar valor do medico subtraindo valor da clinica
					$valorHonorarioMedico = calcularValorMedico($valorPercentualMedico, $valorProcedimento);
					$valorClinica = $valorProcedimento - $valorHonorarioMedico;
				//fim informar valor do medico subtraindo valor da clinica

				//verifica valor pago pelo paciente
					if($valorpago != $valorProcedimento){
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Valor pago pelo paciente R$$valorpago, diferente ao indicado na tabela R$$valorProcedimento!\");</script>";
						echo "<script language='javascript'>history.back()</script>";
					}
				//fim verifica valor pago pelo paciente

				//verifica campo id de pagamento
					if($idpagamento == ""){
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Para procedimento particular, necessario informar o ID de pagamento!\");</script>";
						echo "<script language='javascript'>history.back()</script>";
					}else{
						//verificar se pagamento existe
							$sqlVerificaPagamento = $con->prepare("SELECT * FROM tbl_recebimento_rec WHERE num_id_rec = ?");
							$sqlVerificaPagamento->bindParam(1, $idpagamento);
							$sqlVerificaPagamento->execute();
							if($sqlVerificaPagamento->rowCount()<=0){
								echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"ID de Pagamento nao encontrado, favor informar novamente!\");</script>";
								echo "<script language='javascript'>history.back()</script>";
							}
						//fim verificar se pagamento existe
						
						//retirar valor do saldo do paciente
						//fim retirar valor do saldo do paciente
					}
				//fim verificar campo id de pagamento
		//fim exame particular
		//consulta convenio
			}else if($categoria > 1 && $procedimento==1){
				$valorProcedimento = capturaValor($procedimento, $categoria);

				//verificar percentual de repasse (percentual * valor) /100
					$sqlConsultaPercentual = $con->prepare("SELECT `num_repasse_consulta_convenio_med` FROM `tbl_medico_med` WHERE num_id_med = ?");
					$sqlConsultaPercentual->bindParam(1, $medico);
					$sqlConsultaPercentual->execute();
					$valorPercentualMedico = $sqlConsultaPercentual->fetchColumn();
				//fim verificar percentual de repasse (percentual * valor) /100

				//informar valor do medico subtraindo valor da clinica
					$valorHonorarioMedico = calcularValorMedico($valorPercentualMedico, $valorProcedimento);
					$valorClinica = $valorProcedimento - $valorHonorarioMedico;
				//fim informar valor do medico subtraindo valor da clinica

				//verificar se o campo guia foi preenchido
				if($guia == ""){
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Para esta categoria, favor preencher o campo guia!\");</script>";
					echo "<script language='javascript'>history.back()</script>";
				}
				//fim verificar se o campo guia foi preenchido

		//fim consulta convenio
		//exame convenio
			}else if($categoria > 1 && $procedimento > 1){
				$valorProcedimento = capturaValor($procedimento, $categoria);

				//verificar percentual de repasse (percentual * valor) /100
					$sqlConsultaPercentual = $con->prepare("SELECT `num_repasse_consulta_particular_med` FROM `tbl_medico_med` WHERE num_id_med = ?");
					$sqlConsultaPercentual->bindParam(1, $medico);
					$sqlConsultaPercentual->execute();
					$valorPercentualMedico = $sqlConsultaPercentual->fetchColumn();
				//fim verificar percentual de repasse (percentual * valor) /100

				//informar valor do medico subtraindo valor da clinica
					$valorHonorarioMedico = calcularValorMedico($valorPercentualMedico, $valorProcedimento);
					$valorClinica = $valorProcedimento - $valorHonorarioMedico;
				//fim informar valor do medico subtraindo valor da clinica

				//verificar se o campo guia foi preenchido
				if($guia == ""){
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Para esta categoria, favor preencher o campo guia!\");</script>";
					echo "<script language='javascript'>history.back()</script>";
				}
				//fim verificar se o campo guia foi preenchido
			}
		//fim exame convenio
	//fim qual categoria e procedimento

	//registro do atendimento
		$con->beginTransaction();

			$sqlInserirAtendimento = $con->prepare("INSERT INTO `tbl_atendimento_aten`(`tbl_procedimentos_pro_num_id_pro`, `tbl_categoria_cat_num_id_cat`, `tbl_usuario_usu_num_id_usu`, `tbl_paciente_pac_num_id_pac`, 
			
			`tbl_medico_med_num_id_med`, `dth_recepcao_aten`, `txt_observacao_aten`, `txt_prioridade_aten`, `dth_medico_aten`, `dth_termino_aten`, `num_usuario_alteracao_aten`, `dth_alteracao_aten`, `txt_status_honorario_aten`, 
			
			`val_medico_aten`, `val_clinica_aten`, `txt_status_aten`, `dth_registro_aten`) 
													
			VALUES (?,?,?,?,?,now(),?,?,null,null,null,null,'aguardando',?,?,'aguardando',now())");

			$sqlInserirAtendimento->bindParam(1,$procedimento);
			$sqlInserirAtendimento->bindParam(2,$categoria);
			$sqlInserirAtendimento->bindParam(3,$_SESSION['id_usu']);
			$sqlInserirAtendimento->bindParam(4,$codigoPaciente);
			$sqlInserirAtendimento->bindParam(5,$medico);
			$sqlInserirAtendimento->bindParam(6,$observacao);
			$sqlInserirAtendimento->bindParam(7,$tipoprioridade);
			$sqlInserirAtendimento->bindParam(8,$valorHonorarioMedico);
			$sqlInserirAtendimento->bindParam(9,$valorClinica);

			if(!$sqlInserirAtendimento->execute()){
				$con->roolBack();
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Houve um erro no processamento das informacoes, tente novamente!\");</script>";
				echo "<script language='javascript'>history.back()</script>";				
			}

		//capturando registro o codigo do atendimento
			$codigoAtendimento = $con->lastInsertId();

		//inserindo os dados na tabela de convenio ou particular
			if($categoria == 1){//se atendimento for particular

				$sqlInserirParticular = $con->prepare("INSERT INTO `tbl_atendimento_particular_atenp`( `tbl_tipo_desconto_td_num_id_td`, `tbl_atendimento_aten_num_id_aten`, `val_valor_atenp`, `val_desconto_atenp`, `val_pago_atenp`, `num_id_pagamento_atenp`) 
				
				VALUES (?,?,?,?,?,?)");

				$sqlInserirParticular->bindParam(1,$tipodesconto);
				$sqlInserirParticular->bindParam(1,$codigoAtendimento);
				$sqlInserirParticular->bindParam(1,$valorProcedimento);
				$sqlInserirParticular->bindParam(1,$valorDesconto);
				$sqlInserirParticular->bindParam(1,$valorpago);
				$sqlInserirParticular->bindParam(1,$idpagamento);

				if(!$sqlInserirParticular->execute()){
					$con->roolBack();
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Houve um erro no processamento das informacoes, tente novamente!\");</script>";
					echo "<script language='javascript'>history.back()</script>";
				}

				$con->commit();
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-pacientes.php'><script type=\"text/javascript\">alert(\"Atendimento registrado com sucesso!\");</script>";

			}else if($categoria > 1){//se atendimento for convenio
				
				$sqlInserirConvenio = $con->prepare("INSERT INTO `tbl_atendimento_convenio_atenc`(`tbl_atendimento_aten_num_id_aten`, `txt_guia_atenc`, `txt_autorizado_atenc`, `dta_autorizacao_guia_atenc`, `val_valor_atenc`, `txt_status_convenio_atenc`) 
				
				VALUES (?,?,?,?,?,'aguardando')");

				$sqlInserirConvenio->bindParam(1,$codigoAtendimento);
				$sqlInserirConvenio->bindParam(2,$guia);
				$sqlInserirConvenio->bindParam(3,$autorizado);
				$sqlInserirConvenio->bindParam(4,$dataautorizacao);
				$sqlInserirConvenio->bindParam(5,$valorProcedimento);

				if(!$sqlInserirConvenio->execute()){
					$con->roolBack();
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Houve um erro no processamento das informacoes, tente novamente!\");</script>";
					echo "<script language='javascript'>history.back()</script>";
				}

				$con->commit();
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-pacientes.php'><script type=\"text/javascript\">alert(\"Atendimento registrado com sucesso!\");</script>";

			}else{
				$con->roolBack();
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Houve um erro no processamento das informacoes, tente novamente!\");</script>";
				echo "<script language='javascript'>history.back()</script>";
			}
		//fim inserindo os dados na tabela de convenio ou particular



	//fim registro de atendimento
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

							   
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-agenda.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
