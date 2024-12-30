<?php 
		
	include "conexao.php";
	
        
        $idPaciente = base64_decode($_GET['p']);
        $medicoAgenda = base64_decode($_GET['m']);	
        $dataAgenda = base64_decode($_GET['d']);
        $nomeMedico = base64_decode($_GET['nm']);
        $idAgendamento = base64_decode($_GET['ag']);
        
        /*capturar detalhes do paciente*/
	
            $resPaciente = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, paciente.txt_nome_pac, paciente.dta_datanascimento_pac, 
            
            paciente.dta_ultima_visita_pac, paciente.txt_ativo_pac 
            
            FROM tbl_paciente_pac paciente
            
            LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
            LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat  
            
            WHERE num_id_pac = ? AND paciente.txt_ativo_pac = 'sim'");
                
            $resPaciente->bindParam(1,$idPaciente);
            $resPaciente->execute();

                //caso encontre paciente
                if($resPaciente->rowCount()<=0){	
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Favor realizar operacao novamente!\");</script>";
                    echo "<script language='javascript'>history.back()</script>";

                }else{            
                    
                    while ($rowPaciente = $resPaciente->fetch(PDO::FETCH_OBJ)){
                        $numIdPaciente = $rowPaciente->num_id_pac;
                        $txtNomePaciente = $rowPaciente->txt_nome_pac;
                        $txtNomeMedico = $rowPaciente->txt_nome_med;
                        $txtNomeCategoria = $rowPaciente->txt_nome_cat;
                        
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
        /*fim detalhes paciente   			*/                        
        
?>	
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <body>
            <?php include "inicial.php"?>
                    <div class="container col-md-12">			
                        <div class="card">
                            <div class="card-header"><h3>Paciente: <?php echo ucwords($txtNomePaciente) ?> - Data: <?php echo date("d/m/Y", strtotime($dataAgenda)) ?> - Medico: <?php echo ucfirst($nomeMedico) ?></h3></div>
                            <div class="card-body">
                                <div class="form-row"> 
                                <!-- campos que identificam a os na inserçãp-->                  
                                    <input type="hidden" name="idPaciente" id="idPaciente" value="<?php echo $numIdPaciente ?>" />

                                <!--fim campos -->
                                   
                        <!-- FIM --> 
                        <!-- Exibicao da Agenda do dia -->
                        <?php

                        //echo ' <hr><Legend>Selecione o Horario</legend>';
                        
                        $medicoAgenda = $medicoAgenda;	
                        $dataAgenda = $dataAgenda;

                        //funcao para capturar o dia da semana na data
                            function diaDaSemana($data) {
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

                        $resAgendaDia->bindParam(1,$dataDiaSemana);
                        $resAgendaDia->bindParam(2,$medicoAgenda);

                        $resAgendaDia->execute();

                        if($resAgendaDia->rowCount()<=0){
                            echo "pesquisa agenda errada";

                        }else{                        
                            

                                    //atribui as informacoes da agenda em variaveis             
                                    while ($rowAgendaDia = $resAgendaDia->fetch(PDO::FETCH_OBJ)){
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
                                                    <table class="table-hover table table-bordered  responsive">
                                                    <tr class="thead-dark" align="center">
                                                        <th>Hora</th>
                                                        <th>Paciente</th>
                                                        <th>Telefone</th>
                                                        <th>Detalhes</th>
                                                        <th>Usuario</th>                                    
                                                    </tr>'
                                            ; 

                                            //while que varre todos os horarios do dia, com base na duracao do agendamento para montar a tela de visualizacao
                                            while($horaInicial < $horaFinal){                        

                                                    //conversao de Datetime para string para poder funcionar as comparacoes e sql
                                                    $hora = $horaInicial->format("H:i:s");                                 

                                                            //caso nao seja intervalo, ele faz a pesquisa no horario para verificar se possui agendamento paciente, telefone, categoria, usuario, 
                                                            $sqlVagas = $con->prepare("SELECT agendamento.hor_hora_age, agendamento.num_id_age, paciente.txt_nome_pac, paciente.txt_telefone_pac, usuario.txt_login_usu, agendamento.txt_observacao_age

                                                                FROM tbl_agendamento_age agendamento 
                                                                
                                                                LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac
                                                                LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu
                                                                
                                                                WHERE agendamento.tbl_medico_med_num_id_med = ? AND dta_data_age = ? AND hor_hora_age =? ");
                                                                
                                                                $sqlVagas->bindParam(1,$medicoAgenda);
                                                                $sqlVagas->bindParam(2,$dataAgenda);
                                                                $sqlVagas->bindParam(3,$hora);                    
                                                                
                                                                $sqlVagas->Execute();                                                    

                                                                //caso nao encontre registro na pesquisa, ele informa que o horario esta disponivel
                                                                if($sqlVagas->rowCount()==0){	                                        
                                                                    echo '<tr><td><a title="CLIQUE PARA AGENDAR ESTE HORARIO" href="agendamento-dados.php?acao=novo&agendamento='.base64_encode($idAgendamento).'&paciente='.base64_encode($idPaciente).'&medico='.base64_encode($medicoAgenda).'&data='.base64_encode($dataAgenda).'&hora='.base64_encode($hora).'">'.$hora.'</a></td><td  colspan="4">DISPONIVEL</td></tr>';

                                                                }else{

                                                                    while ($rowVagas = $sqlVagas->fetch(PDO::FETCH_OBJ)){
                                                                                                                                        
                                                                    //caso contrario ele mostra as informacoes do agendamento
                                                                    //capturar nomes de procedimentos
                                                                        $protocoloAgendamento = $rowVagas->num_id_age;

                                                                        $sqlDadosAgendamento = $con->prepare("SELECT agendamento.tbl_agendamento_age_num_id_age,  procedimento.txt_nome_pro, categoria.txt_nome_cat

                                                                        FROM tbl_item_agendamento_itage as agendamento 
                                                                                                                                                                                                   
                                                                        LEFT JOIN tbl_procedimentos_pro procedimento ON procedimento.num_id_pro = agendamento.tbl_procedimentos_pro_num_id_pro
                                                                        
                                                                        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = agendamento.tbl_categoria_cat_num_id_cat
                                                                                                                                       
                                                                        WHERE agendamento.tbl_agendamento_age_num_id_age = ?");

                                                                        $sqlDadosAgendamento->bindParam(1,$protocoloAgendamento);

                                                                        $sqlDadosAgendamento->execute();
                                                                        
                                                                        $resultString = "";                                                                        
                                                                        
                                                                        while($rowDadosAgendamento = $sqlDadosAgendamento->fetch(PDO::FETCH_OBJ)){
                                                                            $resultString .= 'Procedimento: '.$rowDadosAgendamento->txt_nome_pro;
                                                                            $resultString .= ' - Categoria: '.$rowDadosAgendamento->txt_nome_cat.'<br>';
                                                                        }

                                                                        $resultString .= 'Observacoes: '.ucwords($rowVagas->txt_observacao_age); 
                                                                        
                                                                            echo '<tr><td>'.$rowVagas->hor_hora_age.'</td>';
                                                                            echo '<td>'.ucwords ($rowVagas->txt_nome_pac).'</td>';
                                                                            echo '<td>'.$rowVagas->txt_telefone_pac.'</td>';
                                                                            echo '<td>'.ucwords($resultString).'</td>';
                                                                            echo '<td>'.ucwords ($rowVagas->txt_login_usu);'</td></tr>';                                             
                                                                        }
                                                                }                                                

                                                    //adciona o tempo de duracao do atendimento para proxima pesquisa na agenda        
                                                    $horaInicial->modify('+ '.$numDuracaoAtendimento.'minutes');
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
