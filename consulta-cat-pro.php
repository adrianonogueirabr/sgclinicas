<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<?php include "inicial.php"?>

				<div class="container col-md-12">								
					<div class="card">
					<div class="card-header"><h3>Consultar Categoria X Procedimento</h3></div>
						<div class="card-body">  
							<form name="listagemCategoria" action="listagem-cat-pro.php?criterio=categoria" method="post">
								<div class="form-row"> 
									<div class="form-group  col-md-2 col-sm-6">
										<label for="medico">Pela Categoria</label>
									</div>

									<div class="form-group  col-md-3 col-sm-6">
										<select name="parametro"  class="form-control" title="SELECIONE VALORES PELA CATEGORIA">
											<?php
											include "conexao.php"; 
											$resCategoria=$con->prepare("SELECT num_id_cat, txt_nome_cat FROM tbl_categoria_cat WHERE txt_ativo_cat = 'sim' order by txt_nome_cat");
											$resCategoria->execute();

											while($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){?>
												<option value="<?php echo $rowCategoria->num_id_cat ?>"><?php echo $rowCategoria->txt_nome_cat ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="form-group col-md-2 col-sm-12">	
										<button type="submit" class="btn btn-outline-primary btn-block">Listar Dados</button>
									</div>
								</div>

							</form>
							<hr>
							<form name="listagemProcedimento" action="listagem-cat-pro.php?criterio=procedimento" method="post">
								<div class="form-row"> 
									<div class="form-group  col-md-2 col-sm-6">
										<label for="medico">Pelo Procedimento</label>
									</div>

									<div class="form-group  col-md-3 col-sm-6">
										<select name="parametro"  class="form-control" title="SELECIONE VALORES PELO PROCEDIMENTO">
											<?php
											include "conexao.php"; 
											$resProcedimento=$con->prepare("SELECT num_id_pro, txt_nome_pro FROM tbl_procedimentos_pro WHERE txt_ativo_pro = 'sim' order by txt_nome_pro");
											$resProcedimento->execute();

											while($rowProcedimento = $resProcedimento->fetch(PDO::FETCH_OBJ)){?>
												<option value="<?php echo $rowProcedimento->num_id_pro ?>"><?php echo $rowProcedimento->txt_nome_pro ?></option>
											<?php } ?>
										</select>
									</div>
									
									<div class="form-group col-md-2 col-sm-12">	
										<button type="submit" class="btn btn-outline-primary btn-block">Buscar Dados</button>
									</div>	
									<div class="form-group col-md-3 col-sm-12">
										<a href="cadastro-cat-pro.php" class="btn btn-outline-success" role="button" aria-pressed="true">Novo Categoria X Procedimento</a>
									</div>				
									
								</div>	
							</form>							
						</div>
					</div>
				</div>

</body>
</html>