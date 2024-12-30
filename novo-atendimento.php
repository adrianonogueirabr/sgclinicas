<?php include 'verifica.php';
		
	include "conexao.php";

    $acao = $_GET['acao'];

    if($acao == "ag"){ 
        
                $codigoItemAgendamento =base64_decode($_GET['i']);
                
                //realizando captura dos dados de agendamento
                $sqlItemAgendamentos = $con->prepare("SELECT agendamento.num_id_itage, categoria.txt_nome_cat, agendamento.tbl_procedimentos_pro_num_id_pro, procedimento.txt_nome_pro, agendamento.tbl_agendamento_age_num_id_age, agendamento.txt_status_itage 

                FROM tbl_item_agendamento_itage agendamento
                
                LEFT JOIN tbl_procedimentos_pro procedimento ON procedimento.num_id_pro = agendamento.tbl_procedimentos_pro_num_id_pro
                LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = agendamento.tbl_categoria_cat_num_id_cat

                WHERE agendamento.num_id_itage = ? ");
        
                $sqlItemAgendamentos->bindParam(1,$codigoItemAgendamento);
        
                if (!$sqlItemAgendamentos->execute()) {
                    echo "Error: " . $sqlItemAgendamentos . "<br>" . mysqli_error($con);
                }
        
                while($rowItemAgendamentos = $sqlItemAgendamentos->fetch(PDO::FETCH_OBJ)){ 
                    $codigoAgendamento = $rowItemAgendamentos->tbl_agendamento_age_num_id_age;
                    $txtCategoria = $rowItemAgendamentos->txt_nome_cat;
                    $txtProcedimento = $rowItemAgendamentos->txt_nome_pro;
                    $numProcedimento = $rowItemAgendamentos->tbl_procedimentos_pro_num_id_pro;
                }
            //fim captura dados
                
    }
        
        /*capturar detalhes do paciente*/
	
            $dadosPacienteAtendimento = $con->prepare("SELECT agendamento.hor_hora_age, agendamento.dta_data_age, medico.txt_nome_med as medicoagendamento, agendamento.num_id_age,
            
            agendamento.tbl_paciente_pac_num_id_pac, categoria.txt_nome_cat,

            paciente.txt_nome_pac, paciente.txt_telefone_pac, medicopaciente.txt_nome_med as medicopaciente,paciente.dta_ultima_visita_pac, paciente.txt_matricula_pac, paciente.txt_cns_pac, 
            
            paciente.dta_vencimento_carteira_pac, paciente.txt_carteira_pac,paciente.dta_datanascimento_pac,
            
            usuarioregistro.txt_login_usu as usuarioregistro, 
            
            agendamento.txt_observacao_age, agendamento.txt_status_age, 
            
            usuarioconfirmacao.txt_login_usu as usuarioconfirmacao,
            
            usuarioremarcacao.txt_login_usu as usuarioremarcacao,
            
            agendamento.dth_registro_age, agendamento.dth_confirmacao_age, agendamento.dth_remarcacao_age
            
            FROM tbl_agendamento_age as agendamento          
            
            LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac

            left join tbl_categoria_cat categoria on categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat
            
            left join tbl_medico_med medico on medico.num_id_med = agendamento.tbl_medico_med_num_id_med
            
            left join tbl_medico_med medicopaciente on medicopaciente.num_id_med = paciente.tbl_medico_med_num_id_med
            
            LEFT JOIN tbl_usuario_usu usuarioregistro ON usuarioregistro.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu
            
            LEFT JOIN tbl_usuario_usu usuarioconfirmacao ON usuarioconfirmacao.num_id_usu = agendamento.num_usuario_confirmacao_age
            
            LEFT JOIN tbl_usuario_usu usuarioremarcacao ON usuarioremarcacao.num_id_usu = agendamento.num_usuario_remarcacao_age
            
            WHERE agendamento.num_id_age = ?");
                
            $dadosPacienteAtendimento->bindParam(1,$codigoAgendamento);
            $dadosPacienteAtendimento->execute();

                //caso nao encontre paciente
                if($dadosPacienteAtendimento->rowCount()<=0){	
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Favor realizar operacao novamente!\");</script>";
                    echo "<script language='javascript'>history.back()</script>";

                }else{            
                    
                    while ($rowdadosPacienteAtendimento = $dadosPacienteAtendimento->fetch(PDO::FETCH_OBJ)){
                        $numIdPaciente = $rowdadosPacienteAtendimento->tbl_paciente_pac_num_id_pac;
                        $txtNomePaciente = $rowdadosPacienteAtendimento->txt_nome_pac;
                        $txtNomeMedico = $rowdadosPacienteAtendimento->medicopaciente;
                        $txtNomeCategoria = $rowdadosPacienteAtendimento->txt_nome_cat;
                        $dtaUltimaVisita = $rowdadosPacienteAtendimento->dta_ultima_visita_pac;
                        $medicoAgendamento =  $rowdadosPacienteAtendimento->medicoagendamento;
                        $dataAgendamento =   $rowdadosPacienteAtendimento->dta_data_age;
                        $horaAgendamento =    $rowdadosPacienteAtendimento->hor_hora_age;
                        $txtCns = $rowdadosPacienteAtendimento->txt_cns_pac;
                        $txtMatricula = $rowdadosPacienteAtendimento->txt_matricula_pac;
                        $vencimentoCarteira = $rowdadosPacienteAtendimento->dta_vencimento_carteira_pac;
                        $carteira = $rowdadosPacienteAtendimento->txt_carteira_pac;

                            //calculo idade do paciente
                            $dataNascimento = $rowdadosPacienteAtendimento->dta_datanascimento_pac; 
                            $date = new DateTime($dataNascimento ); 
                            $interval = $date->diff( new DateTime( date('Y-m-d') ) ); 
                            //fim calculo idade

                            //calculo ultima visita
                            if($rowdadosPacienteAtendimento->dta_ultima_visita_pac != NULL){
                                $diferenca =  strtotime(date("Y-m-d")) - strtotime($rowdadosPacienteAtendimento->dta_ultima_visita_pac);
                                $diasUltimaVisita = floor($diferenca / (60 * 60 * 24));  
                                $dataUltimaVisita =  date("d/m/Y", strtotime($rowdadosPacienteAtendimento->dta_ultima_visita_pac));                                                 
                            }else{
                                $dataUltimaVisita = 0;
                                $diasUltimaVisita = 0;
                            }
                            //fim calculo 
                    }
                }
        /*fim detalhes paciente */                
        
?>	
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <body>

            <form name="atendimento" action="processa-atendimento.php?acao=novoag" method="post">
            <table class="table">
                <tr>
                    <td> <?php include "inicial.php"?> </td>
                </tr>
                <tr>
                    <td><legend class="p-4 table-primary">Novo Atendimento<legend></td>
                </tr>
                <tr>
                    <td> 
                        <Legend>Dados Paciente</Legend>                       
                            <div class="form-row">                                

                                    <div class="form-group col-md-4 col-sm-6"><label>Nome e Idade</label>
                                    <input title="NOME DO PACIENTE" value="<?php echo ucwords($txtNomePaciente) ?>  - <?php echo $interval->format( '%Y anos e %m mes(es)' ) ?>" readonly="readonly" class="form-control" readonly /></div>
                                    
                                    <div class="form-group col-md-4 col-sm-6"><label>Medico</label>
                                    <input title="MEDICO DO PACIENTE" value="<?php echo ucwords($txtNomeMedico) ?>" readonly="readonly" class="form-control" readonly /> </div> 

                                    <div class="form-group  col-md-2 col-sm-6"><label>Tipo</label>
                                    <input title="CATEGORIA DO PACIENTE" value="<?php echo ucwords($txtNomeCategoria) ?>" readonly="readonly" class="form-control" readonly /></div> 

                                    <div class="form-group  col-md-2 col-sm-6"><label>Ultima Visita</label>
                                    <input title="DATA ULTIMA VISITA" value="<?php echo $dataUltimaVisita ?> - <?php echo $diasUltimaVisita; ?> dia(s)" readonly="readonly" class="form-control" readonly /></div>                                     
                            </div> 
                        <HR>
                        <Legend>Atendimento</Legend>
                                <div class="form-row">
                                    <div class="form-group col-md-3 col-sm-6"><label>Data e Hora Marcada</label>
                                        <input title="DATA DO AGENDAMENTO"  value="<?php echo date("d/m/Y", strtotime($dataAgendamento)).' - '.$horaAgendamento ?>" readonly="readonly" class="form-control" readonly /> 
                                    </div>  

                                    <div class="form-group col-md-3 col-sm-6"><label>Medico</label>
                                        <select name="medico" id="medico" class="form-control" title="SELECIONE MEDICO DO ATENDIMENTO" >                        
                                            <?php
                                            include "conexao.php"; 
                                            $resMedico=$con->prepare("SELECT num_id_med, txt_nome_med FROM tbl_medico_med WHERE txt_ativo_med = 'sim' order by txt_nome_med");
                                            $resMedico->execute();

                                            while($rowMedico = $resMedico->fetch(PDO::FETCH_OBJ)){?>                            
                                                <option <?php if($rowMedico->txt_nome_med==$medicoAgendamento){?> selected="selected"; <?php } ?> value="<?php echo $rowMedico->num_id_med ?>"><?php echo $rowMedico->txt_nome_med ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>  
                                    
                                    <div class="form-group col-md-3 col-sm-6"><label>Procedimento</label>
                                        <input  title="PROCEDIMENTO A SER REALIZADO" type="text" value="<?php echo ucwords($txtProcedimento) ?>" readonly="readonly" class="form-control" readonly /> 
                                    </div>
                                           
                                    <div class="form-group col-md-3 col-sm-12"><label>Categoria</label>
                                            <select name="categoria" id="categoria" class="form-control" title="SELECIONE CATEGORIA DO AGENDAMENTO">                                            
                                                <?php
                                                include "conexao.php"; 
                                                $resCategoria=$con->prepare("SELECT num_id_cat, txt_nome_cat FROM tbl_categoria_cat WHERE txt_ativo_cat = 'sim' order by txt_nome_cat");
                                                $resCategoria->execute();

                                                while($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){?>                                                    
                                                    <option <?php if($rowCategoria->txt_nome_cat==$txtCategoria){?> selected="selected"; <?php } ?> value="<?php echo $rowCategoria->num_id_cat ?>"><?php echo $rowCategoria->txt_nome_cat ?></option>
                                                <?php } ?>
                                            </select> 
                                    </div> 

                                    <input type="hidden" name="codigoAgendamento" id="codigoAgendamento" value="<?php echo $codigoAgendamento ?>" />
                                    <input type="hidden" name="codigoItemAgendamento" id="codigoItemAgendamento" value="<?php echo $codigoItemAgendamento ?>" /> 
                                    <input type="hidden" name="codigoPaciente" id="codigoPaciente" value="<?php echo $numIdPaciente ?>" />
                                    <input type="hidden" name="procedimento" id="procedimento" value="<?php echo $numProcedimento ?>" />


                                    <div class="form-group col-md-3 col-sm-6"><label for="tipoprioridade">Prioridade</label>
                                        <select name="tipoprioridade" id="tipoprioridade" class="form-control" title="SELECIONE TIPO DE PRIORIDADE" >
                                            <option value="5">Nao</option>
                                            <option value="1">Urgencia</option>
                                            <option value="2">Idoso 80</option>
                                            <option value="3">Autista</option>   
                                            <option value="4">Idoso 65</option>                                                                                       
                                            <option value="4">Recem Nascido</option>	
                                            <option value="4">Cadeirante</option>                                                                                        
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-9 col-sm-6"><label for="observacao">Observacao</label>
                                        <input name="observacao" id="observacao" title="OBSERVACOES" type="text"  class="form-control" id="observacao" name="observacao" /> 
                                    </div> 

                                    <Legend><hr>Preencher para Convenios</Legend>
                                    
                                    <div class="form-group col-md-3 col-sm-6"><label>Numero da Guia</label>
                                        <input name="guia" id="guia" title="INFORMAR O NUMERO DA GUIA" type="text"  class="form-control"  /> 
                                    </div> 
                                    
                                    <div class="form-group col-md-3 col-sm-6"><label for="autorizado">Autorizado</label>
                                        <select name="autorizado" id="autorizado" class="form-control" title="INFORME SE AUTORIZADO OU NAO PELO CONVENIO" >
                                            <option value="sim">Sim</option>
                                            <option value="nao">Nao</option>		
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3 col-sm-6"><label>Data Autorizacao</label>
                                        <input name="dataautorizacao" id="dataautorizacao" title="INFORMAR O DATA DA AUTORIZACAO" type="date"  class="form-control"  /> 
                                    </div> 

                                    <div class="form-group col-md-3 col-sm-6"><label>Matricula</label>
                                        <input name="matricula" id="matricula" title="INFORMAR MATRICULA DO CONVENIO" value="<?php echo $txtMatricula ?>" type="text"  class="form-control" readonly /> 
                                    </div>
                                    
                                    <div class="form-group col-md-4 col-sm-6"><label>CNS</label>
                                        <input name="cns" id="cns" title="INFORMAR NUMERO CARTAO NACIONAL DE SAUDE" value="<?php echo $txtCns ?>" type="text"  class="form-control"  readonly/> 
                                    </div> 

                                    <div class="form-group col-md-4 col-sm-6"><label>Carteira Convenio</label>
                                        <input name="carteira" id="carteira" title="CARTEIRA DO CONVENIO" value="<?php echo $carteira ?>" type="text"  class="form-control"  readonly/> 
                                    </div>
                                    
                                    <div class="form-group col-md-4 col-sm-6"><label>Validade Carteira</label>
                                        <input name="validade" id="validade" title="VALIDADE DA CARTEIRA DO CONVENIO" value="<?php echo $vencimentoCarteira ?>" type="date"  class="form-control"  readonly/> 
                                    </div>

                                    <Legend><hr>Preencher para Particular</Legend>
                                            
                                    <div class="form-group col-md-4 col-sm-6"><label>Valor Pago</label>
                                        <input name="valorpago" id="valorpago" title="INFORMAR O VALOR A SER PAGO" value="0" type="double"  class="form-control"  /> 
                                    </div> 
                                    
                                    <div class="form-group  col-md-4 col-sm-6"><label for="tipodesconto">Tipo Desconto</label>
                                            <select name="tipodesconto" class="form-control" title="SELECIONE TIPO DE DESCONTO" >
                                            <option value="">Selecione</option>
                                            <?php
                                            include "conexao.php"; 
                                            $resDesconto=$con->prepare("SELECT num_id_td, txt_nome_td FROM tbl_tipo_desconto_td WHERE txt_ativo_td = 'SIM' order by txt_nome_td");
                                            $resDesconto->execute();

                                            while($rowDesconto = $resDesconto->fetch(PDO::FETCH_OBJ)){?>
                                                <option value="<?php echo $rowDesconto->num_id_td ?>"><?php echo $rowDesconto->txt_nome_td?></option>
                                            <?php } ?>
                                            </select>
                                    </div>

                                    <!--                
                                        DESATIVADO EM 12/02/2024 POIS OS DESCONTOS AGORA POSSUEM UMA TABELA FIXA E SERÁ APLICADO DIRETAMENTE NA TABELA ATENDIMENTO
                                        <div class="form-group col-md-4 col-sm-6"><label>Valor Desconto</label>
                                            <input name="desconto" id="desconto" title="INFORMAR VALOR DE DESCONTO" value="0"  type="double"  class="form-control"  /> 
                                        </div>
                                    
                                        <div class="form-group col-md-3 col-sm-6"><label>Valor Total</label>
                                            <input name="total" id="total" title="INFORMAR VALOR TOTAL A SER PAGO" value="0"  type="double"  class="form-control"  /> 
                                        </div>
                                    -->
                                  
                                    <div class="form-group col-md-4 col-sm-6"><label>Codigo do Pagamento</label>
                                        <input name="idpagamento" id="idpagamento" title="INFORMAR ID DO PAGAMENTO REALIZADO" value="0"  type="text"  class="form-control"  /> 
                                    </div>                                                                   
                                </div>
                        <HR>                        
                            <div class="form-row"> 
                                    <div class="form-group col-md-12 col-sm-12">
                                        <input type="submit" name="registrar"  value="Registrar Dados" class="btn btn-outline-primary" />                                       
                                        <a href="consulta-pacientes.php" class="btn btn-outline-danger " >Cancelar</a>                                                                                                                                   
                                    </div>                                        
                            </div>
                        </form>
                        
                    </td>                
                </tr>            
            </body>
        </html>
<?php       

?> 
