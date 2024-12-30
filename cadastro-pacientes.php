<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
<?php include "inicial.php"?>

<form  name="paciente" class="needs-validation" novalidate action="processa-pacientes.php?acao=cadastrar" method="post">
			<div class="container col-md-12">			
				<div class="card">
					<div class="card-header"><h3>Cadastro de Pacientes</h3></div>
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col-md-6 col-sm-12 "><label for="razao">Nome*</label>
								<input name="nome" type="text" class="form-control" id="nome" maxlength="100" title="INFORME NOME DO PACIENTE"  required="required" />
									<div class="invalid-feedback">
										Necessário preenchimento do campo Nome!
									</div>
							</div>

							<div class="form-group  col-md-3 col-sm-6"><label for="cpf">CPF</label>
								<input class="form-control input" name="cpf" type="number" id="cpf" onblur="validarCPFeCNPJ(this.value)"  maxlength="11" title="INFORME O CPF DO PACIENTE" />
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="rg">RG - Registro Geral</label>
								<input name="rg" type="text" class="form-control" id="rg" title="INFORME O RG DO PACIENTE" />
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="estadocivil">Estado Civil</label>
								<select name="estadocivil" id="estadocivil" class="form-control" title="SELECIONE ESTADO CIVIL DO PACIENTE" >
									<option value="1">Selecione</option>
									<?php
									include "conexao.php"; 
									$resEstadoCivil=$con->prepare("SELECT num_id_ec, txt_nome_ec FROM tbl_estado_civil_ec WHERE txt_ativo_ec = 'sim' order by txt_nome_ec");
									$resEstadoCivil->execute();
									
									while($rowEstadoCivil = $resEstadoCivil->fetch(PDO::FETCH_OBJ)){?>							
										<option value="<?php echo $rowEstadoCivil->num_id_ec ?>"><?php echo $rowEstadoCivil->txt_nome_ec ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="cor">Cor</label>
								<select name="cor" id="cor" class="form-control" title="SELECIONE COR DO PACIENTE" required>
									<option value="1">Selecione</option>
									<?php
									include "conexao.php"; 
									$resCor=$con->prepare("SELECT num_id_cor, txt_nome_cor FROM tbl_cor_cor WHERE txt_ativo_cor = 'sim' order by txt_nome_cor");
									$resCor->execute();
									
									while($rowCor = $resCor->fetch(PDO::FETCH_OBJ)){?>							
										<option value="<?php echo $rowCor->num_id_cor ?>"><?php echo $rowCor->txt_nome_cor ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="sexo">Sexo</label>
								<select name="sexo" id="sexo" class="form-control" >
									<option value="nao informado">Selecione</option>
									<option value="masculino">Masculino</option>
									<option value="feminino">Feminino</option>
									<option value="nao informar">Nao Informar</option>			
								</select>
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="datanascimento">Data Nascimento*</label>
								<input name="datanascimento" id="datanascimento" class="form-control" type="date" required="required">
									<div class="invalid-feedback">
										Necessário informar data de nascimento!
									</div>
							</div>
							
							<div class="form-group col-md-3 col-sm-6"><label for="telefone">Telefone*</label>
								<input name="telefone" type="number" id="telefone" class="form-control"  maxlength="20" required="required" title="INFORME TELEFONE CELULAR OU FIXO"  />
								<small id="emailHelp" class="form-text text-muted">Somente numeros Ex.: 92988887777</small>
									<div class="invalid-feedback">
										Necessário preenchimento do campo Telefone!
									</div>
							</div>

							<div class="form-group col-md-6 col-sm-12"><label for="email">Email</label>
								<input name="email" type="email" class="form-control" id="email"  maxlength="100" title="INFORME EMAIL DO PACIENTE" />
							</div>

							<div class="form-group  col-md-3 col-sm-6"><label for="profissao">Profissao</label>
								<select name="profissao" class="form-control" title="SELECIONE PROFISSAO DO PACIENTE" >
									<option value="1">Selecione</option>
									<?php
									include "conexao.php"; 
									$resProfissao=$con->prepare("SELECT num_id_prof, txt_nome_prof FROM tbl_profissao_prof WHERE txt_ativo_prof = 'sim' order by txt_nome_prof");
									$resProfissao->execute();
									
									while($rowProfissao = $resProfissao->fetch(PDO::FETCH_OBJ)){?>							
										<option value="<?php echo $rowProfissao->num_id_prof ?>"><?php echo $rowProfissao->txt_nome_prof ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group  col-md-3 col-sm-6"><label for="medico">Medico*</label>
								<select name="medico" class="form-control" title="SELECIONE MEDICO DO PACIENTE" required>
									<option value="">Selecione</option>
									<?php
									include "conexao.php"; 
									$resMedico=$con->prepare("SELECT num_id_med, txt_nome_med FROM tbl_medico_med WHERE txt_ativo_med = 'sim' order by txt_nome_med");
									$resMedico->execute();

									while($rowMedico = $resMedico->fetch(PDO::FETCH_OBJ)){?>
										<option value="<?php echo $rowMedico->num_id_med ?>"><?php echo $rowMedico->txt_nome_med?></option>
									<?php } ?>
								</select>
							</div>
							
							<div class="form-group col-md-3 col-sm-6"><label for="cep">Cep</label>
								<input name="cep" class="form-control" type="number" id="cep" title="INFORME O CEP E PRESSIONE TECLA TAB" size="8" onblur="pesquisacep(this.value);" maxlength="10" />
									<small id="emailHelp" class="form-text text-muted">Somente numeros Ex.:99999999 e pressionar TAB</small>
                                    <span id="msgAlertaCepNaoEncontrado"></span>  
							</div>

							<div class="form-group col-md-6 col-sm-10"><label for="logradouro">Logradouro</label>
								<input name="logradouro" type="text" class="form-control" id="logradouro"  maxlength="100" title="INFORME LOGRADOURO SEM NUMERO"/>
							</div>	

							<div class="form-group col-md-3 col-sm-2"><label for="numero">Numero</label>
								<input name="numero" type="number" class="form-control" id="numero" title="INFORME NUMERO DA RESIDENCIA" value="0"/>
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="bairro">Bairro</label>
								<input name="bairro" type="text" class="form-control" id="bairro"  title="INFORME O BAIRRO DO PACIENTE" />
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="cidade">Cidade</label>
								<input name="cidade" type="text" id="cidade"  class="form-control"  title="INFORME A CIDADE DO PACIENTE" />
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="estado">Estado</label>
								<input name="estado" type="text" id="estado"  class="form-control" title="INFORME A CIDADE DO PACIENTE" />
							</div>

							<div class="form-group col-md-6 col-sm-12"><label for="complemento">Complemento</label>
								<input name="complemento" type="text" id="complemento" class="form-control" title="INFORME COMPLEMENTO DO ENDERECO" />
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="cns">CNS - Carteira Nacional de Saude</label>
								<input name="cns" type="text" id="cns"  class="form-control" title="INFORME NUMERO DA CARTEIRA NACIONAL DE SAUDE CASO POSSUA"/>
							</div>

							<div class="form-group  col-md-3 col-sm-6"><label for="categoria">Categoria*</label>
									<select name="categoria" class="form-control" title="SELECIONE CATEGORIA DE ATENDIMENTO DO PACIENTE" required>
									<option value="">Selecione</option>
									<?php
									include "conexao.php"; 
									$resCategoria=$con->prepare("SELECT num_id_cat, txt_nome_cat FROM tbl_categoria_cat WHERE txt_ativo_cat = 'SIM' order by txt_nome_cat");
									$resCategoria->execute();

									while($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){?>
										<option value="<?php echo $rowCategoria->num_id_cat ?>"><?php echo $rowCategoria->txt_nome_cat?></option>
									<?php } ?>
									</select>
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="matricula">Matricula</label>
								<input name="matricula" type="text" id="matricula"  class="form-control" title="INFORME MATRICULA DO CONVENIO CASO POSSUA" />
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="carteira">Carteira Convenio</label>
								<input name="carteira" type="text" id="carteira" class="form-control"  maxlength="100" title="INFORME NUMERO DA CARTEIRA DO CONVENIO CASO POSSUA"/>
							</div>

							<div class="form-group col-md-3 col-sm-6"><label for="vencimento_carteira">Vencimento Carteira</label>
								<input name="vencimento_carteira" type="date" id="vencimento_carteira" class="form-control"  title="INFORME DATA DE VENCIMENTO DA CARTEIRA DO CONVENIO CASO POSSUA"/>
							</div>	

							<div class="form-group col-md-3 col-sm-6"><label for="pne">PNE</label>
								<select name="pne" id="pne" class="form-control" >
									<option value="Nao">Nao</option>
									<option value="Sim">Sim</option>
								</select>
							</div>

							<div class="form-group col-md-12 col-sm-12"><label for="observacoes">Observações</label>
								<textarea name="observacoes" id="observacoes" class="form-control" cols="60" rows="3" title="INFORMACOES GERAIS DO PACIENTE"></textarea>
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
<script type="text/javascript" src="javascript/cadastro_paciente.js"></script>
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