<?php
include('connect.php');

function verify_user($email, $password){
    $sql = connect();
    // Primeiro, verificamos se o e-mail existe na tabela de servidores da SEPAE.
    $query = $sql->prepare("SELECT * FROM id22194774_sepais.sepae WHERE email = ?");
    $query->bind_param('s', $email);
    $query->execute();
    $result_query = $query->get_result();
    // Depois, verificamos se o e-mail existe na tabela de servidores da portaria.
    $query2 = $sql->prepare("SELECT * FROM id22194774_sepais.portaria WHERE email = ?");
    $query2->bind_param('s', $email);
    $query2->execute();
    $result_query2 = $query2->get_result();

    if ($result_query->num_rows === 1) {
        // Agora, comparamos a senha inserida com a senha no banco de dados
        $result_array = $result_query->fetch_all(MYSQLI_ASSOC);
        $stored_password = $result_array[0]['senha'];
        if (password_verify($password, $stored_password)) {
            // As senhas coincidem, o usuário é logado
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $password;
            $_SESSION['funcao'] = "sepae";
            header('Location: index.php');
        } else {
            // Senha não coincide, usuário redirecionado para login
            secure_page();
        }
    } elseif ($result_query2->num_rows === 1) {
        // Agora, comparamos a senha inserida com a senha no banco de dados
        $result_array2 = $result_query2->fetch_all(MYSQLI_ASSOC);
        $stored_password = $result_array2[0]['senha'];
        if (password_verify($password, $stored_password)) {
            // As senhas coincidem, o usuário é logado
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $password;
            $_SESSION['funcao'] = "portaria";
            header('Location: portaria.php');
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