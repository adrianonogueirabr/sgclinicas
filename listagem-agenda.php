<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
  include_once "conexao.php";

  $criterio = $_GET['criterio'];
	
  $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-agenda.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

	if($criterio == "medico"){

        $res=$con->prepare("SELECT agenda.num_id_agen,usuario.txt_login_usu, medico.txt_nome_med,agenda.txt_dia_semana_agen,agenda.hor_inicio_agen,agenda.hor_final_agen,agenda.num_quantidade_agen,agenda.txt_status_agen,agenda.dth_registro_agen
      
        FROM tbl_agenda_agen agenda

        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agenda.tbl_medico_med_num_id_med
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agenda.tbl_usuario_usu_num_id_usu
                         
        WHERE tbl_medico_med_num_id_med = ? ORDER BY num_id_agen ASC");
	
  }else if($criterio == "dia"){

        $res = $con->prepare("SELECT agenda.num_id_agen,usuario.txt_login_usu, medico.txt_nome_med,agenda.txt_dia_semana_agen,agenda.hor_inicio_agen,agenda.hor_final_agen,agenda.num_quantidade_agen,agenda.txt_status_agen,agenda.dth_registro_agen
      
        FROM tbl_agenda_agen agenda

        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agenda.tbl_medico_med_num_id_med
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agenda.tbl_usuario_usu_num_id_usu
                          
        WHERE txt_dia_semana_agen = ? ORDER BY txt_nome_med, num_id_agen ASC");
	
  }else if($criterio == "status"){
      
        $res = $con->prepare("SELECT agenda.num_id_agen,usuario.txt_login_usu, medico.txt_nome_med,agenda.txt_dia_semana_agen,agenda.hor_inicio_agen,agenda.hor_final_agen,agenda.num_quantidade_agen,agenda.txt_status_agen,agenda.dth_registro_agen
    
        FROM tbl_agenda_agen agenda

        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agenda.tbl_medico_med_num_id_med
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agenda.tbl_usuario_usu_num_id_usu
                        
        WHERE txt_status_agen = ? ORDER BY txt_nome_med, num_id_agen ASC");
}else if($criterio == ""){
    echo $MensagemNaoEncontrado;
}

try{
    $res->bindParam(1,$_POST['parametro']);

    $res->execute();
    
    if($res->rowCount()<=0){
        echo $MensagemNaoEncontrado;		
    }

}catch(Exception $e){
    echo $e->getMessage();
}
?>
<?php include "inicial.php" ?>
            <div class="container col-md-12">								
                <div class="card">
                    <div class="card-header"><h3>Listagem de Agenda</h3></div>
                    <div class="card-body"> 
                        <table class="table-hover table table-bordered  responsive">
                            <tr class="thead-dark" align="center">		  
                            <th scope="col">ID</th>                            
                            <th scope="col">Medico</th>
                            <th scope="col">Dia</th>          
                            <th scope="col">Hora Inicial</th>
                            <th scope="col">Hora Final</th>
                            <th scope="col">Vagas</th>
                            <th scope="col">Status</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Registro</th>
                            <th scope="col">Opcoes</th>
                        </tr>
                        <?php
                        while ($row = $res->fetch(PDO::FETCH_OBJ)){			
                        ?>        
                        <tr align="center">
                            <td><?php echo $row->num_id_agen;?></td>
                            <td><?php echo ucfirst($row->txt_nome_med)?></td>
                            <td><?php echo $row->txt_dia_semana_agen;?></td>          
                            <td><?php echo $row->hor_inicio_agen;?></td>          
                            <td><?php echo $row->hor_final_agen;?></td>
                            <td><?php echo $row->num_quantidade_agen;?></td>
                            <td><?php echo ucfirst($row->txt_status_agen)?></td>
                            <td><?php echo $row->txt_login_usu;?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($row->dth_registro_agen))?></td>

                            <td>
                                <div class="btn-group dropleft">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            
                                            <?php   if($row->txt_status_agen == 'ativo'){ ?>        
                                                <a class="dropdown-item" href="processa-agenda.php?acao=bloquear&idAgenda=<?php echo $row->num_id_agen?>">Bloquear</a> 
                                            <?php }else if($row->txt_status_agen == 'bloqueado'){ ?>                                                                                                                 
                                                <a class="dropdown-item" href="processa-agenda.php?acao=reativar&idAgenda=<?php echo $row->num_id_agen?>">Reativar</a>
                                            <?php } ?>                               
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