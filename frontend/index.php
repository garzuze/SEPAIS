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
    echo json_encode(['success' => true]); 
    exit; 
}

# função de horário em tempo real
date_default_timezone_set('America/Sao_Paulo');

# pegando nome completo do usuário e a sua foto
$sql = connect();
$query = $sql->prepare("SELECT * FROM usuario WHERE email = ?;");
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
    <?php include("includes.php"); ?>
</head>

<body class="grid grid-cols-12 gap-x-1">
    <?php include("navbar.php"); ?>
    <aside class="aside left-0 col-span-2 sm:col-span-1 h-full">
        <div class="h-full overflow-y-auto bg-gray-50 pt-1">
            <ul class="space-y-2 font-medium">
                <li>
                    <a id="escrever-recado" class="select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg group" href="#escrever-recado">
                        <span>Recado</span>
                    </a>
                </li>
                <li>
                    <p id="historico" class="clique-desliza select-destaque flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg group">
                        Histórico
                    </p>
                    <div class="text-sm ml-6">
                        <a id="historico-sepae" class="subclasse-historico hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#historico-sepae">
                            <span>Sepae</span>
                        </a>
                        <a id="historico-responsavel" class="subclasse-historico hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#historico-responsavel">
                            <span>Resp.</span>
                        </a>
                        <a id="historico-atrasos" class="subclasse-historico hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#historico-atrasos">
                            <span>Atrasos</span>
                        </a>
                        <a id="historico-recados" class="subclasse-historico hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#historico-recados">
                            <span>Recados</span>
                        </a>
                    </div>
                </li>
                <li>
                    <p id="cadastrar" class="clique-desliza select-destaque flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg group">
                        Cadastrar
                    </p>
                    <div class="text-sm ml-6">
                        <a id="cadastrar-turma" class="subclasse-cadastrar hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#cadastrar-turma">
                            <span>Turma</span>
                        </a>
                        <a id="cadastrar-motivo" class="subclasse-cadastrar hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#cadastrar-motivo">
                            <span>Motivo</span>
                        </a>
                        <a id="cadastrar-responsavel" class="subclasse-cadastrar hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#cadastrar-responsavel">
                            <span>Resp.</span>
                        </a>
                        <a id="cadastrar-aluno" class="subclasse-cadastrar hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#cadastrar-aluno">
                            <span>Aluno</span>
                        </a>
                        <a id="cadastrar-vinculo" class="subclasse-cadastrar hidden target flex justify-center items-center cursor-pointer p-2 text-gray-900 group" href="#cadastrar-vinculo">
                            <span>Vínculo</span>
                        </a>
                    </div>
                </li>
                <li>
                    <p id="atualizar" class="clique-desliza select-destaque flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg group">
                        Atualizar
                    </p>
                    <div id="atualizar-turma" class="text-sm ml-6">

                    </div>
                </li>
            </ul>
        </div>
    </aside>
    <section id="main" class="col-span-8 sm:col-span-10 overflow-x-auto">
        <snackbar></snackbar>
        <h1 class="boas-vindas text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl absolute top-[50%] left-[50%] transform -translate-x-1/2 -translate-y-1/2">
            Seja bem vindo(a), <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00BF63] to-[#016D39] bg-[#016D39]"><?php echo ucfirst(strtok($nome, ' ')); ?>!</span>
        </h1>
        <div class="modal">
            <p id="editar-recado-titulo" style="visibility: hidden; display: none;"></p>
            <p id="editar-recado-recado" style="visibility: hidden; display: none;"></p>
            <p id="editar-recado-validade" style="visibility: hidden; display: none;"></p>
            <button id="cadastro-escondido" data-modal-target="modal-cadastro" data-modal-toggle="modal-cadastro" type="button" style="visibility: hidden; display: none;">
            </button>
            <button id="atualizar-escondido" data-modal-target="modal-atualizar" data-modal-toggle="modal-atualizar" type="button" style="visibility: hidden; display: none;">
            </button>
            <button id="atualizar-info-escondido" data-modal-target="modal-info-atualizar" data-modal-toggle="modal-info-atualizar" type="button" style="visibility: hidden; display: none;">
            </button>

            <div id="modal-cadastro" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 id="modal-cad-titulo" class="text-xl font-medium text-gray-900">Confirmar cadastro
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-cadastro">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <p id="modal-cad-body" class="text-base leading-relaxed text-gray-500">
                                <p id="modal-cad-opcao" style="visibility: hidden; display: none;"></p>
                            </p>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                            <button id="confirmar-cadastro" type="button" class="text-white inline-flex items-center bg-gradient-to-r from-[#00BF63] to-[#016D39] font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="modal-cadastro">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                <span id="modal-btncad-texto">Confirmar cadastro</span>
                            </button>
                            <button data-modal-hide="modal-cadastro" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal-atualizar" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 id="modal-atu-titulo" class="text-xl font-medium text-gray-900">Confirmar 
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-atualizar">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <p id="modal-atu-body" class="text-base leading-relaxed text-gray-500">
                                <p id="modal-atu-opcao" style="visibility: hidden; display: none;"></p>
                            </p>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                            <button id="confirmar-atualizar" type="button" class="text-white inline-flex items-center bg-gradient-to-r from-[#00BF63] to-[#016D39] font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="modal-atualizar">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                <span id="modal-btnatu-texto">Confirmar </span>
                            </button>
                            <button data-modal-hide="modal-atualizar" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal-info-atualizar" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-3xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Atenção!
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-info-atualizar">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <p class="text-base leading-relaxed text-gray-500">
                                O processo de atualização de alunos por turma funciona da seguinte forma:
                                <span class="font-bold">
                                    1. A alteração começa pelos últimos períodos do curso e vai até o primeiro;
                                    <br>
                                    2. Primeiramente, o usuário deve confirmar os alunos aprovados daquele periodo;
                                    <br> 
                                    3. Em seguida, deverá confirmar os alunos que desistiram do curso 
                                    (os que reprovaram não necessitam ser selecionados em nenhuma etapa).
                                    <br> 
                                    4. Repita o processo para todos os periodos do curso.
                                </span>
                            </p>

                            <p class="text-base leading-relaxed text-gray-500">
                                Idealmente, o processo de atualização das turmas deve ser feito antes do cadastro de novos alunos e apenas uma vez por periodo para todos os periodos 
                                de um curso. Entretanto, caso seja necessário repetir o processo, siga esses passos:
                                <span class="font-bold">
                                    1. Não selecione nenhum aluno das turmas que não deseja alterar;
                                    <br>
                                    2. Com nenhum aluno selecionado, clique nos botões de confirmar aprovação e desistência até chegar na turma que deseja alterar;
                                    <br> 
                                    3. Faça as alterações necessárias e complete a operação de forma íntegra;
                                </span>
                            </p>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button data-modal-hide="modal-info-atualizar" type="button" class="text-white inline-flex items-center bg-gradient-to-r from-[#00BF63] to-[#016D39] font-medium rounded-lg text-sm px-5 py-2.5 text-center">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>


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
            <ul id="ul-turma" class="space-y-2 font-medium">
            </ul>
        </div>
    </aside>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/snackbar.js"></script>
</body>

</html>