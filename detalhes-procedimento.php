<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?php

        include_once "conexao.php";

        $idProcedimento = base64_decode($_GET['idProcedimento']);

        $resProcedimento = $con->prepare("SELECT procedimento.num_id_pro, usuario.txt_login_usu,procedimento.txt_nome_pro, procedimento.txt_descricao_pro, procedimento.txt_tipo_pro, 
        
        procedimento.txt_recomendacoes_pro, procedimento.txt_ativo_pro 
    
        FROM tbl_procedimentos_pro procedimento
        
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = procedimento.tbl_usuario_usu_num_id_usu 
        
        WHERE num_id_pro = ?");

        try{
            $resProcedimento->bindParam(1,$idProcedimento);

            $resProcedimento->execute();

            if($resProcedimento->rowCount()<=0){
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-procedimento.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
            
        while ($rowProcedimento = $resProcedimento->fetch(PDO::FETCH_OBJ)){     
        
    ?>
        <body>
        <?php include "inicial.php"?>
        <form name="detalhes-procedimento" class="needs-validation" novalidate action="processa-procedimento.php?acao=salvar"  method="post">    
                        <div class="container col-md-12">								
                            <div class="card">
                                <div class="card-header"><h3>Dados de <?php echo ucfirst($rowProcedimento->txt_nome_pro) ?></h3></div>
                                <div class="card-body"> 
                                    <div class="form-row"> 
                                        <div class="form-group col-md-3 col-sm-12"><label for="nome">Nome*</label>
                                            <input name="nome" type="text" class="form-control" value="<?php echo $rowProcedimento->txt_nome_pro ?>" title="INFORME O NOME DO PROCEDIMENTO"  required="required"/>
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Nome!
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-6 col-sm-12"><label for="descricao">Descricao</label>
                                            <input name="descricao" type="text" class="form-control" value="<?php echo $rowProcedimento->txt_descricao_pro ?>" title="INFORME A DESCRICAO DO PROCEDIMENTO" />
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="tipo">Tipo</label>
                                            <select name="tipo" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option <?php if($rowProcedimento->txt_tipo_pro=='exame'){?> selected="selected"; <?php } ?> value="<?php echo 'exame' ?>">Exame</option>
                                                <option <?php if($rowProcedimento->txt_tipo_pro=='consulta'){?> selected="selected"; <?php } ?> value="<?php echo 'consulta' ?>">Consulta</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Necessário informar tipo do Procedimento!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 col-sm-12"><label for="Recomendacoes">Recomendacoes*</label>
                                            <textarea name="recomendacoes" type="text" class="form-control"  title="DIGITE AS RECOMENDACOES DO PROCEDIMENTO"  required="required"><?php echo $rowProcedimento->txt_recomendacoes_pro ?></textarea>
                                            <small id="emailHelp" class="form-text text-muted">Digitar Nao Possui caso nao haja recomendações</small>
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Recomendacoes!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="ativo">Ativo</label>
                                            <select name="ativo" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option <?php if($rowProcedimento->txt_ativo_pro=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                <option <?php if($rowProcedimento->txt_ativo_pro=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Necessário informar se procedimento esta Ativo!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="usuariocadastro_">Usuario Cadastro</label>
                                            <input name="usuariocadastro_" class="form-control" type="text" readonly="readonly" title="USUARIO DE CADASTRO DO MEDICO" value="<?php echo $rowProcedimento->txt_login_usu ?>" />
                                        </div>                                        

                                        <div class="form-group col-md-6 col-sm-6">
                                        </div>

                                        <INPUT TYPE="hidden" name="idProcedimento" value="<?php echo $rowProcedimento->num_id_pro ?>">                                            
                                        
                                        <div class="form-group  col-sm-12">
                                            <input type="submit" name="Alterar Dados"  value="Salvar Alterações" class="btn btn-outline-danger"  />
                                            <a href="consulta-procedimento.php" class="btn btn-outline-warning " title="CLIQUE PARA CANCELAR">Cancelar</a>
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