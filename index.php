<?php
require_once 'pessoa.php';
$p = new Pessoa("crudpdo", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-bR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Cadastro de Pessoas</title>
</head>
<body>

  <div class="container">

<?php
//VERIFICA SE CLICOU EM EDITAR OU CADASTRAR
if (isset($_POST['name'])) {

    //-------------------------EDITAR------------------
    if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {

        $id_update = addslashes($_GET['id_up']);
        $name = addslashes($_POST['name']);
        $telephone = addslashes($_POST['telephone']);
        $email = addslashes($_POST['email']);

        $p->setPessoa($id_update, $name, $telephone, $email);
        header("location: index.php");

    } else {
        //------------CADASTRAR--------------------------
        $name = addslashes($_POST['name']);
        $telephone = addslashes($_POST['telephone']);
        $email = addslashes($_POST['email']);

        if (!empty($name) && !empty($telephone) && !empty($email)) {
            if (!$p->registerPessoa($name, $telephone, $email)) {
                echo "e-mail já cadastraddo";
            }
        } else {
            echo " Por favor preencha todos os Campos!";
        }
    }

}

?>

  <?php
if (isset($_GET['id_up'])) {
    $id_update = addslashes($_GET['id_up']);
    $datePessoa = $p->getDatePessoa($id_update);
}
?>

  <section id="left">
    <form method="POST" >
      <h1 id="title">Cadastrar Pessoa<h1>
     <label for="name">NOME</label>
     <input type="text" placeHolder="ex.: João" name="name" id="name"
      value="<?php if (isset($datePessoa)) {echo $datePessoa['nome'];}?>">

     <label for="telephone">TELEFONE</label>
     <input type="text" placeHolder="(xx)9.xxxx-xxxx" name="telephone" id="telephone"
     value="<?php if (isset($datePessoa)) {echo $datePessoa['telefone'];}?>">

     <label for="email">E-MAIL</label>
     <input type="text" placeHolder="digite seu e-mail" name="email" id="email"
     value="<?php if (isset($datePessoa)) {echo $datePessoa['email'];}?>">
     <input type="submit" value="<?php if (isset($datePessoa)) {echo "Atualizar";} else {
    echo "Cadastrar";
}?>">
    </form>
  </section>

  <section class="right">

  <table>
      <tr id="table-title">
        <td>Nome</td>
        <td>Telefone</td>
        <td colspan="2">E-mail</td>
      </tr>


<?php
$date = $p->getDate();
if (count($date) > 0) {
    for ($i = 0; $i < count($date); $i++) {
        echo "<tr>";

        foreach ($date[$i] as $k => $v) {
            if ($k != "id") {
                echo "<td>" . $v . "</td>";
            }
        }
        ?>
        <td>
          <a href="index.php?id_up=<?php echo $date[$i]['id']; ?>">Editar</a>
          <a href="index.php?id=<?php echo $date[$i]['id']; ?>" >Excluir</a>
         </td>
        </tr>
        <?php
}
} else {
    echo "Ainda não há pessoas cadastradas!";
}
?>
    </table>

  </section>
  </div>
</body>
</html>

<?php
if (isset($_GET['id'])) {
    $idPessoa = addslashes($_GET['id']);
    $p->deletePessoa($idPessoa);
    header("location: index.php"); //atualizar a página
}
?>
