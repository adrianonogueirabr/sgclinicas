function adcionaRazaoFantasia(){
		d = document.cliente;
		d.fantasia.value = d.razao.value;	
	}

	//textos em maiusculo
document.getElementById('razao').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});

document.getElementById('fantasia').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});



document.getElementById('contato').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});

document.getElementById('observacao').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});
	//buscar Cep+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('logradouro').value=("");
    document.getElementById('bairro').value=("");
    document.getElementById('cidade').value=("");
    document.getElementById('estado').value=("");
    document.getElementById('logradouro').value=("");
    document.getElementById('bairro').value=("");
    document.getElementById('cidade').value=("");
    document.getElementById('estado').value=("");
    //document.getElementById('ibge').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouro').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('estado').value=(conteudo.uf);
        document.getElementById('logradouro').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('estado').value=(conteudo.uf);
        //document.getElementById('ibge').value=(conteudo.ibge);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        //alert("CEP não encontrado.");
        document.getElementById('msgAlertaCepNaoEncontrado').innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Cep nao encontrado!</div>"
        removeMensagem();
    }
}

function pesquisacep(valor) {

	console.log(valor)

//Nova variável "cep" somente com dígitos.
var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('estado').value="...";
            document.getElementById('logradouro').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('estado').value="...";
            //document.getElementById('ibge').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            //alert("Formato de CEP inválido.");
            document.getElementById('msgAlertaCepNaoEncontrado').innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Cep nao encontrado!</div>"
            removeMensagem();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

//fim buscar cep*********************************************************

//funcao para remover o alerta da tela
function removeMensagem(){
    setTimeout(function(){
        document.getElementById("msgAlertaCepNaoEncontrado").innerHTML = "";//
    },5000);


}//////////////////////



	function validaForm(){
		d = document.cliente;
		
		if (d.pessoa.value == "SELECIONE"){
			alert("O campo pessoa deve ser selecionado!");
			d.pessoa.focus();
			return false;
		}
		
		if (d.ativo.value == "SELECIONE"){
			alert("O campo ativo deve ser selecionado!");
			d.ativo.focus();
			return false;
		}
		
		if (d.sexo.value == "SELECIONE"){
			alert("O campo sexo deve ser selecionado!");
			d.sexo.focus();
			return false;
		}		
		
		if (d.cpfcnpj.value == ""){
			alert("O campo " + d.cpfcnpj.name + " deve ser preenchido!");
			d.cpfcnpj.focus();
			return false;
		}
		
		if (d.razao.value == ""){
			alert("O campo " + d.razao.name + " deve ser preenchido!");
			d.razao.focus();
			return false;
		}
		
		if (d.dia.value == "S"){
			alert("O campo dia deve ser selecionado!");
			d.dia.focus();
			return false;
		}
		
		if (d.mes.value == "S"){
			alert("O campo mes deve ser selecionado!");
			d.mes.focus();
			return false;
		}
		
		if (d.ano.value == "S"){
			alert("O campo ano deve ser selecionado!");
			d.ano.focus();
			return false;
		}
		
		if (d.estado.value == "S"){
			alert("O campo estado deve ser selecionado!");
			d.estado.focus();
			return false;
		}
		
		
		//validar email 
		if (d.email.value == ""){
			alert("O campo " + d.email.name + " deve ser preenchido!");
			d.email.focus();
			return false;
		}
		
		parte1 = d.email.value.indexOf("@");
		parte2 = d.email.value.indexOf(".");
		parte3 = d.email.value.lenght;
			if (parte1 >=3 && parte2 >=2 && parte3 >=5){
				alert("O campo " + d.email.name + " deve conter um endereco eletronico correto!");
				d.email.focus();
				return false;				
			}
		
	
		if(d.site.value == ""){
			d.site.value = "NI";
		}
		
		if(d.logradouro.value == ""){
			d.logradouro.value = "NI";	
		}
		
		if(d.bairro.value == ""){
			d.bairro.value = "NI";	
		}

		if(d.complemento.value == ""){
			d.complemento.value = "NI";	
		}
	
		if(d.referencia.value == ""){
			d.referencia.value = "NI";	
		}
		
		if(d.cidade.value == ""){
			d.cidade.value = "NI";	
		}
		
		if(d.contato.value == ""){
			d.contato.value = "NI";	
		}
		
		if(d.observacao.value == ""){
			d.observacao.value = "NI";	
		}
		
	
		return true;
		
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
  
