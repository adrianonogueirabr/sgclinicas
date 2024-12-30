<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?php

        include_once "conexao.php";

        $idCategoria = base64_decode($_GET['idCategoria']);

        $resCategoria = $con->prepare("SELECT categoria.num_id_cat, categoria.txt_nome_cat, categoria.num_retorno_cat,usuario.txt_login_usu,  categoria.txt_gera_remessa_convenio_cat,categoria.txt_gera_receber_caixa_cat, categoria.txt_ativo_cat 

        FROM tbl_categoria_cat categoria 
       
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = categoria.tbl_usuario_usu_num_id_usu 
        
        WHERE num_id_cat = ?");

        try{
            $resCategoria->bindParam(1,$idCategoria);

            $resCategoria->execute();

            if($resCategoria->rowCount()<=0){
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=consulta-categoria.php'><script type=\"text/javascript\">alert(\"Dados nao encontrados!\");</script>";
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
            
        while ($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){     
        
    ?>
        <body>
        <?php include "inicial.php"?>
        <form name="detalhes-categoria" class="needs-validation" novalidate action="processa-categoria.php?acao=salvar"  method="post">    
                        <div class="container col-md-12">								
                            <div class="card">
                                <div class="card-header"><h3>Dados de <?php echo ucfirst($rowCategoria->txt_nome_cat) ?></h3></div>
                                <div class="card-body"> 
                                    <div class="form-row"> 
                                        <div class="form-group col-md-3 col-sm-12"><label for="nome">Nome*</label>
                                            <input name="nome" required="required" type="text" value="<?php echo $rowCategoria->txt_nome_cat ?>" title="NOME DA CATEGORIA" required class="form-control"  />
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Nome!
                                            </div>
                                        </div>
                                    
                                        <div class="form-group col-md-3 col-sm-12"><label for="retorno">Dias Retorno*</label>
                                            <input name="retorno" type="number" class="form-control" value="<?php echo $rowCategoria->num_retorno_cat ?>" title="INFORME QUANTOS DIAS PARA RETORNO"  required="required" />
                                            <div class="invalid-feedback">
                                                Necessário preenchimento do campo Dias Retorno!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="geraremessa">Gera Remessa Convenio</label>
                                            <select name="geraremessa" class="form-control" required>
                                                <option <?php if($rowCategoria->txt_gera_remessa_convenio_cat=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                <option <?php if($rowCategoria->txt_gera_remessa_convenio_cat=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>		
                                            </select>
                                            <div class="invalid-feedback">
                                                Necessário informar se Gera Remessa de Convenio!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="geracaixa">Gera Recebimento Caixa</label>
                                            <select name="geracaixa" class="form-control" required>
                                                <option <?php if($rowCategoria->txt_gera_receber_caixa_cat=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                <option <?php if($rowCategoria->txt_gera_receber_caixa_cat=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Necessário informar se Gera Recebimento de Caixa!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-12"><label for="ativo">Ativo</label>
                                            <select name="ativo" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option <?php if($rowCategoria->txt_ativo_cat=='sim'){?> selected="selected"; <?php } ?> value="<?php echo 'sim' ?>">Sim</option>
                                                <option <?php if($rowCategoria->txt_ativo_cat=='nao'){?> selected="selected"; <?php } ?> value="<?php echo 'nao' ?>">Nao</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Necessário informar se categoria Ativo!
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6"><label for="usuariocadastro_">Usuario Cadastro</label>
                                            <input name="usuariocadastro_" class="form-control" type="text" readonly="readonly" title="USUARIO DE CADASTRO DO MEDICO" value="<?php echo $rowCategoria->txt_login_usu ?>" />
                                        </div>

                                        <div class="form-group col-md-6 col-sm-6">
                                        </div>

                                        <INPUT TYPE="hidden" name="idCategoria" id="idCategoria" value="<?php echo $rowCategoria->num_id_cat ?>">                                            
                                        
                                        <div class="form-group col-md-12 col-sm-12">
                                            <input type="submit" name="Alterar Dados"  value="Salvar Alterações" class="btn btn-outline-danger"  />
                                            <a href="consulta-categoria.php" class="btn btn-outline-warning " title="CLIQUE PARA CANCELAR">Cancelar</a>                                        
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