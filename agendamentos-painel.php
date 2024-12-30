<?php include 'verifica.php';

include "conexao.php";


$medicoAgenda = base64_decode($_GET['m']);
$dataAgenda = base64_decode($_GET['d']);
$nomeMedico = base64_decode($_GET['nm']);

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>

    <form name="listagem" method="post" action="#">
        <table class="table">
            <tr>
                <td>
                    <?php include "inicial.php" ?>
                </td>
            </tr>
            <tr>
                <td>
                    <legend class="p-4 table-primary">Agendamento Data:
                        <?php echo date("d/m/Y", strtotime($dataAgenda)) ?> - Medico:
                        <?php echo ucfirst($nomeMedico) ?>
                        <legend>
                </td>
            </tr>
            <tr>
                <td>

                    <!-- Exibicao da Agenda do dia -->
                    <?php

                    $medicoAgenda = $medicoAgenda;
                    $dataAgenda = $dataAgenda;

                    //funcao para capturar o dia da semana na data
                    function diaDaSemana($data)
                    {
                        $dataObj = new DateTime($data);
                        $diaDaSemana = $dataObj->format('N');
                        $nomesDias = [
                            1 => 'Segunda-feira',
                            2 => 'Terca-feira',
                            3 => 'Quarta-feira',
                            4 => 'Quinta-feira',
                            5 => 'Sexta-feira',
                            6 => 'Sabado',
                            7 => 'Domingo'
                        ];
                        return $nomesDias[$diaDaSemana];
                    }
                    //fim funcao
                    
                    //consulta para capturar informacoes da agenda na data
                    $dataDiaSemana = diaDaSemana($dataAgenda);

                    $resAgendaDia = $con->prepare("SELECT * FROM tbl_agenda_agen WHERE txt_dia_semana_agen = ? AND txt_status_agen = 'ativo' AND tbl_medico_med_num_id_med = ?");

                    $resAgendaDia->bindParam(1, $dataDiaSemana);
                    $resAgendaDia->bindParam(2, $medicoAgenda);

                    $resAgendaDia->execute();

                    if ($resAgendaDia->rowCount() <= 0) {
                        echo "pesquisa agenda errada";

                    } else {


                        //atribui as informacoes da agenda em variaveis             
                        while ($rowAgendaDia = $resAgendaDia->fetch(PDO::FETCH_OBJ)) {
                            $horaInicial = $rowAgendaDia->hor_inicio_agen;
                            $horaFinal = $rowAgendaDia->hor_final_agen;
                            $qtdAgenda = $rowAgendaDia->num_quantidade_agen;
                            //echo$numDuracao = $rowAgendaDia->num_duracao_agen;
                            $numDuracaoAtendimento = $rowAgendaDia->num_duracao_atendimento_agen;

                            //converte as strings em objeto Datetime para poder realizar a funcao while
                            $horaInicial = new DateTime($horaInicial);
                            $horaFinal = new DateTime($horaFinal);

                            //Inicio da tabela
                            echo '  <!--<div class="form-group col-md-12 col-sm-6"> -->
                                                    <table width="100%" class=" table table-hover table-bordered table-striped" border="1">                        
                                                        <tr align="center">
                                                            <th>Codigo</td>
                                                            <th>Hora</td>
                                                            <th>Paciente</td>
                                                            <th>Telefone</td>
                                                            <th>Detalhes</td>
                                                            <th>Agendamento</td> 
                                                            <th>Remarcacao</td> 
                                                            <th>Confirmacao</td> 
                                                            <th>Opcoes</td>                                   
                                                        </tr>'
                            ;

                            //while que varre todos os horarios do dia, com base na duracao do agendamento para montar a tela de visualizacao
                            while ($horaInicial < $horaFinal) {

                                //conversao de Datetime para string para poder funcionar as comparacoes e sql
                                $hora = $horaInicial->format("H:i:s");

                                //caso nao seja intervalo, ele faz a pesquisa no horario para verificar se possui agendamento paciente, telefone, categoria, usuario, 
                                $sqlVagas = $con->prepare("SELECT agendamento.hor_hora_age, agendamento.num_id_age,agendamento.tbl_paciente_pac_num_id_pac, paciente.txt_nome_pac, paciente.txt_telefone_pac, 
                                                            
                                                            usuario.txt_login_usu, agendamento.txt_observacao_age, agendamento.txt_status_age, usuarioconfirmacao.txt_login_usu as usuarioconfirmacao,usuarioremarcacao.txt_login_usu as usuarioremarcacao,
                                                            
                                                            agendamento.dth_registro_age, agendamento.dth_confirmacao_age, agendamento.dth_remarcacao_age
                                                            
                                                            FROM tbl_agendamento_age as agendamento 
                                                                                                                                                                                        
                                                            LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac
                                                            
                                                            LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu
                                                            
                                                            LEFT JOIN tbl_usuario_usu usuarioconfirmacao ON usuarioconfirmacao.num_id_usu = agendamento.num_usuario_confirmacao_age
                                                            
                                                            LEFT JOIN tbl_usuario_usu usuarioremarcacao ON usuarioremarcacao.num_id_usu = agendamento.num_usuario_remarcacao_age

                                                            WHERE agendamento.tbl_medico_med_num_id_med = ? AND dta_data_age = ? AND hor_hora_age = ? ");

                                $sqlVagas->bindParam(1, $medicoAgenda);
                                $sqlVagas->bindParam(2, $dataAgenda);
                                $sqlVagas->bindParam(3, $hora);

                                $sqlVagas->Execute();

                                //caso nao encontre registro na pesquisa, ele informa que o horario esta disponivel
                                if ($sqlVagas->rowCount() == 0) {
                                    echo '<tr><td>' . $hora . '</a></td><td  colspan="8">DISPONIVEL</td></tr>';

                                } else {

                                    $dataHoraConfirmacao = "";

                                    //caso contrario ele mostra as informacoes do agendamento
                                    while ($rowVagas = $sqlVagas->fetch(PDO::FETCH_OBJ)) {

                                        //capturar nomes de procedimentos
                                        $protocoloAgendamento = $rowVagas->num_id_age;
                                        $pacienteAgendamento = $rowVagas->tbl_paciente_pac_num_id_pac;

                                        $sqlDadosAgendamento = $con->prepare("SELECT agendamento.tbl_agendamento_age_num_id_age,  procedimento.txt_nome_pro, categoria.txt_nome_cat

                                                                        FROM tbl_item_agendamento_itage as agendamento 
                                                                                                                                                                                                   
                                                                        LEFT JOIN tbl_procedimentos_pro procedimento ON procedimento.num_id_pro = agendamento.tbl_procedimentos_pro_num_id_pro
                                                                        
                                                                        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = agendamento.tbl_categoria_cat_num_id_cat
                                                                                                                                       
                                                                        WHERE agendamento.tbl_agendamento_age_num_id_age = ?");

                                        $sqlDadosAgendamento->bindParam(1, $protocoloAgendamento);

                                        $sqlDadosAgendamento->execute();

                                        $resultString = "";

                                        while ($rowDadosAgendamento = $sqlDadosAgendamento->fetch(PDO::FETCH_OBJ)) {
                                            $resultString .= $rowDadosAgendamento->txt_nome_pro;
                                            $resultString .= ' - ' . $rowDadosAgendamento->txt_nome_cat . '<br>';
                                        }

                                        if ($rowVagas->dth_confirmacao_age != "") {
                                            $dataHoraConfirmacao = date("d/m/Y H:i", strtotime($rowVagas->dth_confirmacao_age));
                                        }

                                        if ($rowVagas->dth_remarcacao_age != "") {
                                            $dataHoraRemarcacao = date("d/m/Y H:i", strtotime($rowVagas->dth_remarcacao_age));
                                        }

                                        $resultString .= 'Observacoes: ' . ucwords($rowVagas->txt_observacao_age);

                                        //exibicao dos dados em tabela
                                        echo '<tr align="center"><td>' . $rowVagas->num_id_age . '</td>';
                                        echo '<td>' . $rowVagas->hor_hora_age . '</td>';
                                        echo '<td align="left">' . ucwords($rowVagas->txt_nome_pac) . '</td>';
                                        echo '<td>' . $rowVagas->txt_telefone_pac . '</td>';
                                        echo '<td align="left">' . ucwords($resultString) . '</td>';
                                        echo '<td>' . ucwords($rowVagas->txt_login_usu) . '<br>' . date("d/m/Y H:i", strtotime($rowVagas->dth_registro_age)) . '</td>';
                                        echo '<td>' . ucwords($rowVagas->usuarioremarcacao) . '<br>' . $dataHoraRemarcacao . '</td>';
                                        echo '<td>' . ucwords($rowVagas->usuarioconfirmacao) . '<br>' . $dataHoraConfirmacao . '</td>';
                                        echo '<td>
                                                                                    <div class="btn-group dropleft">
                                                                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                            <a class="dropdown-item" href="agendamento-detalhes.php?acao=detalhes&agendamento=' . base64_encode($protocoloAgendamento) . ' "target="_blank">Detalhes</a>
                                                                                            <a class="dropdown-item" href="agendamento.php?idPaciente=' . base64_encode($pacienteAgendamento) . '&agendamento=' . base64_encode($protocoloAgendamento) . ' "target="_blank"">Reagendar</a>';
                                        if ($rowVagas->txt_status_age == "agendado") {
                                            echo '<a class="dropdown-item" href="processa-agendamento.php?acao=confirmar&c=' . base64_encode($protocoloAgendamento) . '&m=' . base64_encode($medicoAgenda) . '&d=' . base64_encode($dataAgenda) . '&nm=' . base64_encode($nomeMedico) . '">Confirmar</a>';
                                        }
                                        echo '</div></div>';
                                        echo '</td></tr>';
                                    }
                                }

                                //adciona o tempo de duracao do atendimento para proxima pesquisa na agenda        
                                $horaInicial->modify('+ ' . $numDuracaoAtendimento . 'minutes');
                            }
                            echo '</table>';

                        }
                    }

                    ?>
                    <!-- fim exibicao agenda do dia -->
                </td>
            </tr>
</body>

</html>
<?php

?>