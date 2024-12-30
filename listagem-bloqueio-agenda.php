<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
  include_once "conexao.php";

  $criterio = $_GET['criterio'];
	
  $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-bloqueio-agenda.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

	if($criterio == "medico"){

        $resBloqueioAgenda=$con->prepare("SELECT bloqueioagenda.num_id_blage, medico.txt_nome_med, usuario.txt_login_usu, bloqueioagenda.txt_descricao_blage, bloqueioagenda.dta_data_blage, bloqueioagenda.dth_registro_blage 
        
        FROM tbl_bloqueio_agenda_blage bloqueioagenda

        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = bloqueioagenda.tbl_medico_med_num_id_med
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = bloqueioagenda.tbl_usuario_usu_num_id_usu
                         
        WHERE tbl_medico_med_num_id_med = ? ORDER BY num_id_blage DESC");
	
  }else if($criterio == ""){
    echo $MensagemNaoEncontrado;
}

try{
    $resBloqueioAgenda->bindParam(1,$_POST['parametro']);

    $resBloqueioAgenda->execute();
    
    if($resBloqueioAgenda->rowCount()<=0){
        echo $MensagemNaoEncontrado;		
    }

}catch(Exception $e){
    echo $e->getMessage();
}
?>
<?php include "inicial.php" ?>
            <div class="container col-md-12">								
                <div class="card">
                    <div class="card-header"><h3>Lista de Bloqueio em Agenda</h3></div>
                    <div class="card-body"> 
                        <table class="table-hover table table-bordered  responsive">
                            <tr class="thead-dark" align="center">		  
                            <th scope="col">ID</th>                            
                            <th scope="col">Medico</th>
                            <th scope="col">Motivo</th>          
                            <th scope="col">Data Bloqueio</th>
                            <th scope="col">Registro</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Opcoes</th>
                        </tr>
                        <?php
                        while ($rowBloqueioAgenda = $resBloqueioAgenda->fetch(PDO::FETCH_OBJ)){			
                        ?>        
                        <tr align="center">
                            <td><?php echo $rowBloqueioAgenda->num_id_blage;?></td>
                            <td><?php echo ucfirst($rowBloqueioAgenda->txt_nome_med)?></td>
                            <td><?php echo $rowBloqueioAgenda->txt_descricao_blage;?></td>          
                            <td><?php echo date('d/m/Y', strtotime($rowBloqueioAgenda->dta_data_blage))?></td>          
                            <td><?php echo date('d/m/Y H:i:s', strtotime($rowBloqueioAgenda->dth_registro_blage))?></td>
                            <td><?php echo ucfirst($rowBloqueioAgenda->txt_login_usu)?></td>
                            <td>
                                <div class="btn-group dropleft">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">     
                                            <a class="dropdown-item" href="processa-bloqueio-agenda.php?acao=excluir&idBloqueioAgenda=<?php echo $rowBloqueioAgenda->num_id_blage?>">Excluir</a>
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