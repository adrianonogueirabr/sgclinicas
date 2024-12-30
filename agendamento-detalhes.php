<?php include 'verifica.php';
		
	include "conexao.php";

    if($_POST['acao']==""){
        $acao = $_GET['acao'];
    }else{
        $acao = $_POST['acao'];
    }


    if($acao == "detalhes"){ 
        
                $codigoAgendamento =base64_decode($_GET['agendamento']);
                
                //realizando captura dos dados de agendamento
                $sqlAgendamentos = $con->prepare("SELECT agendamento.hor_hora_age, agendamento.dta_data_age, medico.txt_nome_med,agendamento.num_id_age,agendamento.tbl_paciente_pac_num_id_pac, paciente.txt_nome_pac, paciente.txt_telefone_pac, 
                                                                    
                usuario.txt_login_usu, agendamento.txt_observacao_age,agendamento.txt_solicitacao_age, agendamento.txt_status_age, usuarioconfirmacao.txt_login_usu as usuarioconfirmacao,usuarioremarcacao.txt_login_usu as usuarioremarcacao,
                
                agendamento.dth_registro_age, agendamento.dth_confirmacao_age, agendamento.dth_remarcacao_age
                
                FROM tbl_agendamento_age as agendamento 
        
                LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med
                                                                                                                                            
                LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac
                
                LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu
                
                LEFT JOIN tbl_usuario_usu usuarioconfirmacao ON usuarioconfirmacao.num_id_usu = agendamento.num_usuario_confirmacao_age
                
                LEFT JOIN tbl_usuario_usu usuarioremarcacao ON usuarioremarcacao.num_id_usu = agendamento.num_usuario_remarcacao_age                                   
                                                        
                WHERE num_id_age = ? ");
        
                $sqlAgendamentos->bindParam(1,$codigoAgendamento);
        
                if (!$sqlAgendamentos->execute()) {
                    echo "Error: " . $sqlAgendamentos . "<br>" . mysqli_error($con);
                }
        
                while($rowAgendamentos = $sqlAgendamentos->fetch(PDO::FETCH_OBJ)){ 
                    $codigoAgendamento = $rowAgendamentos->num_id_age;
                    $idPaciente = $rowAgendamentos->tbl_paciente_pac_num_id_pac;
                    $nomeMedico = ucwords($rowAgendamentos->txt_nome_med);
                    $dataAgenda = $rowAgendamentos->dta_data_age;
                    $horaAgenda = $rowAgendamentos->hor_hora_age;
                    $observacao = $rowAgendamentos->txt_observacao_age;
                    $solicitacao = $rowAgendamentos->txt_solicitacao_age;
                }
            //fim captura dados
                
    }else if($acao == "procedimento"){

                //recebe dados via POST
                $codigoAgendamento =filter_input(INPUT_POST,"codigoAgendamento", FILTER_SANITIZE_NUMBER_INT);
                $procedimentoAgendamento =filter_input(INPUT_POST,"procedimento", FILTER_SANITIZE_NUMBER_INT);
                $categoriaAgendamento =filter_input(INPUT_POST,"categoria", FILTER_SANITIZE_NUMBER_INT);

                //verifica campos vazios
                if($codigoAgendamento =="" || $procedimentoAgendamento=="" || $categoriaAgendamento==""){
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Problemas na execucao!\");</script>";    
                }else{

                    //realiza inclusao do item na tabela itens agendamento
                    $resIncluirProcedimento = $con->prepare("INSERT INTO `tbl_item_agendamento_itage`(`tbl_categoria_cat_num_id_cat`, `tbl_procedimentos_pro_num_id_pro`, `tbl_agendamento_age_num_id_age`) VALUES (?,?,?)");
                    $resIncluirProcedimento->bindParam(1,$categoriaAgendamento);
                    $resIncluirProcedimento->bindParam(2,$procedimentoAgendamento);
                    $resIncluirProcedimento->bindParam(3,$codigoAgendamento);

                    if (!$resIncluirProcedimento->execute()) {
                        echo "Error: " . $resIncluirProcedimento . "<br>" . mysqli_error($con);
                    }

                    //registra fazendo alteracoes
                    $sqlUsuarioAlteracao = $con->prepare("UPDATE `tbl_agendamento_age` SET `num_usuario_alteracao_age`=?,`dth_alteracao_age`=now() WHERE `num_id_age`=?");
                    $sqlUsuarioAlteracao->bindParam(1,$_SESSION['id_usu']);
                    $sqlUsuarioAlteracao->bindParam(2,$codigoAgendamento);

                    if(!$sqlUsuarioAlteracao->execute()){
                        echo "Error: " . $sqlUsuarioAlteracao . "<br>" . mysqli_error();
                    }

                    //fim inclusao item

                    //realizando captura dos dados de agendamento
                        $sqlAgendamentos = $con->prepare("SELECT agendamento.hor_hora_age,agendamento.dta_data_age,  medico.txt_nome_med,agendamento.num_id_age,agendamento.tbl_paciente_pac_num_id_pac, paciente.txt_nome_pac, paciente.txt_telefone_pac, 
                                                            
                        usuario.txt_login_usu, agendamento.txt_observacao_age, agendamento.txt_solicitacao_age,agendamento.txt_status_age, usuarioconfirmacao.txt_login_usu as usuarioconfirmacao,usuarioremarcacao.txt_login_usu as usuarioremarcacao,
                        
                        agendamento.dth_registro_age, agendamento.dth_confirmacao_age, agendamento.dth_remarcacao_age
                        
                        FROM tbl_agendamento_age as agendamento 

                        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med
                                                                                                                                                    
                        LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac
                        
                        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu
                        
                        LEFT JOIN tbl_usuario_usu usuarioconfirmacao ON usuarioconfirmacao.num_id_usu = agendamento.num_usuario_confirmacao_age
                        
                        LEFT JOIN tbl_usuario_usu usuarioremarcacao ON usuarioremarcacao.num_id_usu = agendamento.num_usuario_remarcacao_age                                    
                                                                
                        WHERE num_id_age = ? ");

                        $sqlAgendamentos->bindParam(1,$codigoAgendamento);

                        if (!$sqlAgendamentos->execute()) {
                            echo "Error: " . $sqlAgendamentos . "<br>" . mysqli_error($con);
                        }

                        while($rowAgendamentos = $sqlAgendamentos->fetch(PDO::FETCH_OBJ)){ 
                            $codigoAgendamento = $rowAgendamentos->num_id_age;
                            $idPaciente = $rowAgendamentos->tbl_paciente_pac_num_id_pac;
                            $nomeMedico = ucwords($rowAgendamentos->txt_nome_med);
                            $dataAgenda = $rowAgendamentos->dta_data_age;
                            $horaAgenda = $rowAgendamentos->hor_hora_age;
                            $observacao = $rowAgendamentos->txt_observacao_age;
                            $solicitacao = $rowAgendamentos->txt_solicitacao_age;
                        }

                    //fim captura dados

                }
    }else if($acao == "excluiritem"){

        $codigoAgendamento = $_GET['codigoagendamento'];

        //realizando captura dos dados de agendamento
        $sqlAgendamentos = $con->prepare("SELECT agendamento.hor_hora_age,agendamento.dta_data_age,  medico.txt_nome_med,agendamento.num_id_age,agendamento.tbl_paciente_pac_num_id_pac, paciente.txt_nome_pac, paciente.txt_telefone_pac, 
                                                            
        usuario.txt_login_usu, agendamento.txt_observacao_age,agendamento.txt_solicitacao_age, agendamento.txt_status_age, usuarioconfirmacao.txt_login_usu as usuarioconfirmacao,usuarioremarcacao.txt_login_usu as usuarioremarcacao,
        
        agendamento.dth_registro_age, agendamento.dth_confirmacao_age, agendamento.dth_remarcacao_age
        
        FROM tbl_agendamento_age as agendamento 

        LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med
                                                                                                                                    
        LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac
        
        LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu
        
        LEFT JOIN tbl_usuario_usu usuarioconfirmacao ON usuarioconfirmacao.num_id_usu = agendamento.num_usuario_confirmacao_age
        
        LEFT JOIN tbl_usuario_usu usuarioremarcacao ON usuarioremarcacao.num_id_usu = agendamento.num_usuario_remarcacao_age                             
                                                
        WHERE num_id_age = ? ");

        $sqlAgendamentos->bindParam(1,$codigoAgendamento);

        if (!$sqlAgendamentos->execute()) {
            echo "Error: " . $sqlAgendamentos . "<br>" . mysqli_error($con);
        }

        while($rowAgendamentos = $sqlAgendamentos->fetch(PDO::FETCH_OBJ)){ 
            $codigoAgendamento = $rowAgendamentos->num_id_age;
            $idPaciente = $rowAgendamentos->tbl_paciente_pac_num_id_pac;
            $nomeMedico = ucwords($rowAgendamentos->txt_nome_med);
            $dataAgenda = $rowAgendamentos->dta_data_age;
            $horaAgenda = $rowAgendamentos->hor_hora_age;
            $observacao = $rowAgendamentos->txt_observacao_age;
            $solicitacao = $rowAgendamentos->txt_solicitacao_age;
           
        }
        //fim captura dados
    }      
        
        /*capturar detalhes do paciente*/
	
            $resPaciente = $con->prepare("SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, paciente.txt_nome_pac, paciente.dta_ultima_visita_pac, paciente.txt_ativo_pac 
            
            FROM tbl_paciente_pac paciente
            
            LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
            LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat  
            
            WHERE num_id_pac = ? AND paciente.txt_ativo_pac = 'sim'");
                
            $resPaciente->bindParam(1,$idPaciente);
            $resPaciente->execute();

                //caso nao encontre paciente
                if($resPaciente->rowCount()<=0){	
                    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL='><script type=\"text/javascript\">alert(\"Favor realizar operacao novamente dados paciente!\");</script>";
                    echo "<script language='javascript'>history.back()</script>";

                }else{            
                    
                    while ($rowPaciente = $resPaciente->fetch(PDO::FETCH_OBJ)){
                        $numIdPaciente = $rowPaciente->num_id_pac;
                        $txtNomePaciente = $rowPaciente->txt_nome_pac;
                        $txtNomeMedico = $rowPaciente->txt_nome_med;
                        $txtNomeCategoria = $rowPaciente->txt_nome_cat;
                        $dtaUltimaVisita = $rowPaciente->dta_ultima_visita_pac;            
                    }
                }
        /*fim detalhes paciente */                        
        
?>	
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <body>

            <form name="listagem" method="post" action="#">
            <table class="table">
                <tr>
                    <td> <?php include "inicial.php"?> </td>
                </tr>
                <tr>
                    <td><legend class="p-4 table-primary">Agendamento Data: <?php echo date("d/m/Y", strtotime($dataAgenda)) ?> Hora: <?php echo $horaAgenda ?> Medico: <?php echo ucfirst($nomeMedico) ?><legend></td>
                </tr>
                <tr>
                    <td> 
                        <Legend>Dados Paciente</Legend>                       
                            <div class="form-row">                                

                                    <div class="form-group col-md-3 col-sm-6"><label>Nome</label>
                                    <input title="NOME DO PACIENTE" value="<?php echo ucwords($txtNomePaciente) ?>" readonly="readonly" class="form-control" readonly /> </div> 
                                    
                                    <div class="form-group col-md-3 col-sm-6"><label>Medico</label>
                                    <input title="MEDICO DO PACIENTE" value="<?php echo ucwords($txtNomeMedico) ?>" readonly="readonly" class="form-control" readonly /> </div> 

                                    <div class="form-group  col-md-3 col-sm-6"><label>Tipo</label>
                                    <input title="CATEGORIA DO PACIENTE" value="<?php echo ucwords($txtNomeCategoria) ?>" readonly="readonly" class="form-control" readonly /></div> 

                                    <!-- Funcao para exibir dias da ultima visita -->
                                        <?php 
                                            if($dtaUltimaVisita != NULL){
                                                $diferenca =  strtotime(date("Y-m-d")) - strtotime($dtaUltimaVisita);
                                                $diasUltimaVisita = floor($diferenca / (60 * 60 * 24)); 
                                                $dataUltimaVisita =  date("d/m/Y", strtotime($dtaUltimaVisita));                                                 
                                            }else{
                                                $dataUltimaVisita = 0;
                                                $diasUltimaVisita = 0;
                                            }
                                        ?>

                                    <div class="form-group  col-md-3 col-sm-6"><label>Ultima Visita</label>
                                    <input title="DATA ULTIMA VISITA" value="<?php echo $dataUltimaVisita ?> - <?php echo $diasUltimaVisita; ?> dia(s)" readonly="readonly" class="form-control" readonly /></div>                                     
                                                
                                    <div class="form-group  col-md-12 col-sm-6"></div><!-- linha para organizar formulario -->
                                    <!-- FIM --> 
                            </div> 
                            <HR>
                      
                        <Legend>Procedimentos</Legend>
                            <div class="form-row">
                                    <form name="procedimentos" method="post" action="">
                                    <input type="hidden" name="codigoAgendamento" id="codigoAgendamento" value="<?php echo $codigoAgendamento ?>" />
                                    <input type="hidden" name="acao" id="acao" value="procedimento" />
                                        
                                            <div class="form-group col-md-3 col-sm-12">
                                            <select name="procedimento" id="procedimento" class="form-control" title="SELECIONE PROCEDIMENTO PARA AGENDAMENTO">                                            
                                                <?php
                                                include "conexao.php"; 
                                                $resProcedimento=$con->prepare("SELECT num_id_pro, txt_nome_pro FROM tbl_procedimentos_pro WHERE txt_ativo_pro = 'sim' order by txt_nome_pro");
                                                $resProcedimento->execute();

                                                while($rowProcedimento = $resProcedimento->fetch(PDO::FETCH_OBJ)){?>
                                                    <option value="<?php echo $rowProcedimento->num_id_pro ?>"><?php echo $rowProcedimento->txt_nome_pro?></option>
                                                <?php } ?>
                                                </select> 
                                            </div>
                                            
                                            <div class="form-group col-md-3 col-sm-12">
                                            <select name="categoria" id="categoria" class="form-control" title="SELECIONE PROCEDIMENTO PARA AGENDAMENTO">                                            
                                                <?php
                                                include "conexao.php"; 
                                                $resCategoria=$con->prepare("SELECT num_id_cat, txt_nome_cat FROM tbl_categoria_cat WHERE txt_ativo_cat = 'sim' order by txt_nome_cat");
                                                $resCategoria->execute();

                                                while($rowCategoria = $resCategoria->fetch(PDO::FETCH_OBJ)){?>
                                                    <option value="<?php echo $rowCategoria->num_id_cat ?>"><?php echo $rowCategoria->txt_nome_cat?></option>
                                                <?php } ?>
                                                </select> 
                                            </div>  
                                            
                                            <div class="form-group col-md-2 col-sm-2">
                                                <input type="submit" class="btn btn-outline-primary" name="button" id="button" value="Incluir Procedimento" />                                            
                                            </div>
                                    </form>                       

                                <!--Itens de Agendamento-->
                                        <?php                                    
                                            $sqlItensAgendamentos = $con->prepare("SELECT agendamento.num_id_itage, categoria.txt_nome_cat, procedimento.txt_nome_pro, procedimento.txt_recomendacoes_pro,  agendamento.tbl_agendamento_age_num_id_age 

                                            FROM tbl_item_agendamento_itage agendamento
                                            
                                            LEFT JOIN tbl_procedimentos_pro procedimento ON procedimento.num_id_pro = agendamento.tbl_procedimentos_pro_num_id_pro
                                            LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = agendamento.tbl_categoria_cat_num_id_cat
                                            
                                            WHERE tbl_agendamento_age_num_id_age = ?");

                                            $sqlItensAgendamentos->bindParam(1,$codigoAgendamento);

                                            if (!$sqlItensAgendamentos->execute()) {
                                                echo "Error: " . $sqlItensAgendamentos . "<br>" . mysqli_error($con);
                                            }

                                            //verifica se nao existem registros na consulta de itens
                                            if($sqlItensAgendamentos->rowCount()>0){
                                        ?>                                    
                                                                                
                                            <div class="form-group col-md-12 col-sm-12">
                                                    <table width="100%" class=" table table-striped table-bordered">                        
                                                        <tr align="center">
                                                            <th>Procedimento</td>
                                                            <th>Recomendacoes</td>
                                                            <th>Categoria</td> 
                                                            <th>Opcoes</td>                                     
                                                        </tr>                                           
                                                        <?php while($rowItensAgendamentos = $sqlItensAgendamentos->fetch(PDO::FETCH_OBJ)){ ?>
                                                        <tr align="center">                                                      
                                                            <td><?php echo ucwords($rowItensAgendamentos->txt_nome_pro) ?></td>
                                                            <td align="left"><?php echo ucwords(utf8_encode($rowItensAgendamentos->txt_recomendacoes_pro)) ?></td>
                                                            <td><?php echo ucwords($rowItensAgendamentos->txt_nome_cat) ?></td>
                                                            <td>
                                                                <div class="btn-group dropleft">
                                                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcoes</button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" href="processa-agendamento.php?acao=excluiritemdetalhes&i=<?php echo base64_encode($rowItensAgendamentos->num_id_itage)?>&c=<?php echo base64_encode($codigoAgendamento)?>">Excluir</a>                                                                                                                                                                                                                
                                                                        </div>
                                                                </div>
                                                            </td>                                                                                                                                                           
                                                        </tr>
                                                        <?php }  ?> 
                                                    </table>                                       
                                            </div>
                                            <?php } //fim caso possua registros?>
                                <!--fim agendamentos Paciente-->
                        
                            <!-- fim inclusao de procedimentos -->
                            </div>                                                   

                        <HR>
                        <Legend>Informacoes Adcionais</Legend>
                        <form name="dados_gerais" action="processa-agendamento.php?acao=dadosgerais&c=<?php echo base64_encode($codigoAgendamento)?>" method="post">
                            <div class="form-row"> 
                                    <!-- nao implementado                           
                                    <div class="form-group col-md-3 col-sm-12"><label for="arquivosolicitacao">Arquivo Solicitacao</label>
                                        <input class="form-control" type="file" id="arquivosolicitacao" name="arquivosolicitacao" disabled>
                                    </div> 
                                    -->
                                    <div class="form-group col-md-3 col-sm-12"><label for="numerosolicitacao">Numero Solicitacao</label>
                                        <input name="numerosolicitacao" type="text" class="form-control" id="numerosolicitacao" value="<?php echo $solicitacao ?>" readonly title="INFORME NUMERO DA SOLICITACAO"  />
                                    </div>

                                    <div class="form-group col-md-9 col-sm-12"><label for="observacoes">Observacoes</label>
                                        <input name="observacoes" type="text" class="form-control" id="observacoes"  maxlength="100" value="<?php echo $observacao ?>" readonly  title="INFORMACOES GERAIS DO AGENDAMENTO" />
                                    </div> 
                                        
                                    <div class="form-group col-md-12 col-sm-12">
                                        <a  class="btn btn-outline-warning " href="alterar-dados-gerais.php?c=<?php echo base64_encode($codigoAgendamento) ?>">Alterar Dados Gerais</a>                                        
                                        <a href="processa-agendamento.php?acao=cancelar&c=<?php echo base64_encode($codigoAgendamento)?>" class="btn btn-outline-danger " >Cancelar Agendamento</a>                                                
                                        <input type="submit" class="btn btn-outline-success" name="button" id="button" value="Salvar Agendamento" />                                              
                                    </div>                                        
                            </div>
                        </form>
                        
                    </td>                
                </tr>            
            </body>
        </html>
<?php       

?> 
