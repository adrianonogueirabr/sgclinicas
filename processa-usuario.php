<?php
include "verifica.php";

/*
FILTER_SANITIZE_STRING
FILTER_SANITIZE_NUMBER_INT
FILTER_SANITIZE_NUMBER_float	
FILTER_SANITIZE_STRING

*/
		 $nome			=filter_input(INPUT_POST,"nome", FILTER_SANITIZE_STRING);
		 $login			=filter_input(INPUT_POST,"login", FILTER_SANITIZE_STRING);
		 $tipo			=filter_input(INPUT_POST,"tipo", FILTER_SANITIZE_STRING);
		 $telefone		=filter_input(INPUT_POST,"telefone", FILTER_SANITIZE_STRING);
		 $email			=filter_input(INPUT_POST,"email", FILTER_SANITIZE_STRING);
		 $senha			=filter_input(INPUT_POST,"senha", FILTER_SANITIZE_STRING);
		 $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);		
		
include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_STRING);

if($acao == "cadastrar"){

	if(($nome=="")|| ($login=="") || ($tipo=="") || ($telefone=="") || ($email=="") || ($senha=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{		
	
		$resUsuario = $con->prepare("SELECT * FROM tbl_usuario_usu WHERE txt_nome_usu = ? AND txt_login_usu = ? AND txt_tipo_usu = ?");
		$resUsuario->bindParam(1,$nome);
		$resUsuario->bindParam(2,$login);
		$resUsuario->bindParam(3,$tipo);

		$resUsuario->execute();
		
		if($resUsuario->rowCount() > 0){
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Ja existe um medico cadastrado com os dados informados!\");</script>";
			echo "<script language='javascript'>history.back()</script>";
			
		}else{	

				$resRegistroUsuario = $con->prepare("INSERT INTO `tbl_usuario_usu`(`txt_tipo_usu`, `txt_nome_usu`, `txt_login_usu`, `txt_senha_usu`, `txt_email_usu`, `txt_telefone_usu`, `dth_registro_usu`, `txt_ativo_usu`) 
				
				VALUES (?,?,?,?,?,?,now(),'SIM')");
											
				$resRegistroUsuario->bindParam(1,$tipo);	
				$resRegistroUsuario->bindParam(2,$nome);
				$resRegistroUsuario->bindParam(3,$login);
				$resRegistroUsuario->bindParam(4,$senha_criptografada);	
				$resRegistroUsuario->bindParam(5,$email);
				$resRegistroUsuario->bindParam(6,$telefone);

				try{
					$resRegistroUsuario->execute();
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-usuario.php'><script type=\"text/javascript\">alert(\"Registro efetuado com sucesso!\");</script>";
				}catch (Exception $e){
					echo "Error: " . $e->getMessage();
				}	
				
		}//FIM DA VERIFICACAO DE CADASTRO JA EXISTENTE 

	}//FIM CAMPOS NOME, TELEFONE E DATA DE NASCIMENTO VAZIOS

}else if($acao == "salvar"){

	if(($nome=="")|| ($login=="") || ($tipo=="") || ($senha=="")){
	
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Preencha todos os campos obrigatorios!\");</script>";
		echo "<script language='javascript'>history.back()</script>";
		
	}else{

				$ativo		=filter_input(INPUT_POST,"ativo", FILTER_SANITIZE_STRING);
				$idUsuario  =filter_input(INPUT_POST,"idUsuario", FILTER_SANITIZE_NUMBER_INT);				

				$resUsuario = $con->prepare("UPDATE `tbl_usuario_usu` SET `txt_tipo_usu`=?,`txt_nome_usu`=?,`txt_login_usu`=?,`txt_senha_usu`=?,`txt_email_usu`=?,`txt_telefone_usu`=?,`txt_ativo_usu`=? WHERE num_id_usu=?");

					$resUsuario->bindParam(1,$tipo);
					$resUsuario->bindParam(2,$nome);
					$resUsuario->bindParam(3,$login);
					$resUsuario->bindParam(4,$senha);
					$resUsuario->bindParam(5,$email);
					$resUsuario->bindParam(6,$telefone);
					$resUsuario->bindParam(7,$ativo);
					$resUsuario->bindParam(8,$idUsuario);

					if ($resUsuario->execute()) {
						echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-usuario.php'><script type=\"text/javascript\">alert(\"Registro atualizado com sucesso!\");</script>";
					} else {
						echo "Error: " . $resUsuario . "<br>" . mysqli_error();
					}	
	}
				
	
}else if($acao == "ativar"){

	$idUsuario		=filter_input(INPUT_GET,"idUsuario", FILTER_SANITIZE_NUMBER_INT);

	$resUsuario = $con->prepare("UPDATE tbl_usuario_usu SET txt_ativo_usu = 'SIM'  WHERE num_id_usu = ?");
	$resUsuario->bindParam(1,$idUsuario);

	if ($resUsuario->execute()) {
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-usuario.php'><script type=\"text/javascript\">alert(\"Usuario ativado com sucesso!\");</script>";
 	}else {
		echo "Error: " . $resUsuario . "<br>" . mysqli_error();
  	}	
	
}else if($acao == "inativar"){

	$idUsuario		=filter_input(INPUT_GET,"idUsuario", FILTER_SANITIZE_NUMBER_INT);

	$resUsuario = $con->prepare("UPDATE tbl_usuario_usu SET txt_ativo_usu = 'NAO'  WHERE num_id_usu = ?");
	$resUsuario->bindParam(1,$idUsuario);

	if ($resUsuario->execute()) {
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-usuario.php'><script type=\"text/javascript\">alert(\"Usuario inativado com sucesso!\");</script>";
 	}else {
		echo "Error: " . $resUsuario . "<br>" . mysqli_error();
  	}	
	
}else{	
	
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=cadastro-usuario.php'><script type=\"text/javascript\">alert(\"Tente Novamente!\");</script>";	

}


?>
