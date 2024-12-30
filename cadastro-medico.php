
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>
<form  name="medico"  class="needs-validation" novalidate  action="processa-medico.php?acao=cadastrar" method="post">
			<div class="container col-md-12">			
					<div class="card">
					<div class="card-header"><h3>Cadastro de Medicos</h3></div>
						<div class="card-body">
							<div class="form-row">
									<div class="form-group col-md-3  col-sm-6"><label for="medico">Especialidade*</label>
										<select name="especialidade" id="especialidade" class="form-control" title="SELECIONE ESPECIALIDADE DO MEDICO" required>
										<option value="">Selecione</option>
											<?php
												include "conexao.php"; 
												$resEspecialidade=$con->prepare("SELECT num_id_esp, txt_nome_esp FROM tbl_especialidade_esp WHERE txt_ativo_esp = 'SIM' order by txt_nome_esp");
												$resEspecialidade->execute();

												while($rowEspecialidade = $resEspecialidade->fetch(PDO::FETCH_OBJ)){?>
													<option value="<?php echo $rowEspecialidade->num_id_esp ?>"><?php echo $rowEspecialidade->txt_nome_esp ?></option>
											<?php } ?>
										</select>										
									</div>
								
								<div class="form-group col-md-3 col-sm-12"><label for="registro">Registro Medico*</label>
									<input name="registro" type="text" class="form-control" title="INFORME REGISTRO DO MEDICO"  required="required"/>
									<small id="emailHelp" class="form-text text-muted">Ex.: CRM123 ou CRO321</small>
									<div class="invalid-feedback">
										Necessário preenchimento do campo Registro Medico!
									</div>
								</div>

								<div class="form-group col-md-6 col-sm-12"><label for="nome">Nome*</label>
									<input name="nome" type="text" class="form-control"  title="INFORME NOME DO MEDICO"  required="required" />
									<div class="invalid-feedback">
										Necessário preenchimento do campo Nome!
									</div>
								</div>

								<div class="form-group col-md-4 col-sm-12"><label for="cpf">CPF*</label>
									<input name="cpf" type="number" class="form-control" minlength="11" maxlength="11"  title="INFORME CPF DO MEDICO"  required="required" />
									<small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 99999999999</small>
									<div class="invalid-feedback">
										Necessário preenchimento do campo CPF!
									</div>
								</div>

								<div class="form-group col-md-4 col-sm-12"><label for="telefone">Telefone*</label>
									<input name="telefone" type="number" class="form-control" id="telefone"  title="INFORME TELEFONE DO MEDICO" required="required" />
									<small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 92988887777</small>
									<div class="invalid-feedback">
										Necessário preenchimento do campo Telefone!
									</div>
								</div>

								<div class="form-group col-md-4 col-sm-12"><label for="idsistema">ID Sistema*</label>
									<input name="idsistema" type="number" class="form-control" id="idsistema"  title="INFORME ID DE USUARIO DO MEDICO"  required="required" />
									<small id="emailHelp" class="form-text text-muted">Informar ID de Usuario</small>
									<div class="invalid-feedback">
										Necessário preenchimento do campo ID de Sistema!
									</div>									
								</div>

								<!--<div class="form-group col-md-12 col-sm-12"><hr><fieldset><legend>Financeiro</legend></fieldset></div>						-->
								
								<div class="form-group col-md-3 col-sm-12"><label for="exame">Porcentagem Exame Particular*</label>
									<input name="exameparticular" type="number" class="form-control"   title="INFORME % DE REPASSE AO MEDICO"  required="required" />
									<div class="invalid-feedback">
										Necessário preenchimento do campo!
									</div>
								</div>

								<div class="form-group col-md-3 col-sm-12"><label for="consulta">Porcentagem Consulta Particular*</label>
									<input name="consultaparticular" type="number" class="form-control"  title="INFORME % DE REPASSE AO MEDICO"  required="required" />
									<div class="invalid-feedback">
										Necessário preenchimento do campo!
									</div>
								</div>

								<div class="form-group col-md-3 col-sm-12"><label for="particular">Porcentagem exame Convenio*</label>
									<input name="exameconvenio" type="number" class="form-control"   title="INFORME % DE REPASSE AO MEDICO"  required="required" />
									<div class="invalid-feedback">
										Necessário preenchimento do campo Nome!
									</div>
								</div>

								<div class="form-group col-md-3 col-sm-12"><label for="particular">Porcentagem Consulta Convenio*</label>
									<input name="consultaconvenio" type="number" class="form-control"  title="INFORME % DE REPASSE AO MEDICO"  required="required" />
									<div class="invalid-feedback">
										Necessário preenchimento do campo Nome!
									</div>
								</div>

								<div class="form-group col-md-4 col-sm-12"><label for="sexo">Sexo</label>
									<select name="sexo" id="sexo" class="form-control" >
										<option value="Nao informado">Selecione</option>
										<option value="Masculino">Masculino</option>
										<option value="Feminino">Feminino</option>
										<option value="Nao informar">Nao informar</option>			
									</select>
								</div>

								<div class="form-group col-md-8 col-sm-12"><label for="observacao">Observacao</label>
									<input name="observacao" type="text" class="form-control" id="observacao"  title="ALGUMAS OBSERVACOES SOBRE O MEDICO" />
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