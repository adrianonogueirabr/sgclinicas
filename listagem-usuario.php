<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
  include_once "conexao.php";

  $criterio = filter_input(INPUT_POST,"criterio", FILTER_SANITIZE_STRING);
	
  $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-usuario.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

        if($criterio == "N"){
            
            $valor = $_POST['valor'];
            $parametro = '%'.$valor.'%';	  
            $res=$con->prepare("SELECT `num_id_usu`, `txt_tipo_usu`, `txt_nome_usu`, `txt_login_usu`, `txt_senha_usu`, `txt_email_usu`,`txt_telefone_usu`, `txt_ativo_usu` FROM `tbl_usuario_usu` WHERE txt_nome_usu LIKE ? ORDER BY num_id_usu ASC limit 50;");
            
        }else if($criterio == "L"){

            $parametro = $_POST['valor'];	
            $res=$con->prepare("SELECT `num_id_usu`, `txt_tipo_usu`, `txt_nome_usu`, `txt_login_usu`, `txt_senha_usu`, `txt_email_usu`,`txt_telefone_usu`, `txt_ativo_usu` FROM `tbl_usuario_usu` WHERE txt_login_usu = ?;");
        
        }else if($criterio == "I"){

            $parametro = $_POST['valor'];	
            $res=$con->prepare("SELECT `num_id_usu`, `txt_tipo_usu`, `txt_nome_usu`, `txt_login_usu`, `txt_senha_usu`, `txt_email_usu`, `txt_telefone_usu`,`txt_ativo_usu` FROM `tbl_usuario_usu` WHERE num_id_usu = ?;");        		
        
        }else if($criterio == ""){
                echo $MensagemNaoEncontrado;		
        }

        try{
            $res->bindParam(1,$parametro);
            $res->execute();
            
            if($res->rowCount()<=0){
                echo $MensagemNaoEncontrado;
            }
        }catch (Exception $e){
            $MensagemNaoEncontrado;
        }
        
?>
<?php include "inicial.php" ?>

            <div class="container col-md-12">								
                <div class="card">
                    <div class="card-header"><h3>Listagem de Usuarios</h3></div>
                    <div class="card-body"> 
                        <table class="table-hover table table-bordered  responsive">
                            <tr class="thead-dark" align="center">			  
                                <th scope="col">ID</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Login</th>
                                <th scope="col">Telefone</th>          
                                <th scope="col">Email</th>
                                <th scope="col">Ativo</th>
                                <th scope="col">Opcoes</th>
                            </tr>
                            <?php
                            while ($row = $res->fetch(PDO::FETCH_OBJ)){			
                            ?>        
                            <tr align="center">
                                <td><?php echo $row->num_id_usu;?></td>
                                <td align="left"><?php echo $row->txt_tipo_usu;?></td>
                                <td align="left"><?php echo $row->txt_nome_usu ;?></td>
                                <td align="left"><?php echo $row->txt_login_usu;?></td>   
                                <td><?php echo $row->txt_telefone_usu;?></td>        
                                <td align="left"><?php echo $row->txt_email_usu;?></td>          
                                <td><?php echo ucfirst($row->txt_ativo_usu)?></td>

                                <td>
                                    <div class="btn-group dropleft">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="detalhes-usuario.php?idUsuario=<?php echo base64_encode($row->num_id_usu)?>">Detalhes</a>                                   
                                                <?php   if($row->txt_ativo_usu == 'SIM'){ ?>                                              
                                                    <a class="dropdown-item" href="processa-usuario.php?idUsuario=<?php echo $row->num_id_usu?>&acao=inativar">Inativar</a> 
                                                <?php }else if($row->txt_ativo_usu == 'NAO'){ ?>                                                                                                                 
                                                    <a class="dropdown-item" href="processa-usuario.php?idUsuario=<?php echo $row->num_id_usu?>&acao=ativar">Ativar</a> 
                                                <?php }  ?>                                                                      
                                            </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>    

<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>
</body>
</html>