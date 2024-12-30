<?php include 'verifica.php';

include "conexao.php";

$acao = $_GET['acao'];

if ($acao == "n") {

    $codigoPaciente = base64_decode($_GET['p']);

    $dataAtual = date('Y-m-d');

    //realizando captura dos dados de agendamento
    $sqlAgendamentos = $con->prepare("SELECT agendamento.hor_hora_age, agendamento.dta_data_age, medico.txt_nome_med,agendamento.num_id_age, 
    
                agendamento.tbl_paciente_pac_num_id_pac, paciente.txt_nome_pac, paciente.txt_telefone_pac, 
                                                                    
                usuario.txt_login_usu, agendamento.txt_observacao_age,agendamento.txt_solicitacao_age, agendamento.txt_status_age, usuarioconfirmacao.txt_login_usu as usuarioconfirmacao,
                
                usuarioremarcacao.txt_login_usu as usuarioremarcacao,
                
                agendamento.dth_registro_age, agendamento.dth_confirmacao_age, agendamento.dth_remarcacao_age
                
                FROM tbl_agendamento_age as agendamento 
        
                LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med
                                                                                                                                            
                LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac                

                LEFT JOIN tbl_medico_med medicopaciente ON medicopaciente.num_id_med = paciente.tbl_medico_med_num_id_med
                
                LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu
                
                LEFT JOIN tbl_usuario_usu usuarioconfirmacao ON usuarioconfirmacao.num_id_usu = agendamento.num_usuario_confirmacao_age
                
                LEFT JOIN tbl_usuario_usu usuarioremarcacao ON usuarioremarcacao.num_id_usu = agendamento.num_usuario_remarcacao_age                                   
                                                        
                WHERE agendamento.tbl_paciente_pac_num_id_pac = ? and agendamento.dta_data_age = ? ");

    $sqlAgendamentos->bindParam(1, $codigoPaciente);
    $sqlAgendamentos->bindParam(2, $dataAtual);

    if (!$sqlAgendamentos->execute()) {
        echo "Error: " . $sqlAgendamentos . "<br>" . mysqli_error($con);
    }

    //fim captura dados

}

/*capturar detalhes do paciente*/

$resPaciente = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, paciente.txt_nome_pac, paciente.dta_ultima_visita_pac,paciente.dta_datanascimento_pac, paciente.txt_ativo_pac 
            
            FROM tbl_paciente_pac paciente
            
            LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
            LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat  
            
            WHERE num_id_pac = ? AND paciente.txt_ativo_pac = 'sim'");

$resPaciente->bindParam(1, $codigoPaciente);
$resPaciente->execute();

//caso nao encontre paciente
if ($resPaciente->rowCount() <= 0) {
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Favor realizar operacao novamente dados paciente!\");</script>";
    echo "<script language='javascript'>history.back()</script>";

} else {

    while ($rowPaciente = $resPaciente->fetch(PDO::FETCH_OBJ)) {
        $numIdPaciente = $rowPaciente->num_id_pac;
        $txtNomePaciente = $rowPaciente->txt_nome_pac;
        $txtNomeMedico = $rowPaciente->txt_nome_med;
        $txtNomeCategoria = $rowPaciente->txt_nome_cat;
        $dtaUltimaVisita = $rowPaciente->dta_ultima_visita_pac;
        //calculo idade do paciente
        $dataNascimento = $rowPaciente->dta_datanascimento_pac; 
        $date = new DateTime($dataNascimento ); 
        $interval = $date->diff( new DateTime( date('Y-m-d') ) ); 
        //fim calculo idade

    }
}
/*fim detalhes paciente */

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
    <?php include "inicial.php" ?>
    <div class="container col-md-12">								
                            <div class="card">
                                <div class="card-header"><h3>Registrar Atendimento de: <?php echo ucwords($txtNomePaciente) ?></h3></div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-4 col-sm-6"><label>Nome e Idade</label>
                                            <input title="NOME DO PACIENTE" value="<?php echo ucwords($txtNomePaciente) ?> - <?php echo $interval->format( '%Y anos e %m mes(es)' ) ?>"readonly="readonly" class="form-control" readonly />
                                        </div>

                                        <div class="form-group col-md-4 col-sm-6"><label>Medico</label>
                                            <input title="MEDICO DO PACIENTE" value="<?php echo ucwords($txtNomeMedico) ?>"readonly="readonly" class="form-control" readonly />
                                        </div>

                                        <div class="form-group  col-md-2 col-sm-6"><label>Categoria</label>
                                            <input title="CATEGORIA DO PACIENTE" value="<?php echo ucwords($txtNomeCategoria) ?>"readonly="readonly" class="form-control" readonly />
                                        </div>

                                        <!-- Funcao para exibir dias da ultima visita -->
                                        <?php
                                        if ($dtaUltimaVisita != NULL) {
                                            $diferenca = strtotime(date("Y-m-d")) - strtotime($dtaUltimaVisita);
                                            $diasUltimaVisita = floor($diferenca / (60 * 60 * 24));
                                            $dataUltimaVisita = date("d/m/Y", strtotime($dtaUltimaVisita));
                                        } else {
                                            $dataUltimaVisita = 0;
                                            $diasUltimaVisita = 0;
                                        }
                                        ?>

                                        <div class="form-group  col-md-2 col-sm-6"><label>Ultima Visita</label>
                                            <input title="DATA ULTIMA VISITA" value="<?php echo $dataUltimaVisita ?> - <?php echo $diasUltimaVisita; ?> dia(s)" readonly="readonly" class="form-control" readonly />
                                        </div>

                                        <?php

                                        while ($rowAgendamentos = $sqlAgendamentos->fetch(PDO::FETCH_OBJ)) {
                                                $codigoAgendamento = $rowAgendamentos->num_id_age;
                                                $idPaciente = $rowAgendamentos->tbl_paciente_pac_num_id_pac;        

                                                $sqlItensAgendamentos = $con->prepare("SELECT agendamento.num_id_itage, categoria.txt_nome_cat, procedimento.txt_nome_pro, procedimento.txt_recomendacoes_pro,  
                                                            
                                                    agendamento.tbl_agendamento_age_num_id_age, agendamento.txt_status_itage 

                                                    FROM tbl_item_agendamento_itage agendamento
                                                            
                                                    LEFT JOIN tbl_procedimentos_pro procedimento ON procedimento.num_id_pro = agendamento.tbl_procedimentos_pro_num_id_pro
                                                    LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = agendamento.tbl_categoria_cat_num_id_cat
                                                            
                                                    WHERE tbl_agendamento_age_num_id_age = ?");

                                                        $sqlItensAgendamentos->bindParam(1, $codigoAgendamento);

                                                        if (!$sqlItensAgendamentos->execute()) {
                                                            echo "Error: " . $sqlItensAgendamentos . "<br>" . mysqli_error($con);
                                                        }

                                                        //verifica se nao existem registros na consulta de itens
                                                        if ($sqlItensAgendamentos->rowCount() > 0) {
                                                            
                                                        ?>
                                                        <hr>
                                                        <h4><hr>Existe um agendamento para hoje (<?php echo date("d/m/Y", strtotime($rowAgendamentos->dta_data_age)) ?>) as (<?php echo $rowAgendamentos->hor_hora_age ?>)  com Medico: (<?php echo ucfirst($rowAgendamentos->txt_nome_med) ?>)<hr></h4>
                                                        <div class="form-group col-md-12 col-sm-12">
                                                            <table width="100%" class=" table table-bordered">
                                                                <tr align="center">
                                                                    <th>Procedimento</td>
                                                                    <th>Recomendacoes</td>
                                                                    <th>Categoria</td>
                                                                    <th>Status</td>
                                                                    <th>Opcoes</td>
                                                                </tr>
                                                                <?php while ($rowItensAgendamentos = $sqlItensAgendamentos->fetch(PDO::FETCH_OBJ)) { ?>
                                                                    <tr align="center">
                                                                        <td>
                                                                            <?php echo ucwords($rowItensAgendamentos->txt_nome_pro) ?>
                                                                        </td>
                                                                        <td align="left">
                                                                            <?php echo ucwords($rowItensAgendamentos->txt_recomendacoes_pro) ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo ucwords($rowItensAgendamentos->txt_nome_cat) ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo ucwords($rowItensAgendamentos->txt_status_itage) ?>
                                                                        </td>
                                                                        <td>                                               
                                                                            <a  class="btn btn-outline-success " href="novo-atendimento.php?acao=ag&i=<?php echo base64_encode($rowItensAgendamentos->num_id_itage) ?>">Registrar <?php echo $rowItensAgendamentos->txt_nome_pro?></a>  
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                            
                                        <?php } //fim caso possua registros?>
                                        <tr><td colspan='5'>
                                            <div class="form-row">
                                        <div class="form-group col-md-3 col-sm-12"><label for="numerosolicitacao">Numero Solicitacao</label>
                                            <input name="numerosolicitacao" type="text" class="form-control" id="numerosolicitacao"
                                                value="<?php echo $rowAgendamentos->txt_solicitacao_age ?>" readonly title="NUMERO DA SOLICITACAO" />
                                        </div>

                                        <div class="form-group col-md-9 col-sm-12"><label for="observacoes">Observacoes</label>
                                            <input name="observacoes" type="text" class="form-control" id="observacoes" maxlength="100"
                                                value="<?php echo $rowAgendamentos->txt_observacao_age ?>" readonly title="INFORMACOES GERAIS DO AGENDAMENTO" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="usuarioagendamento">Usuario Agendamento</label>
                                            <input name="usuarioagendamento" type="text" class="form-control" id="numerosolicitacao"
                                            value="<?php echo $rowAgendamentos->txt_login_usu ?>" readonly title="USUARIO DO AGENDAMENTO" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="dataagendamento">Data Agendamento</label>
                                            <input name="dataagendamento" type="text" class="form-control" id="numerosolicitacao"
                                            value="<?php echo date("d/m/Y H:m:s", strtotime($rowAgendamentos->dth_registro_age)) ?>" readonly title="DATA DO AGENDAMENTO" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="usuarioagendamento">Usuario Confirmacao</label>
                                            <input name="usuarioagendamento" type="text" class="form-control" id="numerosolicitacao"
                                            value="<?php echo $rowAgendamentos->usuarioconfirmacao ?>" readonly title="USUARIO DE CONFIRMACAO DO AGENDAMENTO" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="dataagendamento">Data Confirmacao</label>
                                            <input name="dataagendamento" type="text" class="form-control" id="numerosolicitacao"
                                            value="<?php if($rowAgendamentos->dth_confirmacao_age == ""){ }else { echo date("d/m/Y H:m:s", strtotime($rowAgendamentos->dth_confirmacao_age));} ?>" readonly title="DATA DA CONFIRMACAO DO AGENDAMENTO" />
                                        </div>
                                                    </td></tr>
                                        </table>
                                            </div>
                                    </div>
                        <?php     } ?>
        </td>
        </tr>
    </table>
</body>

</html>