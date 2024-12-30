<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
  include_once "conexao.php";

  $criterio = $_GET['criterio'];
	
  $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-categoria.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

    if($criterio == "categoria"){        
       
        $parametro = '%'.$_POST['parametro'].'%';

        $resCategoria = $con->prepare("SELECT categoria.num_id_cat, usuario.txt_login_usu,categoria.txt_nome_cat, categoria.num_retorno_cat, categoria.txt_gera_remessa_convenio_cat, categoria.txt_gera_receber_caixa_cat, categoria.txt_ativo_cat 
    
        FROM tbl_categoria_cat categoria
        
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = categoria.tbl_usuario_usu_num_id_usu
        
        WHERE txt_nome_cat LIKE :categoria ORDER BY txt_nome_cat ASC limit 50;");

    }else{
        echo $MensagemNaoEncontrado;		
    }	

    try{
        $resCategoria->bindValue(':categoria',$parametro, PDO::PARAM_STR);
        $resCategoria->execute();
        
        if($resCategoria->rowCount()<=0){
            echo $MensagemNaoEncontrado;
        }
    }catch (Exception $e){
        echo $e->getMessage();
    }
?>
<?php include "inicial.php" ?>
            <div class="container col-md-12">								
                <div class="card">
                    <div class="card-header"><h3>Listagem de Categorias</h3></div>
                    <div class="card-body"> 
                        <table class="table-hover table table-bordered  responsive">
                            <tr class="thead-dark" align="center">		  
                                <th scope="col">ID</th>                  
                                <th scope="col">Nome</th>
                                <th scope="col">Retorno</th>          
                                <th scope="col">Gera Remessa Convenio</th>
                                <th scope="col">Gera Recebimento Caixa</th>
                                <th scope="col">Ativo</th>
                                <th scope="col">Usuario Cadastro</th>
                                <th scope="col">Opcoes</th>
                            </tr>
                            <?php
                            while ($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){			
                            ?>        
                            <tr align="center">
                                <td><?php echo $rowCategoria->num_id_cat;?></td>                  
                                <td align="left"><?php echo ucfirst($rowCategoria->txt_nome_cat)?></td>
                                <td><?php echo $rowCategoria->num_retorno_cat;?></td>          
                                <td><?php echo ucfirst($rowCategoria->txt_gera_remessa_convenio_cat)?></td>          
                                <td><?php echo ucfirst($rowCategoria->txt_gera_receber_caixa_cat)?></td>
                                <td><?php echo ucfirst($rowCategoria->txt_ativo_cat)?></td>
                                <td><?php echo ucfirst($rowCategoria->txt_login_usu)?></td>

                                <td>
                                    <div class="btn-group dropleft">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="detalhes-categoria.php?idCategoria=<?php echo base64_encode($rowCategoria->num_id_cat)?>">Detalhes</a>                                   
                                                <?php   if($rowCategoria->txt_ativo_cat == 'sim'){ ?>                                              
                                                    <a class="dropdown-item" href="processa-categoria.php?idCategoria=<?php echo $rowCategoria->num_id_cat?>&acao=inativar">Inativar</a> 
                                                <?php }else if($rowCategoria->txt_ativo_cat == 'nao'){ ?>                                                                                                                 
                                                    <a class="dropdown-item" href="processa-categoria.php?idCategoria=<?php echo $rowCategoria->num_id_cat?>&acao=ativar">Ativar</a> 
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