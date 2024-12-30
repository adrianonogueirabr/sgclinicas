
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>
<form  name="categoria"  class="needs-validation" novalidate  action="processa-categoria.php?acao=cadastrar" method="post">
			<div class="container col-md-12">			
					<div class="card">
					<div class="card-header"><h3>Cadastro de Categoria</h3></div>
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-3 col-sm-12"><label for="nome">Nome*</label>
									<input name="nome" type="text" class="form-control" title="INFORME O NOME DA CATEGORIA"  required="required"/>
									<div class="invalid-feedback">
										Necessário preenchimento do campo Nome!
									</div>
								</div>

								<div class="form-group col-md-3 col-sm-12"><label for="retorno">Dias Retorno*</label>
									<input name="retorno" type="number" class="form-control"  title="INFORME QUANTOS DIAS PARA RETORNO"  required="required" />
									<div class="invalid-feedback">
										Necessário preenchimento do campo Dias Retorno!
									</div>
								</div>

								<div class="form-group col-md-3 col-sm-12"><label for="geraremessa">Gera Remessa Convenio*</label>
									<select name="geraremessa" class="form-control" required>
										<option value="">Selecione</option>
										<option value="Sim">Sim</option>
										<option value="nao">Nao</option>		
									</select>
									<div class="invalid-feedback">
										Necessário informar se Gera Remessa de Convenio!
									</div>
								</div>

								<div class="form-group col-md-3 col-sm-12"><label for="geracaixa">Gera Recebimento Caixa*</label>
									<select name="geracaixa" class="form-control" required>
										<option value="">Selecione</option>
										<option value="Sim">Sim</option>
										<option value="nao">Nao</option>		
									</select>
									<div class="invalid-feedback">
										Necessário informar se Gera Recebimento de Caixa!
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