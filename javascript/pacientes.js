const tbody = document.querySelector(".listar-pacientes");

const cadPacienteForm = document.getElementById("cad-paciente-form");
const ediPacienteForm = document.getElementById("edi-paciente-form");

const msgAlerta = document.getElementById("msgAlerta");
const msgAlertaCad = document.getElementById("msgAlertaCad");
const msgAlertaEdit = document.getElementById("msgAlertaEdit");
const msgAlertaForm = document.getElementById("msgAlertaForm");

const ediPacienteModal = new bootstrap.Modal(document.getElementById("ediPacienteModal"));
const visPacienteModal = new bootstrap.Modal(document.getElementById("visPacienteModal"));

const cadCategoriaPaciente = document.getElementById("inputCategoria");
const ediCategoriaPaciente = document.getElementById("categoriaPacienteEdi");

const inputPesquisar = document.getElementById("inputPesquisar");

const formPesquisar = document.getElementById("form-pesquisar");

//buscar Cep+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('inputLogradouro').value=("");
    document.getElementById('inputBairro').value=("");
    document.getElementById('inputCidade').value=("");
    document.getElementById('inputEstado').value=("");
    document.getElementById('logradouroPacienteEdi').value=("");
    document.getElementById('bairroPacienteEdi').value=("");
    document.getElementById('cidadePacienteEdi').value=("");
    document.getElementById('estadoPacienteEdi').value=("");
    //document.getElementById('ibge').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('inputLogradouro').value=(conteudo.logradouro);
        document.getElementById('inputBairro').value=(conteudo.bairro);
        document.getElementById('inputCidade').value=(conteudo.localidade);
        document.getElementById('inputEstado').value=(conteudo.uf);
        document.getElementById('logradouroPacienteEdi').value=(conteudo.logradouro);
        document.getElementById('bairroPacienteEdi').value=(conteudo.bairro);
        document.getElementById('cidadePacienteEdi').value=(conteudo.localidade);
        document.getElementById('estadoPacienteEdi').value=(conteudo.uf);
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

//Nova variável "cep" somente com dígitos.
var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('inputLogradouro').value="...";
            document.getElementById('inputBairro').value="...";
            document.getElementById('inputCidade').value="...";
            document.getElementById('inputEstado').value="...";
            document.getElementById('logradouroPacienteEdi').value="...";
            document.getElementById('bairroPacienteEdi').value="...";
            document.getElementById('cidadePacienteEdi').value="...";
            document.getElementById('estadoPacienteEdi').value="...";
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

//textos em maiusculo
document.getElementById('inputNome').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});

document.getElementById('nomePacienteEdi').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});
//

//listar dados de tipo de categoria

if(inputCategoria){
    listarCategorias();
}

async function listarCategorias(){
    const dadosCategoria = await fetch('listar_categorias.php');
    const respostaCategoria = await dadosCategoria.json();  

    if(respostaCategoria['status']){
        document.getElementById("msgAlertaCategoria").innerHTML = "";

        for (var i = 0; i< respostaCategoria.dados.length; i++){
            //preenche formulario de cadastro de paciente
            cadCategoriaPaciente.innerHTML = cadCategoriaPaciente.innerHTML +  '<option value="' + respostaCategoria.dados[i]['num_id_cat'] + '"> ' + respostaCategoria.dados[i]['txt_nome_cat'] + ' </option>' 
            //]preenche formulario edicao de paciente
            ediCategoriaPaciente.innerHTML = ediCategoriaPaciente.innerHTML +  '<option value="' + respostaCategoria.dados[i]['num_id_cat'] + '"> ' + respostaCategoria.dados[i]['txt_nome_cat'] + ' </option>' 
        }
    }else{
        document.getElementById("msgAlertaCategoria").innerHTML = respostaCategoria['msg'];
    }
}
//fim listar dados de tipo de categoria

//funcao para remover o alerta da tela
function removeMensagem(){
    setTimeout(function(){
        document.getElementById("msgAlertaCad").innerHTML = "";//
        document.getElementById("msgAlertaEdit").innerHTML = "";//
        document.getElementById("msgAlertaForm").innerHTML = "";//
        document.getElementById("msgAlertaCepNaoEncontrado").innerHTML = "";//
    },8000);


}

//funcao para consultar paciente ao digitar
async function consultarPaciente(){

    const dadosFormPesquisar = new FormData(formPesquisar)

    const dados = await fetch("dao.paciente.php?acao=consu",{
        method: "POST",
        body: dadosFormPesquisar
    });

    const resposta = await dados.json();

    if(resposta['status']){
        document.querySelector(".listar-pacientes").innerHTML = resposta['dados'];
        removeMensagem();
    }else{
        document.getElementById("msgAlertaForm").innerHTML = resposta['msg'];
        removeMensagem();
        document.querySelector(".listar-pacientes").innerHTML = "";
    }
}
//fim funcao para consultar usuarios


//cadastrar registro
if(cadPacienteForm){
    cadPacienteForm.addEventListener("submit", async(e) => {
        
        e.preventDefault();//nao permitir atualizacao da pagina

        document.getElementById("cad-paciente-btn").value= "Salvando..."//exibir texto do botao salvando..

                //validacao campos javascript
                if(document.getElementById("inputNome").value == ""){            
                    msgAlertaCad.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Nome!</div>"
                }else if(document.getElementById("inputCpf").value == ""){
                    msgAlertaCad.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo CPF!</div>"
                }else if(document.getElementById("inputCategoria").value == ""){
                    msgAlertaCad.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Categoria!</div>"
                }else if(document.getElementById("inputTelefone").value == ""){
                    msgAlertaCad.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Telefone!</div>"
                }else{        
                                        
                        const dadosForm = new FormData(cadPacienteForm);
                        dadosForm.append("add",1);            
                        
                        const dados = await fetch("dao.paciente.php?acao=cad",{
                            method: "POST",
                            body: dadosForm,
                        });

                            const resposta = await dados.json();

                                if(resposta['erro']){
                                    msgAlertaCad.innerHTML = resposta['msg'];
                                    console.log(resposta);
                                }else{
                                    msgAlertaCad.innerHTML = resposta['msg'];
                                    cadPacienteForm.reset();                     
                                    //listarUsuarios(1);//atualizar registros da tela.                        
                                }

                }//fim validacao campos em javascript        
            
                document.getElementById("cad-paciente-btn").value= "Salvar"//botar texto padrao do botao salvar no modal
                removeMensagem(); 
                //cadUsuarioModal.hide();       
    })    
    
}//fim cadastro de usuario

//inicio visualziacao usuario
async function visPaciente(num_id_pac){

    const dados = await fetch('dao.paciente.php?acao=' + "vis" + '&id=' + num_id_pac);
    const resposta = await dados.json();

    if(resposta['erro']){
        msgAlerta.innerHTML = resposta['msg'];
    }else{
        const visPacienteModal1 = new bootstrap.Modal(document.getElementById("visPacienteModal"));
        visPacienteModal1.show();
        document.getElementById("idPaciente").value = resposta['dados'].num_id_pac;
        document.getElementById("nomePaciente").value = resposta['dados'].txt_nome_pac;
        document.getElementById("categoriaPaciente").value = resposta['dados'].txt_nome_cat;
        document.getElementById("cpfPaciente").value = resposta['dados'].txt_cpf_pac;
        document.getElementById("corPaciente").value = resposta['dados'].txt_cor_pac;
        document.getElementById("sexoPaciente").value = resposta['dados'].txt_sexo_pac;
        document.getElementById("nascimentoPaciente").value = resposta['dados'].dta_datanascimento_pac;
        document.getElementById("emailPaciente").value = resposta['dados'].txt_email_pac;
        document.getElementById("telefonePaciente").value = resposta['dados'].txt_telefone_pac;
        document.getElementById("civilPaciente").value = resposta['dados'].txt_estadocivil_pac;       
        document.getElementById("cepPaciente").value = resposta['dados'].txt_cep_pac;
        document.getElementById("logradouroPaciente").value = resposta['dados'].txt_logradouro_pac;
        document.getElementById("casaPaciente").value = resposta['dados'].num_numero_pac;
        document.getElementById("complementoPaciente").value = resposta['dados'].txt_complemento_pac;
        document.getElementById("bairroPaciente").value = resposta['dados'].txt_bairro_pac;
        document.getElementById("cidadePaciente").value = resposta['dados'].txt_cidade_pac;
        document.getElementById("estadoPaciente").value = resposta['dados'].txt_estado_pac;
        document.getElementById("observacoesPaciente").value = resposta['dados'].txt_observacoes_pac;
        document.getElementById("matriculaPaciente").value = resposta['dados'].txt_matricula_pac;
        document.getElementById("ultimaVisitaPaciente").value = resposta['dados'].dta_ultimavisita_pac;
        document.getElementById("usuarioRegistroPaciente").value = resposta['dados'].usuarioCadastro;
        document.getElementById("dataRegistroPaciente").value = resposta['dados'].dta_registro_pac;
        document.getElementById("usuarioAlteracaoPaciente").value = resposta['dados'].usuarioAlteracao;
        document.getElementById("dataAlteracaoPaciente").value = resposta['dados'].dth_alteracao_pac;
        document.getElementById("ativoPaciente").value = resposta['dados'].txt_ativo_pac;

    }
    
}//fim visualizacao paciente

//inicio edicao de paciente

async function ediPaciente(num_id_pac){  
    msgAlertaEdit.innerHTML = ""; 

    const dados = await fetch('dao.paciente.php?acao=' + "vis" + '&id=' + num_id_pac);
    const resposta = await dados.json();
    
    if(resposta['erro']){
        msgAlertaEdit.innerHTML = resposta['msg'];
    }else{
        const ediPacienteModal1 = new bootstrap.Modal(document.getElementById("ediPacienteModal"));
        ediPacienteModal1.show();
        document.getElementById("idPacienteEdi").value = resposta['dados'].num_id_pac;
        document.getElementById("nomePacienteEdi").value = resposta['dados'].txt_nome_pac;
        document.getElementById("categoriaPacienteEdi").value = resposta['dados'].txt_nome_cat;
        document.getElementById("cpfPacienteEdi").value = resposta['dados'].txt_cpf_pac;
        document.getElementById("corPacienteEdi").value = resposta['dados'].txt_cor_pac;
        document.getElementById("sexoPacienteEdi").value = resposta['dados'].txt_sexo_pac;
        document.getElementById("nascimentoPacienteEdi").value = resposta['dados'].dta_datanascimento_pac;
        document.getElementById("emailPacienteEdi").value = resposta['dados'].txt_email_pac;
        document.getElementById("telefonePacienteEdi").value = resposta['dados'].txt_telefone_pac;
        document.getElementById("civilPacienteEdi").value = resposta['dados'].txt_estadocivil_pac;       
        document.getElementById("cepPacienteEdi").value = resposta['dados'].txt_cep_pac;
        document.getElementById("logradouroPacienteEdi").value = resposta['dados'].txt_logradouro_pac;
        document.getElementById("casaPacienteEdi").value = resposta['dados'].num_numero_pac;
        document.getElementById("complementoPacienteEdi").value = resposta['dados'].txt_complemento_pac;
        document.getElementById("bairroPacienteEdi").value = resposta['dados'].txt_bairro_pac;
        document.getElementById("cidadePacienteEdi").value = resposta['dados'].txt_cidade_pac;
        document.getElementById("estadoPacienteEdi").value = resposta['dados'].txt_estado_pac;
        document.getElementById("observacoesPacienteEdi").value = resposta['dados'].txt_observacoes_pac;
        document.getElementById("matriculaPacienteEdi").value = resposta['dados'].txt_matricula_pac;
        document.getElementById("ativoPacienteEdi").value = resposta['dados'].txt_ativo_pac;

    }
}

ediPacienteForm.addEventListener("submit",async(e) => {

    document.getElementById("edi-paciente-btn").value = "Salvando...";

    e.preventDefault();
    const dadosForm = new FormData(ediPacienteForm);
    /*
        verificar os dados do array antes de enviar
        for (var dadosFormEdit of dadosForm.entries()){
            console.log(dadosFormEdit[0] + " - " + dadosFormEdit[1]);
        }
    */
        const dados = await fetch("dao.paciente.php?acao=edit", {
            method: "POST",
            body:dadosForm
        });

        const resposta = await dados.json();

            if(resposta['erro']){
                msgAlertaEdit.innerHTML = resposta['msg'];
                document.getElementById("edi-paciente-btn").value = "Salvar"; 
            }else{
                msgAlertaEdit.innerHTML = resposta['msg'];
                ediPacienteForm.reset();
                //ediUsuarioModal.dismiss(); //verificar motivo de nao fechar 23/03/2023
                //listarUsuarios(1);//atualizar registros da tela. //retirada listagemn com paginacao 07/03/2023 - adriano nogueira
                document.getElementById("edi-paciente-btn").value = "Salvar"; 
            }

})
//funcao para apagar registro do usuario
async function apagarUsuario(num_id_usu){

    var confirmar = confirm("Tem certeza que deseja excluir o registro?");
        if(confirmar){
            const dados = await fetch('dao.usuario.php?acao=' + "apagar" + '&id=' + num_id_usu);
            const resposta = await dados.json();
            
            if(resposta['erro']){
                msgAlertaForm.innerHTML = resposta['msg'];
            }else{
                msgAlertaForm.innerHTML = resposta['msg'];
                //listarUsuarios(1); retirada listagemn com paginacao 07/03/2023 - adriano nogueira
                removeMensagem();
            }
        }else{

        }
    
}
