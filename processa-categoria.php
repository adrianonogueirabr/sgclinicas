<?php
include "verifica.php";

/*
FILTER_SANITIZE_STRING
FILTER_SANITIZE_NUMBER_INT
FILTER_SANITIZE_NUMBER_float	
FILTER_SANITIZE_STRING

*/

		$nome			=filter_input(INPUT_POST,"nome", FILTER_SANITIZE_STRING);
		$retorno		=filter_input(INPUT_POST,"retorno", FILTER_SANITIZE_NUMBER_INT);
		$geraremessa	=filter_input(INPUT_POST,"geraremessa", FILTER_SANITIZE_STRING);
		$geracaixa		=filter_input(INPUT_POST,"geracaixa", FILTER_SANITIZE_STRING);
		
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($nome=="")|| ($retorno=="") || ($geraremessa=="") || ($geracaixa=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resCategoria = $con->prepare("SELECT * FROM tbl_categoria_cat WHERE txt_nome_cat = ? AND num_retorno_cat = ? AND txt_gera_remessa_convenio_cat = ? AND txt_gera_receber_caixa_cat = ?");
		$resCategoria->bindParam(1,$nome);
		$resCategoria->bindParam(2,$retorno);
		$resCategoria->bindParam(3,$geraremessa);
		$resCategoria->bindParam(4,$geracaixa);

		$resCategoria->execute();
		
			if($resCategoria->rowCount() > 0){
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existe uma categoria cadastrado com os dados informados!\");</script>";
				echo "<script language='javascript'>history.back()</script>";
				
			}else{

					$resRegistroCategoria = $con->prepare("INSERT INTO `tbl_categoria_cat`(`tbl_usuario_usu_num_id_usu`, `txt_nome_cat`, `num_retorno_cat`, `txt_gera_remessa_convenio_cat`, `txt_gera_receber_caixa_cat`, `txt_ativo_cat`) 
					
					VALUES (:usuario,:nome,:retorno,:geraremessa,:geracaixa,'sim')");
												
					$resRegistroCategoria->bindValue(':usuario',$_SESSION['id_usu']);	
					$resRegistroCategoria->bindValue(':nome',$nome);
					$resRegistroCategoria->bindValue(':retorno', $retorno);
					$resRegistroCategoria->bindValue(':geraremessa',$geraremessa);	
					$resRegistroCategoria->bindValue(':geracaixa',$geracaixa);

					try{
						$resRegistroCategoria->execute();
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-categoria.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>";
						
					}catch(Exception $e){
						echo $e->getMessage();
					}

			}//FIM VERIFICACAO CATEGORIA JA CADASTRADA

	}//FIM CAMPOS NOME, TELEFONE E DATA DE NASCIMENTO VAZIOS

}else if($acao == "salvar"){

	$ativo			=filter_input(INPUT_POST,"ativo", FILTER_SANITIZE_STRING);
	$idCategoria 	=filter_input(INPUT_POST,"idCategoria", FILTER_SANITIZE_NUMBER_INT);

	if(($nome=="")|| ($retorno=="") || ($geraremessa=="") || ($geracaixa=="")|| ($ativo=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		

		$resCategoria = $con->prepare("UPDATE `tbl_categoria_cat` SET `txt_nome_cat`=:nome,`num_retorno_cat`=:retorno,`txt_gera_remessa_convenio_cat`=:geraremessa,`txt_gera_receber_caixa_cat`=:geracaixa,`txt_ativo_cat`=:ativo  WHERE num_id_cat=:idCategoria");

		$resCategoria->bindValue(':nome',$nome);
		$resCategoria->bindValue(':retorno',$retorno);
		$resCategoria->bindValue(':geraremessa',$geraremessa);
		$resCategoria->bindValue(':geracaixa',$geracaixa);
		$resCategoria->bindValue(':ativo',$ativo);
		$resCategoria->bindValue(':idCategoria',$idCategoria);

		try{
			$resCategoria->execute();
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-categoria.php'><script type=\"text/javascript\">alert(\"Registro atualizado com sucesso!\");</script>";						
		}catch(Exception $e){
			echo $e->getMessage();
		}	
	}
				
	
}else if($acao == "ativar"){

	$idCategoria		=filter_input(INPUT_GET,"idCategoria", FILTER_SANITIZE_NUMBER_INT);

	$resCategoria = $con->prepare("UPDATE tbl_categoria_cat SET txt_ativo_cat = 'sim'  WHERE num_id_cat = ?");
	$resCategoria->bindParam(1,$idCategoria);

	try{
		$resCategoria->execute(); 
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-categoria.php'><script type=\"text/javascript\">alert(\"Categoria ativado com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else if($acao == "inativar"){

	$idCategoria		=filter_input(INPUT_GET,"idCategoria", FILTER_SANITIZE_NUMBER_INT);

	$resCategoria = $con->prepare("UPDATE tbl_categoria_cat SET txt_ativo_cat = 'nao'  WHERE num_id_cat = ?");
	$resCategoria->bindParam(1,$idCategoria);

	try{
		$resCategoria->execute(); 
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-categoria.php'><script type=\"text/javascript\">alert(\"Categoria inativada com sucesso!\");</script>";
 	}catch(Exception $e){
		echo $e->getMessage();
  	}	
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-procedimento.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
