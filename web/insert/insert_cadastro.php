<?php
include('../secure.php');
if (isset($_POST['submit'])){

// Preparando variáveis para inserção no BD
$funcao = $_POST['funcao'];
$username = strtolower($_POST['username']);
$name = $_POST['name'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$hashed_password = password_hash($senha, PASSWORD_DEFAULT);
$foto_path = 'nenhum';
// Conectando ao BD e inserindo novos dados
$sql = connect();
if ($funcao == 'portaria'){
    $query = $sql->prepare("INSERT INTO portaria (username, nome, email, senha, foto_path) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $username, $name, $email, $hashed_password, $foto_path);
    $query->execute();
} elseif ($funcao == 'sepae'){
    $query = $sql->prepare("INSERT INTO sepae (username, nome, email, senha, foto_path) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $username, $name, $email, $hashed_password, $foto_path);
    $query->execute(); 
}

header('Location: ../login.php');
}

?>