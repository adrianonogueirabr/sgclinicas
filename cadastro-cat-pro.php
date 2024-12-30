
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>
<form  name="catpro"  class="needs-validation" novalidate  action="processa-cat-pro.php?acao=cadastrar" method="post">
			<div class="container col-md-12">			
					<div class="card">
					<div class="card-header"><h3>Cadastro de Procedimento X Categoria</h3></div>
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-4 col-sm-12"><label for="procedimento">Procedimento*</label>
										<select name="procedimento"  class="form-control" title="SELECIONE O PROCEDIMENTO" required>
										<option value="">Selecione</option>
											<?php
											include "conexao.php"; 
											$resProcedimento=$con->prepare("SELECT num_id_pro, txt_nome_pro FROM tbl_procedimentos_pro WHERE txt_ativo_pro = 'sim' order by txt_nome_pro");
											$resProcedimento->execute();

											while($rowProcedimento = $resProcedimento->fetch(PDO::FETCH_OBJ)){?>
												<option value="<?php echo $rowProcedimento->num_id_pro ?>"><?php echo $rowProcedimento->txt_nome_pro ?></option>
											<?php } ?>
										</select>
										<div class="invalid-feedback">
											Necessário selecionar o Procedimento!
										</div>
								</div>

								<div class="form-group col-md-4  col-sm-6"><label for="categoria">Categoria*</label>
										<select name="categoria"  class="form-control" title="SELECIONE A CATEGORIA" required>
											<option value="">Selecione</option>
											<?php
											include "conexao.php"; 
											$resCategoria=$con->prepare("SELECT num_id_cat, txt_nome_cat FROM tbl_categoria_cat WHERE txt_ativo_cat = 'sim' order by txt_nome_cat");
											$resCategoria->execute();

											while($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){?>
												<option value="<?php echo $rowCategoria->num_id_cat ?>"><?php echo $rowCategoria->txt_nome_cat ?></option>
											<?php } ?>
										</select>
										<div class="invalid-feedback">
											Necessário selecionar a Categoria!
										</div>									
								</div>
								
								<div class="form-group col-md-4 col-sm-12"><label for="valor">Valor*</label>
									<input name="valor" type="double" class="form-control"   title="INFORME O VALOR DO PROCEDIMENTO NESTA CATEGORIA"  required="required" />
									<small id="emailHelp" class="form-text text-muted">Use ponto no lugar de virgula Ex.: 300.50</small>
									<div class="invalid-feedback">
										Necessário preenchimento do Valor!
									</div>									
								</div>
								
								<div class="form-group col-md-2">
									<input type="submit" name="registrar"  value="Registrar Dados" class="btn btn-outline-primary" />
								</div>	
						
							</div>
						</div>
					</div>										
				</form>										
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