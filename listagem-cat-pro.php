<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
  include_once "conexao.php";

  $criterio = $_GET['criterio'];
	
  $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-cat-pro.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

    if($criterio == "categoria"){
        
        $parametro = $_POST['parametro'];	  
        $res=$con->prepare("SELECT catpro.num_id_cat_pro, usuario.txt_login_usu, procedimentos.txt_nome_pro, categoria.txt_nome_cat, catpro.val_valor_cat_pro, catpro.dth_registro_cat_pro,catpro.txt_ativo_cat_pro 
        
        FROM tbl_cat_pro catpro
                                    
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = catpro.tbl_usuario_usu_num_id_usu
        LEFT JOIN tbl_procedimentos_pro procedimentos ON procedimentos.num_id_pro = catpro.tbl_procedimentos_pro_num_id_pro
        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = catpro.tbl_categoria_cat_num_id_cat 
                                    
        WHERE catpro.tbl_categoria_cat_num_id_cat = :parametro ORDER BY txt_nome_pro  ASC;");
        
    }else if($criterio == "procedimento"){

        $parametro = $_POST['parametro'];	
        $res = $con->prepare("SELECT catpro.num_id_cat_pro, usuario.txt_login_usu, procedimentos.txt_nome_pro, categoria.txt_nome_cat, catpro.val_valor_cat_pro, catpro.dth_registro_cat_pro,catpro.txt_ativo_cat_pro 
        
        FROM tbl_cat_pro catpro
                                    
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = catpro.tbl_usuario_usu_num_id_usu
        LEFT JOIN tbl_procedimentos_pro procedimentos ON procedimentos.num_id_pro = catpro.tbl_procedimentos_pro_num_id_pro
        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = catpro.tbl_categoria_cat_num_id_cat 
                                    
        WHERE catpro.tbl_procedimentos_pro_num_id_pro = :parametro ORDER BY txt_nome_pro  ASC;");

    }else if($criterio == ""){
            echo $MensagemNaoEncontrado;		
    }	

    try{
        $res->bindValue(':parametro',$parametro);
        $res->execute();
        
        if($res->rowCount()<=0){
            echo $MensagemNaoEncontrado;
        }
    }catch (Exception $e){
        echo $e->getMessage();
    }
?>
<?php include "inicial.php" ?>
            <div class="container col-md-12">								
                <div class="card">
                    <div class="card-header"><h3>Listagem de Procedimentos X Categorias</h3></div>
                    <div class="card-body"> 
                        <table class="table-hover table table-bordered  responsive">
                            <tr class="thead-dark" align="center">		  
                                <th scope="col">ID</th>                  
                                <th scope="col">Procedimento</th>
                                <th scope="col">Categoria</th>          
                                <th scope="col">Valor</th>
                                <th scope="col">Registro</th>
                                <th scope="col">Ativo</th>                                
                                <th scope="col">Usuario</th>
                                <th scope="col">Opcoes</th>
                            </tr>
                            <?php
                            while ($row = $res->fetch(PDO::FETCH_OBJ)){			
                            ?>        
                            <tr align="center">
                                <td><?php echo $row->num_id_cat_pro?></td>                  
                                <td align="left"><?php echo ucfirst($row->txt_nome_pro)?></td>
                                <td align="left"><?php echo ucfirst($row->txt_nome_cat)?></td>        
                                <td>R$<?php echo number_format($row->val_valor_cat_pro,2)?></td>  
                                <td><?php echo date("d/m/Y H:i:s",strtotime($row->dth_registro_cat_pro))?></td>
                                <td><?php echo ucfirst($row->txt_ativo_cat_pro)?></td>        
                                <td align="left"><?php echo ucfirst($row->txt_login_usu)?></td>  
                                <td>
                                    <div class="btn-group dropleft">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                                            
                                            <a class="dropdown-item" href="processa-cat-pro.php?acao=excluir&idCatPro=<?php echo $row->num_id_cat_pro?>">Excluir</a>                                 
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