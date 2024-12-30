<?php 

class usuario{    

    public function login($login,$senha){
        global $con;

        try{

        include "conexao.php";

        //$sqlLogar = "SELECT * FROM tbl_usuario_usu WHERE txt_login_usu = :login AND txt_senha_usu = :senha AND txt_ativo_usu = 'SIM'";
        
        $sqlLogar = "SELECT * FROM tbl_usuario_usu WHERE txt_login_usu = :login AND txt_ativo_usu = 'SIM'";
        $senha_segura = $senha;

        $res = $con->prepare($sqlLogar);
		$res->bindValue("login",$login);

            if(!$res->execute()){die ('Houve um erro na transacao: ' . mysqli_error());}        

            if($res->rowCount()==1)
            {
                while ($row = $res->fetch(PDO::FETCH_OBJ))
                {
                    $id_usu = $row->num_id_usu;	
                    $login_usu = $row->txt_login_usu;		
                    $tipo_usu = $row->txt_tipo_usu;   
                    $senha_usu = $row->txt_senha_usu;
                    
                    if(password_verify($senha_segura,$senha_usu)){

                        session_start(); 
                        $_SESSION['id_usu'] = $id_usu;	
                        $_SESSION['login_usu'] = $login_usu;		
                        $_SESSION['tipo_usu'] = $tipo_usu; 
                        return true;  
                    }else{
                        return false;
                    }                    
                }                

            }else{

                return false;         
            }
        
        }catch (Exception $e){
            echo 'Erro de execucao: ', $e->getMessage();
        }    
    }

    public function logged($login){
        global $con;

        $sqlLogado = "SELECT * FROM tbl_usuario_usu WHERE txt_login_usu = :login AND txt_ativo_usu = 'SIM'";
        
        $res = $con->prepare($sqlLogado);
		$res->bindValue("login",$login);

        if(!$res->execute()){die ('Houve um erro na transacao: ' . mysqli_error($con));}

        if($res->rowCount()>0){
            return true;
        }
        return false;
    }



}


?>