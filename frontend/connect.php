<?php 
function connect() {
    // =========== Configuração ==============
    $_DB['server'] = 'localhost'; // Servidor MySQL
    $_DB['user'] = 'root'; // Usuário MySQL
    $_DB['password'] = 'senha'; // senha MySQL
    $_DB['database'] = 'sepaisdb'; // Banco de dados MySQL
    // =======================================

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Desativa relatórios de erros
    try {
        $sql = new mysqli($_DB['server'], $_DB['user'], $_DB['password'], $_DB['database']);
        $sql->set_charset("utf8mb4");
        return $sql;
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('Alguma coisa estranha aconteceu...');
    }
}

function write_log($log_msg, $log_pasta) {
    date_default_timezone_set('America/Sao_Paulo');

    $log_root = __DIR__ . '/logs';
    $months = [
        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];
    $pasta = [
        'cadastros', 'validar_saidas'
    ];

    $month_num = intval(date('m'));
    $log_month = $months[$month_num - 1]; 
    $log_dir = $log_root . '/' . $pasta[$log_pasta] . '/' . $log_month . ' ' . date('Y');
    $log_file = $log_dir . '/sepais_'. $pasta[$log_pasta] .'_' . date('Y-m-d') . '.log';

    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0777, true);
    }

    $formatted_log_msg = "[" .date('Y-m-d H:i:s') . "] " . $log_msg;
    file_put_contents($log_file, $formatted_log_msg . "\n", FILE_APPEND);
}
?>