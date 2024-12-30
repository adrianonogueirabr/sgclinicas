
	function validaForm(){
		d = document.usuario;
		
		if (d.nome.value == ""){
			alert("O campo " + d.nome.name + " deve ser preenchido!");
			d.nome.focus();
			return false;
		}
		
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
		
		if (d.login.value == ""){
			alert("O campo " + d.login.name + " deve ser preenchido!");
			d.login.focus();
			return false;
		}
		
		if (d.senha.value == ""){
			alert("O campo " + d.senha.name + " deve ser preenchido!");
			d.senha.focus();
			return false;
		}
		
		return true;
		
	}


