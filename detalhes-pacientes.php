<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?php

        include_once "conexao.php";

        $idPaciente = base64_decode($_GET['idPaciente']);

        $resPaciente = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, usuario.txt_login_usu as 'usuario_cadastro', profissao.txt_nome_prof, paciente.txt_nome_pac, 

        paciente.txt_cpf_pac, paciente.txt_rg_pac, cor.txt_nome_cor, paciente.txt_sexo_pac, paciente.dta_datanascimento_pac, paciente.txt_email_pac, paciente.txt_telefone_pac, paciente.txt_senha_pac, 
        
        estadocivil.txt_nome_ec,paciente.txt_cep_pac, paciente.txt_logradouro_pac, paciente.num_numero_pac, paciente.txt_complemento_pac, paciente.txt_bairro_pac, paciente.txt_cidade_pac, 
        
        paciente.txt_estado_pac, paciente.txt_matricula_pac, paciente.val_saldo_pac, paciente.txt_pne_pac, paciente.txt_cns_pac, paciente.txt_carteira_pac, paciente.dta_vencimento_carteira_pac, 
        
        paciente.dth_registro_pac, usuarioalt.txt_login_usu as 'usuario_alteracao', paciente.dth_alteracao_pac, paciente.txt_bloquear_agendamento_pac, paciente.txt_observacoes_pac, paciente.dta_ultima_visita_pac, 
        
        paciente.txt_ativo_pac 
        
        FROM tbl_paciente_pac paciente
        
        LEFT JOIN tbl_profissao_prof profissao ON profissao.num_id_prof = paciente.tbl_profissao_prof_num_id_prof
        LEFT JOIN tbl_estado_civil_ec estadocivil ON estadocivil.num_id_ec = paciente.tbl_estado_civil_ec_num_id_ec
        LEFT JOIN tbl_cor_cor cor ON cor.num_id_cor = paciente.tbl_cor_cor_num_id_cor
        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = paciente.tbl_usuario_usu_num_id_usu
        LEFT JOIN tbl_usuario_usu usuarioalt ON usuarioalt.num_id_usu = paciente.num_usuario_alteracao_pac
        
        WHERE num_id_pac = ?");

        try{
            $resPaciente->bindParam(1,$idPaciente);
        
            $resPaciente->execute();

            if($resPaciente->rowCount()<=0){
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-paciente.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
            
            
        while ($rowPaciente = $resPaciente->fetch(PDO::FETCH_OBJ)){     
        
    ?>
        <body>
        <?php include "inicial.php"?>
        <form name="detalhes-pacientes" class="needs-validation" novalidate action="processa-pacientes.php?acao=salvar"  method="post">    
                        <div class="container col-md-12">								
                            <div class="card">
                                <div class="card-header"><h3>Dados de <?php echo ucfirst($rowPaciente->txt_nome_pac) ?></h3></div>
                                <div class="card-body">

                                    <div class="form-row"> 
                                        <div class="form-group col-md-3 col-sm-6"><label for="cpf">CPF</label>
                                            <input name="cpf" id="cpf"   type="text" title="CPF DO PACIENTE" value="<?php echo $rowPaciente->txt_cpf_pac ?>" class="form-control"  />
                                            <small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 99999999999</small>                                           
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="nome">Nome*</label>
                                            <input name="nome" id="nome"  type="text" value="<?php echo $rowPaciente->txt_nome_pac ?>" title="NOME DO PACIENTE" required class="form-control"  required/>                                            
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Nome!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="datanascimento">Data de Nascimento*</label>
                                            <input name="datanascimento" id="datanascimento" type="date"  class="form-control" title="DATA DE NASCIMENTO DO PACIENTE CLIQUE PARA ALTERAR" value="<?php echo $rowPaciente->dta_datanascimento_pac ?>" required />           
                                            <div class="invalid-feedback">
                                                Necessário informar data de Nascimento!
                                            </div>
                                        </div> 
                                    
                                        <div class="form-group  col-md-3 col-sm-6"><label for="categoria">Categoria*</label>
                                            <select name="categoria" class="form-control" title="SELECIONE ESTADO CIVIL DO PACIENTE" required> 
                                            <option value="">Selecione</option>                       
                                            <?php
                                            include "conexao.php"; 
                                            $resCategoria=$con->prepare("SELECT num_id_cat, txt_nome_cat FROM tbl_categoria_cat WHERE txt_ativo_cat = 'sim' order by txt_nome_cat");
                                            $resCategoria->execute();

                                            while($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){?>                            
                                                <option <?php if($rowCategoria->txt_nome_cat==$rowPaciente->txt_nome_cat){?> selected="selected"; <?php } ?> value="<?php echo $rowCategoria->num_id_cat ?>"><?php echo $rowCategoria->txt_nome_cat ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group  col-md-3 col-sm-6"><label for="medico">Medico*</label>
                                            <select name="medico" class="form-control" title="SELECIONE MEDICO DO PACIENTE" >                        
                                            <?php
                                            include "conexao.php"; 
                                            $resMedico=$con->prepare("SELECT num_id_med, txt_nome_med FROM tbl_medico_med WHERE txt_ativo_med = 'sim' order by txt_nome_med");
                                            $resMedico->execute();

                                            while($rowMedico = $resMedico->fetch(PDO::FETCH_OBJ)){?>                            
                                                <option <?php if($rowMedico->txt_nome_med==$rowPaciente->txt_nome_med){?> selected="selected"; <?php } ?> value="<?php echo $rowMedico->num_id_med ?>"><?php echo $rowMedico->txt_nome_med ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    
                                        <div class="form-group  col-md-3 col-sm-6"><label for="estadocivil">Estado Civil</label>
                                            <select name="estadocivil" class="form-control" title="SELECIONE ESTADO CIVIL DO PACIENTE" >                        
                                            <?php
                                            include "conexao.php"; 
                                            $resEstadoCivil=$con->prepare("SELECT num_id_ec, txt_nome_ec FROM tbl_estado_civil_ec WHERE txt_ativo_ec = 'sim' order by txt_nome_ec");
                                            $resEstadoCivil->execute();

                                            while($rowEstadoCivil = $resEstadoCivil->fetch(PDO::FETCH_OBJ)){?>                            
                                                <option <?php if($rowEstadoCivil->txt_nome_ec==$rowPaciente->txt_nome_ec){?> selected="selected"; <?php } ?> value="<?php echo $rowEstadoCivil->num_id_ec ?>"><?php echo $rowEstadoCivil->txt_nome_ec ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group  col-md-3 col-sm-6"><label for="cor">Cor</label>
                                            <select name="cor" class="form-control" title="SELECIONE COR DO PACIENTE" >                        
                                            <?php
                                            include "conexao.php"; 
                                            $resCor=$con->prepare("SELECT num_id_cor, txt_nome_cor FROM tbl_cor_cor WHERE txt_ativo_cor = 'sim' order by txt_nome_cor");
                                            $resCor->execute();

                                            while($rowCor = $resCor->fetch(PDO::FETCH_OBJ)){?>                            
                                                <option <?php if($rowCor->txt_nome_cor==$rowPaciente->txt_nome_cor){?> selected="selected"; <?php } ?> value="<?php echo $rowCor->num_id_cor ?>"><?php echo $rowCor->txt_nome_cor ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    
                                        <div class="form-group col-md-3 col-sm-6"><label for="sexo">Sexo</label>
                                        <select name="sexo" id="sexo" class="form-control" >	
                                                <option <?php if($rowPaciente->txt_sexo_pac=='masculino'){?> selected="selected"; <?php } ?> value="<?php echo 'masculino' ?>">Masculino</option>
                                                <option <?php if($rowPaciente->txt_sexo_pac=='feminino'){?> selected="selected"; <?php } ?> value="<?php echo 'feminino' ?>">Feminino</option>
                                                <option <?php if($rowPaciente->txt_sexo_pac=='nao informar'){?> selected="selected"; <?php } ?> value="<?php echo 'nao informar' ?>">Nao Informar</option>nao informado
                                                <option <?php if($rowPaciente->txt_sexo_pac=='nao informado'){?> selected="selected"; <?php } ?> value="<?php echo 'nao informado' ?>">nao informado</option>
                                            </select>
                                        </div>
                                    
                                        <div class="form-group  col-md-3 col-sm-6"><label for="profissao">Profissao</label>
                                            <select name="profissao" class="form-control" title="SELECIONE PROFISSAO DO PACIENTE" >                        
                                            <?php
                                            include "conexao.php"; 
                                            $resProfissao=$con->prepare("SELECT num_id_prof, txt_nome_prof FROM tbl_profissao_prof WHERE txt_ativo_prof = 'sim' order by txt_nome_prof");
                                            $resProfissao->execute();

                                            while($rowProfissao = $resProfissao->fetch(PDO::FETCH_OBJ)){?>                            
                                                <option <?php if($rowProfissao->txt_nome_prof==$rowPaciente->txt_nome_prof){?> selected="selected"; <?php } ?> value="<?php echo $rowProfissao->num_id_prof ?>"><?php echo $rowProfissao->txt_nome_prof ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                                   
                                        <div class="form-group col-md-3 col-sm-6"><label for="telefone">Telefone*</label>
                                            <input name="telefone"  type="text" class="form-control" required value="<?php echo $rowPaciente->txt_telefone_pac ?>" title="TELEFONE CELULAR OU FIXO DO PACIENTE" />
                                            <small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 92988887777</small>
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Telefone!
                                            </div>
                                        </div>                                    
                                    
                                        <div class="form-group col-md-6 col-sm-6"><label for="email">Email</label>
                                            <input name="email" id="email" class="form-control" type="email" value="<?php echo $rowPaciente->txt_email_pac ?>" title="EMAIL DO PACIENTE" />
                                        </div> 
                                    
                                        <div class="form-group col-md-3 col-sm-6"><label for="cep">CEP</label>
                                            
                                            <input name="cep" id="cep" class="form-control" type="number" size="8" onblur="pesquisacep(this.value);"  value="<?php echo $rowPaciente->txt_cep_pac; ?>" title="INFORME O CEP E PRESSIONE TECLA TAB" />
                                            <small id="emailHelp" class="form-text text-muted">Somente numeros Ex.:99999999 e pressionar TAB</small>
                                            <span id="msgAlertaCepNaoEncontrado"></span>                                            
                                        </div>

                                        <div class="form-group col-md-6 col-sm-10"><label for="logradouro">Logradouro</label>
                                            <input name="logradouro" id="logradouro" class="form-control" type="text"  value="<?php echo $rowPaciente->txt_logradouro_pac; ?>" title="LOGRADOURO"/>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-2"><label for="numero">Numero</label>
                                            <input name="numero" id="numero" class="form-control" type="text"  value="<?php echo $rowPaciente->num_numero_pac; ?>" title="NUMERO DA RESIDENCIA"/>
                                        </div>
                                    
                                        <div class="form-group col-md-3 col-sm-6"><label for="bairro">Bairro</label>
                                            <input name="bairro" id="bairro" class="form-control" type="text"   value="<?php echo $rowPaciente->txt_bairro_pac; ?>" title="BAIRRO DO PACIENTE" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="complemento">Complemento</label>
                                            <input name="complemento" id="complemento"  class="form-control" type="text"  value="<?php echo $rowPaciente->txt_complemento_pac ?>" title="COMPLEMENTO DO ENDERECO" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="cidade">Cidade</label>
                                            <input name="cidade" id="cidade" type="text" class="form-control"  value="<?php echo $rowPaciente->txt_cidade_pac; ?>" title="CIDADE DO PACIENTE" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="estado">Estado</label>
                                            <input name="estado" id="estado" type="text" title="ESTADO DO PACIENTE" value="<?php echo $rowPaciente->txt_estado_pac ?>" class="form-control" />
                                        </div>
                                    
                                        <div class="form-group col-md-12 col-sm-12"><label for="observacoes">Observacoes</label>
                                            <textarea class="form-control" rows="3" name="observacoes" id="observacoes" title="INFORMACOES GERAIS DO PACIENTE"><?php echo $rowPaciente->txt_observacoes_pac; ?></textarea>
                                        </div>
                                                   
                                        <div class="form-group col-md-3 col-sm-6"><label for="rg">RG - Registro Geral</label>
                                            <input name="rg" id="rg" type="text" class="form-control" value="<?php echo $rowPaciente->txt_rg_pac ?>" title="RG DO PACIENTE" />
                                        </div>
                                        
                                        <div class="form-group col-md-3 col-sm-6"><label for="matricula">Matricula Convenio</label>
                                            <input name="matricula" id="matricula" class="form-control" type="text" title="MATRICULA DO PACIENTE NO CONVENIO" value="<?php echo $rowPaciente->txt_matricula_pac ?>" />
                                        </div>            

                                        <div class="form-group col-md-3 col-sm-6"><label for="carteira">Carteira Convenio</label>
                                            <input name="carteira" id="carteira" class="form-control" type="text" title="NUMERO CARTEIRA DO CONVENIO DO PACIENTE" value="<?php echo $rowPaciente->txt_carteira_pac ?>" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="vendimento_carteira">Vencimento Carteira</label>
                                            <input name="vendimento_carteira" type="date" class="form-control"  type="text" title="DATA VENCIMENTO CARTEIRA DO CONVENIO DO PACIENTE CLIQUE PARA ALTERAR" value="<?php if($rowPaciente->dta_vencimento_carteira_pac != NULL){ echo $rowPaciente->dta_vencimento_carteira_pac;} ?>" />
                                        </div>
                                                  
                                        <div class="form-group col-md-3 col-sm-6"><label for="cns">CNS - Carteira Nacional de Saude</label>
                                            <input name="cns" id="cns" class="form-control" type="text" title="NUMERO CARTEIRA NACIONAL DE SAUDE DO PACIENTE" value="<?php echo $rowPaciente->txt_cns_pac ?>" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="saldo_">Saldo Paciente</label>
                                            <input name="saldo_" class="form-control" type="text" readonly="readonly" value="R$<?php echo number_format($rowPaciente->val_saldo_pac,2) ?>" title="SALDO EM ADIANTAMENTO DO PACIENTE" disabled="disabled" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="bloqueio_agendamento">Bloquear Agendamento</label>
                                            <select name="bloqueio_agendamento" id="bloqueio_agendamento" class="form-control" >	
                                                <option <?php if($rowPaciente->txt_bloquear_agendamento_pac=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                <option <?php if($rowPaciente->txt_bloquear_agendamento_pac=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-3 col-sm-6"><label for="ativo">Cadastro Ativo</label>        
                                            <select name="ativo" id="ativo" class="form-control" >	
                                                <option <?php if($rowPaciente->txt_ativo_pac=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                <option <?php if($rowPaciente->txt_ativo_pac=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>
                                            </select>
                                        </div>
                                    
                                        <div class="form-group col-md-3 col-sm-6"><label for="usuariocadastro_">Usuario Cadastro</label>
                                            <input name="usuariocadastro_" class="form-control" type="text" readonly="readonly" title="USUARIO DE CADASTRO DO PACIENTE" value="<?php echo $rowPaciente->usuario_cadastro ?>" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="registro_">Data Cadastro</label>
                                            <input name="registro_" class="form-control" type="text" readonly="readonly" title="DATA DE REGISTRO DO PACIENTE" value="<?php echo date("d/m/Y H:i:s", strtotime($rowPaciente->dth_registro_pac)); ?>" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="usuarioalteracao_">Usuario Alteracao</label>
                                            <input name="usuarioalteracao_" class="form-control" type="text" readonly="readonly" title="USUARIO DE ALTERACAO DO PACIENTE" value="<?php echo $rowPaciente->usuario_alteracao ?>" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="alteracao_">Data Ultima Alteracao</label>
                                            <input name="alteracao_" class="form-control" type="text" readonly="readonly" title="DATA DA ULTIMA ALTERACAO DO PACIENTE" value="<?php if($rowPaciente->dth_alteracao_pac != NULL){ echo date("d/m/Y H:i:s",strtotime($rowPaciente->dth_alteracao_pac)); } ?>"/>
                                        </div>            

                                        <INPUT TYPE="hidden" name="idPaciente" id="idPaciente" value="<?php echo $rowPaciente->num_id_pac ?>">
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <input class="btn btn-outline-danger "  type="submit" name="Alterar Dados"  value="Salvar Alterações" title="Clique para salvar alteracoes"/>                                            
                                            <a href="consulta-pacientes.php" class="btn btn-outline-warning " title="CLIQUE PARA CANCELAR">Cancelar</a>                                        
                                            <a  class="btn btn-outline-success" title="Clique para um novo atendimento" href="atendimento.php?acao=n&p=<?php echo base64_encode($idPaciente) ?>">Novo Atendimento</a> 
                                        </div> 
                                    </div> 
                                    <hr>
                                    <div class="form-row">                                        
                                    
                                    <!-- FIM CAMPOS DE INFORMACAO-->                                                                       

                                    <!--Historico de agendamentos Paciente-->
                                        <?php                                    
                                            $sqlAgendamentosPaciente = $con->prepare("SELECT agendamento.num_id_age,agendamento.dta_data_age,agendamento.hor_hora_age,agendamento.txt_status_age,medico.txt_nome_med
                                                
                                                FROM tbl_agendamento_age agendamento
                                                
                                                LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med                                        
                                                                                        
                                                WHERE tbl_paciente_pac_num_id_pac = ? ORDER BY dta_data_age DESC limit 10");

                                            $sqlAgendamentosPaciente->bindParam(1,$idPaciente);
                                            $sqlAgendamentosPaciente->execute();                                            
                                        ?>                                    
                                                                            
                                        <div class="form-group col-md-6 col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><Legend>Historico de Agendamento</legend></div>
                                                <div class="card-body">
                                                    <?php 
                                                        if($sqlAgendamentosPaciente->rowCount()<=0){
                                                                echo "Sem histórico de agendamento!";
                                                        }else{
                                                    ?>   
                                                        <table width="100%" class=" table-sm table-bordered table-hover">                        
                                                            <tr align="center">
                                                                <th>ID</td>
                                                                <th>Medico</td>
                                                                <th>Data</td>
                                                                <th>Hora</td> 
                                                                <th>Status</td>                                     
                                                            </tr>                                           
                                                            <?php                                                
                                                                while($rowAgendamentosPaciente = $sqlAgendamentosPaciente->fetch(PDO::FETCH_OBJ)){ 
                                                            ?>
                                                            <tr align="center">                                                  
                                                                <td><?php if(($_SESSION['tipo_usu']=='recepcionista') && ($rowAgendamentosPaciente->dta_data_age == date('Y-m-d'))) { ?><a href="agendamento-detalhes.php?acao=detalhes&agendamento=<?php echo base64_encode($rowAgendamentosPaciente->num_id_age)?>"><i class="fa fa-address-card" aria-hidden="true"></i></a><?php }else { ?><i class="fa fa-address-card" aria-hidden="true"></i> <?php } ?></td>
                                                                <td><?php echo ucwords($rowAgendamentosPaciente->txt_nome_med) ?></td> 
                                                                <td><?php echo date("d/m/Y", strtotime($rowAgendamentosPaciente->dta_data_age)) ?></td>
                                                                <td><?php echo $rowAgendamentosPaciente->hor_hora_age ?></td>
                                                                <td><?php echo ucwords($rowAgendamentosPaciente->txt_status_age) ?></td>                                                                                                                                                           
                                                            </tr>
                                                            <?php }  ?> 
                                                        </table> 
                                                    <?php 
                                                        } 
                                                    ?>
                                                </div>
                                            </div>                                      
                                        </div>                             
                                        
                                    <!--fim agendamentos Paciente-->

                                    <!--Historico de atendimentos Paciente-->
                                        <?php                                    
                                            $sqlHistoricoPaciente = $con->prepare("SELECT atendimento.num_id_aten,atendimento.tbl_paciente_pac_num_id_pac,atendimento.dth_registro_aten,medico.txt_nome_med,procedimentos.txt_nome_pro,categoria.txt_nome_cat 
                                                    
                                                FROM tbl_atendimento_aten atendimento
                                                    
                                                LEFT JOIN tbl_medico_med medico ON medico.num_id_med = atendimento.tbl_medico_med_num_id_med
                                                LEFT JOIN tbl_procedimentos_pro procedimentos ON procedimentos.num_id_pro = atendimento.tbl_procedimentos_pro_num_id_pro
                                                LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = atendimento.tbl_categoria_cat_num_id_cat
                                                    
                                                WHERE tbl_paciente_pac_num_id_pac = ? ORDER BY dth_registro_aten DESC limit 10");

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
                                                            <table width="100%" class=" table-sm table-hover table-bordered">                        
                                                                <tr align="center">
                                                                    <th>ID</td>
                                                                    <th>Categoria</td> 
                                                                    <th>Medico</td>
                                                                    <th>Procedimento</td>                   
                                                                    <th>Data</td>                                                   
                                                                </tr>                                           
                                                                <?php 
                                                                    while($rowHistoricoPaciente = $sqlHistoricoPaciente->fetch(PDO::FETCH_OBJ)){ 
                                                                ?>
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
                                    <!--fim Historico de atendimentos Paciente-->                        
                    
                        </div>          
        </form>
    
    </body>
    <script type="text/javascript" src="javascript/cadastro_paciente.js"></script>
    <script>
    // Exemplo de JavaScript inicial para desativar envios de formulário, se houver campos inválidos.
    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Pega todos os formulários que nós queremos aplicar estilos de validação Bootstrap personalizados.
        var forms = document.getElementsByClassName('needs-validation');
        // Faz um loop neles e evita o envio
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();
    </script>
    <?php
        }
    ?>
</html>