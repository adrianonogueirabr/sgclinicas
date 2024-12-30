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
    <div class="container-md">
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
                        <form class="row g-3" id="cad-paciente-form">
                            <span id="msgAlertaCad"></span>

                            <div class="col-md-8"><label for="inputNome" class="form-label">Nome*</label><input type="nome" class="form-control" id="inputNome" name="inputNome"></div>

                            <div class="col-md-4">
                                <span id="msgAlertaCategoria"></span>
                                <label for="inputCategoria" class="form-label">Categoria*</label>
                                <select id="inputCategoria" class="form-select" name="inputCategoria">
                                <option value="" selected>SELECIONE</option></select>
                            </div>                            

                            <div class="col-md-4"><label for="inputCpf" class="form-label">CPF*</label><input type="cpf" class="form-control" id="inputCpf" name="inputCpf"></div>

                            <div class="col-md-4"><label for="inputMatricula" class="form-label">Matricula</label><input type="matricula" class="form-control" id="inputMatricula" name="inputMatricula"></div>

                            <div class="col-md-4">
                                <label for="inputCor" class="form-label">Cor</label>
                                <select id="inputCor" class="form-select" name="inputCor">
                                    <option value="">SELECIONE</option>
                                    <option value="BRANCO">BRANCO</option>
                                    <option value="PARDO">PARDO</option>
                                    <option value="NEGRO">NEGRO</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="inputSexo" class="form-label">Sexo</label>
                                <select id="inputSexo" class="form-select" name="inputSexo">
                                    <option value="">SELECIONE</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                    <option value="FEMININO">FEMININO</option>
                                </select>
                            </div>

                            <div class="col-md-4"><label for="inputDataNascimento" class="form-label">Data de Nascimento*</label><input type="date" class="form-control" id="inputDataNascimento" name="inputDataNascimento"></div>

                            <div class="col-md-6"><label for="inputEmail" class="form-label">E-mail</label><input type="email" class="form-control" id="inputEmail" name="inputEmail"></div>

                            <div class="col-md-3"><label for="inputTelefone" class="form-label">Telefone*</label><input type="telefone" class="form-control" id="inputTelefone" name="inputTelefone" placeholder="9299990000"></div>

                            <div class="col-md-3">
                                <label for="inputEstadoCivil" class="form-label">Estado Civil</label>
                                <select id="inputEstadoCivil" class="form-select" name="inputEstadoCivil">
                                    <option value="">SELECIONE</option>
                                    <option value="CASADO">CASADO</option>
                                    <option value="SOLTEIRO">SOLTEIRO</option>
                                    <option value="SEPARADO">SEPARADO</option>
                                    <option value="VIUVO">VIUVO</option>
                                </select>
                            </div>
                            
                            <span id="msgAlertaCepNaoEncontrado"></span>

                            <div class="col-md-3"><label for="inputCep" class="form-label">CEP</label><input type="CEP" class="form-control" id="inputCep" name="inputCep" onblur="pesquisacep(this.value);" placeholder="Somente numeros"></div>
                            <div class="col-md-7"><label for="inputLogradouro" class="form-label">Logradouro</label><input type="logradouro" class="form-control" id="inputLogradouro" name="inputLogradouro"></div>
                            <div class="col-md-2"><label for="inputNumero" class="form-label">Numero</label><input type="numero" class="form-control" id="inputNumero" name="inputNumero"></div>
                            <div class="col-md-3"><label for="inputComplemento" class="form-label">Complemento</label><input type="complemento" class="form-control" id="inputComplemento" name="inputComplemento"></div>
                            <div class="col-md-3"><label for="inputBairro" class="form-label">Bairro</label><input type="bairro" class="form-control" id="inputBairro" name="inputBairro"></div>
                            <div class="col-md-3"><label for="inputCidade" class="form-label">Cidade</label><input type="cidade" class="form-control" id="inputCidade" name="inputCidade"></div>
                            <div class="col-md-3"><label for="inputEstado" class="form-label">Estado</label><input type="estado" class="form-control" id="inputEstado" name="inputEstado"></div>
                            <div class="col-md-12"><label for="inputObservacoes" class="form-label">Observações</label><textarea type="observaoes" class="form-control" id="inputObservacoes" name="inputObservacoes"></textarea></div>

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

        <!-- Inicio modal detalhes paciente-->
        <div class="modal" id="visPacienteModal" tabindex="-1" aria-labellebdy="visPacienteModal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visPacienteModal">Detalhes do Paciente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form class="row g-3">
                            <div class="form-group col-md-2"><label for="idPaciente">ID</label><input class="form-control" id="idPaciente" disabled></div>
                            <div class="form-group col-md-2"><label for="ativoPaciente">Cadastro Ativo</label><input class="form-control" id="ativoPaciente" disabled></div>
                            <div class="form-group col-md-5"><label for="nomePaciente">Nome</label><input type="text" class="form-control" id="nomePaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="categoriaPaciente">Categoria</label><input class="form-control" id="categoriaPaciente" disabled></div>                            
                            <div class="form-group col-md-3"><label for="cpfPaciente">CPF</label><input type="text" class="form-control" id="cpfPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="corPaciente">Cor</label><input type="text" class="form-control" id="corPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="sexoPaciente">Sexo</label><input type="text" class="form-control" id="sexoPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="nascimentoPaciente">Data Nascimento</label><input type="date" class="form-control" id="nascimentoPaciente" disabled></div>
                            <div class="form-group col-md-6"><label for="emailPaciente">Email</label><input type="text" class="form-control" id="emailPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="telefonePaciente">Telefone</label><input type="text" class="form-control" id="telefonePaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="civilPaciente">Estado Civil</label><input type="text" class="form-control" id="civilPaciente" disabled></div>
                            <div class="form-group col-md-2"><label for="cepPaciente">CEP</label><input type="text" class="form-control" id="cepPaciente" disabled></div>
                            <div class="form-group col-md-8"><label for="logradouroPaciente">Logradouro</label><input type="text" class="form-control" id="logradouroPaciente" disabled></div>
                            <div class="form-group col-md-2"><label for="casaPaciente">Numero</label><input type="text" class="form-control" id="casaPaciente" disabled></div>
                            <div class="form-group col-md-4"><label for="complementoPaciente">Complemento</label><input type="text" class="form-control" id="complementoPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="bairroPaciente">Bairro</label><input type="text" class="form-control" id="bairroPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="cidadePaciente">Cidade</label><input type="text" class="form-control" id="cidadePaciente" disabled></div>
                            <div class="form-group col-md-2"><label for="estadoPaciente">Estado</label><input type="text" class="form-control" id="estadoPaciente" disabled></div>
                            <div class="col-md-12"><label for="observacoesPaciente" class="form-label">Observações</label><textarea type="observaoes" class="form-control" id="observacoesPaciente" name="observacoesPaciente" disabled></textarea></div>
                            <div class="form-group col-md-3"><label for="matriculaPaciente">Matricula Convenio</label><input type="text" class="form-control" id="matriculaPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="ultimaVisitaPaciente">Ultima Visita</label><input type="text" class="form-control" id="ultimaVisitaPaciente" disabled></div>
                            <div class="form-group col-md-6"></div><!-- Div apenas para alinhar campos -->
                            <div class="form-group col-md-3"><label for="usuarioRegistroPaciente">Usuario Registro</label><input type="text" class="form-control" id="usuarioRegistroPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="dataRegistroPaciente">Data Registro</label><input type="text" class="form-control" id="dataRegistroPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="usuarioAlteracaoPaciente">Usuario Alteração</label><input type="text" class="form-control" id="usuarioAlteracaoPaciente" disabled></div>
                            <div class="form-group col-md-3"><label for="dataAlteracaoPaciente">Data Alteração</label><input type="text" class="form-control" id="dataAlteracaoPaciente" disabled></div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim modal detalhes paciente-->

        <!-- Inicio modal editar paciente-->
        <div class="modal" id="ediPacienteModal" tabindex="-1" aria-labellebdy="ediPacienteModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ediPacienteModal">Editar Paciente</h5>
                        <button type="button" id="btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                   

                        <form class="row g-3" id="edi-paciente-form">
                        <span id="msgAlertaEdit"></span>
                            <div class="form-group col-md-2"><label for="idPacienteEdi">ID</label><input type="number" class="form-control" id="idPacienteEdi" name="idPacienteEdi" readonly></div>
                            <div class="form-group col-md-7"><label for="nomePacienteEdi">Nome*</label><input type="text" name="nomePacienteEdi" class="form-control" id="nomePacienteEdi"></div>
                            
                            <div class="form-group col-md-3"><label for="cpfPacienteEdi">CPF*</label><input type="text" class="form-control" id="cpfPacienteEdi" name="cpfPacienteEdi" readonly></div>

                            <div class="col-md-3">
                                <label for="categoriaPacienteEdi" class="form-label">Categoria*</label>
                                <select id="categoriaPacienteEdi" class="form-select" name="categoriaPacienteEdi">
                                <option value="" selected>SELECIONE</option></select>
                            </div>

                            <div class="col-md-3">
                                <label for="corPacienteEdi" class="form-label">Cor</label>
                                <select id="corPacienteEdi" class="form-select" name="corPacienteEdi">
                                    <option value="">SELECIONE</option>
                                    <option value="BRANCO">BRANCO</option>
                                    <option value="PARDO">PARDO</option>
                                    <option value="NEGRO">NEGRO</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="sexoPacienteEdi" class="form-label">Sexo</label>
                                <select id="sexoPacienteEdi" class="form-select" name="sexoPacienteEdi">
                                    <option value="">SELECIONE</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                    <option value="FEMININO">FEMININO</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="civilPacienteEdi" class="form-label">Estado Civil</label>
                                <select id="civilPacienteEdi" class="form-select" name="civilPacienteEdi">
                                    <option value="">SELECIONE</option>
                                    <option value="CASADO">CASADO</option>
                                    <option value="SOLTEIRO">SOLTEIRO</option>
                                    <option value="SEPARADO">SEPARADO</option>
                                    <option value="VIUVO">VIUVO</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3"><label for="matriculaPacienteEdi">Matricula Convenio</label><input type="text" class="form-control" id="matriculaPacienteEdi" name="matriculaPacienteEdi"></div>  
                            <div class="form-group col-md-3"><label for="nascimentoPacienteEdi">Data Nascimento*</label><input type="date" class="form-control" id="nascimentoPacienteEdi" name="nascimentoPacienteEdi" ></div>
                            <div class="form-group col-md-3"><label for="emailPacienteEdi">Email</label><input type="text" class="form-control" id="emailPacienteEdi" name="emailPacienteEdi"></div>
                            <div class="form-group col-md-3"><label for="telefonePacienteEdi">Telefone*</label><input type="text" class="form-control" id="telefonePacienteEdi" name="telefonePacienteEdi" ></div>                            
                            <span id="msgAlertaCepNaoEncontrado"></span>
                            <div class="form-group col-md-3"><label for="cepPacienteEdi">CEP</label><input type="text" class="form-control" id="cepPacienteEdi" name="cepPacienteEdi" onblur="pesquisacep(this.value);" placeholder="Somente numeros"></div>
                            <div class="form-group col-md-6"><label for="logradouroPacienteEdi">Logradouro</label><input type="text" class="form-control" id="logradouroPacienteEdi" name="logradouroPacienteEdi"  ></div>
                            <div class="form-group col-md-3"><label for="casaPacienteEdi">Numero</label><input type="text" class="form-control" id="casaPacienteEdi" name="casaPacienteEdi"  ></div>
                            <div class="form-group col-md-3"><label for="complementoPacienteEdi">Complemento</label><input type="text" class="form-control" id="complementoPacienteEdi" name="complementoPacienteEdi" ></div>
                            <div class="form-group col-md-3"><label for="bairroPacienteEdi">Bairro</label><input type="text" class="form-control" id="bairroPacienteEdi" name="bairroPacienteEdi"  ></div>
                            <div class="form-group col-md-3"><label for="cidadePacienteEdi">Cidade</label><input type="text" class="form-control" id="cidadePacienteEdi" name="cidadePacienteEdi" ></div>
                            <div class="form-group col-md-3"><label for="estadoPacienteEdi">Estado</label><input type="text" class="form-control" id="estadoPacienteEdi" name="estadoPacienteEdi" ></div>
                            <div class="col-md-12"><label for="observacoesPacienteEdi" class="form-label">Observações</label><textarea type="observaoes" class="form-control" id="observacoesPacienteEdi"  name="observacoesPacienteEdi"></textarea></div>
                            <div class="form-group col-md-2"><label for="ativoPacienteEdi" class="form-label">Ativo*</label><select id="ativoPacienteEdi" class="form-select" name="ativoPacienteEdi"><option value="SIM">SIM</option><option value="NAO">NAO</option></select></div>

                            <div class="col-12">                            
                                <input type="submit" class="btn btn-outline-warning" id="edi-paciente-btn" value="Salvar">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
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