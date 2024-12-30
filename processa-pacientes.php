<?php
require "verifica.php";

		 $medico				=filter_input(INPUT_POST,"medico", FILTER_SANITIZE_NUMBER_INT);
		$profissao			=filter_input(INPUT_POST,"profissao", FILTER_SANITIZE_NUMBER_INT);	
		$categoria			=filter_input(INPUT_POST,"categoria", FILTER_SANITIZE_NUMBER_INT);
		  $cor				=filter_input(INPUT_POST,"cor", FILTER_SANITIZE_NUMBER_INT);
		$estadocivil		=filter_input(INPUT_POST,"estadocivil", FILTER_SANITIZE_NUMBER_INT);
		
		$nome				=strtolower(filter_input(INPUT_POST,"nome", FILTER_SANITIZE_STRING));
		$cpf				=filter_input(INPUT_POST,"cpf", FILTER_SANITIZE_STRING);
		$rg					=filter_input(INPUT_POST,"rg", FILTER_SANITIZE_STRING);
		 $sexo				=filter_input(INPUT_POST,"sexo", FILTER_SANITIZE_STRING);
		$datanascimento		=filter_input(INPUT_POST,"datanascimento", FILTER_DEFAULT);
		$email				=filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);
		$telefone			=filter_input(INPUT_POST,"telefone", FILTER_SANITIZE_STRING);

		$cep				=filter_input(INPUT_POST,"cep", FILTER_SANITIZE_STRING);
		$logradouro			=filter_input(INPUT_POST,"logradouro", FILTER_SANITIZE_STRING);
		$numero				=filter_input(INPUT_POST,"numero", FILTER_SANITIZE_NUMBER_INT);
		$complemento		=filter_input(INPUT_POST,"complemento", FILTER_SANITIZE_STRING);
		$bairro				=filter_input(INPUT_POST,"bairro", FILTER_SANITIZE_STRING);
		$cidade				=filter_input(INPUT_POST,"cidade", FILTER_SANITIZE_STRING);
		$estado				=filter_input(INPUT_POST,"estado", FILTER_SANITIZE_STRING);

		$matricula			=filter_input(INPUT_POST,"matricula", FILTER_SANITIZE_STRING);
		$pne				=filter_input(INPUT_POST,"pne", FILTER_SANITIZE_STRING);
		$cns				=filter_input(INPUT_POST,"cns", FILTER_SANITIZE_STRING);
		$carteira			=filter_input(INPUT_POST,"carteira", FILTER_SANITIZE_STRING);
		$vencimento_carteira=filter_input(INPUT_POST,"vencimento_carteira", FILTER_DEFAULT);
		$observacoes		=filter_input(INPUT_POST,"observacoes", FILTER_SANITIZE_STRING);

include_once "conexao.php";

 $acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($nome=="")|| ($telefone=="") || ($datanascimento=="")|| ($categoria=="")|| ($medico=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resPaciente = $con->prepare("SELECT * FROM tbl_paciente_pac WHERE txt_nome_pac = ? AND txt_telefone_pac = ? AND dta_datanascimento_pac = ?");
		$resPaciente->bindParam(1,$nome);
		$resPaciente->bindParam(2,$telefone);
		$resPaciente->bindParam(3,$datanascimento);

		$resPaciente->execute();
		
		if($resPaciente->rowCount() > 0){
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Paciente com mesmo nome, data de nascimento e telefone ja foi cadastrado!\");</script>";
			echo "<script language='javascript'>history.back()</script>";
			
		}else{			

				$resRegistroPaciente=$con->prepare("INSERT INTO `tbl_paciente_pac`(`num_id_pac`,`tbl_profissao_prof_num_id_prof`, `tbl_estado_civil_ec_num_id_ec`, `tbl_cor_cor_num_id_cor`, `tbl_medico_med_num_id_med`, 
				
				`tbl_categoria_cat_num_id_cat`, `tbl_usuario_usu_num_id_usu`, 
				
				`txt_nome_pac`, `txt_cpf_pac`, `txt_rg_pac`, `txt_sexo_pac`,`dta_datanascimento_pac`, `txt_email_pac`, `txt_telefone_pac`, `txt_senha_pac`, 
				
				`txt_cep_pac`, `txt_logradouro_pac`, `num_numero_pac`, `txt_complemento_pac`, `txt_bairro_pac`, `txt_cidade_pac`, `txt_estado_pac`, 
				
				`txt_matricula_pac`, `val_saldo_pac`, `txt_pne_pac`, `txt_cns_pac`, `txt_carteira_pac`, `dta_vencimento_carteira_pac`, `dth_registro_pac`, `num_usuario_alteracao_pac`, `dth_alteracao_pac`, 
				
				`txt_bloquear_agendamento_pac`, `txt_observacoes_pac`, `dta_ultima_visita_pac`, `txt_ativo_pac`)
				
				VALUES (null,:profissao,:estadocivil,:cor,:medico,:categoria,:usuario,:nome,:cpf,:rg,:sexo,:datanascimento,:email,:telefone,:datanascimento,:cep,:logradouro,:numero,:complemento,:bairro,:cidade,
				
				:estado,:matricula,0,:pne,:cns,:carteira,:vencimento_carteira,now(),null,null,'nao',:observacoes,null,'sim');");
				
				$resRegistroPaciente->bindValue(':profissao',$profissao);
				$resRegistroPaciente->bindParam(':estadocivil',$estadocivil);
				$resRegistroPaciente->bindParam(':cor',$cor);
				$resRegistroPaciente->bindParam(':medico',$medico);
				$resRegistroPaciente->bindParam(':categoria',$categoria);
				$resRegistroPaciente->bindParam(':usuario',$_SESSION['id_usu']);				

				$resRegistroPaciente->bindParam(':nome',$nome);
				$resRegistroPaciente->bindParam(':cpf',$cpf);
				$resRegistroPaciente->bindParam(':rg',$rg);
				$resRegistroPaciente->bindParam(':sexo',$sexo);
				$resRegistroPaciente->bindParam(':datanascimento',$datanascimento);//senha do paciente para acesso do exames
				$resRegistroPaciente->bindParam(':email',$email);
				$resRegistroPaciente->bindParam(':telefone',$telefone);
				$resRegistroPaciente->bindParam(':datanascimento',$datanascimento);//senha do paciente para acesso do exames
				
				$resRegistroPaciente->bindParam(':cep',$cep);
				$resRegistroPaciente->bindParam(':logradouro',$logradouro);
				$resRegistroPaciente->bindParam(':numero',$numero);
				$resRegistroPaciente->bindParam(':complemento',$complemento);
				$resRegistroPaciente->bindParam(':bairro',$bairro);
				$resRegistroPaciente->bindParam(':cidade',$cidade);
				$resRegistroPaciente->bindParam(':estado',$estado);

				$resRegistroPaciente->bindParam(':matricula',$matricula);
				$resRegistroPaciente->bindParam(':pne',$pne);
				$resRegistroPaciente->bindParam(':cns',$cns);
				$resRegistroPaciente->bindParam(':carteira',$carteira);
				$resRegistroPaciente->bindParam(':vencimento_carteira',$vencimento_carteira);

				$resRegistroPaciente->bindParam(':observacoes',$observacoes);				

					if (!$resRegistroPaciente->execute()) {
						echo "Error: " . $resRegistroPaciente . "<br>" . mysqli_error($con);
					}else{
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-pacientes.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>";
					}

		}//FIM DA VERIFICACAO DE CADASTRO JA EXISTENTE 

	}//FIM CAMPOS NOME, TELEFONE E DATA DE NASCIMENTO VAZIOS

}else if($acao == "salvar"){

	if(($nome=="") || ($telefone=="") || ($datanascimento=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{

				 $ativo						=filter_input(INPUT_POST,"ativo", FILTER_SANITIZE_STRING);
				 $bloqueio_agendamento		=filter_input(INPUT_POST,"bloqueio_agendamento", FILTER_SANITIZE_STRING);

				 $idPaciente =filter_input(INPUT_POST,"idPaciente", FILTER_SANITIZE_NUMBER_INT);
				

				$atualizaPaciente = $con->prepare("UPDATE tbl_paciente_pac SET txt_cpf_pac = ?, txt_nome_pac = ?, txt_rg_pac = ?, txt_telefone_pac = ?, txt_email_pac = ?, txt_cep_pac = ?, 
				
				txt_logradouro_pac = ?, num_numero_pac = ?, txt_complemento_pac =?,txt_bairro_pac = ?, txt_cidade_pac = ?, txt_estado_pac = ?, txt_matricula_pac = ?, 
				
				txt_carteira_pac = ?, txt_cns_pac = ?, txt_observacoes_pac = ?, num_usuario_alteracao_pac = ?, dth_alteracao_pac = now(),txt_ativo_pac = ?, txt_sexo_pac = ?, txt_bloquear_agendamento_pac = ?,  
				
				tbl_profissao_prof_num_id_prof = ?,tbl_estado_civil_ec_num_id_ec = ?, tbl_cor_cor_num_id_cor = ?, tbl_medico_med_num_id_med = ?, tbl_categoria_cat_num_id_cat = ? WHERE num_id_pac = ?");

							$atualizaPaciente->bindParam(1,$cpf);
							$atualizaPaciente->bindParam(2,$nome);
							$atualizaPaciente->bindParam(3,$rg);
							$atualizaPaciente->bindParam(4,$telefone);
							$atualizaPaciente->bindParam(5,$email);
							$atualizaPaciente->bindParam(6,$cep);
							$atualizaPaciente->bindParam(7,$logradouro);
							$atualizaPaciente->bindParam(8,$numero);
							$atualizaPaciente->bindParam(9,$complemento);
							$atualizaPaciente->bindParam(10,$bairro);
							$atualizaPaciente->bindParam(11,$cidade);
							$atualizaPaciente->bindParam(12,$estado);
							$atualizaPaciente->bindParam(13,$matricula);
							$atualizaPaciente->bindParam(14,$carteira);
							$atualizaPaciente->bindParam(15,$cns);							
							$atualizaPaciente->bindParam(16,$observacoes);
							$atualizaPaciente->bindParam(17,$_SESSION['id_usu']);
							$atualizaPaciente->bindParam(18,$ativo);
							$atualizaPaciente->bindParam(19,$sexo);
							$atualizaPaciente->bindParam(20,$bloqueio_agendamento);
							$atualizaPaciente->bindParam(21,$profissao);
							$atualizaPaciente->bindParam(22,$estadocivil);
							$atualizaPaciente->bindParam(23,$cor);
							$atualizaPaciente->bindParam(24,$medico);
							$atualizaPaciente->bindParam(25,$categoria);
							$atualizaPaciente->bindParam(26,$idPaciente);
							
					if ($atualizaPaciente->execute()) {
						$idPaciente = base64_encode($idPaciente);
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=detalhes-pacientes.php?idPaciente=$idPaciente'><script type=\"text/javascript\">alert(\"Registro atualizado com sucesso!\");</script>";
					} else {
						echo "Error: " . $atualizaPaciente . "<br>" . mysqli_error();
					}	
	}
				
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-pacientes.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}

?>
