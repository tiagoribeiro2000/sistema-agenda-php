<?php
    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">


    <title>Login</title>
</head>
<body>
<header>
    <div id="title">
      <h1>Sempre Bela</h1>
    </div>   
</header> 
<main>   
<aside> 
<h2>Acessar</h2>           
<form method="post">
    <input type="text" name="email" placeholder="email" maxlength="35">
    <input type="password" name="senha" placeholder="senha" maxlength="32">
    <input type="submit" value="Cadastrar">
    <a href="cadastrar.php">Ainda não é inscrito?<strong>Cadastre-se!</strong></a> 
</form>   
</aside>

<article>
<div id="img-article">    
<img src="./imagens/cabeleireiro.png" alt="cabeleireiro"> 
</div>   
</article> 

</main> 
<?php
if(isset($_POST['email']))
{
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    if(!empty($email) && !empty($senha))
    {
        $u->conectar("projeto_login","localhost","root","");
        if($u->msgErro == "")
        {

        
        if($u->logar($email,$senha))
        {
            header("location: areaprivada.php");
        }
        else{
            echo "Email ou Senha incorretos.";
        }
    }else{
        echo "Erro ".$u->msgErro;
    }
    }else
    {
        echo "Preencha todos os campos!";
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>