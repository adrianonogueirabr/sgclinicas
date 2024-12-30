<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<?php 
    include_once "conexao.php";

    $valor = $_POST['valor'];
    $criterio = $_POST['criterio'];
    
    $MensagemNaoEncontrado = "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-pacientes.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";

    if($criterio == "C"){

        $res=$con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, paciente.txt_nome_pac, paciente.txt_cpf_pac, paciente.dta_datanascimento_pac, paciente.txt_telefone_pac, 
      
        paciente.txt_pne_pac, paciente.txt_cns_pac, paciente.dth_registro_pac, paciente.dth_alteracao_pac, paciente.txt_bloquear_agendamento_pac, paciente.dta_ultima_visita_pac, paciente.txt_ativo_pac 
          
        FROM tbl_paciente_pac paciente
          
        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat 
          
        WHERE txt_cpf_pac = ? ");

    }else if($criterio == "R"){

        $valor = '%'.$valor.'%';
        $res = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, paciente.txt_nome_pac, paciente.txt_cpf_pac, paciente.dta_datanascimento_pac, paciente.txt_telefone_pac, 
      
        paciente.txt_pne_pac, paciente.txt_cns_pac, paciente.dth_registro_pac, paciente.dth_alteracao_pac, paciente.txt_bloquear_agendamento_pac, paciente.dta_ultima_visita_pac, paciente.txt_ativo_pac 
          
        FROM tbl_paciente_pac paciente
          
        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat  
          
        WHERE txt_nome_pac LIKE ? limit 25");

    }else if($criterio = ""){
        echo $MensagemNaoEncontrado;		
    }    
    
    try{

        $res->bindParam(1,$valor);

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
                        <div class="card-header"><h3>Listagem de Pacientes</h3></div>
                        <div class="card-body"> 
                            <table class="table-hover table table-bordered  responsive">
                                <tr class="thead-dark" align="center">		  
                                    <th scope="col">Nome</th>  
                                    <!--<th scope="col">CPF</th>DESATIVADO EM 26/04/2024 PARA MELHOR ALINHAMENTO DA TELA-->
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Nascimento</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Medico</th>
                                    <th scope="col">PNE</th>
                                    <th scope="col">Ultima Visita</th>
                                    <!--<th scope="col">Data</th>DESATIVADO EM 26/04/2024 PARA MELHOR ALINHAMENTO DA TELA-->
                                    <th scope="col">Opcoes</th>
                                </tr>
                                <?php
                                    while ($row = $res->fetch(PDO::FETCH_OBJ)){	
                                    
                                    //calculo idade do paciente
                                    $dataNascimento = $row->dta_datanascimento_pac; 
                                    $date = new DateTime($dataNascimento ); 
                                    $interval = $date->diff( new DateTime( date('Y-m-d') ) ); 
                                    //fim calculo idade

                                    //Captura data da ultima visita e calcula numero de dias--> 
                                        if($row->dta_ultima_visita_pac != NULL){
                                            $diferenca =  strtotime(date("Y-m-d")) - strtotime($row->dta_ultima_visita_pac);
                                            $diasUltimaVisita = floor($diferenca / (60 * 60 * 24));  
                                            $dataUltimaVisita =  date("d/m/Y", strtotime($row->dta_ultima_visita_pac));                                                 
                                        }else{
                                          $dataUltimaVisita = 0;
                                          $diasUltimaVisita = 0;
                                        }
                                    
                                    //fim

                                ?>        
                                <tr align="center">
                                    <td align="left"><?php echo ucwords($row->txt_nome_pac);?></td>
                                    <!--<td><?php echo $row->txt_cpf_pac;?></td>DESATIVADO EM 26/04/2024 PARA MELHOR ALINHAMENTO DA TELA-->                            
                                    <td><?php echo $row->txt_telefone_pac;?></td>
                                    <td><?php echo date("d/m/Y",strtotime($row->dta_datanascimento_pac))?> <br> <?php echo $interval->format( '%Y anos e %m mes(es)' ) ?></td>
                                    <td><?php echo ucwords($row->txt_nome_cat);?></td>
                                    <td align="left"><?php echo ucwords($row->txt_nome_med);?></td>
                                    <td><?php echo $row->txt_pne_pac;?></td>
                                    <td align="center"><?php echo $dataUltimaVisita ?> <br> <?php echo $diasUltimaVisita ?> dia(s)</td>
                                    <?php //mensagem para exibicao de data de registro e alteracao do cliente 
                                        $dataRegistro = date("d/m/Y  H:i:s",strtotime($row->dth_registro_pac));
                                        $dataAlteracao = date("d/m/Y  H:i:s",strtotime($row->dth_alteracao_pac));
                                        $MensagemPopover = "Registro: $dataRegistro | Alteracao: $dataAlteracao";  
                                    ?>            
                                    <!--<td><a href="#" data-toggle="popover" title="Cronologia do Paciente" data-content="<?php echo $MensagemPopover ?>">Clique</a></td>DESATIVADO EM 26/04/2024 PARA MELHOR ALINHAMENTO DA TELA-->
                                    <td>
                                        <div class="btn-group dropleft">
                                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="detalhes-pacientes.php?idPaciente=<?php echo base64_encode($row->num_id_pac)?>">Detalhes</a>
                                                    <?php  if($row->txt_bloquear_agendamento_pac == 'nao'){ ?>   
                                                        <a class="dropdown-item" href="agendamento.php?idPaciente=<?php echo base64_encode($row->num_id_pac)?>">Agendar</a>
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