<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
 <title>SGCLINIC - Sistema de Gestão de Clinicas 🚑🏥💉🩺📊</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="author" content="Adriano Nogueira - Desenvolvedor">
   <meta content= "SGCLINIC - SISTEMA DE GESTÃO DE CLINICAS" name="description">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta charset="utf-8">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
   <script src="js/bootstrap.min.js"></script>

 </head>
<body>
    <div class="divider d-flex align-items-center my-4">
        <p class="text-center fw-bold mx-3 mb-0"></p>
    </div>
    
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5"><img src="imagens/login.png" class="img-fluid" alt="Sample image"></div>            
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method="post" action="processa-login.php">
                            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                <p class="lead fw-normal mb-0 me-3">Seja Bem Vindo!</p>
                            </div>

                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" class="form-control form-control-lg" name="login" required="true" placeholder="Insira o Usuario" />
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="password" name="senha" required="true"  class="form-control form-control-lg" placeholder="Insira a Senha" />
                            </div>

                            <div class="text-lg-start mt-4 pt-2">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Acessar Sistema</button>
                            </div>
                            <div class=" d-flex text-center  align-items-center my-4">
                                <small class="text-muted">Sistema de Gestão de Clinicas - Versão 1.11.23</small>
                            </div>                            
                        </form>                        
                    </div>                    
                </div>
                
            </div>    
        </div>
    </section>

</body>
</html>


<!--

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
 <title>SGCLINIC - Sistema de Gestão de Clinicas 🚑🏥💉🩺📊</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="author" content="Adriano Nogueira - Desenvolvedor">
   <meta content= "SGCLINIC - SISTEMA DE GESTÃO DE CLINICAS" name="description">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta charset="utf-8">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
   <script src="js/bootstrap.min.js"></script>

 </head>
<body>

<table  align="center" width="800">
    <tr>
        <td><img src="imagens/login.png" class="img-thumbnail" alt="" width="100%" height="100%" /></td>
        <td>
            <h5 class="m-1">Bem Vindo</legend>
                <form method="post" action="processa-login.php">
                
                    <div class="form-group  col-12">
                        <input type="text" class="form-control" id="login" name="login" required="true"  placeholder="Informe Usuario">    
                    </div>

                    <div class="form-group  col-12">
                        <input type="password" class="form-control" id="senha" name="senha" required="true" placeholder="Senha">
                    </div>
                    
                    <input type="submit" class="btn btn-outline-primary m-2" name="btnEntrar" value="Acessar Sistema" />

                    <small class="text-muted m-2">Versão 1.11.23</small>
        </td>
    </tr>
</table>
</form>
</body>
</html>


-->