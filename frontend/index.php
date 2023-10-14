<?php
# segurança da página
session_start();
include('secure.php');
secure_page();
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
}

# função de horário em tempo real
date_default_timezone_set('America/Sao_Paulo');

# pegando nome completo do usuário e a sua foto

$sql = connect();
$query = $sql->prepare("SELECT * FROM sepaisdb.sepae WHERE email = ?;");
$query->bind_param("s", $_SESSION['email']);
$query->execute();
$result_query = $query->get_result();
$result_array = $result_query->fetch_all(MYSQLI_ASSOC);
$nome = $result_array[0]['nome'];
$foto_path = $result_array[0]['foto_path'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SEPAIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function updateTime() {
            var currentTime = new Date()
            var hours = currentTime.getHours()
            var minutes = currentTime.getMinutes()

            if (hours < 10) {
                hours = "0" + hours
            }

            if (minutes < 10) {
                minutes = "0" + minutes
            }

            var time = hours + ":" + minutes;
            document.getElementById('time').innerHTML = time;
        }
        setInterval(updateTime, 1000);

        $(function(){
        //button select all or cancel
        $("#select-all").click(function () {
            var all = $("input.select-all")[0];
            all.checked = !all.checked
            var checked = all.checked;
            $("input.select-item").each(function (index,item) {
                item.checked = checked;
            });
        });
        //column checkbox select all or cancel
        $("input.select-all").click(function () {
            var checked = this.checked;
            $("input.select-item").each(function (index,item) {
                item.checked = checked;
            });
        });
        //check selected items
        $("input.select-item").click(function () {
            var checked = this.checked;
            var all = $("input.select-all")[0];
            var total = $("input.select-item").length;
            var len = $("input.select-item:checked:checked").length;
            all.checked = len===total;
        });
        
    });
    </script>
</head>

<body class="grid grid-cols-12 gap-1">
<header class="col-span-12 h-16 bg-[#040401] grid grid-cols-3 justify-items-center content-center">
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
<aside class="aside left-0 col-span-2 h-screen" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
        <ul class="space-y-2 font-medium">
            <li>
                <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                <svg class="w-[15px] h-[15px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                    <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"/>
                </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Escrever recado</span>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                <svg class="w-[15px] h-[15px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                    <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z"/>
                </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Histórico de liberações</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<section class="col-span-8">
    <table class="text-sm text-left text-gray-500 sm:rounded-lg shadow-lg mx-auto">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="checkbox-all" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 hidden">
                    id
                </th>
                <th scope="col" class="px-6 py-3">
                    Nome do aluno
                </th>
                <th scope="col" class="px-6 py-3">
                    Nome do responsável
                </th>
                <th scope="col" class="px-6 py-3">
                    Email do responsável
                </th>
                <th scope="col" class="px-6 py-3 hidden">
                    Turma
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="checkbox-table-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    Lucas Garzuze Cordeiro
                </th>
                <td class="px-6 py-4">
                    Leda Aparecida Sodré Garzuze Cordeiro
                </td>
                <td class="px-6 py-4">
                    leda.garzuze@gmail.com
                </td>
            </tr>
        </tbody>
    </table>
</section>
<aside class="right-0 col-span-2 h-screen" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
        <ul class="space-y-2 font-medium text-center">
            <li>
                <a href="?turma=adm1" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">ADM 1</span>
                </a>
            </li>
            <li>
                <a href="?turma=adm2" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">ADM 2</span>
                </a>
            </li>
            <li>
                <a href="?turma=adm3" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">ADM 3</span>
                </a>
            </li>
            <li>
                <a href="?turma=adm4" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">ADM 4</span>
                </a>
            </li>
            <li>
                <a href="?turma=info1" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">INFO 1</span>
                </a>
            </li>
            <li>
                <a href="?turma=info2" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">INFO 2</span>
                </a>
            </li>
            <li>
                <a href="?turma=info3" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">INFO 3</span>
                </a>
            </li>
            <li>
                <a href="?turma=info4" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">INFO 4</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

</body>

</html>