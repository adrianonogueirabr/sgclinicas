<?php

include_once "conexao.php";



$acao = filter_input(INPUT_GET,"acao", FILTER_SANITIZE_STRING);

if($acao=="list"){//inicio lista de pacientes

            //$pagina = filter_input(INPUT_GET,"pagina", FILTER_SANITIZE_NUMBER_INT);

        if(!empty($pagina)){

            //calcular pagina de visualizacao
            //$quantidade_result_pg = 10; //quantidade de registros por pagina

            //$inicio = ($pagina * $quantidade_result_pg) - $quantidade_result_pg;

            $query_pacientes = "SELECT tbl_paciente_pac.num_id_pac, tbl_paciente_pac.txt_nome_pac, tbl_paciente_pac.txt_cpf_pac, TIMESTAMPDIFF(YEAR,tbl_paciente_pac.dta_datanascimento_pac,NOW()) AS num_idade_pac, tbl_paciente_pac.txt_telefone_pac, tbl_categoria_cat.txt_nome_cat
                                FROM tbl_paciente_pac
                                INNER JOIN tbl_categoria_cat on tbl_paciente_pac.tbl_categoria_cat_num_id_cat = tbl_categoria_cat.num_id_cat
                                ORDER BY tbl_paciente_pac.txt_nome_pac ASC LIMIT 10";

            $result_pacientes = $conn->prepare($query_pacientes);
            $result_pacientes->execute();

            $dadosPacientes = "<div class='table-responsive'>
                                <table class='table table-striped table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Idade</th>
                                            <th>Telefone/th>
                                            <th>Categoria</th>
                                            <th>Ações</th>
                                        </tr>        
                                    </thead>
                                <tbody>";

            while($row_pacientes = $result_pacientes->fetch(PDO::FETCH_ASSOC)){

                extract($row_pacientes);
                

                    $dadosPacientes .= "<tr>
                                            <td>$num_id_pac</td>
                                            <td>$txt_nome_pac</td>
                                            <td>$txt_cpf_pac</td>
                                            <td>$num_idade_pac</td>
                                            <td>$txt_telefone_pac</td>
                                            <td>$txt_nome_cat</td>
                                            <td>
                                                <button id='$num_id_pac' class='btn btn-outline-primary btn-sm' onclick='visPaciente($num_id_pac)'>Visualizar</button>
                                                <button id='$num_id_pac' class='btn btn-outline-warning btn-sm' onclick='ediPaciente($num_id_pac)'>Editar</button>
                                                <button id='$num_id_pac' class='btn btn-outline-danger btn-sm' onclick='apagarPaciente($num_id_pac)'>Apagar</button>
                                            </td>
                                        </tr>";
            }

            $dadosPacientes .= "             <!-- Lugar onde irao aparecer os dados-->
                                        </tbody>
                                    </table>
                                </div>";

            echo $dadosPacientes;

        }else{//caso variavel $pagina venha vazio.
            echo "<div class='alert alert-danger' role='alert'> Erro: nenhum paciente encontrado! </div>";
        }


}elseif($acao=="vis"){//fim lista de usuarios e inicio visualizacao

            $id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT);

            if(!empty($id)){

                $query_pacientes = "SELECT paciente.num_id_pac, categoria.txt_nome_cat, usuariocadastro.txt_login_usu AS usuarioCadastro, 
                paciente.txt_nome_pac, paciente.txt_cpf_pac, paciente.txt_cor_pac, paciente.txt_sexo_pac, paciente.dta_datanascimento_pac,  
                paciente.txt_email_pac, paciente.txt_telefone_pac, paciente.txt_senha_pac, paciente.txt_estadocivil_pac, paciente.txt_cep_pac, paciente.txt_logradouro_pac, 
                paciente.num_numero_pac, paciente.txt_complemento_pac, paciente.txt_bairro_pac, paciente.txt_cidade_pac, paciente.txt_estado_pac,
                paciente.txt_observacoes_pac, paciente.txt_matricula_pac, paciente.dta_registro_pac,usuarioalteracao.txt_login_usu AS usuarioAlteracao, 
                paciente.dth_alteracao_pac, paciente.dta_ultimavisita_pac, paciente.txt_ativo_pac 
        
            FROM tbl_paciente_pac AS paciente
            
            LEFT JOIN tbl_categoria_cat AS categoria on paciente.tbl_categoria_cat_num_id_cat  = categoria.num_id_cat 
            LEFT JOIN tbl_usuario_usu AS usuariocadastro on paciente.tbl_usuario_usu_num_id_usu  = usuariocadastro.num_id_usu 
            LEFT JOIN tbl_usuario_usu AS usuarioalteracao on paciente.num_usuario_alteracao_pac  = usuarioalteracao.num_id_usu
            
            WHERE paciente.num_id_pac = :num_id_pac LIMIT 1";
                
                $result_pacientes = $conn->prepare($query_pacientes);
                $result_pacientes->bindParam(':num_id_pac', $id);
                $result_pacientes->execute();

                $row_pacientes = $result_pacientes->fetch(PDO::FETCH_ASSOC);

                $retorna = ['erro' => false, 'dados' => $row_pacientes];    

            }else{//caso variavel $pagina venha vazio.    
                $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: nenhum paciente encontrado!</div>"];
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
    $dados_edit = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    
    //validar os dados do formulario
    if(empty($dados_edit['nomePacienteEdi'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Nome!</div>"];
    }elseif(empty($dados_edit['categoriaPacienteEdi'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Categoria!</div>"];
    }elseif(empty($dados_edit['telefonePacienteEdi'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Telefone corretamente!</div>"];
    }elseif(empty($dados_edit['nascimentoPacienteEdi'])){
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Data de Nascimento corretamente!</div>"];
    }else{

        //Atualizando os dados no banco
            $query_paciente="UPDATE `tbl_paciente_pac` SET `tbl_categoria_cat_num_id_cat`= :categoria,`txt_nome_pac`= :nome,`txt_cor_pac`= :cor,`txt_sexo_pac`= :sexo,

                            `dta_datanascimento_pac`= :datanascimento,`txt_email_pac`= :email,`txt_telefone_pac`= :telefone,`txt_estadocivil_pac`= :estadocivil,`txt_cep_pac`= :cep,

                            `txt_logradouro_pac`= :logradouro,`num_numero_pac`= :numero,`txt_complemento_pac`= :complemento,`txt_bairro_pac`= :bairro,`txt_cidade_pac`= :cidade,

                            `txt_estado_pac`= :estado,`txt_observacoes_pac`= :observacoes,`txt_matricula_pac`= :matricula,`num_usuario_alteracao_pac`= 49,

                            `dth_alteracao_pac`= now(),`txt_ativo_pac`= :ativo WHERE `num_id_pac` = :idPaciente";

            $edi_paciente = $conn->prepare($query_paciente);
            

            $edi_paciente->bindParam(':categoria',$dados_edit['categoriaPacienteEdi']);
            $edi_paciente->bindParam(':nome',$dados_edit['nomePacienteEdi']);        
            $edi_paciente->bindParam(':cor',$dados_edit['corPacienteEdi']);
            $edi_paciente->bindParam(':sexo',$dados_edit['sexoPacienteEdi']);    
            $edi_paciente->bindParam(':datanascimento',$dados_edit['nascimentoPacienteEdi']); 
            $edi_paciente->bindParam(':email',$dados_edit['emailPacienteEdi']);     
            $edi_paciente->bindParam(':telefone',$dados_edit['telefonePacienteEdi']);  
            $edi_paciente->bindParam(':estadocivil',$dados_edit['civilPacienteEdi']);  
            $edi_paciente->bindParam(':cep',$dados_edit['cepPacienteEdi']);  
            $edi_paciente->bindParam(':logradouro',$dados_edit['logradouroPacienteEdi']);  
            $edi_paciente->bindParam(':numero',$dados_edit['casaPacienteEdi']);  
            $edi_paciente->bindParam(':complemento',$dados_edit['complementoPacienteEdi']);  
            $edi_paciente->bindParam(':bairro',$dados_edit['bairroPacienteEdi']);  
            $edi_paciente->bindParam(':cidade',$dados_edit['cidadePacienteEdi']);  
            $edi_paciente->bindParam(':estado',$dados_edit['estadoPacienteEdi']);  
            $edi_paciente->bindParam(':observacoes',$dados_edit['observacoesPacienteEdi']);  
            $edi_paciente->bindParam(':matricula',$dados_edit['matriculaPacienteEdi']);  
            $edi_paciente->bindParam(':ativo',$dados_edit['ativoPacienteEdi']);  
            $edi_paciente->bindParam(':idPaciente',$dados_edit['idPacienteEdi']);  


            if($edi_paciente->execute()){
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
        }elseif(empty($dados['inputCpf'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo CPF!</div>"];
        }elseif(empty($dados['inputCategoria'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Categoria!</div>"];
        }elseif(empty($dados['inputTelefone'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Telefone corretamente!</div>"];
        }elseif(empty($dados['inputDataNascimento'])){
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Necessario preenchimento do campo Data de Nascimento corretamente!</div>"];
        }else{

                    //atribui login de usuario a variavel para verificar se ja existe
                    $nomePaciente = $dados['inputNome'];
                    $cpfPaciente = $dados['inputCpf'];

                    //verificar se ja existe usuario com mesmo nome e CPF
                    $query_pacientes = "SELECT tbl_paciente_pac.txt_nome_pac, tbl_paciente_pac.txt_cpf_pac
                                        FROM tbl_paciente_pac
                                        WHERE tbl_paciente_pac.txt_nome_pac = :inputNome  and tbl_paciente_pac.txt_cpf_pac = :inputCpf LIMIT 1";

                    $result_pacientes = $conn->prepare($query_pacientes);

                    $result_pacientes->bindParam(':inputNome',$nomePaciente);
                    $result_pacientes->bindParam(':inputCpf',$cpfPaciente);

                    $result_pacientes->execute();

                    if($result_pacientes->rowCount()){

                            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Ja existe um paciente com este nome e CPF!</div>"];

                    }else{

                                //inserindo os dados no banco
                                $query_paciente = "INSERT INTO `tbl_paciente_pac`(`num_id_pac`, `tbl_categoria_cat_num_id_cat`, `tbl_usuario_usu_num_id_usu`, `txt_nome_pac`, `txt_cpf_pac`, 
                                                  
                                                  `txt_cor_pac`, `txt_sexo_pac`, `dta_datanascimento_pac`, `txt_email_pac`, `txt_telefone_pac`, `txt_senha_pac`, `txt_estadocivil_pac`, `txt_cep_pac`, 
                                                  
                                                  `txt_logradouro_pac`, `num_numero_pac`, `txt_complemento_pac`, `txt_bairro_pac`, `txt_cidade_pac`, `txt_estado_pac`,`txt_observacoes_pac`, `txt_matricula_pac`,  
                                                  
                                                  `dta_registro_pac`, `num_usuario_alteracao_pac`, `dth_alteracao_pac`, `dta_ultimavisita_pac`, `txt_ativo_pac`) 
                                                  
                                                  VALUES (NULL,:inputCategoria,1,:inputNome,:inputCpf,:inputCor,:inputSexo,:inputDataNascimento,:inputEmail,:inputTelefone,'cedof',:inputEstadoCivil,
                                                  
                                                  :inputCep,:inputLogradouro,:inputNumero,:inputComplemento,:inputBairro,:inputCidade,:inputEstado,:inputObservacoes,:inputMatricula,
                                                  
                                                  now(),NULL,NULL,NULL, 'SIM')";

                                $cad_paciente = $conn->prepare($query_paciente);

                                    $cad_paciente->bindParam(':inputCategoria',$dados['inputCategoria']);
                                    $cad_paciente->bindParam(':inputNome',$dados['inputNome']);
                                    $cad_paciente->bindParam(':inputCpf',$dados['inputCpf']);
                                    $cad_paciente->bindParam(':inputCor',$dados['inputCor']);
                                    $cad_paciente->bindParam(':inputSexo',$dados['inputSexo']);
                                    $cad_paciente->bindParam(':inputDataNascimento',$dados['inputDataNascimento']);
                                    $cad_paciente->bindParam(':inputEmail',$dados['inputEmail']);
                                    $cad_paciente->bindParam(':inputTelefone',$dados['inputTelefone']);
                                    $cad_paciente->bindParam(':inputEstadoCivil',$dados['inputEstadoCivil']);
                                    $cad_paciente->bindParam(':inputCep',$dados['inputCep']);
                                    $cad_paciente->bindParam(':inputLogradouro',$dados['inputLogradouro']);
                                    $cad_paciente->bindParam(':inputNumero',$dados['inputNumero']);
                                    $cad_paciente->bindParam(':inputComplemento',$dados['inputComplemento']);
                                    $cad_paciente->bindParam(':inputBairro',$dados['inputBairro']);
                                    $cad_paciente->bindParam(':inputCidade',$dados['inputCidade']);
                                    $cad_paciente->bindParam(':inputEstado',$dados['inputEstado']);
                                    $cad_paciente->bindParam(':inputObservacoes',$dados['inputObservacoes']);
                                    $cad_paciente->bindParam(':inputMatricula',$dados['inputMatricula']);

                                $cad_paciente->execute();

                                if($cad_paciente->rowCount()){
                                    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Paciente cadastrado com sucesso!</div>"];
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
        
        $pacienteNome = "%".$dados['inputPesquisar']."%";//recebe o valor da string consulta

            if(strlen($pacienteNome)>2){//verifica se tem ao menos 3 caracteres para realizar a pesquisa
                
                   //select para consulta 
                    $query_pacientes = "SELECT tbl_paciente_pac.num_id_pac, tbl_paciente_pac.txt_nome_pac, tbl_paciente_pac.txt_cpf_pac, TIMESTAMPDIFF(YEAR,tbl_paciente_pac.dta_datanascimento_pac,NOW()) AS num_idade_pac, tbl_paciente_pac.txt_telefone_pac, tbl_categoria_cat.txt_nome_cat, TIMESTAMPDIFF(DAY,tbl_paciente_pac.dta_ultimavisita_pac,NOW()) AS num_ultimavisita_pac
                    FROM tbl_paciente_pac
                    INNER JOIN tbl_categoria_cat on tbl_paciente_pac.tbl_categoria_cat_num_id_cat = tbl_categoria_cat.num_id_cat
                    WHERE tbl_paciente_pac.txt_nome_pac LIKE :pacienteNome LIMIT 10";

                    $result_pacientes = $conn->prepare($query_pacientes);

                    $result_pacientes->bindParam(':pacienteNome',$pacienteNome);

                    $result_pacientes->execute();

                    // variavel criada para receber os dados de usuarios
                    $dadosPacientes = "<div class='table-responsive'>
                    <table class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Idade</th>
                                <th>Telefone</th>
                                <th>Categoria</th>
                                <th>Visita</th>
                                <th>Ações</th>
                            </tr>        
                        </thead>
                    <tbody>";

                    
                    //acessa if quando traz dados do banco
                    if(($result_pacientes) and ($result_pacientes->rowCount() != 0)){

                        while($row_pacientes = $result_pacientes->fetch(PDO::FETCH_ASSOC)){

                            extract($row_pacientes);

                            $dadosPacientes .= "<tr>
                            <td>$num_id_pac</td>
                            <td>$txt_nome_pac</td>
                            <td>$txt_cpf_pac</td>
                            <td>$num_idade_pac</td>
                            <td>$txt_telefone_pac</td>
                            <td>$txt_nome_cat</td>
                            <td>$num_ultimavisita_pac</td>
                            <td>
                                <button id='$num_id_pac' class='btn btn-outline-success btn-sm' onclick='#'>Contato</button>
                                <button id='$num_id_pac' class='btn btn-outline-primary btn-sm' onclick='visPaciente($num_id_pac)'>Visualizar</button>
                                <button id='$num_id_pac' class='btn btn-outline-warning btn-sm' onclick='ediPaciente($num_id_pac)'>Editar</button>
                                <!--<button id='$num_id_pac' class='btn btn-outline-danger btn-sm' onclick='apagarPaciente($num_id_pac)'>Apagar</button>-->
                            </td>
                        </tr>";
                        }    

                        $retorna = ['status' => true, 'dados' => $dadosPacientes];

                    }else{                        

                        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'> Erro: Nenhum paciente encontrado!</div>"];

                    }
                
            }
    }else{
        //$retorna = ['status' => false, 'msg' => "<div class='alert alert-warning' role='alert'> Aviso: Informe ao menos 1 letra!</div>"];
    }   

    echo json_encode($retorna);



}
?>

