<?php 

include_once "conexao.php";

$query_tipousuario = "SELECT num_id_tu, txt_nome_tu, txt_ativo_tu FROM tbl_tipousuario_tu ORDER BY txt_nome_tu ASC"; //where num_id_pro = 100 

$result_tipousuario = $conn->prepare($query_tipousuario);

$result_tipousuario->execute();

if(($result_tipousuario) and ($result_tipousuario->rowCount() != 0)){
    while($row_tipousuario = $result_tipousuario->fetch(PDO::FETCH_ASSOC)){
        extract($row_tipousuario);
        $dados[] = [
            'num_id_tu' => $num_id_tu,
            'txt_nome_tu' => $txt_nome_tu
        ];
    }

    $retornatipoUsuario = ['status' => true, 'dados' => $dados];

}else{
    $retornatipoUsuario = ['status' => false, 'msg' => "<p style='color :#f00'>Erro: nenhum tipo de usuario encontrada!</p>"];
}

echo json_encode($retornatipoUsuario);

?>