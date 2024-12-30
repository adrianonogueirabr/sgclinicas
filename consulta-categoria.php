<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<?php include "inicial.php"?>

				<div class="container col-md-12">								
					<div class="card">
					<div class="card-header"><h3>Consultar Categoria</h3></div>
						<div class="card-body">  
							<form name="listagemCategoria" action="listagem-categoria.php?criterio=categoria" method="post">
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
										<a href="cadastro-categoria.php" class="btn btn-outline-success btn-block" role="button" aria-pressed="true">Nova Categoria</a>
									</div>
								</div>	
							</form>							
						</div>
					</div>
				</div>

</body>
</html>