<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?php

        include_once "conexao.php";

        $idUsuario = base64_decode($_GET['idUsuario']);

        $resUsuario = $con->prepare("SELECT `num_id_usu`, `txt_tipo_usu`, `txt_nome_usu`, `txt_telefone_usu`,`dth_registro_usu`, `txt_login_usu`, `txt_senha_usu`, `txt_email_usu`, `txt_ativo_usu` FROM `tbl_usuario_usu` WHERE num_id_usu = ?");

        try{
            $resUsuario->bindParam(1,$idUsuario);

            $resUsuario->execute();
            
            if($resUsuario->rowCount()<=0){
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-usuario.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
            
        while ($rowUsuario = $resUsuario->fetch(PDO::FETCH_OBJ)){     
        
    ?>
        <body>
        <?php include "inicial.php"?>
        <form name="detalhes-usuario" class="needs-validation" novalidate  action="processa-usuario.php?acao=salvar"  method="post">    
                        <div class="container col-md-12">								
                            <div class="card">
                                <div class="card-header"><h3>Dados de <?php echo ucfirst($rowUsuario->txt_nome_usu) ?></h3></div>
                                <div class="card-body"> 
                                    <div class="form-row">
                                            <div class="form-group col-md-2 col-sm-12"><label for="id">ID*</label>
                                                <input name="id" id="id"  type="text" value="<?php echo $rowUsuario->num_id_usu ?>" title="ID DO USUARIO" readonly required class="form-control"  />
                                            </div>

                                            <div class="form-group col-md-6 col-sm-12"><label for="nome">Nome*</label>
                                                <input name="nome" id="nome"  type="text" value="<?php echo $rowUsuario->txt_nome_usu ?>" title="NOME DO USUARIO" required class="form-control"  />
                                                <div class="invalid-feedback">
                                                    Necessário preenchimento do campo nome!
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-12"><label for="login">Login*</label>
                                                <input name="login" id="login"  type="text" value="<?php echo $rowUsuario->txt_login_usu ?>" title="LOGIN DO USUARIO" required class="form-control"  />
                                                <small id="emailHelp" class="form-text text-muted">Ex.: nome.sobrenome</small>
                                                <div class="invalid-feedback">
                                                    Necessário preenchimento do campo Login!
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6"><label for="tipo">Tipo*</label>        
                                                <select name="tipo" id="tipo" class="form-control">
                                                    <option <?php if($rowUsuario->txt_tipo_usu=='administrador'){?> selected="selected"; <?php } ?> value="<?php echo 'administrador' ?>">Administrador</option>
                                                    <option <?php if($rowUsuario->txt_tipo_usu=='financeiro'){?> selected="selected"; <?php } ?> value="<?php echo 'financeiro' ?>">Financeiro</option>
                                                    <option <?php if($rowUsuario->txt_tipo_usu=='agendamento'){?> selected="selected"; <?php } ?> value="<?php echo 'agendamento' ?>">Agendamento</option>
                                                    <option <?php if($rowUsuario->txt_tipo_usu=='recepcionista'){?> selected="selected"; <?php } ?> value="<?php echo 'recepcionista' ?>">Recepcionista</option>
                                                    <option <?php if($rowUsuario->txt_tipo_usu=='medico'){?> selected="selected"; <?php } ?> value="<?php echo 'medico' ?>">Medico</option>
                                                </select>
                                            </div>
                                        
                                            <div class="form-group col-md-4 col-sm-6"><label for="telefone">Telefone*</label>
                                                <input name="telefone" type="number" class="form-control" required="required"  value="<?php echo $rowUsuario->txt_telefone_usu ?>" title="TELEFONE CELULAR OU FIXO DO USUARIO" />
                                                <small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 99999999999</small>
                                                <div class="invalid-feedback">
                                                    Necessário preenchimento do campo Telefone!
                                                </div>
                                            </div>                            

                                            <div class="form-group col-md-4 col-sm-6"><label for="email">Email</label>
                                                <input name="email"  class="form-control" type="text"  title="EMAIL DE USUARIO"  value="<?php echo $rowUsuario->txt_email_usu ?>" />
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6"><label for="senha">Senha*</label>
                                                <input name="senha"  class="form-control" type="password" required title="SENHA DE USUARIO"  value="<?php echo $rowUsuario->txt_senha_usu ?>" />
                                                <div class="invalid-feedback">
                                                    Necessário preenchimento do campo Senha!
                                                </div>
                                            </div>
                                        
                                            <div class="form-group col-md-4 col-sm-6"><label for="ativo">Cadastro Ativo</label>        
                                                <select name="ativo"  class="form-control" >	
                                                    <option <?php if($rowUsuario->txt_ativo_usu=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                    <option <?php if($rowUsuario->txt_ativo_usu=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6"><label for="registro_">Data Cadastro</label>
                                                <input name="registro_" class="form-control" type="text" readonly="readonly" title="DATA DE REGISTRO DO USUARIO" value="<?php echo date("d/m/Y H:i:s", strtotime($rowUsuario->dth_registro_usu)); ?>" />
                                            </div>

                                            <INPUT TYPE="hidden" name="idUsuario" id="idUsuario" value="<?php echo $rowUsuario->num_id_usu ?>">                                                

                                            <div class="form-group col-sm-12">
                                                <input type="submit" name="Alterar Dados"  value="Salvar Alterações" class="btn btn-outline-danger"  />                                                
                                                <a href="consulta-usuario.php" class="btn btn-outline-warning " title="CLIQUE PARA CANCELAR">Cancelar</a>
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