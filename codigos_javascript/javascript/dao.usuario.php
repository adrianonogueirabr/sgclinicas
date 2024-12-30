<?php

include_once "conexao.php";

$acao = filter_input(INPUT_GET,"acao", FILTER_SANITIZE_STRING);

if($acao=="list"){//inicio lista de usuario

            $pagina = filter_input(INPUT_GET,"pagina", FILTER_SANITIZE_NUMBER_INT);

        if(!empty($pagina)){

            //calcular pagina de visualizacao
            $quantidade_result_pg = 10; //quantidade de registros por pagina

            $inicio = ($pagina * $quantidade_result_pg) - $quantidade_result_pg;

            $query_usuarios = "SELECT tbl_usuario_usu.num_id_usu, tbl_tipousuario_tu.txt_nome_tu, tbl_usuario_usu.txt_nome_usu, tbl_usuario_usu.txt_login_usu, tbl_usuario_usu.txt_email_usu, tbl_usuario_usu.txt_ativo_usu 
                                FROM tbl_usuario_usu 
                                INNER JOIN tbl_tipousuario_tu on tbl_usuario_usu.tbl_tipousuario_tu_num_id_tu = tbl_tipousuario_tu.num_id_tu
                                ORDER BY tbl_usuario_usu.num_id_usu DESC LIMIT $inicio, $quantidade_result_pg";

            $result_usuarios = $conn->prepare($query_usuarios);
            $result_usuarios->execute();

            $dadosUsuarios = "<div class='table-responsive'>
                                <table class='table table-striped table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo Usuario</th>
                                            <th>Nome</th>
                                            <th>Login</th>
                                            <th>E-mail</th>
                                            <th>Ativo</th>
                                            <th>Ações</th>
                                        </tr>        
                                    </thead>
                                <tbody>";

            while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){

                //var_dump($row_usuario);
                extract($row_usuario);

                    $dadosUsuarios .= "<tr>
                                            <td>$num_id_usu</td>
                                            <td>$txt_nome_tu</td>
                                            <td>$txt_nome_usu</td>
                                            <td>$txt_login_usu</td>
                                            <td>$txt_email_usu</td>
                                            <td>$txt_ativo_usu</td>
                                            <td>
                                                <button id='$num_id_usu' class='btn btn-outline-primary btn-sm' onclick='visUsuario($num_id_usu)'>Visualizar</button>
                                                <button id='$num_id_usu' class='btn btn-outline-warning btn-sm' onclick='ediUsuario($num_id_usu)'>Editar</button>
                                                <button id='$num_id_usu' class='btn btn-outline-danger btn-sm' onclick='apagarUsuario($num_id_usu)'>Apagar</button>
                                            </td>
                                        </tr>";
            }

            $dadosUsuarios .= "             <!-- Lugar onde irao aparecer os dados de usuarios-->
                                        </tbody>
                                    </table>
                                </div>";

            //paginacao somar a quantidade de usuarios
            $query_pg = "SELECT COUNT(tbl_usuario_usu.num_id_usu) AS num_result FROM tbl_usuario_usu";
            $result_pg = $conn->prepare($query_pg);
            $result_pg->execute();
            $row_pg = $result_pg->fetch(PDO::FETCH_ASSOC);

            //quantidade de paginas
            $quantidade_paginas = ceil($row_pg['num_result'] / $quantidade_result_pg);//funcao ceil para arrendodar o valor para cima 

            $max_links = 2; //links por exibicao

            //menu de paginacao
            $dadosUsuarios .= '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';
                    
                $dadosUsuarios .= "<li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios(1)'>Primeira</a></li>";

                for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
                    if($pag_ant >= 1){
                        $dadosUsuarios .= "<li class='page-item'><a class='page-link' href='#'  onclick='listarUsuarios($pag_ant)'>$pag_ant</a></li>";
                    }
                }        
                
                $dadosUsuarios .= "<li class='page-item active'><a class='page-link' href='#'>$pagina</a></li>";

                for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
                    if($pag_dep <= $quantidade_paginas){
                        $dadosUsuarios .= "<li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios($pag_dep)'>$pag_dep</a></li>";
                    }            
                }
                
                $dadosUsuarios .= "<li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios($quantidade_paginas)'>Ultima</a></li>";
                $dadosUsuarios .= '</ul></nav>';    

            echo $dadosUsuarios;

        }else{//caso variavel $pagina venha vazio.
            echo "<div class='alert alert-danger' role='alert'> Erro: nenhum usuario encontrado! </div>";
        }


}elseif($acao=="vis"){//fim lista de usuarios e inicio visualizacao

            $id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT);

            if(!empty($id)){

                $query_usuarios = "SELECT tbl_usuario_usu.num_id_usu, tbl_tipousuario_tu.txt_nome_tu, tbl_usuario_usu.txt_nome_usu, tbl_usuario_usu.txt_login_usu, tbl_usuario_usu.txt_email_usu,tbl_usuario_usu.txt_senha_usu, tbl_usuario_usu.txt_ativo_usu 
                                    FROM tbl_usuario_usu 
                                    INNER JOIN tbl_tipousuario_tu on tbl_usuario_usu.tbl_tipousuario_tu_num_id_tu = tbl_tipousuario_tu.num_id_tu
                                    WHERE tbl_usuario_usu.num_id_usu = :num_id_usu LIMIT 1";
                
                $result_usuario = $conn->prepare($query_usuarios);
                $result_usuario->bindParam(':num_id_usu', $id);
                $result_usuario->execute();

                $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

                $retorna = ['erro' => false, 'dados' => $row_usuario];    

            }else{//caso variavel $pagina venha vazio.    
                $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: nenhum usuario encontrado!</div>"];
            }

            echo json_encode($retorna);

}elseif($acao=="apagar"){//inicio apagar


    $id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT);

    if(!empty($id)){

        $query_usuarios = "DELETE FROM tbl_usuario_usu WHERE num_id_usu = :num_id_usu";
        
        $result_usuario = $conn->prepare($query_usuarios);
        $result_usuario->bindParam(':num_id_usu', $id);

            if($result_usuario->execute()){
                $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'> Registro excluido com sucesso!</div>"];
            }else{
                $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Registro nao excluido!</div>"];
            }        

    }else{//caso variavel $id venha vazio.    
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: nenhum usuario encontrado!</div>"];
    }

    echo json_encode($retorna);

}elseif($acao=="edit"){//fim apagar inicio editar

    //receber os dados do post
    $dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);

    //validar os dados do formulario
    if (empty($dados['ediid'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Problemas com sua requisicao, tente mais tarde!</div>"];
    }elseif(empty($dados['ediNome'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Nome!</div>"];
    }elseif(empty($dados['ediSenha'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Senha!</div>"];
    }elseif(empty($dados['ediEmail'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Email corretamente!</div>"];
    }elseif(empty($dados['ediTipo'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario selecionar o tipo de Usuario!</div>"];
    }elseif(empty($dados['ediAtivo'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario selecionar se usuario esta ativo ou nao!</div>"];
    }else{

        //Atualizando os dados no banco
            $query_usuario="UPDATE tbl_usuario_usu SET tbl_tipousuario_tu_num_id_tu = :tipo, txt_nome_usu = :nome , txt_senha_usu = :senha, txt_email_usu = :email, txt_ativo_usu = :ativo WHERE num_id_usu = :id";

            $edi_usuario = $conn->prepare($query_usuario);

            $edi_usuario->bindParam(':tipo',$dados['ediTipo']);
            $edi_usuario->bindParam(':nome',$dados['ediNome']);        
            $edi_usuario->bindParam(':senha',$dados['ediSenha']);
            $edi_usuario->bindParam(':email',$dados['ediEmail']);    
            $edi_usuario->bindParam(':ativo',$dados['ediAtivo']); 
            $edi_usuario->bindParam(':id',$dados['ediid']);       

            if($edi_usuario->execute()){
                $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Usuario alterado com sucesso!</div>"];
            }else{
                $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Cadastro nao foi alterado, tente novamente!</div>"];
            }

    }

        echo json_encode($retorna);


}elseif($acao=="cad"){//fim editar e inicio cadastrar
                //receber os dados do post
        $dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);

        //validar os dados do formulario
        if (empty($dados['inputNome'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Nome!</div>"];
        }elseif(empty($dados['inputLogin'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Login!</div>"];
        }elseif(empty($dados['inputSenha'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Senha!</div>"];
        }elseif(empty($dados['inputEmail'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Email corretamente!</div>"];
        }elseif(empty($dados['inputTipo'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario selecionar o tipo de Usuario!</div>"];
        }else{

                    //atribui login de usuario a variavel para verificar se ja existe
                    $loginDesejado = $dados['inputLogin'];

                    //verificar se ja existe usuario com mesmo login
                    $query_usuarios = "SELECT tbl_usuario_usu.num_id_usu, tbl_tipousuario_tu.txt_nome_tu, tbl_usuario_usu.txt_nome_usu, tbl_usuario_usu.txt_login_usu, tbl_usuario_usu.txt_email_usu,tbl_usuario_usu.txt_senha_usu, tbl_usuario_usu.txt_ativo_usu 
                                        FROM tbl_usuario_usu 
                                        INNER JOIN tbl_tipousuario_tu on tbl_usuario_usu.tbl_tipousuario_tu_num_id_tu = tbl_tipousuario_tu.num_id_tu
                                        WHERE tbl_usuario_usu.txt_login_usu = :loginDesejado LIMIT 1";

                    $result_usuarios = $conn->prepare($query_usuarios);

                    $result_usuarios->bindParam(':loginDesejado',$loginDesejado);

                    $result_usuarios->execute();

                    if($result_usuarios->rowCount()){

                            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Ja existe um usuario com esse login!</div>"];

                    }else{

                                //inserindo os dados no banco
                                $query_usuario="INSERT INTO tbl_usuario_usu (`num_id_usu`, `tbl_tipousuario_tu_num_id_tu`, `txt_nome_usu`, `txt_login_usu`, `txt_senha_usu`, `txt_email_usu`, `txt_ativo_usu`)
                                VALUES (NULL,:tipoUsuario, :nomeUsuario, :loginUsuario, :senhaUsuario, :emailUsuario, 'S');";

                                $cad_usuario = $conn->prepare($query_usuario);

                                    $cad_usuario->bindParam(':tipoUsuario',$dados['inputTipo']);
                                    $cad_usuario->bindParam(':nomeUsuario',$dados['inputNome']);
                                    $cad_usuario->bindParam(':loginUsuario',$dados['inputLogin']);
                                    $cad_usuario->bindParam(':senhaUsuario',$dados['inputSenha']);
                                    $cad_usuario->bindParam(':emailUsuario',$dados['inputEmail']);

                                $cad_usuario->execute();

                                if($cad_usuario->rowCount()){
                                    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Usuario cadastrado com sucesso!</div>"];
                                }else{
                                    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Cadastro nao pode ser realizado, tente novamente!</div>"];
                                }

                    }

        }

        echo json_encode($retorna);

//fim cadastrar
}elseif($acao=="consu"){//inicio consultar usuario ao digitar

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);    

    if(!empty($dados['inputPesquisar'])){//verifica se o campo a pesquisar veio vazio
        
        $loginNome = "%".$dados['inputPesquisar']."%";//recebe o valor da string consulta

            if(strlen($loginNome)>2){//verifica se tem ao menos 3 caracteres para realizar a pesquisa
                
                   //select para consulta de usuarios
                   $query_usuarios = "SELECT tbl_usuario_usu.num_id_usu, tbl_tipousuario_tu.txt_nome_tu, tbl_usuario_usu.txt_nome_usu, tbl_usuario_usu.txt_login_usu, tbl_usuario_usu.txt_email_usu,tbl_usuario_usu.txt_senha_usu, tbl_usuario_usu.txt_ativo_usu 
                                        FROM tbl_usuario_usu 
                                        INNER JOIN tbl_tipousuario_tu on tbl_usuario_usu.tbl_tipousuario_tu_num_id_tu = tbl_tipousuario_tu.num_id_tu
                                        WHERE tbl_usuario_usu.txt_nome_usu LIKE :loginNome LIMIT 10";

                    $result_usuarios = $conn->prepare($query_usuarios);

                    $result_usuarios->bindParam(':loginNome',$loginNome);

                    $result_usuarios->execute();

                    // variavel criada para receber os dados de usuarios
                    $dadosUsuarios = "<div class='table-responsive'>
                                <table class='table table-striped table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo Usuario</th>
                                            <th>Nome</th>
                                            <th>Login</th>
                                            <th>E-mail</th>
                                            <th>Ativo</th>
                                            <th>Ações</th>
                                        </tr>        
                                    </thead>
                                <tbody>";
                    
                    //acessa if quando traz dados do banco
                    if(($result_usuarios) and ($result_usuarios->rowCount() != 0)){

                        while($row_usuarios = $result_usuarios->fetch(PDO::FETCH_ASSOC)){

                            extract($row_usuarios);

                            $dadosUsuarios .= "<tr>
                                            <td>$num_id_usu</td>
                                            <td>$txt_nome_tu</td>
                                            <td>$txt_nome_usu</td>
                                            <td>$txt_login_usu</td>
                                            <td>$txt_email_usu</td>
                                            <td>$txt_ativo_usu</td>
                                            <td>
                                                <button id='$num_id_usu' class='btn btn-outline-primary btn-sm' onclick='visUsuario($num_id_usu)'>Visualizar</button>
                                                <button id='$num_id_usu' class='btn btn-outline-warning btn-sm' onclick='ediUsuario($num_id_usu)'>Editar</button>
                                                <button id='$num_id_usu' class='btn btn-outline-danger btn-sm' onclick='apagarUsuario($num_id_usu)'>Apagar</button>
                                            </td>
                                        </tr>";
                        }    

                        $retorna = ['status' => true, 'dados' => $dadosUsuarios];

                    }else{                        

                        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Nenhum usuario encontrado!</div>"];

                    }
                
            }
    }else{
        //$retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Problemas na consulta, Tente Novamente!</div>"];
    }   

    echo json_encode($retorna);



}
?>

