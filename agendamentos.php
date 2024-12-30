<?php
		
	include "conexao.php";
	
        if($_POST){

            //recebe dados do medico para pesquisar            
            $medico = $_POST['medico'];
            /*desativado pois painel precisa mostrar todos os dias selecionados 05/01/2024 
                //verificar se a data informada é inferior a data atual, para nao permitir agendamentos retroativos
                if($_POST['datainicial'] < date('Y-m-d')){
                    $dataInicial = date('Y-m-d');
                }else{
                    $dataInicial = $_POST['datainicial'];
                }
            */
            $dataInicial = $_POST['datainicial'];                        
            $dataFinal = $_POST['datafinal'];
        }	
        
        
?>	
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <body>

            <form name="listagem" method="post" action="#">
            <table class="table">
                <tr>
                    <td> <?php include "inicial.php"?> </td>
                </tr>
                <tr>
                    <td><legend class="p-4 table-primary">Agendamentos<legend></td>
                </tr>
                <tr>
                    <td>
                        <!-- inicio selecao do dia para agendamento -->
                            <form name="vagas" method="post" action="">
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-sm-9">
                                    <select name="medico" id="medico" class="form-control" title="SELECIONE MEDICO PARA PESQUISA">
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
                                        <p class="font-weight-bold"><input type="date" name="datainicial" id="datainicial" class="form-control" title="INFORME DATA INICIAL" required /></p>
                                    </div>

                                    <div class="form-group col-md-2 col-sm-12">                
                                        <p class="font-weight-bold"><input type="date" name="datafinal" id="datafinal" class="form-control" title="INFORME DATA FINAL" required /></p>
                                    </div>
                                    
                                    <div class="form-group col-md-2 col-sm-2">
                                        <input type="submit" class="btn btn-outline-primary btn-block" name="button" id="button" value="Buscar Dados" />
                                    </div>
                                </div>
                            </form>
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
                            <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12"> 
                            <table width="100%" class="table table-striped table-bordered">                        
                                <tr align="center">                                    
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

                                                    $resQuantidadeAgendamentos = $con->prepare("SELECT count(dta_data_age) AS 'qtd', dta_data_age FROM tbl_agendamento_age WHERE dta_data_age = ? AND tbl_medico_med_num_id_med = ? ");

                                                    $resQuantidadeAgendamentos->bindParam(1,$dia);
                                                    $resQuantidadeAgendamentos->bindParam(2,$medico);
                                                    $resQuantidadeAgendamentos->execute();

                                                        while ($rowQuantidadeAgendamentos = $resQuantidadeAgendamentos->fetch(PDO::FETCH_OBJ)){                                       

                                                                //funcao para capturar quantidade de vagas no dia de atendimento 
                                                                    $quantidadeDia = $con->prepare("SELECT sum(num_quantidade_agen) FROM tbl_agenda_agen WHERE txt_dia_semana_agen = ? AND tbl_medico_med_num_id_med = ? AND txt_status_agen = 'ativo' GROUP BY txt_dia_semana_agen");
                                                                    $quantidadeDia->bindParam(1,diaDaSemana($dia));
                                                                    $quantidadeDia->bindParam(2,$medico);				
                                                                    $quantidadeDia->execute();
                                                                    
                                                                    $quantidadeVagas = $quantidadeDia->fetchColumn();
                    
                                                                    if($quantidadeVagas == ""){
                                                                        $quantidadeVagas = 0;
                                                                    }
                                                                //fim funcao

                                                                    $vagasDisponiveis = $quantidadeVagas-$rowQuantidadeAgendamentos->qtd;                                                                                                
                                                                                                                                        
                                                                    if($quantidadeVagas == 0){//SE POSSUI 0 VAGAS PARA ATENDIMENTO MEDICO NAO ATENDE
                                                                        //echo '<td>MEDICO NAO ATENDE</td></tr>'; DESATIVADO EM 09/01/2024 PARA EXIBICAO APENAS DE DADOS E NAO AVISOS
                                                                    }else if($vagasDisponiveis == 0){//SE POSSUI 0 VAGAS DISPONIVEIS, AGENDA COMPLETA
                                                                        echo '<tr align="center"><td>'.strtoupper($medicoNome).'</td><td>'.date("d/m/Y", strtotime($dia)).'</td><td>'.strtoupper(diaDaSemana($dia)).'</td><td>'.$quantidadeVagas.'</td><td>'.$vagasDisponiveis.'</td><td><a title="CLIQUE PARA SEGUIR" href="agendamentos-painel.php?&m='.base64_encode($medico).'&d='.base64_encode($dia).'&nm='.base64_encode($medicoNome).'"  target="_blank">CLIQUE PARA VISUALIZAR</a></td></tr>';
                                                                    }else{//CASO CONTRARIO, SE POSSUI VAGAS DISPONIVEIS, EXIBE UM LINK PARA AGENDAR NA DATA E HORA APONTADA
                                                                        echo '<tr align="center"><td>'.strtoupper($medicoNome).'</td><td>'.date("d/m/Y", strtotime($dia)).'</td><td>'.strtoupper(diaDaSemana($dia)).'</td><td>'.$quantidadeVagas.'</td><td>'.$vagasDisponiveis.'</td><td><a title="CLIQUE PARA SEGUIR" href="agendamentos-painel.php?&m='.base64_encode($medico).'&d='.base64_encode($dia).'&nm='.base64_encode($medicoNome).'" target="_blank" >CLIQUE PARA VISUALIZAR</a></td></tr>';
                                                                    }                                        
                                                        }
                                                    }//FIM VERIFICA SE BLOQUEADO

                                    }//FIM VERIFICA SE FERIADO 
                                                                      
                                
                                $dateStart = $dateStart->modify('+1day');
                            }
                        }?>
                        </div>
                        <!-- fim script busca dia -->

                    </td>                
                </tr>            
            </body>
            </html>

