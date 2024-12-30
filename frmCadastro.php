[...]

<?php

include "../Conexao.php";

include "../Classes/ContasPagar.php";

include "../DAO/ContasPagarDAO.php";

if (isset($_GET['cadastro'])){

     $CP = new ContasPagar();

     $CP->setDocumento_contaspagar($_POST['txtDocumento']);

     $CP->setValor_contaspagar($_POST['txtValor']);

     $CP->setFornecedor_contaspagar($_POST['cbFornecedor']);

     $CP->setVencimento_contaspagar($_POST['txtData']);

     $CP->setStatus_contaspagar("N");

     $CPDAO = new ContasPagarDAO();

     if ($CPDAO->InsertContasPagar($CP)){

        echo "<script>alert('Conta a pagar, cadastrada com succeso!');</script>";

        echo "<script>window.location = 'listar.php';</script>";

     }

}

?>

[...]

<form action="?cadastro" method="post">

   <table style="width: 100%" class="ms-classic3-main">

[...]

            <select name="cbFornecedor">

               <?php

                    $CP = new ContasPagar();

                    $CPDAO = new ContasPagarDAO();

                    foreach($CPDAO->ShowFornecedores($CP) as $exibir){

                       echo $exibir;

                    }

               ?>

            </select>

         </td>

      </tr>

      <tr>

         <td style="width: 136px" class="ms-classic3-left">Data de Vencimento:</td>

         <td class="ms-classic3-even"><input name="txtData" style="width: 127px"

            type="text" /></td>

      </tr>

      <tr>

      <td style="width: 136px" class="ms-classic3-left"> </td>

      <td class="ms-classic3-even"><input name="btCadastrar" type="submit"

         value="Cadastrar" /></td>

      </tr>

   </table>

</form>

</body>

</html>