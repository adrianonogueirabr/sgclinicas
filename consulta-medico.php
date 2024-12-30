<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<?php include "inicial.php"?>

				<div class="container col-md-12">								
					<div class="card">
					<div class="card-header"><h3>Consultar Medico</h3></div>
						<div class="card-body">  
							<form name="listagemEspecialidades" action="listagem-medico.php?criterio=especialidade" method="post">
								<div class="form-row"> 
									<div class="form-group  col-md-2 col-sm-6">
										<label for="medico">Pela Especialidade</label>
									</div>

									<div class="form-group  col-md-3 col-sm-6">
										<select name="parametro"  class="form-control" title="SELECIONE MEDICOS PELA ESPECIALIDADE">
											<?php
											include "conexao.php"; 
											$resEspecialidade=$con->prepare("SELECT num_id_esp, txt_nome_esp FROM tbl_especialidade_esp WHERE txt_ativo_esp = 'SIM' order by txt_nome_esp");
											$resEspecialidade->execute();

											while($rowEspecialidade = $resEspecialidade->fetch(PDO::FETCH_OBJ)){?>
												<option value="<?php echo $rowEspecialidade->num_id_esp ?>"><?php echo $rowEspecialidade->txt_nome_esp ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="form-group col-md-2 col-sm-12">	
										<button type="submit" class="btn btn-outline-primary btn-block">Listar Dados</button>
									</div>
								</div>

							</form>
							<hr>
							<form name="listagemMedico" action="listagem-medico.php?criterio=medico" method="post">
								<div class="form-row"> 
									<div class="form-group  col-md-2 col-sm-6">
										<label>Pelo Nome</label>
									</div>

									<div class="form-group col-md-3 ">
										<input class="form-control"  type="text"  name="parametro" required="required" placeholder="Informe nome e clique em buscar dados"  />
									</div>
									
									<div class="form-group col-md-2 col-sm-12">	
										<button type="submit" class="btn btn-outline-primary btn-block">Buscar Dados</button>
									</div>	
									<div class="form-group col-md-2 col-sm-12">
										<a href="cadastro-medico.php" class="btn btn-outline-success btn-block" role="button" aria-pressed="true">Novo Medico</a>
									</div>				
									
								</div>	
							</form>							
						</div>
					</div>
				</div>

</body>
</html>