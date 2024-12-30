
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>
<form  name="procedimento"  class="needs-validation" novalidate  action="processa-procedimento.php?acao=cadastrar" method="post">
			<div class="container col-md-12">			
					<div class="card">
					<div class="card-header"><h3>Cadastro de Procedimento</h3></div>
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-3 col-sm-12"><label for="nome">Nome*</label>
									<input name="nome" type="text" class="form-control" title="INFORME O NOME DO PROCEDIMENTO"  required="required"/>
									<div class="invalid-feedback">
										Necessário preenchimento do campo Nome!
									</div>
								</div>

								<div class="form-group col-md-6 col-sm-12"><label for="Descricao">Descricao</label>
									<input name="descricao" type="text" class="form-control" title="INFORME DESCRICAO DO EXAME" />
								</div>

								<div class="form-group col-md-3 col-sm-12"><label for="tipo">Tipo*</label>
									<select name="tipo" class="form-control" required>
										<option value="">Selecione</option>
										<option value="consulta">Consulta</option>
										<option value="exame">Exame</option>		
									</select>
									<div class="invalid-feedback">
										Necessário informar o tipo de Procedimento!
									</div>
								</div>

								<div class="form-group col-md-12 col-sm-12"><label for="Recomendacoes">Recomendacoes*</label>
									<textarea name="recomendacoes" type="text" class="form-control" title="INFORME O NOME DO PROCEDIMENTO"  required="required"></textarea>
									<small id="emailHelp" class="form-text text-muted">Digitar Nao Possui caso nao haja recomendações</small>
									<div class="invalid-feedback">
										Necessário preenchimento do campo Recomendacoes!
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