<?php
    $pdo = new PDO ('mysql:host=localhost;dbname=cliente','root','');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    //insert 
    if(isset($_POST['nome'])){
        $sql = $pdo->prepare("INSERT INTO clientes VALUES (NOT NULL, ?, ?)");
        $sql-> execute(array($_POST['nome'],$_POST['email']));
        echo 'inserido com sucesso';
        
    }
?>



<?php
$sql = $pdo -> prepare("SELECT * FROM clientes"); 
$sql -> execute(); 
$fetchClientes = $sql -> fetchAll();

foreach ($fetchClientes as $key => $value){
    echo $value['nome'].'|'.$value['email'];
    echo '<hr>';

}

?>