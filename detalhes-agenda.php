<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?php

        include_once "conexao.php";

        $idPaciente = base64_decode($_GET['idPaciente']);

        $resPaciente = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, usuario.txt_login_usu as 'usuario_cadastro', profissao.txt_nome_pro, paciente.txt_nome_pac, 

        paciente.txt_cpf_pac, paciente.txt_rg_pac, paciente.txt_cor_pac, paciente.txt_sexo_pac, paciente.dta_datanascimento_pac, paciente.txt_email_pac, paciente.txt_telefone_pac, paciente.txt_senha_pac, 
        
        paciente.txt_estadocivil_pac,paciente.txt_cep_pac, paciente.txt_logradouro_pac, paciente.num_numero_pac, paciente.txt_complemento_pac, paciente.txt_bairro_pac, paciente.txt_cidade_pac, 
        
        paciente.txt_estado_pac, paciente.txt_matricula_pac, paciente.val_saldo_pac, paciente.txt_pne_pac, paciente.txt_cns_pac, paciente.txt_carteira_pac, paciente.dta_vencimento_carteira_pac, 
        
        paciente.dth_registro_pac, usuarioalt.txt_login_usu as 'usuario_alteracao', paciente.dth_alteracao_pac, paciente.txt_bloquear_agendamento_pac, paciente.txt_observacoes_pac, paciente.dta_ultima_visita_pac, 
        
        paciente.txt_ativo_pac 
        
        FROM tbl_paciente_pac paciente
        
        LEFT JOIN tbl_profissao_pro profissao ON profissao.num_id_pro = paciente.tbl_profissao_pro_num_id_pro
        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
        LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = paciente.tbl_usuario_usu_num_id_usu
        LEFT JOIN tbl_usuario_usu usuarioalt ON usuarioalt.num_id_usu = paciente.num_usuario_alteracao_pac
        
        WHERE num_id_pac = ?");

        $resPaciente->bindParam(1,$idPaciente);
        if (!$resPaciente->execute()) { echo "Error: " . $sql . "<br>" . mysqli_error();}
            
        while ($rowPaciente = $resPaciente->fetch(PDO::FETCH_OBJ)){     
        
    ?>
        <body>
        <form name="detalhes-pacientes" action="processa-pacientes.php?acao=salvar"  method="post">    
            <table width="100%" class="table responsive">
                <tr>
                    <td> <?php include "inicial.php"?></td>
                </tr>
                <tr>
                    <td><legend class="p-4 table-primary">Detalhes: <?php echo ucwords($rowPaciente->txt_nome_pac) ?></legend></td>
                </tr>
                <tr>
                    <td>
                        <div class="form-row"> 
                            <div class="form-group col-md-3 col-sm-6"><label for="cpf">CPF</label>
                                <input name="cpf" id="cpf"   type="text" title="CPF DO PACIENTE" value="<?php echo $rowPaciente->txt_cpf_pac ?>" class="form-control"  />
                            </div>

                            <div class="form-group col-md-6 col-sm-12"><label for="nome">Nome*</label>
                                <input name="nome" id="nome"  type="text" value="<?php echo $rowPaciente->txt_nome_pac ?>" title="NOME DO PACIENTE" required class="form-control"  />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="datanascimento">Data de Nascimento*</label>
                                <a href="alterar-data-nascimento.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">                
                                <input name="datanascimento" id="datanascimento"  class="form-control" title="DATA DE NASCIMENTO DO PACIENTE CLIQUE PARA ALTERAR"value="<?php echo date("d/m/Y", strtotime($rowPaciente->dta_datanascimento_pac)) ?>" readonly="readonly" /></a>            
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="categoria">Categoria</label>
                                <a href="alterar-categoria.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="categoria" class="form-control" type="text" readonly="readonly" title="CATEGORIA DE ATENDIMENTO DO PACIENTE CLIQUE PARA ALTERAR" value="<?php echo $rowPaciente->txt_nome_cat ?>" /></a>
                            </div> 
                            
                            <div class="form-group col-md-3 col-sm-6"><label for="estadocivil">Estado Civil</label>
                                <a href="alterar-estado-civil.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="estadocivil" id="estadocivil" type="text" class="form-control" readonly="readonly" value="<?php echo $rowPaciente->txt_estadocivil_pac ?>" title="ESTADO CIVIL DO PACIENTE CLIQUE PARA ALTERAR" /></a>
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="cor">Cor</label>
                                <a href="alterar-cor.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="cor" id="cor" type="text" class="form-control" readonly="readonly" value="<?php echo $rowPaciente->txt_cor_pac ?>" title="COR DO PACIENTE CLIQUE PARA ALTERAR" /></a>
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="sexo">Sexo</label>
                                <a href="alterar-sexo.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="sexo" id="sexo" type="text" class="form-control" readonly="readonly" value="<?php echo $rowPaciente->txt_sexo_pac ?>" title="SEXO DO PACIENTE CLIQUE PARA ALTERAR" /></a>
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="profissao">Profissao</label>
                                <a href="alterar-profissao.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="profissao" id="profissao" type="text" class="form-control" readonly="readonly" value="<?php echo $rowPaciente->txt_nome_pro ?>" title="PROFISSAO DO PACIENTE CLIQUE PARA ALTERAR" /></a>
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="medico">Medico</label>
                                <a href="alterar-medico.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="medico" id="medico" type="text" class="form-control" readonly="readonly" value="<?php echo $rowPaciente->txt_nome_med ?>" title="MEDICO DO PACIENTE CLIQUE PARA ALTERAR" /></a>
                            </div>
                            
                            <div class="form-group col-md-3 col-sm-6"><label for="telefone">Telefone*</label>
                                <input name="telefone" id="telefone" type="text" class="form-control" required value="<?php echo $rowPaciente->txt_telefone_pac ?>" title="TELEFONE CELULAR OU FIXO DO PACIENTE" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="email">Email</label>
                                <input name="email" id="email" class="form-control" type="email" value="<?php echo $rowPaciente->txt_email_pac ?>" title="EMAIL DO PACIENTE" />
                            </div>                            

                            <div class="form-group col-md-3 col-sm-6"><label for="cep">CEP</label>
                                <span id="msgAlertaCepNaoEncontrado"></span>
                                <input name="cep" id="cep" class="form-control" type="text" size="8" onblur="pesquisacep(this.value);"  value="<?php echo $rowPaciente->txt_cep_pac; ?>" title="CEP DO PACIENTE" />
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
                            
                            <div class="form-group col-md-3 col-sm-6"><label for="rg">RG</label>
                                <input name="rg" id="rg" type="text" class="form-control" value="<?php echo $rowPaciente->txt_rg_pac ?>" title="RG DO PACIENTE" />
                            </div>
                            
                            <div class="form-group col-md-3 col-sm-6"><label for="matricula">Matricula Convenio</label>
                                <input name="matricula" id="matricula" class="form-control" type="text" title="MATRICULA DO PACIENTE NO CONVENIO" value="<?php echo $rowPaciente->txt_matricula_pac ?>" />
                            </div>            

                            <div class="form-group col-md-3 col-sm-6"><label for="carteira">Carteira Convenio</label>
                                <input name="carteira" id="carteira" class="form-control" type="text" title="NUMERO CARTEIRA DO CONVENIO DO PACIENTE" value="<?php echo $rowPaciente->txt_carteira_pac ?>" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="vendimento_carteira">Vencimento Carteira</label>
                                <a href="alterar-data-carteira.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="vendimento_carteira" class="form-control" readonly="readonly" type="text" title="DATA VENCIMENTO CARTEIRA DO CONVENIO DO PACIENTE CLIQUE PARA ALTERAR" value="<?php if($rowPaciente->dth_alteracao_pac != NULL){ echo date("d/m/Y", strtotime($rowPaciente->dta_vencimento_carteira_pac));} ?>" /></a>
                            </div>            

                            <div class="form-group col-md-3 col-sm-6"><label for="cns">CNS</label>
                                <input name="cns" id="cns" class="form-control" type="text" title="NUMERO CARTEIRA NACIONAL DE SAUDE DO PACIENTE" value="<?php echo $rowPaciente->txt_cns_pac ?>" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="saldo_">Saldo Paciente</label>
                                <input name="saldo_" class="form-control" type="text" readonly="readonly" value="R$<?php echo number_format($rowPaciente->VAL_SALDO_CLI,2) ?>" title="SALDO EM ADIANTAMENTO DO PACIENTE" disabled="disabled" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="bloqueio_agendamento">Bloqueio de Agendamento</label>
                                <a href="alterar-bloqueio-agendamento.php?idPaciente=<?php echo base64_encode($idPaciente) ?>" target="_self">
                                <input name="bloqueio_agendamento" class="form-control" type="text" readonly="readonly" title="BLOQUEAR AGENDAMENTO DE PACIENTE CLIQUE PARA ALTERAR" value="<?php echo $rowPaciente->txt_bloquear_agendamento_pac ?>" /></a>
                            </div>
                            
                            <div class="form-group col-md-3 col-sm-6"><label for="ativo">Cadastro Paciente Ativo</label>        
                                <select name="ativo" id="ativo" class="form-control" >		    
                                    <option value="SIM">SIM</option>
                                    <option value="NAO">NAO</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="usuariocadastro_">Usuario Cadastro</label>
                                <input name="usuariocadastro_" class="form-control" type="text" readonly="readonly" title="USUARIO DE CADASTRO DO PACIENTE" value="<?php echo $rowPaciente->usuario_cadastro ?>" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="registro_">Paciente Desde</label>
                                <input name="registro_" class="form-control" type="text" readonly="readonly" title="DATA DE REGISTRO DO PACIENTE" value="<?php echo date("d/m/Y H:i:s", strtotime($rowPaciente->dth_registro_pac)); ?>" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="usuarioalteracao_">Usuario Alteracao</label>
                                <input name="usuarioalteracao_" class="form-control" type="text" readonly="readonly" title="USUARIO DE ALTERACAO DO PACIENTE" value="<?php echo $rowPaciente->usuario_alteracao ?>" />
                            </div>

                            <div class="form-group col-md-3 col-sm-6"><label for="alteracao_">Data Ultima Alteracao</label>
                                <input name="alteracao_" class="form-control" type="text" readonly="readonly" title="DATA DA ULTIMA ALTERACAO DO PACIENTE" value="<?php if($rowPaciente->dth_alteracao_pac != NULL){ echo date("d/m/Y H:i:s",strtotime($rowPaciente->dth_alteracao_pac)); } ?>"/>
                            </div>            

                            <INPUT TYPE="hidden" name="idPaciente" id="idPaciente" value="<?php echo $rowPaciente->num_id_pac ?>">
                                
                            <?php
                                }
                            ?>
                            <div class="form-group col-md-2 col-sm-12">
                                <input type="submit" name="Alterar Dados"  value="Salvar Dados" class="btn btn-outline-danger"  />
                            </div>
                        </div>        
                    </td>
                </tr>
            </table>
        </form>
    <script type="text/javascript" src="javascript/cadastro_paciente.js"></script>
    </body>
</html>