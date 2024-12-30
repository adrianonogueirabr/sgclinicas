function adcionaRazaoFantasia(){
		d = document.cliente;
		d.fantasia.value = d.razao.value;	
	}
	
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
		
		//validar telefone
		if (d.telefone.value == ""){
			alert("O campo " + d.telefone.name + " deve ser preenchido!");
			d.telefone.focus();
			return false;
		}
		if (isNaN(d.telefone.value)){
			alert("O campo " + d.telefone.name + " deve conter apenas numeros sem espacos!");
			d.telefone.focus();
			return false;
		}
		
		if (isNaN(d.ramal.value)){
			alert("O campo " + d.ramal.name + " deve conter apenas numeros sem espacos!");
			d.ramal.focus();
			return false;
		}
		
		if (isNaN(d.numero.value)){
			alert("O campo " + d.numero.name + " deve conter apenas numeros sem espacos!");
			d.numero.focus();
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




function isCpf(cpf) {
var soma;
var resto;
var i;
 
 if ( (cpf.length != 11) ||
 (cpf == "00000000000") || (cpf == "11111111111") ||
 (cpf == "22222222222") || (cpf == "33333333333") ||
 (cpf == "44444444444") || (cpf == "55555555555") ||
 (cpf == "66666666666") || (cpf == "77777777777") ||
 (cpf == "88888888888") || (cpf == "99999999999") ) {
 return false;
 }
 
 soma = 0;
 
 for (i = 1; i <= 9; i++) {
 soma += Math.floor(cpf.charAt(i-1)) * (11 - i);
 }
 
 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
 
 if ( (resto == 10) || (resto == 11) ) {
 resto = 0;
 }
 
 if ( resto != Math.floor(cpf.charAt(9)) ) {
 return false;
 }
 
 soma = 0;
 
 for (i = 1; i<=10; i++) {
 soma += cpf.charAt(i-1) * (12 - i);
 }
 
 resto = 11 - (soma - (Math.floor(soma / 11) * 11));
 
 if ( (resto == 10) || (resto == 11) ) {
 resto = 0;
 }
 
 if (resto != Math.floor(cpf.charAt(10)) ) {
 return false;
 }
 
 return true;
}

function isCnpj(s){
var i;
var c = s.substr(0,12);
var dv = s.substr(12,2);
var d1 = 0;
 
 for (i = 0; i < 12; i++){
 d1 += c.charAt(11-i)*(2+(i % 8));
 }
 
 if (d1 == 0) return false;
 
 d1 = 11 - (d1 % 11);
 
 if (d1 > 9) d1 = 0;
 if (dv.charAt(0) != d1){
 return false;
 }
 
 d1 *= 2;
 
 for (i = 0; i < 12; i++){
 d1 += c.charAt(11-i)*(2+((i+1) % 8));
 }
 
 d1 = 11 - (d1 % 11);
 
 if (d1 > 9) d1 = 0;
 if (dv.charAt(1) != d1){
 return false;
 }
 
 return true;
}

