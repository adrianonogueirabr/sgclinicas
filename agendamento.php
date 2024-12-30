<?php 

	include "conexao.php";           

        $idPaciente = base64_decode($_GET['idPaciente']);
        $idAgendamento = base64_decode($_GET['agendamento']);
        $medico = $_POST['medico'];

        //verificar se a data informada é inferior a data atual, para nao permitir agendamentos retroativos
        if($_POST['datainicial'] < date('Y-m-d')){
            $dataInicial = date('Y-m-d');
        }else{
            $dataInicial = $_POST['datainicial'];
        }
                        
        $dataFinal = $_POST['datafinal'];   
	
        $resAgendar = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, paciente.txt_nome_pac, paciente.dta_datanascimento_pac,paciente.dta_ultima_visita_pac, paciente.txt_ativo_pac 
        
        FROM tbl_paciente_pac paciente
        
        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat  
        
        WHERE num_id_pac = ? AND paciente.txt_ativo_pac = 'sim'");
            
        $resAgendar->bindParam(1,$idPaciente);
        $resAgendar->execute();

        //caso encontre paciente
        if($resAgendar->rowCount()<=0){	
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Favor realizar operacao novamente!\");</script>";
            echo "<script language='javascript'>history.back()</script>";

        }else{
        
?>	
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <body>
            <?php include "inicial.php"?>
            <div class="container col-md-12">			
				<div class="card">
					<div class="card-header"><h3>Agendamento</h3></div>
					<div class="card-body">
						<div class="form-row">   
                                <?php
                                    while ($rowAgendar = $resAgendar->fetch(PDO::FETCH_OBJ)){
                                    //calculo idade do paciente
                                        $dataNascimento = $rowAgendar->dta_datanascimento_pac; 
                                        $date = new DateTime($dataNascimento ); 
                                        $interval = $date->diff( new DateTime( date('Y-m-d') ) ); 
                                    //fim calculo idade

                                    //calculo ultima visita
                                        if($rowAgendar->dta_ultima_visita_pac != NULL){
                                            $diferenca =  strtotime(date("Y-m-d")) - strtotime($rowAgendar->dta_ultima_visita_pac);
                                            $diasUltimaVisita = floor($diferenca / (60 * 60 * 24));  
                                            $dataUltimaVisita =  date("d/m/Y", strtotime($rowAgendar->dta_ultima_visita_pac));                                                 
                                        }else{
                                        $dataUltimaVisita = 0;
                                        $diasUltimaVisita = 0;
                                        }
                                    //fim calculo
                                ?>
                                    <!-- campos que identificam a os na inserçãp-->                  
                                    <input type="hidden" name="idPaciente" id="idPaciente" value="<?php echo $rowAgendar->num_id_pac ?>" />                  
                                    <!--fim campos -->

                                        <div class="form-row">

                                            <div class="form-group col-md-4 col-sm-6"><label>Nome e Idade</label>
                                            <input title="NOME DO PACIENTE" value="<?php echo ucwords($rowAgendar->txt_nome_pac) ?> - <?php echo $interval->format( '%Y anos e %m mes(es)' ) ?>" readonly="readonly" class="form-control" readonly /> </div> 
                                            
                                            <div class="form-group col-md-4 col-sm-6"><label>Medico</label>
                                            <input title="MEDICO DO PACIENTE" value="<?php echo ucwords($rowAgendar->txt_nome_med) ?>" readonly="readonly" class="form-control" readonly /> </div> 

                                            <div class="form-group  col-md-2 col-sm-6"><label>Tipo</label>
                                            <input title="CATEGORIA DO PACIENTE" value="<?php echo ucwords($rowAgendar->txt_nome_cat) ?>" readonly="readonly" class="form-control" readonly /></div> 

                                            <div class="form-group  col-md-2 col-sm-6"><label>Ultima Visita</label>
                                            <input title="DATA ULTIMA VISITA" value="<?php echo $dataUltimaVisita ?> - <?php echo $diasUltimaVisita; ?> dia(s)" readonly="readonly" class="form-control" readonly /></div>                                     
                                            
                                            <div class="form-group  col-md-12 col-sm-6"></div><!-- linha para organizar formulario -->
                                            <!-- FIM -->
                                        
                                <?php } ?>              
                                
                                            <!--Historico de agendamentos Paciente-->
                                                <?php                                    
                                                    $sqlAgendamentosPaciente = $con->prepare("SELECT agendamento.num_id_age,agendamento.dta_data_age,agendamento.hor_hora_age,agendamento.txt_status_age,medico.txt_nome_med
                                                        
                                                        FROM tbl_agendamento_age agendamento
                                                        
                                                        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med                                        
                                                                                                
                                                        WHERE tbl_paciente_pac_num_id_pac = ? ORDER BY dta_data_age DESC limit 5");

                                                    $sqlAgendamentosPaciente->bindParam(1,$idPaciente);
                                                    $sqlAgendamentosPaciente->execute();
                                                ?>                                    
                                                    <div class="form-group col-md-6 col-sm-6">                                 
                                                        <div class="card">
                                                            <div class="card-header"><Legend>Historico de Agendamento</legend></div>
                                                                <div class="card-body">
                                                                    <?php 
                                                                        if($sqlAgendamentosPaciente->rowCount()<=0){
                                                                                echo "Sem histórico de Atendimento!";
                                                                        }else{
                                                                    ?> 
                                                                        <table width="100%" class=" table-sm table-striped table-bordered">                        
                                                                            <tr align="center">
                                                                                        <th>ID</td>
                                                                                        <th>Medico</td>
                                                                                        <th>Data</td>
                                                                                        <th>Hora</td> 
                                                                                        <th>Status</td>                                     
                                                                            </tr>                                           
                                                                            <?php while($rowAgendamentosPaciente = $sqlAgendamentosPaciente->fetch(PDO::FETCH_OBJ)){ ?>
                                                                            <tr align="center">                                                  
                                                                                        <td><?php echo $rowAgendamentosPaciente->num_id_age ?></td>
                                                                                        <td><?php echo ucwords($rowAgendamentosPaciente->txt_nome_med) ?></td> 
                                                                                        <td><?php echo date("d/m/Y", strtotime($rowAgendamentosPaciente->dta_data_age)) ?></td>
                                                                                        <td><?php echo $rowAgendamentosPaciente->hor_hora_age ?></td>
                                                                                        <td><?php echo ucwords($rowAgendamentosPaciente->txt_status_age) ?></td>                                                                                                                                                           
                                                                            </tr>
                                                                            <?php }  ?> 
                                                                        </table>
                                                                    <?php }  ?> 
                                                                </div>
                                                        </div>
                                                    </div>                                          
                                            <!--fim agendamentos Paciente-->
                                            
                                            <!--Historico de atendimentos Paciente-->
                                                <?php
                                                    //historico de pacientes
                                                    $sqlHistoricoPaciente = $con->prepare("SELECT atendimento.num_id_aten,atendimento.tbl_paciente_pac_num_id_pac,atendimento.dth_registro_aten,medico.txt_nome_med,procedimentos.txt_nome_pro,categoria.txt_nome_cat 
                                                        
                                                        FROM tbl_atendimento_aten atendimento
                                                        
                                                        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = atendimento.tbl_medico_med_num_id_med
                                                        LEFT JOIN tbl_procedimentos_pro procedimentos ON procedimentos.num_id_pro = atendimento.tbl_procedimentos_pro_num_id_pro
                                                        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = atendimento.tbl_categoria_cat_num_id_cat
                                                        
                                                        WHERE tbl_paciente_pac_num_id_pac = ? ORDER BY dth_registro_aten DESC limit 5");

                                                    $sqlHistoricoPaciente->bindParam(1,$idPaciente);
                                                    $sqlHistoricoPaciente->execute();
                                                ?>                                                                       
                                                <div class="form-group col-md-6 col-sm-6"> 
                                                    <div class="card">
                                                        <div class="card-header"><Legend>Historico de Atendimento</legend></div>
                                                            <div class="card-body">
                                                                <?php 
                                                                    if($sqlHistoricoPaciente->rowCount()<=0){
                                                                            echo "Sem histórico de Atendimento!";
                                                                    }else{
                                                                ?>
                                                                        <table width="100%" class=" table-sm table-striped table-bordered">                        
                                                                            <tr align="center">
                                                                                        <th>ID</td>
                                                                                        <th>Categoria</td> 
                                                                                        <th>Medico</td>
                                                                                        <th>Procedimento</td>                   
                                                                                        <th>Data</td>                                                   
                                                                            </tr>                                           
                                                                            <?php while($rowHistoricoPaciente = $sqlHistoricoPaciente->fetch(PDO::FETCH_OBJ)){ ?>
                                                                            <tr align="center">                                                  
                                                                                        <td><?php echo $rowHistoricoPaciente->num_id_aten ?></td>
                                                                                        <td><?php echo ucwords($rowHistoricoPaciente->txt_nome_cat) ?></td>
                                                                                        <td><?php echo ucwords($rowHistoricoPaciente->txt_nome_med) ?></td>
                                                                                        <td><?php echo ucwords($rowHistoricoPaciente->txt_nome_pro) ?></td>
                                                                                        <td><?php echo date("d/m/Y H:i:s", strtotime($rowHistoricoPaciente->dth_registro_aten)) ?></td>                                            
                                                                            </tr>
                                                                            <?php }  ?> 
                                                                        </table>
                                                                <?php 
                                                                    } 
                                                                ?> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!--fim Historico de atendimentos Paciente-->
                                

                                <!-- inicio selecao do dia para agendamento -->
                                        <div class="form-group col-md-12 col-sm-6"> 
                                            <div class="card">
                                                <div class="card-header"><legend>Encontrar Vagas</legend></div>
                                                <div class="card-body">
                                                    <form name="vagas" method="post" action="">
                                                        <input type="hidden" name="idPaciente" id="idPaciente" value="<?php echo $idPaciente ?>" /> 
                                                        <input type="hidden" name="idAgendamento" id="idAgendamento" value="<?php echo $idAgendamento ?>" />
                                                        <input type="hidden" name="acao" id="acao" value="buscavagas" />  
                                                        
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                <select name="medico" id="medico" class="form-control" title="SELECIONE MEDICO PARA AGENDAMENTO">
                                                                    <?php
                                                                    include "conexao.php"; 
                                                                    $resMedico=$con->prepare("SELECT num_id_med, txt_nome_med FROM tbl_medico_med WHERE txt_ativo_med = 'SIM' order by txt_nome_med");
                                                                    $resMedico->execute();

                                                                    while($rowMedico = $resMedico->fetch(PDO::FETCH_OBJ)){?>
                                                                        <option value="<?php echo $rowMedico->num_id_med ?>"><?php echo $rowMedico->txt_nome_med?></option>
                                                                    <?php } ?>
                                                                    </select> 
                                                                </div>

                                                                <div class="form-group col-md-2 col-sm-12">                
                                                                    <p class="font-weight-bold"><input type="date" name="datainicial"  class="form-control" title="INFORME DATA INICIAL" required /></p>
                                                                </div>

                                                                <div class="form-group col-md-2 col-sm-12">                
                                                                    <p class="font-weight-bold"><input type="date" name="datafinal"  class="form-control" title="INFORME DATA FINAL" required /></p>
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 col-sm-2">
                                                                    <input type="submit" class="btn btn-outline-primary btn-block" name="button" id="button" value="Buscar Vagas" />
                                                                </div>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                <!-- fim selecao do dia -->
                        

                            <?php if($_POST){ ?>
                                <!-- Inicio script busca dia -->
                                    <?php 

                                        //funcao para capturar o dia da data
                                            function diaDaSemana($data) {
                                                // Converte a string da data para um objeto DateTime
                                                $dataObj = new DateTime($data);
                                            
                                                // Formata a data para obter o dia da semana (N: 1 para segunda-feira, 7 para domingo)
                                                $diaDaSemana = $dataObj->format('N');
                                            
                                                // Array associativo para mapear os números dos dias da semana para os nomes
                                                $nomesDias = [
                                                    1 => 'Segunda-feira',
                                                    2 => 'Terca-feira',
                                                    3 => 'Quarta-feira',
                                                    4 => 'Quinta-feira',
                                                    5 => 'Sexta-feira',
                                                    6 => 'Sabado',
                                                    7 => 'Domingo'
                                                ];
                                            
                                                // Retorna o nome do dia da semana correspondente
                                                return $nomesDias[$diaDaSemana];
                                            }
                                            
                                            // Exemplo de uso
                                            //$data = '2023-12-18';
                                            //$diaDaSemana = diaDaSemana($data);
                                            //echo "O dia da semana para $data é $diaDaSemana.";
                                            
                                        //fim funcao
                                        
                                        //GRAVA AS VARIAVEIS DATA INICIAL E DATA FINAL DA PESQUISA DE VAGAS 
                                            $dateStart 		= new DateTime($dataInicial);                            
                                            $dateEnd 		= new DateTime($dataFinal);

                                        include_once "conexao.php";

                                        //funcao para capturar nome do medico
                                            $nomeMedico = $con->prepare("SELECT txt_nome_med FROM tbl_medico_med WHERE num_id_med = ?");
                                            $nomeMedico->bindParam(1,$medico);			
                                            $nomeMedico->execute();  

                                            $medicoNome = $nomeMedico->fetchColumn();
                                        //fim funcao
                                        
                                        //Prints days according to the interval
                                        $dateRange = array();                            
                                    ?>                                                                                       
                                            
                                            <div class="form-group col-md-12 col-sm-12"> 
                                                <table class="table-hover table table-bordered  responsive">
                                                    <tr class="thead-dark" align="center">	                                    
                                                        <th>Medico</td>
                                                        <th>Data</td>
                                                        <th>Dia Semana</td>
                                                        <th>Vagas</td>
                                                        <th>Disponivel</td>
                                                        <th>Detalhes</td>
                                                    </tr> 
                                                        <?php

                                                            //FUNCAO QUE PERCORRE DATA INICIAL E DATA FINAL REALIZANDO CONSULTA DA AGENDA DO MEDICO
                                                            while($dateStart <= $dateEnd){            

                                                                $dateRange[] = $dateStart->format('Y-m-d');

                                                                $dateStart->format('Y-m-d').'###';

                                                                    $dia = $dateStart->format('Y-m-d');

                                                                    //VERIFICAR SE A DATA É FERIADO
                                                                    $sqlVerificaSeFeriado = $con->prepare("SELECT txt_nome_fer FROM tbl_feriados_fer WHERE dta_data_fer = ?  and txt_permite_agendar_fer = 'nao'");
                                                                    $sqlVerificaSeFeriado->bindParam(1,$dia);
                                                                    
                                                                    $sqlVerificaSeFeriado->execute();
                                                                    if($sqlVerificaSeFeriado->rowCount()==1){
                                                                        $nomeFeriado = strtoupper($sqlVerificaSeFeriado->fetchColumn());
                                                                        echo '<tr align="center"><td>'.strtoupper($medicoNome).'</td><td>'.date("d/m/Y", strtotime($dia)).'</td><td>'.strtoupper(diaDaSemana($dia)).'</td><td colspan="3">FERIADO, '.$nomeFeriado.', SEM EXPEDIENTE</td></tr>';
                                                                    }else{

                                                                            //VERIFICAR SE A DATA EXISTE BLOQUEIO PARA AGENDAMENTO
                                                                            $sqlVerificaSeBloqueado = $con->prepare("SELECT txt_descricao_blage FROM tbl_bloqueio_agenda_blage WHERE dta_data_blage = ? and tbl_medico_med_num_id_med = ?");
                                                                            $sqlVerificaSeBloqueado->bindParam(1,$dia);
                                                                            $sqlVerificaSeBloqueado->bindParam(2,$medico);
                                                                            
                                                                            $sqlVerificaSeBloqueado->execute();
                                                                            if($sqlVerificaSeBloqueado->rowCount()==1){ 
                                                                                $descricaoBloqueio = strtoupper($sqlVerificaSeBloqueado->fetchColumn());                                               
                                                                                echo '<tr align="center"><td>'.strtoupper($medicoNome).'</td><td>'.date("d/m/Y", strtotime($dia)).'</td><td>'.strtoupper(diaDaSemana($dia)).'</td><td colspan="3">DATA BLOQUEADA MOTIVO: '.$descricaoBloqueio.' </td></tr>';
                                                                            }else{

                                                                                    $resQuantidadeAgendamentos = $con->prepare("SELECT count(dta_data_age) AS 'qtd', dta_data_age FROM tbl_agendamento_age WHERE dta_data_age = ? AND tbl_medico_med_num_id_med = ?;");

                                                                                    $resQuantidadeAgendamentos->bindParam(1,$dia);
                                                                                    $resQuantidadeAgendamentos->bindParam(2,$medico);
                                                                                    $resQuantidadeAgendamentos->execute();

                                                                                        while ($rowQuantidadeAgendamentos = $resQuantidadeAgendamentos->fetch(PDO::FETCH_OBJ)){                                       

                                                                                                //funcao para capturar quantidade de vagas no dia de atendimento 
                                                                                                    $quantidadeDia = $con->prepare("SELECT sum(num_quantidade_agen) FROM tbl_agenda_agen WHERE txt_dia_semana_agen = ? AND tbl_medico_med_num_id_med = ? AND txt_status_agen = 'ativo' GROUP BY txt_dia_semana_agen");
                                                                                                    $quantidadeDia->bindValue(1,diaDaSemana($dia));
                                                                                                    $quantidadeDia->bindParam(2,$medico);				
                                                                                                    $quantidadeDia->execute();  
                                                    
                                                                                                    $quantidadeVagas = $quantidadeDia->fetchColumn();

                                                                                                    if($quantidadeVagas == ""){
                                                                                                        $quantidadeVagas = 0;
                                                                                                    }
                                                                                                //fim funcao

                                                                                                    $vagasDisponiveis = $quantidadeVagas-$rowQuantidadeAgendamentos->qtd;
                                                                                                    
                                                                                                    if($quantidadeVagas == 0){//SE POSSUI 0 VAGAS PARA ATENDIMENTO MEDICO NAO ATENDE
                                                                                                        
                                                                                                    }else if($vagasDisponiveis == 0){//SE POSSUI 0 VAGAS DISPONIVEIS, AGENDA COMPLETA
                                                                                                        echo '<tr align="center"><td>'.strtoupper($medicoNome).'</td><td>'.date("d/m/Y", strtotime($dia)).'</td><td>'.strtoupper(diaDaSemana($dia)).'</td><td>'.$quantidadeVagas.'</td><td>'.$vagasDisponiveis.'</td><td>AGENDA COMPLETA</td></tr>';
                                                                                                    }else{//CASO CONTRARIO, SE POSSUI VAGAS DISPONIVEIS, EXIBE UM LINK PARA AGENDAR NA DATA E HORA APONTADA
                                                                                                        echo '<tr align="center"><td>'.strtoupper($medicoNome).'</td><td>'.date("d/m/Y", strtotime($dia)).'</td><td>'.strtoupper(diaDaSemana($dia)).'</td><td>'.$quantidadeVagas.'</td><td>'.$vagasDisponiveis.'</td><td><a title="CLIQUE PARA SEGUIR" href="agendamento2.php?p='.base64_encode($idPaciente).'&m='.base64_encode($medico).'&d='.base64_encode($dia).'&nm='.base64_encode($medicoNome).'&ag='.base64_encode($idAgendamento).'">VAGAS DISPONIVEIS</a></td></tr>';
                                                                                                    }                                        
                                                                                        }
                                                                                    }//FIM VERIFICA SE BLOQUEADO

                                                                    }//FIM VERIFICA SE FERIADO                                                                                
                                                                
                                                                $dateStart = $dateStart->modify('+1day');
                                                            }
                                                            }?>
                                                </table>
                                            </div>
                                        
                                <!-- fim script busca dia -->
                            </div>
                        </div>
                    </div>
                              
            </body>
            </html>
<?php

        }//fim pacientes

?> 
