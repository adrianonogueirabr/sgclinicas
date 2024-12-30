
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>
<form  name="usuario" class="needs-validation" novalidate action="processa-usuario.php?acao=cadastrar" method="post">
			<div class="container col-md-12">				
					<div class="card">
					<div class="card-header"><h3>Cadastro de Usuarios</h3></div>
						<div class="card-body">
							<div class="form-row">
									<div class="form-group col-md-4 col-sm-6"><label for="tipo">Tipo*</label>        
										<select name="tipo"  class="form-control">		    
											<option value="administrador">Administrador</option>
											<option value="financeiro">Financeiro</option>
											<option value="agendamento">Agendamento</option>
											<option value="recepcionista">Recepcionista</option>
											<option value="medico">Medico</option>
										</select>
									</div>

									<div class="form-group col-md-4 col-sm-12"><label for="nome">Nome*</label>
										<input name="nome" type="text" id="name" class="form-control" id="nome"  title="INFORME NOME DO USUARIO"  required="required" />
										<div class="invalid-feedback">
											Necessário preenchimento do campo nome!
										</div>
									</div>

									<div class="form-group col-md-4 col-sm-12"><label for="login">Login*</label>
										<input name="login" type="text" class="form-control" id="login"  title="INFORME LOGIN DO USUARIO"  required="required" />
										<small id="emailHelp" class="form-text text-muted">Ex.: nome.sobrenome</small>
										<div class="invalid-feedback">
											Necessário preenchimento do campo Login!
										</div>
									</div>

									<div class="form-group col-md-4 col-sm-12"><label for="senha">Senha*</label>
										<input name="senha" type="password" class="form-control" id="senha"  title="INFORME SENHA DO USUARIO"  required="required" />
										<div class="invalid-feedback">
											Necessário preenchimento do campo Senha!
										</div>
									</div>

									<div class="form-group col-md-4 col-sm-12"><label for="email">Email*</label>
										<input name="email" type="email" class="form-control" id="email"  title="INFORME EMAIL DO USUARIO"  required="required" />
										<div class="invalid-feedback">
											Necessário preenchimento do campo Email!
										</div>
									</div>

									<div class="form-group col-md-4 col-sm-12"><label for="telefone">Telefone*</label>
										<input name="telefone" type="number" class="form-control" id="telefone"  title="INFORME TELEFONE DO USUARIO"  required="required" />
										<small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 99999999999</small>
										<div class="invalid-feedback">
											Necessário preenchimento do campo Telefone!
										</div>
									</div>

									<div class="form-group col-md-2">
										<input type="submit" name="registrar"  value="Registrar Dados" class="btn btn-outline-primary" />
									</div>
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