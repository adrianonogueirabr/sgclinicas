<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
  include_once "conexao.php";

  $criterio = $_GET['criterio'];
	
  $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-categoria.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

    if($criterio == "procedimento"){        
       
        $parametro = '%'.$_POST['parametro'].'%';

        $resProcedimento = $con->prepare("SELECT procedimento.num_id_pro, usuario.txt_login_usu,procedimento.txt_nome_pro, procedimento.txt_descricao_pro, procedimento.txt_tipo_pro, 
        
        procedimento.txt_recomendacoes_pro, procedimento.txt_ativo_pro 
    
        FROM tbl_procedimentos_pro procedimento
        
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = procedimento.tbl_usuario_usu_num_id_usu
        
        WHERE txt_nome_pro LIKE :procedimento ORDER BY txt_nome_pro ASC limit 50;");

    }else{
        echo $MensagemNaoEncontrado;		
    }	

    try{
        $resProcedimento->bindValue(':procedimento',$parametro, PDO::PARAM_STR);
        $resProcedimento->execute();
        
        if($resProcedimento->rowCount()<=0){
            echo $MensagemNaoEncontrado;
        }
    }catch (Exception $e){
        echo $e->getMessage();
    }
?>
<?php include "inicial.php" ?>
            <div class="container col-md-12">								
                <div class="card">
                    <div class="card-header"><h3>Listagem de Procedimentos</h3></div>
                    <div class="card-body"> 
                        <table class="table-hover table table-bordered  responsive">
                            <tr class="thead-dark" align="center">		  
                                <th scope="col">ID</th>                  
                                <th scope="col">Nome</th>
                                <th scope="col">Descricao</th>          
                                <th scope="col">Tipo</th>
                                <th scope="col">Recomendacoes</th>
                                <th scope="col">Ativo</th>
                                <th scope="col">Opcoes</th>
                            </tr>
                            <?php
                            while ($rowPRocedimento = $resProcedimento->fetch(PDO::FETCH_OBJ)){			
                            ?>        
                            <tr align="center">
                                <td><?php echo $rowPRocedimento->num_id_pro?></td>                  
                                <td align="left"><?php echo ucfirst($rowPRocedimento->txt_nome_pro)?></td>
                                <td align="left"><?php echo ucfirst($rowPRocedimento->txt_descricao_pro)?></td>        
                                <td><?php echo ucfirst($rowPRocedimento->txt_tipo_pro)?></td>          
                                <td align="left" title="<?php echo ucfirst($rowPRocedimento->txt_recomendacoes_pro)?>"><?php echo mb_substr($rowPRocedimento->txt_recomendacoes_pro, 0, 100, 'ISO-8859-1')?></td>
                                <td><?php echo ucfirst($rowPRocedimento->txt_ativo_pro)?></td>

                                <td>
                                    <div class="btn-group dropleft">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="detalhes-procedimento.php?idProcedimento=<?php echo base64_encode($rowPRocedimento->num_id_pro)?>">Detalhes</a>                                   
                                                <?php   if($rowPRocedimento->txt_ativo_pro == 'sim'){ ?>                                              
                                                    <a class="dropdown-item" href="processa-procedimento.php?idProcedimento=<?php echo $rowPRocedimento->num_id_pro?>&acao=inativar">Inativar</a> 
                                                <?php }else if($rowPRocedimento->txt_ativo_pro == 'nao'){ ?>                                                                                                                 
                                                    <a class="dropdown-item" href="processa-procedimento.php?idProcedimento=<?php echo $rowPRocedimento->num_id_pro?>&acao=ativar">Ativar</a> 
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