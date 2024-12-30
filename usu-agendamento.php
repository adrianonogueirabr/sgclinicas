<?php include "verifica.php" ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head> 
      <title>SGCLINIC - Sistema de Gestão de Clinicas 🚑🏥💉🩺📊</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="author" content="Adriano Nogueira - Desenvolvedor">
      <meta content= "SGCLINIC - SISTEMA DE GESTÃO DE CLINICAS" name="description">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <script src="css/jquery-3.3.1.slim.min.js"></script>
      <script src="css/popper.min.js"></script>
      <script src="css/bootstrap.min.js"></script>
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
      <!-- Google Fonts Roboto -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
      <!-- MDB -->
      <link rel="stylesheet" href="css/mdb.min.css" />

</head>

<body>
    <table  width="100%" class="table responsive border">
        <tr>
            <td>
                <nav class="navbar navbar-expand-lg bg-info navbar-dark">
                <a class="navbar-brand" href="#">
                    <!--<img src="imagens/inicial.jpg" width="30" height="30" class="d-inline-block align-top" alt=""> -->
                    <i class="far fa-hospital"></i> 
                    <?php echo ucfirst($_SESSION['login_usu']) ?>            
                  </a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="consulta-pacientes.php"><i class="fa fa-address-book" aria-hidden="true"></i> PACIENTES</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-clock"></i> AGENDAS
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="cadastro-agenda.php">CADASTRO</a>
                              <a class="dropdown-item" href="consulta-agenda.php">PESQUISAR</a>
                              <a class="dropdown-item" href="consulta-bloqueio-agenda.php">BLOQUEIO</a>
                            </div>
                        </li>

                        <a class="nav-link text-white" href="agendamentos.php"><i class="far fa-calendar-alt"></i> AGENDAMENTOS</a>
                      
                        <li class="nav-item">
                            <a class="nav-link text-white" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> SAIR</a>
                        </li>
                    </ul>
                    
                  </div>
                </nav>
            </td>
        </tr>
    </table>


</body>
</html>