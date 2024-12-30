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
                    <h4>Listagem Usuarios</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cadUsuarioModal" onclick="cadUsuarioForm.reset()">Novo Usuario</button>
                </div>
            </div>
            
        </div>
        <div class="row mt-4 mb-2">
            <div class="col-md-12">
                <div>
                    <form class="form" id="form-pesquisar">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="inputPesquisar" name="inputPesquisar" placeholder="Informe nome para pesquisa..." onkeyup="consultarUsuario(document.getElementById('inputPesquisar').value)">
                        </div>                        
                    </form>
                </div>
            </div>
            
        </div>          
        <hr> 
        
        <span id="msgAlertaForm"></span>
        
        <div class="row">
            <div class="col-md-12">
                <span class="listar-usuarios"></span>
            </div>
        </div>
        
        

    <!-- Inicio modal cadastrar usuario-->
    <div class="modal" id="cadUsuarioModal" name="cadUsuarioModal" tabindex="-1" aria-labellebdy="cadUsuarioModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadUsuarioModal">Novo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="cad-Usuario-Form">
                        <span id="msgAlertaCad"></span> 
                        <div class="col-md-12">
                            <label for="inputNome" class="form-label">Nome</label>
                            <input type="nome" class="form-control" id="inputNome" name="inputNome">
                        </div>
                        <div class="col-md-6">
                            <label for="inputLogin" class="form-label">Login</label>
                            <input type="login" class="form-control" id="inputLogin" name="inputLogin" >
                        </div>
                        <div class="col-md-6">
                            <label for="inputSenha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="inputSenha" name="inputSenha" >
                        </div>
                        <div class="col-md-12">
                            <label for="inputEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="inputEmail" name="inputEmail" >
                        </div>
                        <div class="col-md-12">
                            <span id="msgAlertaTipo"></span>
                            <label for="inputTipo" class="form-label">Tipo Usuario</label>
                            <select id="inputTipo" class="form-select" name="inputTipo" >
                            <option value="" selected>Selecione...</option>
                            </select>
                        </div> 
                        <div class="col-12">
                            <input type="submit" class="btn btn-outline-success" id="cad-Usuario-btn" value="Salvar">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>                   
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal cadastrar usuario-->

    <!-- Inicio modal detalhes usuario-->
    <div class="modal" id="visUsuarioModal" tabindex="-1" aria-labellebdy="visUsuarioModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visUsuarioModal">Detalhes do Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9"><span id="idUsuario"></span></dd>

                        <dt class="col-sm-3">Tipo:</dt>
                        <dd class="col-sm-9"><span id="tipoUsuario"></span></dd>

                        <dt class="col-sm-3">Nome:</dt>
                        <dd class="col-sm-9"><span id="nomeUsuario"></span></dd>

                        <dt class="col-sm-3">Login:</dt>
                        <dd class="col-sm-9"><span id="loginUsuario"></span></dd>

                        <dt class="col-sm-3">Email:</dt>
                        <dd class="col-sm-9"><span id="emailUsuario"></span></dd>

                        <dt class="col-sm-3">Ativo:</dt>
                        <dd class="col-sm-9"><span id="ativoUsuario"></span></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal detalhes usuario-->

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

    <script src="js/usuarios.js"></script>


</body>
</html>