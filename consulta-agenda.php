<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<?php include "inicial.php"?>
				<div class="container col-md-12">								
					<div class="card">
					<div class="card-header"><h3>Consultar Agenda</h3></div>
						<div class="card-body">   
							<form name="listagemMedico" action="listagem-agenda.php?criterio=medico" method="post">
								<div class="form-row m-2"> 
									<div class="form-group  col-md-2 col-sm-6">
										<label for="medico">Por Medico</label>
									</div>

									<div class="form-group  col-md-4 col-sm-6">
											<select name="parametro" class="form-control" title="SELECIONE MEDICO DA AGENDA">
											<?php
											include "conexao.php"; 
											$resMedico=$con->prepare("SELECT num_id_med, txt_nome_med FROM tbl_medico_med WHERE txt_ativo_med = 'SIM' order by txt_nome_med");
											$resMedico->execute();

											while($rowMedico = $resMedico->fetch(PDO::FETCH_OBJ)){?>
												<option value="<?php echo $rowMedico->num_id_med ?>"><?php echo $rowMedico->txt_nome_med ?></option>
											<?php } ?>
											</select>
									</div>

									<div class="form-group col-md-2 col-sm-12">	
										<button type="submit" class="btn btn-outline-primary btn-block">Buscar Dados</button>
									</div>
								</div>

							</form>

							<hr>

							<form name="listagemDiaSemana" action="listagem-agenda.php?criterio=dia" method="post">
								<div class="form-row m-2"> 
									<div class="form-group  col-md-2 col-sm-6">
										<label for="diasemana">Por Dia da Semana</label>
									</div>

									<div class="form-group col-md-4 col-sm-6">
										<select name="parametro"  class="form-control" title="SELECIONE O DIA DA SEMANA">
											<option value="Nao Selecionado">..Selecione..</option>
											<option value="Segunda-Feira">Segunda Feira</option>
											<option value="Terca-Feira">Terca Feira</option>
											<option value="Quarta-Feira">Quarta Feira</option>			
											<option value="Quinta-Feira">Quinta Feira</option>			
											<option value="Sexta-Feira">Sexta Feira</option>
											<option value="Sabado">Sabado</option>
											<option value="Domingo">Domingo</option>		
										</select>
									</div>
									
									<div class="form-group col-md-2 col-sm-12">	
										<button type="submit" class="btn btn-outline-primary btn-block">Buscar Dados</button>
									</div>
									<div class="form-group col-md-2 col-sm-12">
										<a href="cadastro-agenda.php" class="btn btn-outline-success btn-block" role="button" aria-pressed="true">Nova Agenda</a>
									</div>						
								</div>	
							</form>			
						</div>
					</div>
				</div>

</body>
</html>