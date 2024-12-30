<?php 
session_start(); 
include "conexao.php";

$acao = $_REQUEST['acao'];

if ($acao == "novo") {

    $idPaciente = base64_decode($_GET['paciente']);
    $idAgendamento = base64_decode($_GET['agendamento']);
    $medicoAgenda = base64_decode($_GET['medico']);
    $dataAgenda = base64_decode($_GET['data']);
    $horaAgenda = base64_decode($_GET['hora']);

    if ($idAgendamento == "") {

        //registrando um novo agendamento
        if (($idPaciente == "") || ($medicoAgenda == "") || ($dataAgenda == "") || ($horaAgenda == "")) {
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Problemas na execucao, refaça operacao!\");</script>";

        } else {

            $con->beginTransaction();

            $resAgendamento = $con->prepare("INSERT INTO `tbl_agendamento_age`( `tbl_medico_med_num_id_med`, `tbl_paciente_pac_num_id_pac`, `tbl_usuario_usu_num_id_usu`,`dta_data_age`, `hor_hora_age`,
                                    
                                    `dth_registro_age`, `num_usuario_alteracao_age`, `dth_alteracao_age`, `num_usuario_confirmacao_age`, `dth_confirmacao_age`, `txt_status_age`) 
                                    
                                    VALUES (?,?,?,?,?,now(),0,NULL,0,NULL,'agendado')");

            $resAgendamento->bindParam(1, $medicoAgenda);
            $resAgendamento->bindParam(2, $idPaciente);
            $resAgendamento->bindParam(3, $_SESSION['id_usu']);
            $resAgendamento->bindParam(4, $dataAgenda);
            $resAgendamento->bindParam(5, $horaAgenda);

            if (!$resAgendamento->execute()) {
                echo "Error: " . $resAgendamento . "<br>" . mysqli_error($con);
                $con->rollBack();
            }

            $con->commit();

            //capturando numero do agendamento 
            $sqlNumeroAgendamento = $con->prepare("SELECT num_id_age, medico.txt_nome_med

                                        FROM tbl_agendamento_age agendamento
                                                
                                        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med
                                        
                                        WHERE num_id_age = (select MAX(num_id_age) from tbl_agendamento_age)");

            if (!$sqlNumeroAgendamento->execute()) {
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-pacientes.php'><script type=\"text/javascript\">alert(\"Problemas na execucao, acesse agenda do medico e continue com agendamento!\");</script>";
            } else {
                while ($rowAgendamentoDados = $sqlNumeroAgendamento->fetch(PDO::FETCH_OBJ)) {
                    $codigoAgendamento = $rowAgendamentoDados->num_id_age;
                    $nomeMedico = $rowAgendamentoDados->txt_nome_med;
                }

            }
        }
        ;
        //fim re um novo agendamento

    } else {
        //caso seja um reagendamento
        if (($idPaciente == "") || ($medicoAgenda == "") || ($dataAgenda == "") || ($horaAgenda == "") || ($idAgendamento == "")) {
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Problemas na execucao, refaça operacao!\");</script>";

        } else {
            $con->beginTransaction();

            $resAgendamento = $con->prepare("UPDATE `tbl_agendamento_age` SET `tbl_medico_med_num_id_med`=?, `dta_data_age`=?,`hor_hora_age`=?, 
                                    
                                    `dth_remarcacao_age`=now(),`num_usuario_remarcacao_age`=?, `txt_status_age`='agendado',`num_usuario_confirmacao_age`= null,`dth_confirmacao_age`= null WHERE `num_id_age`= ?");

            $resAgendamento->bindParam(1, $medicoAgenda);
            $resAgendamento->bindParam(2, $dataAgenda);
            $resAgendamento->bindParam(3, $horaAgenda);
            $resAgendamento->bindParam(4, $_SESSION['id_usu']);
            $resAgendamento->bindParam(5, $idAgendamento);

            if (!$resAgendamento->execute()) {
                echo "Error: " . $resAgendamento . "<br>" . mysqli_error($con);
                $con->rollBack();
            }

            $con->commit();

            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-pacientes.php'><script type=\"text/javascript\">alert(\"Paciente reagendado com sucesso!\");</script>";

        }
        //fim reagendamento    
    }



} else if ($acao == "procedimento") {

    //recebe dados via POST
    $codigoAgendamento = filter_input(INPUT_POST, "codigoAgendamento", FILTER_SANITIZE_NUMBER_INT);
    $procedimentoAgendamento = filter_input(INPUT_POST, "procedimento", FILTER_SANITIZE_NUMBER_INT);
    $categoriaAgendamento = filter_input(INPUT_POST, "categoria", FILTER_SANITIZE_NUMBER_INT);

    //verifica campos vazios
    if ($codigoAgendamento == "" || $procedimentoAgendamento == "" || $categoriaAgendamento == "") {
        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Problemas na execucao!\");</script>";
    } else {
        //realiza inclusao do item na tabela itens agendamento
        $resIncluirProcedimento = $con->prepare("INSERT INTO `tbl_item_agendamento_itage`(`tbl_categoria_cat_num_id_cat`, `tbl_procedimentos_pro_num_id_pro`, `tbl_agendamento_age_num_id_age`, `txt_status_itage`) VALUES (?,?,?, 'aguardando')");
        $resIncluirProcedimento->bindParam(1, $categoriaAgendamento);
        $resIncluirProcedimento->bindParam(2, $procedimentoAgendamento);
        $resIncluirProcedimento->bindParam(3, $codigoAgendamento);

        if (!$resIncluirProcedimento->execute()) {
            echo "Error: " . $resIncluirProcedimento . "<br>" . mysqli_error($con);
        }

        //fim inclusao item

        //realizando captura dos dados de agendamento
        $sqlAgendamentos = $con->prepare("SELECT agendamento.num_id_age, agendamento.tbl_paciente_pac_num_id_pac,agendamento.dta_data_age,agendamento.hor_hora_age,agendamento.hor_hora_age,agendamento.txt_status_age,medico.txt_nome_med
                                                        
                        FROM tbl_agendamento_age agendamento
                        
                        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med                                        
                                                                
                        WHERE num_id_age = ? ");

        $sqlAgendamentos->bindParam(1, $codigoAgendamento);

        if (!$sqlAgendamentos->execute()) {
            echo "Error: " . $sqlAgendamentos . "<br>" . mysqli_error($con);
        }

        while ($rowAgendamentos = $sqlAgendamentos->fetch(PDO::FETCH_OBJ)) {
            $codigoAgendamento = $rowAgendamentos->num_id_age;
            $idPaciente = $rowAgendamentos->tbl_paciente_pac_num_id_pac;
            $nomeMedico = ucwords($rowAgendamentos->txt_nome_med);
            $dataAgenda = $rowAgendamentos->dta_data_age;
            $horaAgenda = $rowAgendamentos->hor_hora_age;
        }


        //fim captura dados

    }
} else if ($acao == "excluiritem") {

    $codigoAgendamento = $_GET['codigoagendamento'];

    //realizando captura dos dados de agendamento
    $sqlAgendamentos = $con->prepare("SELECT agendamento.num_id_age, agendamento.tbl_paciente_pac_num_id_pac,agendamento.dta_data_age,agendamento.hor_hora_age,agendamento.hor_hora_age,agendamento.txt_status_age,medico.txt_nome_med
                                                        
        FROM tbl_agendamento_age agendamento
        
        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med                                        
                                                
        WHERE num_id_age = ? ");

    $sqlAgendamentos->bindParam(1, $codigoAgendamento);

    if (!$sqlAgendamentos->execute()) {
        echo "Error: " . $sqlAgendamentos . "<br>" . mysqli_error($con);
    }

    while ($rowAgendamentos = $sqlAgendamentos->fetch(PDO::FETCH_OBJ)) {
        $codigoAgendamento = $rowAgendamentos->num_id_age;
        $idPaciente = $rowAgendamentos->tbl_paciente_pac_num_id_pac;
        $nomeMedico = ucwords($rowAgendamentos->txt_nome_med);
        $dataAgenda = $rowAgendamentos->dta_data_age;
        $horaAgenda = $rowAgendamentos->hor_hora_age;

    }
    //fim captura dados
}

/*capturar detalhes do paciente*/

$resPaciente = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, paciente.txt_nome_pac, paciente.dta_ultima_visita_pac, paciente.dta_datanascimento_pac, paciente.txt_ativo_pac 
            
            FROM tbl_paciente_pac paciente
            
            LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
            LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat  
            
            WHERE num_id_pac = ? AND paciente.txt_ativo_pac = 'sim'");

$resPaciente->bindParam(1, $idPaciente);
$resPaciente->execute();

//caso nao encontre paciente
if ($resPaciente->rowCount() <= 0) {
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Favor realizar operacao novamente!\");</script>";
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

        //calculo ultima visita
        if($rowPaciente->dta_ultima_visita_pac != NULL){
            $diferenca =  strtotime(date("Y-m-d")) - strtotime($rowPaciente->dta_ultima_visita_pac);
            $diasUltimaVisita = floor($diferenca / (60 * 60 * 24));  
            $dataUltimaVisita =  date("d/m/Y", strtotime($rowPaciente->dta_ultima_visita_pac));                                                 
        }else{
            $dataUltimaVisita = 0;
            $diasUltimaVisita = 0;
        }
        //fim calculo
    }
}
/*fim detalhes paciente */

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
    <?php include 'inicial.php'?>
                    <div class="container col-md-12">			
                        <div class="card">
                            <div class="card-header"><h3>Paciente: <?php echo ucwords($txtNomePaciente) ?> - Data: <?php echo date("d/m/Y", strtotime($dataAgenda)) ?> - Hora: <?php echo $horaAgenda ?> - Medico: <?php echo ucfirst($nomeMedico) ?></h3></div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4 col-sm-6"><label>Nome e Idade</label>
                                        <input title="NOME DO PACIENTE" value="<?php echo ucwords($txtNomePaciente) ?>  - <?php echo $interval->format( '%Y anos e %m mes(es)' ) ?>"
                                            readonly="readonly" class="form-control" readonly />
                                    </div>

                                    <div class="form-group col-md-4 col-sm-6"><label>Medico</label>
                                        <input title="MEDICO DO PACIENTE" value="<?php echo ucwords($txtNomeMedico) ?>"
                                            readonly="readonly" class="form-control" readonly />
                                    </div>

                                    <div class="form-group  col-md-2 col-sm-6"><label>Tipo</label>
                                        <input title="CATEGORIA DO PACIENTE" value="<?php echo ucwords($txtNomeCategoria) ?>"
                                            readonly="readonly" class="form-control" readonly />
                                    </div>

                                    <div class="form-group  col-md-2 col-sm-6"><label>Ultima Visita</label>
                                        <input title="DATA ULTIMA VISITA" value="<?php echo $dataUltimaVisita ?> - <?php echo $diasUltimaVisita; ?> dia(s)" readonly="readonly" class="form-control" readonly /></div> 

                                    <div class="form-group  col-md-12 col-sm-6"></div><!-- linha para organizar formulario -->
                                </div>

                                <?php
                                $sqlItensAgendamentos = $con->prepare("SELECT agendamento.num_id_itage, categoria.txt_nome_cat, procedimento.txt_nome_pro, procedimento.txt_recomendacoes_pro,  agendamento.tbl_agendamento_age_num_id_age 

                                                                FROM tbl_item_agendamento_itage agendamento
                                                                
                                                                LEFT JOIN tbl_procedimentos_pro procedimento ON procedimento.num_id_pro = agendamento.tbl_procedimentos_pro_num_id_pro
                                                                LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = agendamento.tbl_categoria_cat_num_id_cat
                                                                
                                                                WHERE tbl_agendamento_age_num_id_age = ?");

                                $sqlItensAgendamentos->bindParam(1, $codigoAgendamento);

                                if (!$sqlItensAgendamentos->execute()) {
                                    echo "Error: " . $sqlItensAgendamentos . "<br>" . mysqli_error($con);
                                }
                                ?>
                                
                                    
                                    <div class="form-group col-md-12 col-sm-12">
                                        <!--incluir itens no agendamento-->
                                        <HR>
                                            <fieldset>
                                                <Legend>Incluir Procedimento</Legend>
                                                    <form name="procedimentos" method="post" action="">
                                                            <input type="hidden" name="codigoAgendamento" value="<?php echo $codigoAgendamento ?>" />
                                                            <input type="hidden" name="acao" value="procedimento" />
                                                            <div class="form-row">
                                                                <div class="form-group col-md-3 col-sm-12">
                                                                    <select name="procedimento" class="form-control"title="SELECIONE PROCEDIMENTO PARA AGENDAMENTO">
                                                                        <?php
                                                                        include "conexao.php";
                                                                        $resProcedimento = $con->prepare("SELECT num_id_pro, txt_nome_pro FROM tbl_procedimentos_pro WHERE txt_ativo_pro = 'sim' order by txt_nome_pro");
                                                                        $resProcedimento->execute();

                                                                        while ($rowProcedimento = $resProcedimento->fetch(PDO::FETCH_OBJ)) { ?>
                                                                            <option value="<?php echo $rowProcedimento->num_id_pro ?>"><?php echo $rowProcedimento->txt_nome_pro ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-md-3 col-sm-12">
                                                                    <select name="categoria"  class="form-control"title="SELECIONE CATEGORIA PARA AGENDAMENTO">
                                                                        <?php
                                                                        include "conexao.php";
                                                                        $resCategoria = $con->prepare("SELECT num_id_cat, txt_nome_cat FROM tbl_categoria_cat WHERE txt_ativo_cat = 'sim' order by txt_nome_cat");
                                                                        $resCategoria->execute();

                                                                        while ($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)) { ?>
                                                                            <option value="<?php echo $rowCategoria->num_id_cat ?>"><?php echo $rowCategoria->txt_nome_cat ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>                                                                

                                                                <div class="form-group col-md-3 col-sm-2"><label for="categoria"></label>
                                                                    <input type="submit" class="btn btn-outline-primary" name="button" value="Incluir Procedimento" />
                                                                </div>
                                                            </div>
                                                    </form>
                                            </fieldset>
                                        
                                        <!--Fim incluir itens no agendamento-->

                                        <!--Exibir itens no agendamento-->
                                           
                                            <fieldset>
                                <?php
                                //verifica se nao existem registros na consulta de itens
                                if ($sqlItensAgendamentos->rowCount() > 0) {
                                ?>               
                                                    <table class="table-hover table table-bordered  responsive">
                                                        <tr class="thead-dark" align="center">
                                                            <th>Procedimento</td>
                                                            <th>Recomendacoes</td>
                                                            <th>Categoria</td>
                                                            <th>Opcoes</td>
                                                        </tr>
                                                        <?php while ($rowItensAgendamentos = $sqlItensAgendamentos->fetch(PDO::FETCH_OBJ)) { ?>
                                                            <tr align="center">
                                                                <td align="left">
                                                                    <?php echo ucwords($rowItensAgendamentos->txt_nome_pro) ?>
                                                                </td>
                                                                <td align="left">
                                                                    <?php echo ucwords(utf8_encode($rowItensAgendamentos->txt_recomendacoes_pro)) ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo ucwords($rowItensAgendamentos->txt_nome_cat) ?>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group dropleft">
                                                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">Opcoes</button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item"
                                                                                href="processa-agendamento.php?acao=excluiritem&i=<?php echo base64_encode($rowItensAgendamentos->num_id_itage) ?>&c=<?php echo base64_encode($codigoAgendamento) ?>">Excluir</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                            </fieldset>
                                        <!--Fim exibir itens no agendamento-->    
                                    
                                    <?php } //fim caso possua registros?>
                                        <!--fim agendamentos Paciente-->
                                        <HR>
                                        <fieldset>
                                            <Legend>Informacoes Adcionais</Legend>
                                                <form name="dados_gerais" action="processa-agendamento.php?acao=dadosgerais&c=<?php echo base64_encode($codigoAgendamento) ?>" method="post">
                                                    <div class="form-row">
                                                        
                                                        <div class="form-group col-md-2 col-sm-12"><label for="numerosolicitacao">Numero Solicitacao</label>
                                                            <input name="numerosolicitacao" type="text" class="form-control" title="INFORME NUMERO DA SOLICITACAO" />
                                                        </div>

                                                        <div class="form-group col-md-10 col-sm-12"><label for="observacoes">Observacoes</label>
                                                            <input name="observacoes" type="text" class="form-control" id="observacoes" maxlength="100" title="INFORMACOES GERAIS DO AGENDAMENTO" />
                                                        </div>

                                                        <div class="form-group col-md-12 col-sm-12">
                                                            <a href="processa-agendamento.php?acao=cancelar&c=<?php echo base64_encode($codigoAgendamento) ?>"class="btn btn-outline-danger ">Cancelar Agendamento</a>
                                                            <input type="submit" class="btn btn-outline-success" name="button" id="button" value="Salvar Agendamento" />
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </fieldset>
                                    </div>
                            </div>
                        </div>
                    </div>


</body>

</html>
<?php

?>