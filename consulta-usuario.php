<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<?php include "inicial.php"?> 

			<div class="container col-md-12">								
				<div class="card">
				<div class="card-header"><h3>Consultar Usuario</h3></div>
					<div class="card-body">   
						<form name="listagem" action="listagem-usuario.php" method="post">

							<div class="form-check">
								<input class="form-check-input" type="radio" name="criterio" id="criterio" value="N" checked>
								<label class="form-check-label" for="criterio">Pesquisar por Nome</label>
							</div>

							<div class="form-check">
								<input class="form-check-input" type="radio" name="criterio" id="criterio" value="L" >
								<label class="form-check-label" for="criterio">Pesquisar por Login</label>
							</div>

							<div class="form-check">
								<input class="form-check-input" type="radio" name="criterio" id="criterio" value="I">
								<label class="form-check-label" for="criterio">Pesquisar por ID</label>
							</div>

							<div class="form-row"> 
							<div class="form-group col-md-4 ">
								<input class="form-control"  type="text"   name="valor" id="valor" required="required" placeholder="Informe Parametro da Pesquisa" title="Informe Parametro da Pesquisa"  />
							</div>

							<div class="form-group col-md-2 col-sm-12">	
								<button type="submit" class="btn btn-outline-primary btn-block">Buscar Dados</button>
							</div>

							<div class="form-group col-md-2 col-sm-12">
								<a href="cadastro-usuario.php" class="btn btn-outline-success btn-block" role="button" aria-pressed="true">Novo Usuario</a>
							</div>		
						</form>

</body>
</html>