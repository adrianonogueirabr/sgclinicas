
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>
<form  name="agenda" class="needs-validation" novalidate  action="processa-agenda.php?acao=cadastrar" method="post">
			<div class="container col-md-12">			
				<div class="card">
				<div class="card-header"><h3>Cadastro de Agenda</h3></div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group  col-md-4 col-sm-6"><label for="medico">Medico*</label>
								<select name="medico" class="form-control" title="SELECIONE MEDICO DA AGENDA">
									<option value="">Selecione</option>
									<?php
									include "conexao.php"; 
									$resMedico=$con->prepare("SELECT num_id_med, txt_nome_med FROM tbl_medico_med WHERE txt_ativo_med = 'SIM' order by txt_nome_med");
									$resMedico->execute();
									
									while($rowMedico = $resMedico->fetch(PDO::FETCH_OBJ)){?>
										<option value="<?php echo $rowMedico->num_id_med ?>"><?php echo $rowMedico->txt_nome_med ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group col-md-4 col-sm-6"><label for="diasemana">Dia Semana*</label>
								<select name="diasemana" id="diasemana" class="form-control" title="SELECIONE O DIA DA SEMANA">
									<option value="Nao Selecionado">Selecione</option>
									<option value="Segunda-Feira">Segunda Feira</option>
									<option value="Terca-Feira">Terca Feira</option>
									<option value="Quarta-Feira">Quarta Feira</option>			
									<option value="Quinta-Feira">Quinta Feira</option>			
									<option value="Sexta-Feira">Sexta Feira</option>
									<option value="Sabado">Sabado</option>
									<option value="Domingo">Domingo</option>		
								</select>
							</div>

							<div class="form-group col-md-4 col-sm-12"><label for="quantidade">Quantidade Vagas*</label>
								<input name="quantidade" type="number" class="form-control" id="quantidade"  title="INFORME QUANTIDADE DE VAGAS"  required="required" />
								<div class="invalid-feedback">
									Necessário preenchimento do campo Quantidade de Vagas!
								</div>
							</div>

							<div class="form-group col-md-4 col-sm-12"><label for="horainicio">Hora Inicial*</label>
								<input name="horainicio" type="time" class="form-control" id="horainicio"  title="INFORME HORARIO DE INICIO DE ATENDIMENTO"  required="required" />
								<div class="invalid-feedback">
									Necessário preenchimento do campo Hora Inicial!
								</div>
							</div>

							<div class="form-group col-md-4 col-sm-12"><label for="horafinal">Hora Final*</label>
								<input name="horafinal" type="time" class="form-control" id="horafinal"  title="INFORME HORARIO DE TERMINO DE ATENDIMENTO"  required="required" />
								<div class="invalid-feedback">
									Necessário preenchimento do campo Hora Final!
								</div>
							</div>				

							<div class="form-group col-md-4 col-sm-12"><label for="observacao">Observacao</label>
								<input name="observacao" type="text" class="form-control" id="observacao" maxlength="50"  title="INFORME ALGUMA OBSERVACAO DA AGENDA"  />
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