<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?php

        include_once "conexao.php";

        $idMedico = base64_decode($_GET['idMedico']);

        $resMedico = $con->prepare("SELECT medico.num_id_med, especialidade.txt_nome_esp, usuario.txt_login_usu,  medico.txt_registro_med,especialidade.txt_nome_esp,  
      
        medico.txt_nome_med, medico.txt_cpf_med, medico.txt_telefone_med, medico.txt_sexo_med, medico.txt_observacao_med, medico.dth_registro_med,  medico.num_repasse_exame_particular_med, 
                        
        medico.num_repasse_consulta_particular_med, medico.num_repasse_exame_convenio_med,medico.num_repasse_consulta_convenio_med, medico.num_idsistema_med, medico.txt_ativo_med 

        FROM tbl_medico_med medico 
       
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = medico.tbl_usuario_usu_num_id_usu 

        LEFT JOIN tbl_especialidade_esp especialidade ON especialidade.num_id_esp = medico.tbl_especialidade_esp_num_id_esp
        
        WHERE num_id_med = ?");

        try{
            $resMedico->bindParam(1,$idMedico);

            $resMedico->execute();

            if($resMedico->rowCount()<=0){
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-medico.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
            
        while ($rowMedico = $resMedico->fetch(PDO::FETCH_OBJ)){     
        
    ?>
        <body>
        <form name="detalhes-medicos" class="needs-validation" novalidate action="processa-medico.php?acao=salvar"  method="post"> 
        <?php include "inicial.php"?>   
                        <div class="container col-md-12">								
                            <div class="card">
                                <div class="card-header"><h3>Dados de <?php echo ucfirst($rowMedico->txt_nome_med) ?></h3></div>
                                <div class="card-body"> 
                                    <div class="form-row"> 
                                        <div class="form-group col-md-3 col-sm-6"><label for="cpf">CPF</label>
                                            <input name="cpf" id="cpf" required="required"  type="number" title="CPF DO MEDICO" value="<?php echo $rowMedico->txt_cpf_med ?>" class="form-control"  />
                                            <small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 99999999999</small>
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo CPF!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="nome">Nome*</label>
                                            <input name="nome" required="required" id="nome"  type="text" value="<?php echo $rowMedico->txt_nome_med ?>" title="NOME DO MEDICO" required class="form-control"  />
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Nome!
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-3 col-sm-6"><label for="telefone">Telefone*</label>
                                            <input name="telefone" required="required" id="telefone" type="number" class="form-control" required value="<?php echo $rowMedico->txt_telefone_med ?>" title="TELEFONE CELULAR OU FIXO DO MEDICO" />
                                            <small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 92988887777</small>
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Telefone!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="sexo">Sexo</label>
                                            <select name="sexo" id="sexo" class="form-control" >	
                                                <option <?php if($rowMedico->txt_sexo_med=='masculino'){?> selected="selected"; <?php } ?> value="<?php echo 'masculino' ?>">Masculino</option>
                                                <option <?php if($rowMedico->txt_sexo_med=='feminino'){?> selected="selected"; <?php } ?> value="<?php echo 'feminino' ?>">Feminino</option>
                                                <option <?php if($rowMedico->txt_sexo_med=='nao informar'){?> selected="selected"; <?php } ?> value="<?php echo 'nao informar' ?>">Nao Informar</option>nao informado
                                                <option <?php if($rowMedico->txt_sexo_med=='nao informado'){?> selected="selected"; <?php } ?> value="<?php echo 'nao informado' ?>">nao informado</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="exame">Porcentagem Exame Particular</label>
                                            <input name="exameparticular" required="required"  class="form-control" type="number" title="INFORME % DE REPASSE AO MEDICO" value="<?php echo $rowMedico->num_repasse_exame_particular_med ?>" />
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="consulta">Porcentagem Consulta Particular</label>
                                            <input name="consultaparticular" required="required"  class="form-control" type="number" title="INFORME % DE REPASSE AO MEDICO" value="<?php echo $rowMedico->num_repasse_consulta_particular_med ?>" />
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="exame">Porcentagem Exame Convenio</label>
                                            <input name="exameconvenio" required="required"  class="form-control" type="number" title="INFORME % DE REPASSE AO MEDICO" value="<?php echo $rowMedico->num_repasse_exame_convenio_med ?>" />
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo!
                                            </div>
                                        </div>                                        

                                        <div class="form-group col-md-3 col-sm-6"><label for="particular">Porcentagem Consulta Convenio</label>
                                            <input name="consultaconvenio" required="required"  class="form-control" type="number" title="INFORME % DE REPASSE AO MEDICO" value="<?php echo $rowMedico->num_repasse_consulta_convenio_med ?>" />
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12"><label for="observacoes">Observacoes</label>
                                            <input name="observacao" type="text" class="form-control" value="<?php echo $rowMedico->txt_observacao_med ?>" title="ALGUMAS OBSERVACOES SOBRE O MEDICO" />
                                        </div>

                                        <div class="form-group  col-md-3 col-sm-6"><label for="medico">Especialidade*</label>
                                            <select name="especialidade" id="especialidade" class="form-control" title="SELECIONE ESPECIALIDADE DO MEDICO">
                                                <?php
                                                    include "conexao.php"; 
                                                    $resEspecialidade=$con->prepare("SELECT num_id_esp, txt_nome_esp FROM tbl_especialidade_esp WHERE txt_ativo_esp = 'SIM' order by txt_nome_esp");
                                                    $resEspecialidade->execute();

                                                    while($rowEspecialidade = $resEspecialidade->fetch(PDO::FETCH_OBJ)){?>
                                                        <option <?php if($rowEspecialidade->txt_nome_esp ==$rowMedico->txt_nome_esp) {?> selected="selected" ; <?php } ?>value="<?php echo $rowEspecialidade->num_id_esp ?>"><?php echo $rowEspecialidade->txt_nome_esp ?></option>                                                                                                                
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="idsistema">ID Sistema</label>
                                            <input name="idsistema"  class="form-control" required="required" type="number"  title="ID DE USUARIO DO MEDICO"  value="<?php echo $rowMedico->num_idsistema_med ?>" />
                                            <small id="emailHelp" class="form-text text-muted">Informar ID de Usuario</small>
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo ID de Sistema!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="registro">Registro Medico*</label>
                                            <input name="registro" class="form-control" required="required" type="text"  title="REGISTRO DO MEDICO" placeholder="Ex CRM123 OU CRO123" value="<?php echo $rowMedico->txt_registro_med ?>" />
                                            <small id="emailHelp" class="form-text text-muted">Ex.: CRM123 ou CRO321</small>
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Registro Medico!
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-3 col-sm-6"><label for="ativo">Cadastro Medico Ativo</label>        
                                            <select name="ativo" id="ativo" class="form-control" >	
                                                <option <?php if($rowMedico->txt_ativo_med=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                <option <?php if($rowMedico->txt_ativo_med=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="usuariocadastro_">Usuario Cadastro</label>
                                            <input name="usuariocadastro_" class="form-control" type="text" readonly="readonly" title="USUARIO DE CADASTRO DO MEDICO" value="<?php echo $rowMedico->txt_login_usu ?>" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="registro_">Data Cadastro</label>
                                            <input name="registro_" class="form-control" type="text" readonly="readonly" title="DATA DE REGISTRO DO MEDICO" value="<?php echo date("d/m/Y H:i:s", strtotime($rowMedico->dth_registro_med)); ?>" />
                                        </div>

                                        <INPUT TYPE="hidden" name="idmedico" id="idmedico" value="<?php echo $rowMedico->num_id_med ?>">                                            
                                        
                                        <div class="form-group col-md-12 col-sm-12">
                                            <input type="submit" name="Alterar Dados"  value="Salvar Alterações" class="btn btn-outline-danger"  />
                                            <a href="consulta-medico.php" class="btn btn-outline-warning " title="CLIQUE PARA CANCELAR">Cancelar</a>                                        
                                        </div>
                                        
                                        <?php
                                            }
                                        ?>
                            
                                    </div>        
                                </div>
                            </div>
                        </div>
        </form>    
    </body>
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
</html>