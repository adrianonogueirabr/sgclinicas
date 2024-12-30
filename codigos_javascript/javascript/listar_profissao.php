<?php 

include_once "conexao.php";

$query_profissao = "SELECT num_id_pro, txt_nome_pro, txt_status_pro FROM tbl_profissao_pro ORDER BY txt_nome_pro ASC"; //where num_id_pro = 100 

$result_profissao = $conn->prepare($query_profissao);

$result_profissao->execute();

if(($result_profissao) and ($result_profissao->rowCount() != 0)){
    while($row_profissao = $result_profissao->fetch(PDO::FETCH_ASSOC)){
        extract($row_profissao);
        $dados[] = [
            'num_id_pro' => $num_id_pro,
            'txt_nome_pro' => $txt_nome_pro
        ];
    }

    $retornaProfissao = ['status' => true, 'dados' => $dados];

}else{
    $retornaProfissao = ['status' => false, 'msg' => "<p style='color :#f00'>Erro: nenhuma profissao encontrada!</p>"];
}

echo json_encode($retornaProfissao);

?>