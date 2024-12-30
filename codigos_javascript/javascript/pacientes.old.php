<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="ADRIANO NOGUEIRA DO NASCIMENTO">
    <meta description="Pagina responsavel pela listagem de usuarios, manutencao e cadastro de novos.">
    <meta version="1.0 - 22/02/2023">
    <link rel="shortcut icon" href="imagens/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <title>SGC - SISTEMA DE GERENCIAMENTO DE CLINICAS</title>
</head>
<body>
    <div class="container">
        <div class="row mt-4 mb-2">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4>Listagem Pacientes</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cadPacienteModal" onclick="cadPacienteForm.reset()">Novo Paciente</button>
                </div>
            </div>
            
        </div>
        <div class="row mt-4 mb-2">
            <div class="col-md-12">
                <div>
                    <form class="form" id="form-pesquisar">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="inputPesquisar" name="inputPesquisar" placeholder="Informe nome para pesquisa..." onkeyup="consultarPaciente(document.getElementById('inputPesquisar').value)">
                        </div>                        
                    </form>
                </div>
            </div>
            
        </div>          
        <hr> 
        
        <span id="msgAlertaForm"></span>
        
        <div class="row">
            <div class="col-sm-12">
                <span class="listar-pacientes"></span>
            </div>
        </div>     
        

    <!-- Inicio modal cadastrar paciente-->
    <div class="modal" id="cadPacienteModal" name="cadPacienteModal" tabindex="-1" aria-labellebdy="cadPacienteModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadPacienteModal">Novo Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="cad-paciente-Form">
                        <span id="msgAlertaCad"></span> 

                        <div class="col-md-8">
                            <label for="inputNome" class="form-label">Nome*</label><input type="nome" class="form-control" id="inputNome" name="inputNome" >
                        </div>

                        <div class="col-md-4">
                            <span id="msgAlertaCategoria"></span>
                            <label for="inputCategoria" class="form-label">Categoria*</label>
                            <select id="inputCategoria" class="form-select" name="inputCategoria" >
                            <option value="" selected>SELECIONE</option>
                            </select>
                        </div>                         

                        <div class="col-md-4">
                            <label for="inputCpf" class="form-label">CPF*</label><input type="cpf" class="form-control" id="inputCpf" name="inputCpf" >
                        </div>

                        <div class="col-md-4">
                            <label for="inputMatricula" class="form-label">Matricula</label><input type="matricula" class="form-control" id="inputMatricula" name="inputMatricula" >
                        </div>

                        <div class="col-md-4">
                            <label for="inputCor" class="form-label">Cor</label>
                            <select id="inputCor" class="form-select" name="inputCor" >
                                <option value="">SELECIONE</option>                                
                                <option value="BRANCO">BRANCO</option>
                                <option value="PARDO">PARDO</option>
                                <option value="NEGRO">NEGRO</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="inputSexo" class="form-label">Sexo</label>
                            <select id="inputSexo" class="form-select" name="inputSexo" > 
                                <option value="">SELECIONE</option>                               
                                <option value="MASCULINO">MASCULINO</option>
                                <option value="FEMININO">FEMININO</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="inputDataNascimento" class="form-label">Data de Nascimento</label><input type="date" class="form-control" id="inputDataNascimento" name="inputDataNascimento">
                        </div>

                        <div class="col-md-4">
                            <label for="inputNatural" class="form-label">Naturalidade</label>
                            <select id="inputNatural" class="form-select" name="inputNatural" > 
                                <option value="">SELECIONE</option>                               
                                <OPTION VALUE="MANAUS">MANAUS</OPTION>
                                <OPTION VALUE="PARINTINS">PARINTINS</OPTION>
                                <OPTION VALUE="ITACOATIARA">ITACOATIARA</OPTION>
                                <OPTION VALUE="MANACAPURU">MANACAPURU</OPTION>
                                <OPTION VALUE="COARI">COARI</OPTION>
                                <OPTION VALUE="TABATINGA">TABATINGA</OPTION>
                                <OPTION VALUE="MAUES">MAUÉS</OPTION>
                                <OPTION VALUE="TEFE">TEFÉ</OPTION>
                                <OPTION VALUE="MANICORE">MANICORÉ</OPTION>
                                <OPTION VALUE="HUMAITA">HUMAITÁ</OPTION>
                                <OPTION VALUE="IRANDUBA">IRANDUBA</OPTION>
                                <OPTION VALUE="LABREA">LÁBREA</OPTION>
                                <OPTION VALUE="SAO GABRIEL DA CACHOEIRA">SÃO GABRIEL DA CACHOEIRA</OPTION>
                                <OPTION VALUE="BENJAMIN CONSTANT">BENJAMIN CONSTANT</OPTION>
                                <OPTION VALUE="BORBA">BORBA</OPTION>
                                <OPTION VALUE="AUTAZES">AUTAZES</OPTION>
                                <OPTION VALUE="SAO PAULO DE OLIVENCA">SÃO PAULO DE OLIVENÇA</OPTION>
                                <OPTION VALUE="CAREIRO">CAREIRO</OPTION>
                                <OPTION VALUE="NOVA OLINDA DO NORTE">NOVA OLINDA DO NORTE</OPTION>
                                <OPTION VALUE="PRESIDENTE FIGUEIREDO">PRESIDENTE FIGUEIREDO</OPTION>
                                <OPTION VALUE="EIRUNEPE">EIRUNEPÉ</OPTION>
                                <OPTION VALUE="BOCA DO ACRE">BOCA DO ACRE</OPTION>
                                <OPTION VALUE="RIO PRETO DA EVA">RIO PRETO DA EVA</OPTION>
                                <OPTION VALUE="MANAQUIRI">MANAQUIRI</OPTION>
                                <OPTION VALUE="BARREIRINHA">BARREIRINHA</OPTION>
                                <OPTION VALUE="CAREIRO DA VÁRZEA">CAREIRO DA VÁRZEA</OPTION>
                                <OPTION VALUE="IPIXUNA">IPIXUNA</OPTION>
                                <OPTION VALUE="CODAJAS">CODAJÁS</OPTION>
                                <OPTION VALUE="CARAUARI">CARAUARI</OPTION>
                                <OPTION VALUE="BARCELOS">BARCELOS</OPTION>
                                <OPTION VALUE="SANTA ISABEL DO RIO NEGRO">SANTA ISABEL DO RIO NEGRO</OPTION>
                                <OPTION VALUE="NOVO ARIPUANA">NOVO ARIPUANÃ</OPTION>
                                <OPTION VALUE="URUCURITUBA">URUCURITUBA</OPTION>
                                <OPTION VALUE="APUI">APUÍ</OPTION>
                                <OPTION VALUE="ANORI">ANORI</OPTION>
                                <OPTION VALUE="NHAMUNDA">NHAMUNDÁ</OPTION>
                                <OPTION VALUE="SANTO ANTONIO DO ICA">SANTO ANTÔNIO DO IÇÁ</OPTION>
                                <OPTION VALUE="ATALAIA DO NORTE">ATALAIA DO NORTE</OPTION>
                                <OPTION VALUE="ENVIRA">ENVIRA</OPTION>
                                <OPTION VALUE="BERURI">BERURI</OPTION>
                                <OPTION VALUE="NOVO AIRAO">NOVO AIRÃO</OPTION>
                                <OPTION VALUE="BOA VISTA DO RAMOS">BOA VISTA DO RAMOS</OPTION>
                                <OPTION VALUE="PAUINI">PAUINI</OPTION>
                                <OPTION VALUE="TONANTINS">TONANTINS</OPTION>
                                <OPTION VALUE="MARAA">MARAÃ</OPTION>
                                <OPTION VALUE="GUAJARA">GUAJARÁ</OPTION>
                                <OPTION VALUE="TAPAUA">TAPAUÁ</OPTION>
                                <OPTION VALUE="FONTE BOA">FONTE BOA</OPTION>
                                <OPTION VALUE="ALVARAES">ALVARÃES</OPTION>
                                <OPTION VALUE="URUCARA">URUCARÁ</OPTION>
                                <OPTION VALUE="CANUTAMA">CANUTAMA</OPTION>
                                <OPTION VALUE="JURUA">JURUÁ</OPTION>
                                <OPTION VALUE="SAO SEBASTIAO DO UATUMA">SÃO SEBASTIÃO DO UATUMÃ</OPTION>
                                <OPTION VALUE="ANAMA">ANAMÃ</OPTION>
                                <OPTION VALUE="UARINI">UARINI</OPTION>
                                <OPTION VALUE="CAAPIRANGA">CAAPIRANGA</OPTION>
                                <OPTION VALUE="JUTAI">JUTAÍ</OPTION>
                                <OPTION VALUE="AMATURA">AMATURÁ</OPTION>
                                <OPTION VALUE="ITAPIRANGA">ITAPIRANGA</OPTION>
                                <OPTION VALUE="SILVES">SILVES</OPTION>
                                <OPTION VALUE="ITAMARATI">ITAMARATI</OPTION>
                                <OPTION VALUE="JAPURA">JAPURÁ</OPTION>
                                <OPTION VALUE="OUTROS">OUTROS</OPTION>

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail" class="form-label">E-mail</label><input type="email" class="form-control" id="inputEmail" name="inputEmail" >
                        </div>

                        <div class="col-md-3">
                            <label for="inputTelefone" class="form-label">Telefone*</label><input type="telefone" class="form-control" id="inputTelefone" name="inputTelefone" placeholder="9299990000">
                        </div>

                        <div class="col-md-3">
                            <label for="inputEstadoCivil" class="form-label">Estado Civil</label>
                            <select id="inputEstadoCivil" class="form-select" name="inputEstadoCivil" > 
                                <option value="">SELECIONE</option>                               
                                <option value="CASADO">CASADO</option>
                                <option value="SOLTEIRO">SOLTEIRO</option>
                                <option value="SEPARADO">SEPARADO</option>
                                <option value="VIUVO">VIUVO</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label for="inputDificuldade" class="form-label">Possui alguma dificuldade?</label><input type="dificuldade" class="form-control" id="inputDificuldade" name="inputDificuldade" placeholder="Descreva aqui...">
                        </div> 

                        <div class="col-md-4">
                            <span id="msgAlertaProfissao"></span>
                            <label for="inputProfissao" class="form-label">Profissão*</label>
                            <select id="inputProfissao" class="form-select" name="inputProfissao" >
                            <option value="" selected>SELECIONE</option>
                            </select>
                        </div>  

                        <span id="msgAlertaCepNaoEncontrado"></span>
                        <div class="col-md-3">
                            <label for="inputCep" class="form-label">CEP</label><input type="CEP" class="form-control" id="inputCep" name="inputCep" onblur="pesquisacep(this.value);" placeholder="Somente numeros">
                        </div>

                        <div class="col-md-7">
                            <label for="inputLogradouro" class="form-label">Logradouro</label><input type="logradouro" class="form-control" id="inputLogradouro" name="inputLogradouro">
                        </div>

                        <div class="col-md-2">
                            <label for="inputNumero" class="form-label">Numero</label><input type="numero" class="form-control" id="inputNumero" name="inputNumero">
                        </div>

                        <div class="col-md-3">
                            <label for="inputComplemento" class="form-label">Complemento</label><input type="complemento" class="form-control" id="inputComplemento" name="inputComplemento">
                        </div>

                        <div class="col-md-3">
                            <label for="inputBairro" class="form-label">Bairro</label><input type="bairro" class="form-control" id="inputBairro" name="inputBairro">
                        </div>

                        <div class="col-md-3">
                            <label for="inputCidade" class="form-label">Cidade</label><input type="cidade" class="form-control" id="inputCidade" name="inputCidade">
                        </div>

                        <div class="col-md-3">
                            <label for="inputEstado" class="form-label">Estado</label><input type="estado" class="form-control" id="inputEstado" name="inputEstado">
                        </div>    
                      
                        <div class="col-md-12">
                            <label for="inputObservacoes" class="form-label">Observações</label><textarea type="observaoes" class="form-control" id="inputObservacoes" name="inputObservacoes"></textarea>
                        </div> 

                        <div class="col-12">
                            <input type="submit" class="btn btn-outline-success" id="cad-paciente-btn" value="Salvar">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>                   
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal cadastrar Paciente-->

    <!-- Inicio modal detalhes usuario-->
    <div class="modal" id="visPacienteModal" tabindex="-1" aria-labellebdy="visPacienteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visPacienteModal">Detalhes do Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9"><span id="idUsuario"></span></dd>

                        <dt class="col-sm-3">Tipo:</dt>
                        <dd class="col-sm-9"><span id="tipoUsuario"></span></dd>

                    </dl>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal detalhes paciente-->

    <!-- Inicio modal editar usuario-->
    <div class="modal" id="ediUsuarioModal" tabindex="-1" aria-labellebdy="ediUsuarioModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ediUsuarioModal">Editar Usuario</h5>
                    <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="edi-Usuario-Form">
                        <span id="msgAlertaEdit"></span> 
                        <input type="hidden" name="ediid" id="ediid">
                        <div class="col-md-12">
                            <label for="ediNome" class="form-label">Nome</label>
                            <input type="nome" class="form-control" id="ediNome" name="ediNome">
                        </div>
                        <div class="col-md-6">
                            <label for="ediLogin" class="form-label">Login</label>
                            <input type="login" class="form-control" id="ediLogin" name="ediLogin" disabled="true">
                        </div>
                        <div class="col-md-6">
                            <label for="ediSenha" class="form-label">Senha</label>
                            <input type="text" class="form-control" id="ediSenha" name="ediSenha" >
                        </div>
                        <div class="col-md-12">
                            <label for="ediEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="ediEmail" name="ediEmail" >
                        </div>
                        <div class="col-md-12">
                            <span id="msgAlertaTipo"></span>
                            <label for="ediTipo" class="form-label">Tipo Usuario</label>
                            <select id="ediTipo" class="form-select" name="ediTipo" >
                                <option value="" selected>Selecione...</option>
                            </select>
                        </div> 
                        <div class="col-md-12">
                            <label for="ediAtivo" class="form-label">Ativo</label>
                            <select id="ediAtivo" class="form-select" name="ediAtivo" >                                
                                <option value="S">SIM</option>
                                <option value="N">NAO</option>
                            </select>
                        </div> 
                        <div class="col-12">                            
                            <input type="submit" class="btn btn-outline-warning" id="edi-Usuario-btn" value="Salvar">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>                   
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal editar usuario-->

    <script src="js/pacientes.js"></script>
    <!--//aumentar o tamanho do modal direto
    <style>
      .padrao {
        width: 900px;
        min-height: 500px;
        
      }
    </style>
    -->

</body>
</html>