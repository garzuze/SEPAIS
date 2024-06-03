<?php 
function connect() {
    // =========== Configuração ==============
    $_DB['server'] = 'localhost'; // Servidor MySQL
    $_DB['user'] = 'id22194774_sepais'; // Usuário MySQL
    $_DB['password'] = 'Senha@BancoSepais777'; // senha MySQL
    $_DB['database'] = 'id22194774_sepais'; // Banco de dados MySQL
    // =======================================

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Desativa relatórios de erros
    try {
        $sql = mysqli_connect($_DB['server'], $_DB['user'], $_DB['password'], $_DB['database']);
        $sql->set_charset("utf8mb4");
        return $sql;
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('Alguma coisa estranha aconteceu...');
    }
}
?>