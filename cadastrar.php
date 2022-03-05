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
    <link rel="stylesheet" href="css/estilo.css">
    <title>Projeto Crud</title>
</head>
<body>
<header>    
<h1>Cadastro de Usuário<h1> 
</header>  
<main> 
<aside>      
<form method="post">
    <input type="text" name="nome" placeholder="nome" maxlength="35">
    <input type="text" name="telefone" placeholder="telefone" maxlength="30">
    <input type="text" name="email" placeholder="seu email" maxlength="65">
    <input type="password" name="senha" placeholder="senha" maxlength="32">
    <input type="password" name="confsenha" placeholder="confirmar senha" maxlength="32">
    <input type="submit" value="Cadastrar">
    <a href="index.php">Já é cadastrado?<strong>Faça seu login!</strong></a>
</aside>
<article>
<img src="./imagens/adicionar-usuario.png" alt="adicionar-usuario">  
</article>    
</form> 
</main>
<?php

//VERIFICAR SE CLICOU NO BOTÃO
if(isset($_POST['nome']))
{
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $confirmarSenha = addslashes($_POST['confsenha']);
    if(!empty($nome)&& !empty($telefone)&& !empty($email)&& !empty($senha)&& !empty($confirmarSenha))
    {
       $u->conectar("projeto_login","localhost","root",""); 
       if($u->msgErro == "")//esta tudo certo
       {
        if($senha == $confirmarSenha) 
        {
           if( $u->cadastrar($nome,$telefone,$email,$senha)){
               ?>
               <div id="msg-sucesso">
               Cadastrado com sucesso! Faça seu login! 
               </div>
               <?php
           }else{
               ?>
               <div class="msg-erro">
                Email já cadastrado!
               </div>
               <?php
           }
        }else{
            ?>
            <div class="msg-erro">
             As senhas não correspondem!
            </div>
            <?php
        }  
        
       }else{
           ?>
           <div class="msg-erro">
                <?php echo "Erro:".$u->msgErro;?>
           </div>
           <?php
       }
    }else
    {
        ?>
        <div class="msg-erro">
            Preencha todos os campos!
        </div>
        <?php
    }
} 


?>
</body>
</html>