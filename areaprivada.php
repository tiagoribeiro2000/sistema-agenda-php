<?php
session_start();
if(!isset($_SESSION['id_usuario']))
{
    header("location: index.php");
    exit;
}

?>

<?php
//verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $celular = (isset($_POST["celular"]) && $_POST["celular"] != null) ? $_POST["celular"] : NULL;
} else if (!isset($id)) {
    //Se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $email = NULL;
    $celular = NULL;
}
try {

    $conexao = new PDO("mysql:host=localhost; dbname=crudsimples", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão com banco de dados! " . $erro->getMessage();
}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    if($id != ""){
    $stmt = $conexao->prepare("UPDATE contatos SET NOME=?, EMAIL=?, CELULAR=? WHERE ID = ?");
    $stmt ->bindParam(4, $id);    
    }else {$stmt = $conexao->prepare("INSERT INTO CONTATOS (NOME,EMAIL,CELULAR)
    VALUES (?,?,?)");
    }
    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $celular);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo "Dados cadastrados com sucesso!";
            $id = NULL;
            $nome = NULL;
            $email = NULL;
            $celular = NULL;
        } else {
            echo "Erro ao tentar efetivar cadastro";
        }
    } else {
        throw new PDOException("Erro: Não foi possível executar a declaração sql");
    }
}

if(isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != ""){
    try {
        $stmt = $conexao->prepare("SELECT * FROM contatos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->ID;
            $nome = $rs->NOME;
            $email = $rs->EMAIL;
            $celular = $rs->CELULAR;
        }else{
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    }catch(PDOException $erro){
        echo "Erro:  ".$erro->getMessage();
    }
}
if(isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != ""){
    try{
        $stmt = $conexao->prepare("DELETE FROM CONTATOS WHERE ID = ?");
        $stmt ->bindParam(1, $id, PDO::PARAM_INT);
        if($stmt->execute()){
            echo "Registro foi excluído com êxito";
            $id=NULL;
        }else{
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
        }catch(PDOException $erro){
            echo "Erro: ".$erro->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo2.css">
    <title>Administração</title>
</head>

<body>
    <main>
    <header>
    <h1>Agenda de Contatos</h1>    
    </header>    
    <form action="?act=save" method="POST" name="form1">
        <hr>
        <input type="hidden" name="id" <?php
                                        //preenche o id no campo id com um valor "value"
                                        if (isset($id) && $id != null || $id != "") {
                                            echo "value=\"{$id}\"";
                                        }
                                        ?> />
        Nome:
        <input type="text" name="nome" <?php
                                        if (isset($nome) && $nome != null || $nome != "") {
                                            echo "value=\"{$nome}\"";
                                        }
                                        ?> />
        Email:
        <input type="text" name="email" <?php
                                        if (isset($email) && $email != null || $email != "") {
                                            echo "value=\"{$email}\"";
                                        }
                                        ?> />
        Celular:
        <input type="text" name="celular" <?php
                                            if (isset($celular) && $celular != null || $celular != "") {
                                                echo "value=\"{$celular}\"";
                                            }
                                            ?> />
        <input class="btn-submit" type="submit" name="salvar" />
        <input class="btn-novo" type="reset" name="novo" />
        <hr>
    </form>
    <table border="1" width="100%">
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Ações</th>
        </tr>
        <?php
        try {
            $stmt = $conexao->prepare("SELECT * FROM CONTATOS");
            if ($stmt->execute()) {
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>" . $rs->NOME . "</td><td>" . $rs->EMAIL . "</td><td>" . $rs->CELULAR
                        . "</td><td><center><a href=\"?act=upd&id=" . $rs->ID . "\">[Alterar]</a>"
                        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"
                        . "<a href=\"?act=del&id=" . $rs->ID . "\">[Excluir]</a></center></td>";
                    echo "</tr>";
                }
            } else {
                echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
        ?>
    </table>
    </main>
</body>

</html>