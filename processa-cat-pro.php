<?php
include "verifica.php";

/*
FILTER_SANITIZE_STRING
FILTER_SANITIZE_NUMBER_INT
FILTER_SANITIZE_NUMBER_float	
FILTER_SANITIZE_STRING

*/

		$procedimento	=filter_input(INPUT_POST,"procedimento", FILTER_SANITIZE_NUMBER_INT);
		echo $categoria		=filter_input(INPUT_POST,"categoria", FILTER_SANITIZE_NUMBER_INT);
		echo $valor			=filter_input(INPUT_POST,"valor", FILTER_SANITIZE_STRING);
		
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($procedimento=="")|| ($categoria=="") || ($valor=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resCatPro = $con->prepare("SELECT `num_id_cat_pro`, `tbl_usuario_usu_num_id_usu`, `tbl_procedimentos_pro_num_id_pro`, `tbl_categoria_cat_num_id_cat`, `val_valor_cat_pro`, `dth_registro_cat_pro`, `txt_ativo_cat_pro` 
		
			FROM `tbl_cat_pro` 
			
			WHERE tbl_procedimentos_pro_num_id_pro = :procedimento AND tbl_categoria_cat_num_id_cat = :categoria");

		$resCatPro->bindValue(':procedimento',$procedimento);
		$resCatPro->bindValue(':categoria',$categoria);

		$resCatPro->execute();
		
		if($resCatPro->rowCount() > 0){
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existem valores cadastrado com os dados informados!\");</script>";
			echo "<script language='javascript'>history.back()</script>";
			
		}else{

			$resRegistroCatPro = $con->prepare("INSERT INTO `tbl_cat_pro`( `tbl_usuario_usu_num_id_usu`, `tbl_procedimentos_pro_num_id_pro`, `tbl_categoria_cat_num_id_cat`, `val_valor_cat_pro`, `dth_registro_cat_pro`, `txt_ativo_cat_pro`) 
			
			VALUES (:usuario,:procedimento,:categoria,:valor,now(),'sim')");
												
			$resRegistroCatPro->bindValue(':procedimento',$procedimento);	
			$resRegistroCatPro->bindValue(':usuario',$_SESSION['id_usu']);
			$resRegistroCatPro->bindValue(':categoria',$categoria);
			$resRegistroCatPro->bindValue(':valor',$valor);

				try{
					$resRegistroCatPro->execute();	
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-cat-pro.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>";				
				}catch(Exception $e){
					echo $e->getMessage();
				}

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
				
	
}else if($acao == "excluir"){

	$idCatPro		=filter_input(INPUT_GET,"idCatPro", FILTER_SANITIZE_NUMBER_INT);

	$resExcluirCatPro = $con->prepare("DELETE FROM `tbl_cat_pro` WHERE num_id_cat_pro = :idcatpro");
	$resExcluirCatPro->bindValue(':idcatpro',$idCatPro);

	try{
		$resExcluirCatPro->execute();
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-cat-pro.php'><script type=\"text/javascript\">alert(\"Valores excluidos com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-medico.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
