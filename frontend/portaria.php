<?php
# segurança da página
session_start();
include('secure.php');
secure_page();
if ($_SESSION['funcao'] == "sepae"){
    header('Location: index.php');
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
}

# função de horário em tempo real
date_default_timezone_set('America/Sao_Paulo');

# pegando nome completo do usuário e a sua foto
$sql = connect();
$query = $sql->prepare("SELECT * FROM sepaisdb.portaria WHERE email = ?;");
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
    <!-- Datatables, vai ser usado no futuro-->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
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
                        <span id="servidor-username" style="visibility: hidden; display: none;" class="block text-sm text-gray-900"><?php echo $username; ?></span>
                        <span class="block text-sm text-gray-900"><?php echo $nome; ?></span>
                        <span class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <form method="post"><input type="submit" name="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 m-auto" value="Logout"></form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <p class="text-white" id="time"></p>
        </div>
        <a href="portaria.php">
            <div class="">
                <img src="static/sepais_logo.png" class="sm:h-6 h-4">
            </div>
        </a>
    </header>
    <aside class="aside left-0 col-span-2 sm:col-span-1 h-full">
        <div class="h-full overflow-y-auto bg-gray-50 pt-1">
            <ul class="space-y-2 font-medium">
                <li>
                <a id="saidas" class="select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>Saídas</span>
                    </a>
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
        <button id="atraso-escondido" data-modal-target="modal-atraso" data-modal-toggle="modal-atraso" type="button" style="visibility: hidden; display: none;">
        </button>
      
        <button id="valida-escondido" data-modal-target="modal-valida" data-modal-toggle="modal-valida" type="button" style="visibility: hidden; display: none;">
        </button>
        
            <div id="modal-atraso" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 class="text-xl font-medium text-gray-900">
                                Registrar atraso
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-atraso">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <p class="text-base leading-relaxed text-gray-500">
                                Deseja registrar o atraso do seguinte aluno?<br>
                                <span class="font-semibold text-green-700" id="modal-nome"></span>
                                <p id="modal-id" style="visibility: hidden; display: none;"></p>
                            </p>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                            <button id="confirmar-atraso" type="button" class="text-white inline-flex items-center bg-gradient-to-r from-[#00BF63] to-[#016D39] font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="modal-atraso">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                Registrar atraso
                            </button>
                            <button data-modal-hide="modal-atraso" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

        <div id="modal-valida" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 class="text-xl font-medium text-gray-900">
                                Validar saída
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-valida">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <p class="text-base text-gray-500">
                                Deseja validar a saída do seguinte aluno?<br>
                                <span class="font-semibold text-green-700" id="valida-nome"></span>
                                <p id="valida-id" style="visibility: hidden; display: none;"></p>
                                <p id="valida-data" style="visibility: hidden; display: none;"></p>
                            </p>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                            <button id="valida-saida" type="button" class="text-white inline-flex items-center bg-gradient-to-r from-[#00BF63] to-[#016D39] font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="modal-valida">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                Validar
                            </button>
                            <button data-modal-hide="modal-valida" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <aside class="turmas min-h-screen h-full right-t-0 col-span-2 sm:col-span-1">
        <div class="h-full overflow-y-auto bg-gray-50 pt-1">
            <ul class="space-y-2 font-medium">
                <li>
                    <a id="adm1" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>ADM1</span>
                    </a>
                </li>
                <li>
                    <a id="adm2" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>ADM2</span>
                    </a>
                </li>
                <li>
                    <a id="adm3" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>ADM3</span>
                    </a>
                </li>
                <li>
                    <a id="adm4" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>ADM4</span>
                    </a>
                </li>
                <li>
                    <a id="info1" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>INFO1</span>
                    </a>
                </li>
                <li>
                    <a id="info2" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>INFO2</span>
                    </a>
                </li>
                <li>
                    <a id="info3" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>INFO3</span>
                    </a>
                </li>
                <li>
                    <a id="info4" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span>INFO4</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="scripts/script_portaria.js"></script>
    <script src="scripts/snackbar.js"></script>
</body>