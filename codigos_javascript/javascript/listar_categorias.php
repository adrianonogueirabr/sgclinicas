<?php 

include_once "conexao.php";

$query_categoria = "SELECT num_id_cat, txt_nome_cat, txt_status_cat FROM tbl_categoria_cat ORDER BY txt_nome_cat ASC";

$result_categoria = $conn->prepare($query_categoria);

$result_categoria->execute();

if(($result_categoria) and ($result_categoria->rowCount() != 0)){
    while($row_categoria = $result_categoria->fetch(PDO::FETCH_ASSOC)){
        extract($row_categoria);
        $dados[] = [
            'num_id_cat' => $num_id_cat,
            'txt_nome_cat' => $txt_nome_cat
        ];
    }

    $retornaCategoriaPaciente = ['status' => true, 'dados' => $dados];

}else{
    $retornaCategoriaPaciente = ['status' => false, 'msg' => "<p style='color :#f00'>Erro: nenhuma categoria encontrada!</p>"];
}

echo json_encode($retornaCategoriaPaciente);

?>