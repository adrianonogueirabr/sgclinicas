<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
  include_once "conexao.php";

  $criterio = $_GET['criterio'];
	
  $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-medico.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

    if($criterio == "medico"){
        
        $medico = $_POST['parametro'];
        $parametro = '%'.$medico.'%';	  
        $res=$con->prepare("SELECT medico.num_id_med, especialidade.txt_nome_esp, medico.txt_registro_med,  
        
                            medico.txt_nome_med, medico.txt_cpf_med, medico.txt_telefone_med, medico.txt_sexo_med, medico.txt_observacao_med, medico.dth_registro_med, medico.num_idsistema_med, medico.txt_ativo_med 
        
                            FROM tbl_medico_med medico 
                            
                            LEFT JOIN tbl_especialidade_esp especialidade ON especialidade.num_id_esp = medico.tbl_especialidade_esp_num_id_esp 
                            
                            WHERE txt_nome_med LIKE ?  ORDER BY num_id_med ASC;");
        
    }else if($criterio == "especialidade"){

        $parametro = $_POST['parametro'];	
        $res = $con->prepare("SELECT medico.num_id_med, especialidade.txt_nome_esp,   medico.txt_registro_med,  
        
                                medico.txt_nome_med, medico.txt_cpf_med, medico.txt_telefone_med, medico.txt_sexo_med, medico.txt_observacao_med, medico.dth_registro_med,medico.num_idsistema_med, medico.txt_ativo_med 

                                FROM tbl_medico_med medico 
                                
                                LEFT JOIN tbl_especialidade_esp especialidade ON especialidade.num_id_esp = medico.tbl_especialidade_esp_num_id_esp 
                                                            
                                WHERE tbl_especialidade_esp_num_id_esp = ? ORDER BY num_id_med ASC limit 50;");

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
        echo $e->getMessage();
    }
?>
<?php include "inicial.php" ?>
            <div class="container col-md-12">								
                <div class="card">
                    <div class="card-header"><h3>Listagem de Medicos</h3></div>
                    <div class="card-body"> 
                        <table class="table-hover table table-bordered  responsive">
                            <tr class="thead-dark" align="center">		  
                                <th scope="col">ID</th>                  
                                <th scope="col">Nome</th>
                                <th scope="col">Cpf</th>          
                                <th scope="col">Telefone</th>
                                <th scope="col">Especialidade</th>
                                <th scope="col">Sexo</th>
                                <th scope="col">Registro</th>
                                <th scope="col">Ativo</th>
                                <th scope="col">Opcoes</th>
                            </tr>
                            <?php
                            while ($row = $res->fetch(PDO::FETCH_OBJ)){			
                            ?>        
                            <tr align="center">
                                <td><?php echo $row->num_id_med;?></td>                  
                                <td align="left"><?php echo ucfirst($row->txt_nome_med)?></td>
                                <td><?php echo $row->txt_cpf_med;?></td>          
                                <td><?php echo $row->txt_telefone_med;?></td>          
                                <td><?php echo $row->txt_nome_esp;?></td>
                                <td><?php echo ucfirst($row->txt_sexo_med)?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($row->dth_registro_med))?></td>                  
                                <td><?php echo ucfirst($row->txt_ativo_med)?></td>

                                <td>
                                    <div class="btn-group dropleft">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="detalhes-medico.php?idMedico=<?php echo base64_encode($row->num_id_med)?>">Detalhes</a>                                   
                                                <?php   if($row->txt_ativo_med == 'SIM'){ ?>                                              
                                                    <a class="dropdown-item" href="processa-medico.php?idMedico=<?php echo $row->num_id_med?>&acao=inativar">Inativar</a> 
                                                <?php }else if($row->txt_ativo_med == 'NAO'){ ?>                                                                                                                 
                                                    <a class="dropdown-item" href="processa-medico.php?idMedico=<?php echo $row->num_id_med?>&acao=ativar">Ativar</a> 
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