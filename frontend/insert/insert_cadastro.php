<?php
include('../secure.php');
if (isset($_POST['submit'])) {

    // Preparando variáveis para inserção no BD
    $funcao = $_POST['funcao'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
    $foto_path = "static/default_user_icon.jpg";
    $sql = connect();

    try {
        $insert_user_query = $sql->prepare("INSERT INTO usuario (nome, email, senha, foto_path) VALUES (?, ?, ?, ?)");
        $insert_user_query->bind_param("ssss", $name, $email, $hashed_password, $foto_path);
        $insert_user_query->execute();

        $insert_child_user_stmt = "INSERT INTO " . $funcao . " (email) VALUES (?)";
        $insert_child_user_query = $sql->prepare($insert_child_user_stmt);
        $insert_child_user_query->bind_param("s", $email);
        $insert_child_user_query->execute();
        header('Location: ../login.php');
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            header("Location: ../signup.php?erro=" . $e->getMessage() . "");
        } else {
            header('Location: ../signup.php?erro=' . $e->getMessage() . '');
            throw $e; // in case it's any other error
        }
    }
}
