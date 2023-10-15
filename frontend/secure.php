<?php
include('connect.php');

function verify_user($email, $password){
    $sql = connect();
    // Primeiro, verificamos se o e-mail existe.
    $query = $sql->prepare("SELECT * FROM sepaisdb.sepae WHERE email = ?");
    $query->bind_param('s', $email);
    $query->execute();
    $result_query = $query->get_result();

    if ($result_query->num_rows === 1) {
        // Agora, comparamos a senha inserida com a senha no banco de dados
        $result_array = $result_query->fetch_all(MYSQLI_ASSOC);
        $stored_password = $result_array[0]['senha'];
        if (password_verify($password, $stored_password)) {
            // As senhas coincidem, o usuário é logado
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $password;
            header('Location: index.php');
        } else {
            // Senha não coincide, usuário redirecionado para login
            secure_page();
        }
    } else {
        // Usuário não encontrado no banco de dados
        header('Location: signup.php');
    }
}

function secure_page() {
    if (!isset($_SESSION['email']) && !isset($_SESSION['senha'])) {
        session_destroy();
        header('Location: login.php');
    }
}