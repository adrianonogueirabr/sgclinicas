
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

function valida_cpf_cnpj(){
	
	d = document.cliente;
	
	if(d.pessoa.value == "F"){
		if(!isCpf(d.cpfcnpj.value)){
			alert('CPF informado inválido!')
			d.cpfcnpj.focus();
		}
		
	}else if(d.pessoa.value == "J"){
		if(!isCnpj(d.cpfcnpj.value));{
			alert('CNPJ informado inválido!')
			d.cpfcnpj.focus();
		}
	}else{
			alert('Selecione tipo de cliente Pessoa Juridica ou Fisica!')
			d.pessoa.focus();		
	}
	
	
}