
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>
<form  name="bloqueio-agenda" class="needs-validation" novalidate  action="processa-bloqueio-agenda.php?acao=cadastrar" method="post">
			<div class="container col-md-12">			
				<div class="card">
				<div class="card-header"><h3>Bloquear Agenda</h3></div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group  col-md-3 col-sm-6"><label for="medico">Medico*</label>
								<select name="medico" class="form-control" title="SELECIONE MEDICO PARA BLOQUEIO" required>
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

							<div class="form-group col-md-5 col-sm-12"><label for="motivo">Motivo*</label>
								<input name="motivo" type="text" class="form-control"  title="INFORME O MOTIVO DO BLOQUEIO"  required="required" />
								<div class="invalid-feedback">
									Necessário preenchimento do campo Motivo!
								</div>
							</div>

							<div class="form-group col-md-2 col-sm-6"><label for="datainicial">Data Inicial*</label>
								<input name="datainicial"  class="form-control" type="date" title="SELECIONE DATA INCIAL DO BLOQUEIO" required="required">
									<div class="invalid-feedback">
										Necessário informar data inicial do bloqueio!
									</div>
							</div>

							<div class="form-group col-md-2 col-sm-6"><label for="datafinal">Data Final*</label>
								<input name="datafinal"  class="form-control" type="date" title="SELECIONE DATA FINAL DO BLOQUEIO" required="required">
									<div class="invalid-feedback">
										Necessário informar data final do bloqueio!
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