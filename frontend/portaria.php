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
    <!-- <link rel="stylesheet" href="datatable.css"> -->
    <link rel="icon" type="image/x-icon" href="static/favicon.ico" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Datatables, vai ser usado no futuro-->
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.8/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script> --> 
    <!-- <script type="text/javascript">var username = " <Tirar espaço?= $username ?>";</script>  --> <!-- Se for necessário fazer registros no BD com o nome do servidor da portaria>-->
</head>

<body class="grid grid-cols-12 gap-1">
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
                            <form method="post"><input type="submit" name="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 m-auto" value="Logout"></form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <p class="text-white" id="time"></p>
        </div>
        <div class="">
            <img src="static/sepais_logo.png" class="sm:h-6 h-4">
        </div>
    </header>
    <aside class="aside left-0 col-span-2 sm:col-span-1 h-full">
        <div class="h-full overflow-y-auto bg-gray-50">
            <ul class="space-y-2 font-medium">
                <li>
                    <a id="saidas" class="select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg group">
                        <span>Saídas</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <section id="main" class="col-span-8 sm:col-span-10 overflow-x-auto">
        <h1 class=" boas-vindas text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl absolute top-[50%] left-[50%] transform -translate-x-1/2 -translate-y-1/2">
            Seja bem vindo(a), <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00BF63] to-[#016D39] bg-[#016D39]"><?php echo ucfirst($username); ?>!</span>
        </h1>
    </section>
    <aside class="turmas min-h-screen h-full right-t-0 col-span-2 sm:col-span-1">
        <div class="h-full overflow-y-auto bg-gray-50">
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
    <script src="script_portaria.js"></script>
</body>