<?php
include "verifica.php";

/*
FILTER_SANITIZE_STRING
FILTER_SANITIZE_NUMBER_INT
FILTER_SANITIZE_NUMBER_float	
FILTER_SANITIZE_STRING

*/

		$nome			=filter_input(INPUT_POST,"nome", FILTER_SANITIZE_STRING);
		$descricao		=filter_input(INPUT_POST,"descricao", FILTER_SANITIZE_STRING);
		$tipo			=filter_input(INPUT_POST,"tipo", FILTER_SANITIZE_STRING);
		$recomendacoes	=filter_input(INPUT_POST,"recomendacoes", FILTER_SANITIZE_STRING);
		
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($nome=="")|| ($tipo=="") || ($recomendacoes=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		//echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resProcedimento = $con->prepare("SELECT * FROM tbl_procedimentos_pro WHERE txt_nome_pro = ? AND txt_tipo_pro = ?");
		$resProcedimento->bindParam(1,$nome);
		$resProcedimento->bindParam(2,$tipo);
		$resProcedimento->execute();
		
			if($resProcedimento->rowCount() > 0){
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existe um Procedimento cadastrado com os dados informados!\");</script>";
				echo "<script language='javascript'>history.back()</script>";
				
			}else{

					$resRegistroProcedimento = $con->prepare("INSERT INTO `tbl_procedimentos_pro`(`tbl_usuario_usu_num_id_usu`, `txt_nome_pro`, `txt_descricao_pro`, `txt_tipo_pro`, `txt_recomendacoes_pro`, `txt_ativo_pro`) 
					
					VALUES (:usuario,:nome,:descricao,:tipo,:recomendacoes,'sim')");
												
					$resRegistroProcedimento->bindValue(':usuario',$_SESSION['id_usu']);	
					$resRegistroProcedimento->bindValue(':nome',$nome);
					$resRegistroProcedimento->bindValue(':descricao', $descricao);
					$resRegistroProcedimento->bindValue(':tipo',$tipo);	
					$resRegistroProcedimento->bindValue(':recomendacoes',$recomendacoes);

					try{
						$resRegistroProcedimento->execute();
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-procedimento.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>";
						
					}catch(Exception $e){
						echo $e->getMessage();
					}

			}//FIM VERIFICACAO PROCEDIMENTO JA CADASTRADO

	}//FIM CAMPOS  VAZIOS

}else if($acao == "salvar"){

	$ativo				=filter_input(INPUT_POST,"ativo", FILTER_SANITIZE_STRING);
	$idProcedimento 	=filter_input(INPUT_POST,"idProcedimento", FILTER_SANITIZE_NUMBER_INT);

	if(($nome=="")|| ($tipo=="") || ($recomendacoes=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{
		
		$resProcedimento = $con->prepare("SELECT * FROM tbl_procedimentos_pro WHERE txt_nome_pro = ? AND txt_tipo_pro = ?");
		$resProcedimento->bindParam(1,$nome);
		$resProcedimento->bindParam(2,$tipo);
		$resProcedimento->execute();
		
			if($resProcedimento->rowCount() > 0){
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existe um Procedimento cadastrado com os dados informados!\");</script>";
				echo "<script language='javascript'>history.back()</script>";
			}else{

				$resUpdateProcedimento = $con->prepare("UPDATE `tbl_procedimentos_pro` SET `txt_nome_pro`=:nome,`txt_descricao_pro`=:descricao,`txt_tipo_pro`=:tipo,`txt_recomendacoes_pro`=:recomendacoes,`txt_ativo_pro`=:ativo
				
				WHERE num_id_pro=:idProcedimento");

				$resUpdateProcedimento->bindValue(':nome',$nome);
				$resUpdateProcedimento->bindValue(':descricao', $descricao);
				$resUpdateProcedimento->bindValue(':tipo',$tipo);	
				$resUpdateProcedimento->bindValue(':recomendacoes',$recomendacoes);
				$resUpdateProcedimento->bindValue(':ativo',$ativo);
				$resUpdateProcedimento->bindValue(':idProcedimento',$idProcedimento);

				try{
					$resUpdateProcedimento->execute();
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-procedimento.php'><script type=\"text/javascript\">alert(\"Registro atualizado com sucesso!\");</script>";						
				}catch(Exception $e){
					echo $e->getMessage();
				}
			}	
	}
				
	
}else if($acao == "ativar"){

	$idProcedimento		=filter_input(INPUT_GET,"idProcedimento", FILTER_SANITIZE_NUMBER_INT);

	$resProcedimento = $con->prepare("UPDATE tbl_procedimentos_pro SET txt_ativo_pro = 'sim'  WHERE num_id_pro = ?");
	$resProcedimento->bindParam(1,$idProcedimento);

	try{
		$resProcedimento->execute(); 
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-procedimento.php'><script type=\"text/javascript\">alert(\"Procedimento ativado com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else if($acao == "inativar"){

	$idProcedimento		=filter_input(INPUT_GET,"idProcedimento", FILTER_SANITIZE_NUMBER_INT);

	$resProcedimento = $con->prepare("UPDATE tbl_procedimentos_pro SET txt_ativo_pro = 'nao'  WHERE num_id_pro = ?");
	$resProcedimento->bindParam(1,$idProcedimento);

	try{
		$resProcedimento->execute(); 
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-procedimento.php'><script type=\"text/javascript\">alert(\"Procedimento ativado com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-procedimento.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
