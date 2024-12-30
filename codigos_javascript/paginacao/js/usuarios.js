const tbody = document.querySelector(".listar-usuarios");
const cadUsuarioForm = document.getElementById("cad-Usuario-Form");
const ediUsuarioForm = document.getElementById("edi-Usuario-Form");
const msgAlerta = document.getElementById("msgAlerta");
const msgAlertaEdit = document.getElementById("msgAlertaEdit");
const msgAlertaForm = document.getElementById("msgAlertaForm");
const cadUsuarioModal = new bootstrap.Modal(document.getElementById("cadUsuarioModal"));
const ediUsuarioModal = new bootstrap.Modal(document.getElementById("ediUsuarioModal"));
const visModal = new bootstrap.Modal(document.getElementById("visUsuarioModal"));
const cadtipoUsuario = document.getElementById("inputTipo");
const ediTipoUsuario = document.getElementById("ediTipo");

//textos em maiusculo
document.getElementById('inputNome').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});

document.getElementById('ediNome').addEventListener('keyup', (ev) => {
	const input = ev.target;
	input.value = input.value.toUpperCase();
});
//

//listar dados de tipo de usuario

if(inputTipo){
    listarTipoUsuario();
}

async function listarTipoUsuario(){
    const dadosTipoUsuario = await fetch('listar_tipo_usuario.php');
    const respostaTipoUsuario = await dadosTipoUsuario.json();

    if(respostaTipoUsuario['status']){
        document.getElementById("msgAlertaTipo").innerHTML = "";

        for (var i = 0; i< respostaTipoUsuario.dados.length; i++){
            cadtipoUsuario.innerHTML = cadtipoUsuario.innerHTML +  '<option value="' + respostaTipoUsuario.dados[i]['num_id_tu'] + '"> ' + respostaTipoUsuario.dados[i]['txt_nome_tu'] + ' </option>' 
            ediTipoUsuario.innerHTML = ediTipoUsuario.innerHTML +  '<option value="' + respostaTipoUsuario.dados[i]['num_id_tu'] + '"> ' + respostaTipoUsuario.dados[i]['txt_nome_tu'] + ' </option>' 
        }
    }else{
        document.getElementById("msgAlertaTipo").innerHTML = respostaTipoUsuario['msg'];
    }
}
//fim listar dados de tipo de usuario

//funcao para remover o alerta da tela
function removeMensagem(){
    setTimeout(function(){
        document.getElementById("msgAlerta").innerHTML = "";//
        document.getElementById("msgAlertaEdit").innerHTML = "";//
        document.getElementById("msgAlertaForm").innerHTML = "";//
    },8000);


}
//listar dados
const listarUsuarios = async (pagina) => {
    //const dados = await fetch("./listaUsuarios.php?pagina=" + pagina);
    const dados = await fetch("./dao.usuario.php?acao=list&pagina=" + pagina);
    const resposta = await dados.text();
    tbody.innerHTML = resposta;
}
listarUsuarios(1);

//cadastrar registro

if(cadUsuarioForm){
    cadUsuarioForm.addEventListener("submit", async(e) => {
        
        e.preventDefault();//nao permitir atualizacao da pagina

        document.getElementById("cad-Usuario-btn").value= "Salvando..."//exibir texto do botao salvando..

                //validacao campos javascript
                if(document.getElementById("inputNome").value == ""){            
                    msgAlerta.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Nome!</div>"
                }else if(document.getElementById("inputLogin").value == ""){
                    msgAlerta.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Login!</div>"
                }else if(document.getElementById("inputSenha").value == ""){
                    msgAlerta.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Senha!</div>"
                }else if(document.getElementById("inputEmail").value == ""){
                    msgAlerta.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Email!</div>"
                }else if(document.getElementById("inputTipo").value==""){
                    msgAlerta.innerHTML = "<div class='alert alert-danger' role='alert'> Erro: Necessario selecionar Tipo de Usuario!</div>"
                }else{        
                                        
                        const dadosForm = new FormData(cadUsuarioForm);
                        dadosForm.append("add",1);            
                        
                        const dados = await fetch("dao.usuario.php?acao=cad",{
                            method: "POST",
                            body: dadosForm,
                        });

                            const resposta = await dados.json();

                                if(resposta['erro']){
                                    msgAlerta.innerHTML = resposta['msg'];
                                }else{
                                    msgAlerta.innerHTML = resposta['msg'];
                                    cadUsuarioForm.reset();                     
                                    listarUsuarios(1);//atualizar registros da tela.                        
                                }

                }//fim validacao campos em javascript        
            
                document.getElementById("cad-Usuario-btn").value= "Salvar"//botar texto padrao do botao salvar no modal
                removeMensagem(); 
                //cadUsuarioModal.hide();
       
    })
    
    
}//fim cadastro de usuario

//inicio visualziacao usuario
async function visUsuario(num_id_usu){

    const dados = await fetch('dao.usuario.php?acao=' + "vis" + '&id=' + num_id_usu);
    const resposta = await dados.json();

    if(resposta['erro']){
        msgAlerta.innerHTML = resposta['msg'];
    }else{
        const visModal = new bootstrap.Modal(document.getElementById("visUsuarioModal"));
        visModal.show();
        document.getElementById("idUsuario").innerHTML = resposta['dados'].num_id_usu;
        document.getElementById("tipoUsuario").innerHTML = resposta['dados'].txt_nome_tu;
        document.getElementById("nomeUsuario").innerHTML = resposta['dados'].txt_nome_usu;
        document.getElementById("loginUsuario").innerHTML = resposta['dados'].txt_login_usu;
        document.getElementById("emailUsuario").innerHTML = resposta['dados'].txt_email_usu;
        document.getElementById("ativoUsuario").innerHTML = resposta['dados'].txt_ativo_usu;
    }
    
}//fim visualizacao usuario

//inicio edicao de cadastro de usuario

async function ediUsuario(num_id_usu){  
    msgAlertaEdit.innerHTML = ""; 
    const dados = await fetch('dao.usuario.php?acao=' + "vis" + '&id=' + num_id_usu);

    const resposta = await dados.json();
    
    if(resposta['erro']){
        msgAlerta.innerHTML = resposta['msg']
    }else{
        const ediModal = new bootstrap.Modal(document.getElementById("ediUsuarioModal"));
        ediModal.show();

        document.getElementById("ediid").value = resposta['dados'].num_id_usu;
        document.getElementById("ediLogin").value = resposta['dados'].txt_login_usu;
        document.getElementById("ediNome").value = resposta['dados'].txt_nome_usu;
        document.getElementById("ediSenha").value = resposta['dados'].txt_senha_usu;
        document.getElementById("ediEmail").value = resposta['dados'].txt_email_usu;
    }
}

ediUsuarioForm.addEventListener("submit",async(e) => {

    document.getElementById("edi-Usuario-btn").value = "Salvando...";

    e.preventDefault();
    const dadosForm = new FormData(ediUsuarioForm);

        const dados = await fetch("dao.usuario.php?acao=edit", {
            method: "POST",
            body:dadosForm
        });

        const resposta = await dados.json();

            if(resposta['erro']){
                msgAlertaEdit.innerHTML = resposta['msg'];
            }else{
                msgAlertaEdit.innerHTML = resposta['msg'];
                ediUsuarioForm.reset();
                //ediUsuarioModal.dismiss(); //verificar motivo de nao fechar 23/03/2023
                listarUsuarios(1);//atualizar registros da tela. 
                document.getElementById("edi-Usuario-btn").value = "Salvar";              
                   
            }

})

async function apagarUsuario(num_id_usu){

    var confirmar = confirm("Tem certeza que deseja excluir o registro?");
        if(confirmar){
            const dados = await fetch('dao.usuario.php?acao=' + "apagar" + '&id=' + num_id_usu);
            const resposta = await dados.json();
            
            if(resposta['erro']){
                msgAlertaForm.innerHTML = resposta['msg'];
            }else{
                msgAlertaForm.innerHTML = resposta['msg'];
                listarUsuarios(1);
                removeMensagem();
            }
        }else{

        }
    
}