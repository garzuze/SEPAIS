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
$username = $result_array[0]['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SEPAIS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="static/favicon.ico" />
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

        // Função para os checkbox serem selecionados todos de uma vez
        $(document).ready(function() {
            $("#main").on("click", "input.select-all", function(){
            // Coluna checkbox que seleciona ou deseleciona todos
                var checked = this.checked;
                $("input.select-item").each(function(index, item) {
                    item.checked = checked;
                });
            });
            // Marca os checkbox clicados 
            $("#main").on("click", "input.select-item", function(){
                var checked = this.checked;
                var all = $("input.select-all")[0];
                var total = $("input.select-item").length;
                var len = $("input.select-item:checked:checked").length;
                all.checked = len === total;
            });

            // Função para botões ficarem em destaque quando ativos
            $('.select-destaque').click(function() {
                $('.select-destaque').removeClass('bg-gray-100'); 
                $(this).addClass('bg-gray-100'); 
            });

            // Função para selecionar alunos por turma
            $('.select-turma').click(function() {
                var turma = $(this).attr('id');
                $('.btn-liberar').removeClass('invisible');
                $.ajax({
                    url: 'read/read_alunos_turma.php',
                    data: 'turma=' + turma,
                    type: 'GET',
                    success: function(data) {
                        data = JSON.parse(data)
                        console.log(data);
                        // Limpando o seção principal
                        $("#main > *:not('.modal')").remove();
                        $('#main').prepend(`
                        <table class="text-sm text-left text-gray-500 sm:rounded-lg shadow-lg mx-auto w-3/4 mt-4">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="active p-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" class="select-all gmail-checkbox checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" name="select-all">
                                            <label for="checkbox-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden">
                                        id
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/3">
                                        Nome do aluno
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/3">
                                        Nome do responsável
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/3">
                                        Email do responsável
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden">
                                        Turma
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tb-alunos-resp">

                            </tbody>
                        </table>`)
                        for (var i = 0; i < data.length; i++) {
                            $('#tb-alunos-resp').append(
                                '<tr class="bg-white border-b">' +
                                '<td class="active w-4 p-4">' +
                                '<div class="flex items-center">' +
                                '<input type="checkbox" class="select-item gmail-checkbox checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" name="select-alunos[] value="'+data[i]['id_aluno']+'">' +
                                '<label for="checkbox-table-1" class="sr-only">checkbox</label>' +
                                '</div>' +
                                '</td>' +
                                '<td id="id" scope="col" class="px-6 py-3 hidden">' +
                                data[i]['id_aluno'] +
                                '</td>' +
                                '<td id="nome_aluno" scope="row" class="px-6 py-4 font-medium text-gray-900 w-1/3">' +
                                data[i]['nome_aluno'] +
                                '</td>' +
                                '<td class="px-6 py-4 w-1/3">' +
                                data[i]['nome_responsavel'] +
                                '</td>' +
                                '<td class="px-6 py-4 w-1/3">' +
                                data[i]['email_responsavel'] +
                                '</td>' +
                                '<td scope="col" class="px-6 py-3 hidden">' +
                                data[i]['turma'] +
                                '</td>' +
                                '</tr>');
                        }
                    }
                })
            })
            
            // Função para visualizar histórico 
            $('#historico').click(function() {
                $('.btn-liberar').addClass('invisible');
                $.ajax({
                    url: 'read/read_historico_liberado_sepae.php',
                    type: 'GET',
                    success: function(data) {
                        data = JSON.parse(data)
                        console.log(data);
                        // Limpando o seção principal
                        $("#main > *:not('.modal')").remove();
                        $('#main').prepend(`
                        <table class="text-sm text-left text-gray-500 sm:rounded-lg shadow-lg mx-auto w-3/4 mt-4">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <th scope="col" class="px-6 py-3 hidden">
                                        id
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-3/12">
                                        Nome do aluno
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/12">
                                        Turma
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-2/12">
                                        Data
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-2/12">
                                        Saída
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/12">
                                        Servidor
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-2/12">
                                        Motivo
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tb-alunos-resp">

                            </tbody>
                        </table>`)
                        for (var i = 0; i < data.length; i++) {
                            if(data[i]['saida'] == null){
                                data[i]['saida'] = "Não saiu";
                            }
                            else{
                                data[i]['saida'] = data[i]['saida'].slice(11,19);
                            }
                            $('#tb-alunos-resp').append(
                                '<tr class="bg-white border-b"><td id="id" scope="col" class="px-6 py-3 hidden">' +
                                data[i]['id_aluno'] +
                                '</td>' +
                                '<td id="nome_aluno" scope="row" class="px-6 py-4 font-medium text-gray-900 w-3/12">' +
                                data[i]['nome_aluno'] +
                                '</td>' +
                                '<td class="px-6 py-4 w-1/12">' +
                                data[i]['turma'] +
                                '</td>' +
                                '<td class="px-6 py-4 w-2/12">' +
                                data[i]['data'].slice(0,10) +
                                '</td>' +
                                '<td class="px-6 py-4 w-2/12">' +
                                data[i]['saida']+
                                '</td>' +
                                '<td class="px-6 py-4 w-1/12">' +
                                data[i]['Servidor']+
                                '</td>' +
                                '<td class="px-6 py-4 w-3/12">' +
                                data[i]['motivo']+
                                '</td>' +
                                '</tr>');
                        }
                    }
                })
            })

            // Função para escrever recado.
            $('#escrever-recado').click(function() {
                $('.btn-liberar').addClass('invisible');
                var usernameValue = "<?php echo $username; ?>";
                $("#main > *:not('.modal')").remove();
                $('#main').prepend(`
                <div id="recado" class="mx-auto w-3/4 mt-4">
                    <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Escrever recado</h2>
                    <form id="form_valida" action="insert/insert_recado.php" method="post">
                        <div>
                            <input type="hidden" id="username" name="username" value="${usernameValue}">
                            <label for="titulo" class="block my-2 text-sm font-medium text-gray-900">Título</label>
                            <input type="text" name="titulo" id="titulo" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="O campus Pinhais é bom demais..." required>
                        </div>
                        <div>
                            <label for="recado" class="block my-2 text-sm font-medium text-gray-900">Recado</label>
                            <textarea id="recado" name="recado" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Tem cachorro, tem coruja e muitos outros animais!"></textarea>
                        </div>
                        <div>
                            <label for="validade" class="block my-2 text-sm font-medium text-gray-900">Validade</label>
                            <input type="date" name="validade" id="validade" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5">
                            <label class="text-gray-600" for="comando"><small>*Deixe vazio caso o recado não tenha validade</small></label>
                        </div>
                `)
                $('#form_valida').append(`
                        <input type="submit" name="submit" class="bg-gradient-to-r from-[#00BF63] to-[#016D39] mt-6 bg-[#016D39] shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]"
                        value="Enviar recado">
                        </form>
                </div>`)
            })

        });
    </script>
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
    <aside class="aside left-0 col-span-2 h-screen" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
            <ul class="space-y-2 font-medium">
                <li>
                    <a id="escrever-recado" class="select-destaque flex cursor-pointer items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-[15px] h-[15px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                            <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z" />
                        </svg>
                        <span class="flex-1 ml-3">Escrever recado</span>
                    </a>
                </li>
                <li>
                    <a id="historico" class="select-destaque flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-[15px] h-[15px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                            <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z" />
                        </svg>
                        <span class="flex-1 ml-3">Histórico de liberações</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <section id="main" class="col-span-8">
        <h1 class=" boas-vindas text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl absolute top-[50%] left-[50%] transform -translate-x-1/2 -translate-y-1/2">
            Seja bem vindo(a), <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00BF63] to-[#016D39] bg-[#016D39]"><?php echo ucfirst($username);?>!</span>
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
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2 sm:col-span-2">
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Motivo</label>
                                    <select required id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                        <option disabledselected="">Selecionar motivo</option>
                                        <option value="1">Luto</option>
                                        <option value="2">Médico</option>
                                        <option value="3">Transporte</option>
                                        <option value="4">Mal-estar</option>
                                        <option value="5">Motivo particular</option>
                                        <option value="6">Professor faltou</option>
                                        <option value="7">Aula acabou mais cedo</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="text-white inline-flex items-center bg-gradient-to-r from-[#00BF63] to-[#016D39] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                Liberar alunos
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <a data-modal-target="crud-modal" data-modal-toggle="crud-modal"  type="button" class="btn-liberar invisible bg-gradient-to-r from-[#00BF63] to-[#016D39] bg-[#016D39] mt-6 shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]">
                Liberar
            </a>
        </div>
    </section>
    <aside class="turmas right-0 col-span-2 h-screen" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
            <ul class="space-y-2 font-medium text-center">
                <li>
                    <a id="adm1" class="select-turma select-destaque target cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 active:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">ADM1</span>
                    </a>
                </li>
                <li>
                    <a id="adm2" class="select-turma select-destaque cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">ADM2</span>
                    </a>
                </li>
                <li>
                    <a id="adm3" class="select-turma select-destaque cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">ADM3</span>
                    </a>
                </li>
                <li>
                    <a id="adm4" class="select-turma select-destaque cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">ADM4</span>
                    </a>
                </li>
                <li>
                    <a id="info1" class="select-turma select-destaque cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">INFO1</span>
                    </a>
                </li>
                <li>
                    <a id="info2" class="select-turma select-destaque cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">INFO2</span>
                    </a>
                </li>
                <li>
                    <a id="info3" class="select-turma select-destaque cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">INFO3</span>
                    </a>
                </li>
                <li>
                    <a id="info4" class="select-turma select-destaque cursor-pointer flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <span class="flex-1 ml-3 whitespace-nowrap">INFO4</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>

</html>