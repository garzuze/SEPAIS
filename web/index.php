<?php
# segurança da página
session_start();
include('secure.php');
secure_page();
if ($_SESSION['funcao'] == "portaria") {
    header('Location: portaria.php');
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
}

# função de horário em tempo real
date_default_timezone_set('America/Sao_Paulo');

# pegando nome completo do usuário e a sua foto
$sql = connect();
$query = $sql->prepare("SELECT * FROM id22194774_sepais.sepae WHERE email = ?;");
$query->bind_param("s", $_SESSION['email']);
$query->execute();
$result_query = $query->get_result();
$result_array = $result_query->fetch_all(MYSQLI_ASSOC);
$nome = $result_array[0]['nome'];
$foto_path = $result_array[0]['foto_path'];
$username = $result_array[0]['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SEPAIS</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/datatable.css">
    <link rel="stylesheet" href="styles/snackbar.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="static/favicon.ico" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.8/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript">
        var username = "<?= $username ?>";
    </script>
    <script src="scripts/removeWaterMark.js"></script>
</head>

<body class="grid grid-cols-12 gap-x-1">
    <header class="ações-servidor col-span-12 h-16 bg-[#040401] grid grid-cols-3 justify-items-center content-center">
        <div class="user">
            <div class="flex items-center md:order-2">
                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-[#00bf63]" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Abrir menu de usuário</span>
                    <img class="w-8 h-8 rounded-full" src="<?php echo $foto_path; ?>" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900"><?php echo $nome; ?></span>
                        <span class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <form method="post"><input type="submit" name="logout" class="block px-4 py-2 text-sm text-gray-700 active:hover:bg-gray-100 m-auto" value="Logout"></form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <p class="text-white" id="time"></p>
        </div>
        <a href="index.php">
            <div class="">
                <img src="static/sepais_logo.png" class="sm:h-6 h-4">
            </div>
        </a>
    </header>
    <aside class="aside left-0 col-span-2 sm:col-span-1 h-full">
        <div class="h-full overflow-y-auto bg-gray-50 pt-1">
            <ul class="space-y-2 font-medium">
                <li>
                    <a id="escrever-recado" class="select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg group">
                        <span>Recado</span>
                    </a>
                </li>
                <li>
                    <p class="clique-desliza select-destaque flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg group">
                        Histórico
                    </p>
                    <div class="text-sm ml-6">
                        <a id="historico_sepae" class="subclasse-historico hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group">
                            <span>Sepae</span>
                        </a>
                        <a id="historico_responsavel" class="subclasse-historico hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group">
                            <span>Responsável</span>
                        </a>
                        <a id="historico_atrasos" class="subclasse-historico hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group">
                            <span>Atrasos</span>
                        </a>
                    </div>

                </li>
            </ul>
        </div>
    </aside>
    <section id="main" class="col-span-8 sm:col-span-10 overflow-x-auto">
        <snackbar></snackbar>
        <h1 class=" boas-vindas text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl absolute top-[50%] left-[50%] transform -translate-x-1/2 -translate-y-1/2">
            Seja bem vindo(a), <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00BF63] to-[#016D39] bg-[#016D39]"><?php echo ucfirst($username); ?>!</span>
        </h1>
        <div class="modal">
            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-dark-900">
                                Confirmação de liberação
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="crud-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2 sm:col-span-2">
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Motivo</label>
                                    <select required id="category" class="select-motivo bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                        <option disabled value="regular" selected="">Selecionar motivo</option>
                                    </select>
                                </div>
                            </div>
                            <button disabled class="confirmar-liberar text-white inline-flex items-center bg-gradient-to-r from-[#00BF63] to-[#016D39] font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="crud-modal">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Liberar alunos
                            </button>
                            </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <button disabled style="display:none;" data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button" class="btn-liberar bg-gradient-to-r from-[#00BF63] to-[#016D39] bg-[#016D39] mt-6 shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]">
                Liberar
            </button>
        </div>
    </section>
    <aside class="turmas min-h-screen h-full right-t-0 col-span-2 sm:col-span-1">
        <div class="h-full overflow-y-auto bg-gray-50 pt-1">
            <ul class="space-y-2 font-medium">
                <li>
                    <a id="adm1" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>ADM1</span>
                    </a>
                </li>
                <li>
                    <a id="adm2" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>ADM2</span>
                    </a>
                </li>
                <li>
                    <a id="adm3" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>ADM3</span>
                    </a>
                </li>
                <li>
                    <a id="adm4" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>ADM4</span>
                    </a>
                </li>
                <li>
                    <a id="info1" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>INFO1</span>
                    </a>
                </li>
                <li>
                    <a id="info2" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>INFO2</span>
                    </a>
                </li>
                <li>
                    <a id="info3" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>INFO3</span>
                    </a>
                </li>
                <li>
                    <a id="info4" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                        <span>INFO4</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/snackbar.js"></script>
</body>

</html>