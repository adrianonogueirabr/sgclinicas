function adcionaRazaoFantasia(){
		d = document.cliente;
		d.fantasia.value = d.razao.value;	
	}

//funcao para calcular desconto e modificar campos
function calculaDesconto(){
	let valor = parseFloat(document.getElementById("valor").value);
	let desconto = parseFloat(document.getElementById("desconto").value);
	let total = parseFloat(document.getElementById("total").value);

	if (desconto >= valor) {
		alert("Valor do desconto nao pode ser maior ou igual a: R$" + valor);
		document.getElementById("desconto").value = 0;
		document.getElementById("desconto").focus();
	}else{
		total = valor - desconto;
		document.getElementById("total").value = total;
	}

}
//validacao de cpf e cnpj

// Função para verificar se é CPF ou CNPJ
function validarCPFeCNPJ(input) {
	const cleanedInput = input.replace(/[^\d]/g, ''); // Remove caracteres não numéricos
  
	if (cleanedInput.length === 11) {
	  return validarCPF(cleanedInput);
	} else if (cleanedInput.length === 14) {
	  return validarCNPJ(cleanedInput);
	} else {
	  return false; // Tamanho inválido para CPF ou CNPJ
	}
  }
  
  // Função para validar CPF
  function validarCPF(cpf) {
	cpf = cpf.replace(/[^\d]/g, ''); // Remove caracteres não numéricos
  
	if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
	  ///return document.getElementById("cpfcnpj").style.background = "yellow"; // CPF inválido se não tiver 11 dígitos ou todos os dígitos forem iguais
		return alert("Favor Informar um CPF válido!");
	  
	}
  
	const digit1 = calcularDigitoVerificador(cpf, 9);
	const digit2 = calcularDigitoVerificador(cpf, 10);
  
	return cpf.slice(-2) === `${digit1}${digit2}`;
  }
  
  // Função para calcular dígito verificador do CPF
  function calcularDigitoVerificador(cpf, peso) {
	const sum = cpf
	  .slice(0, peso)
	  .split('')
	  .map(Number)
	  .reduce((acc, digit, index) => acc + digit * (peso + 1 - index), 0);
  
	const remainder = sum % 11;
	///return remainder < 2 ? 0 : 11 - remainder;
	return remainder < 2 ? alert("Favor Informar um CPF válido!") : 11 - remainder;
  }
  
  // Função para validar CNPJ
// Função para validar CNPJ
function validarCNPJ(cnpj) {
	cnpj = cnpj.replace(/[^\d]/g, ''); // Remove caracteres não numéricos
  
	if (cnpj.length !== 14 || /^(\d)\1{13}$/.test(cnpj)) {
	  return alert("Favor Informar um CNPJ válido!");
	}
  
	const digit1 = calcularDigitoCNPJ(cnpj, 12, 5);
	const digit2 = calcularDigitoCNPJ(cnpj, 13, 6);
  
	return cnpj.slice(-2) === `${digit1}${digit2}`;
  }
  
  // Função para calcular dígito verificador do CNPJ
  function calcularDigitoCNPJ(cnpj, pesoInicial, pesoFinal) {
	const sum = cnpj
	  .slice(0, pesoFinal)
	  .split('')
	  .map(Number)
	  .reduce((acc, digit, index) => acc + digit * (pesoInicial + 1 - index), 0);
  
	const remainder = sum % 11;
	//return remainder < 2 ? 0 : 11 - remainder;
	return remainder < 2 ? alert("Favor Informar um CNPJ válido!") : 11 - remainder;
  }
  
