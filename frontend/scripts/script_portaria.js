function updateTime() {
    var currentTime = new Date();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();

    if (hours < 10) {
        hours = "0" + hours;
    }

    if (minutes < 10) {
        minutes = "0" + minutes;
    }

    var time = hours + ":" + minutes;
    $('#time').html(time);
}
setInterval(updateTime, 1000);

window.addEventListener("storage", function (event) {
    if (event.key === "logoutEvent") {
        window.location.href = "index.php";
    }
});

$(document).ready(function () {
    function logout(event) {
        event.preventDefault();

        $.ajax({
            url: "", 
            type: "POST",
            data: { logout: true },
            dataType: "json", 
            success: function(response) {
                if (response.success) {
                    sessionStorage.removeItem("logoutEvent");
                    localStorage.removeItem("logoutEvent");

                    sessionStorage.setItem("logoutEvent", "true");
                    localStorage.setItem("logoutEvent", "true");

                    window.location.href = "index.php"; 
                }
            },
            error: function() {
                alert("An error occurred during logout. Please try again.");
            }
        });
    }

    $("#logoutForm").submit(logout);

    $.ajax({
        url: 'read/read_turmas.php',
        type: 'GET',
        success: function (turma) {
            if (turma == 0) {
                location.reload();
            } else {
                turma = JSON.parse(turma);
                console.log(turma);
                for (var i = 0; i < turma.length; i++) {
                    $('#ul-turma').append(`
                        <li>
                            <a id="`+ turma[i]["turma"] + `" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                                <span>`+ turma[i]["turma"] + `</span>
                            </a>
                        </li>
                    `)
                }
            }
        }
    })

    $("body").on("click", ".select-destaque", function () {
        activateButton(this);
    });

    // Função para botões ficarem em destaque quando ativos
    function activateButton(element) {
        $('.select-destaque').removeClass('bg-gray-100');
        $(element).addClass('bg-gray-100');
    }
    // Função para ler os alunos por turma
    function selectTurma(turma) {
        $.ajax({
            url: 'read/read_alunos_turma.php',
            data: 'turma=' + turma,
            type: 'GET',
            success: function (data) {
                if (data == 0) {
                    location.reload();
                } else {
                    data = JSON.parse(data);
                    console.log(data);
                    // Limpando o seção principal
                    $("#main > *:not('.modal')").remove();
                    $('#main').prepend(`
                            <table class="text-sm text-left text-gray-500 sm:rounded-lg shadow-lg mx-auto w-3/4 mt-4">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 hidden">
                                            id
                                        </th>
                                        <th scope="col" class="px-6 py-3 w-5/12">
                                            Nome do aluno
                                        </th>
                                        <th scope="col" class="px-6 py-3 w-5/12">
                                            Nome do responsável
                                        </th>
                                        <th scope="col" class="px-6 py-3 hidden">
                                            Turma
                                        </th>
                                        <th scope="col" class="text-center active px-6 w-2/12">
                                            Marcar atraso
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tb-alunos-resp">
                                </tbody>`);
                    for (var i = 0; i < data.length; i++) {
                        var aluno_check = "aluno" + i;
                        $('#tb-alunos-resp').append(
                            '<tr class="bg-white border-b">' +
                            '<td id="id" scope="col" class="px-6 py-3 hidden">' +
                            data[i]['id_aluno'] +
                            '</td>' +
                            '<td id="nome_aluno" scope="row" class="px-6 py-4 font-medium text-gray-900">' +
                            data[i]['nome_aluno'] +
                            '</td>' +
                            '<td class="px-6 py-4">' +
                            data[i]['nome_responsavel'] +
                            '</td>' +
                            '<td class="active w-4 p-4">' +
                            '<div class="flex items-center justify-center">' +
                            '<span class="registrar-atraso gmail-clock" name="select-alunos[]" id="' + data[i]['nome_aluno'] + '" value="' + data[i]['id_aluno'] + '">' +
                            '<svg class="h-8 w-8 text-green-900"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2"' +
                            'stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">' +
                            '<path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="13" r="7" />' +
                            '<polyline points="12 10 12 13 14 13" />  <line x1="7" y1="4" x2="4.25" y2="6" /> ' +
                            '<line x1="17" y1="4" x2="19.75" y2="6" /></svg>' +
                            '</span>' +
                            '</div>' +
                            '</td>' +
                            '<td scope="col" class="px-6 py-3 hidden">' +
                            data[i]['turma'] +
                            '</td>' +
                            '</tr>');
                    }
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    };

    // Função para abrir modal de atraso e preparar os dados para registrar o atraso
    $("#main").on("click", ".registrar-atraso", function () {
        // alert($(this).attr('value'));
        $("#modal-nome").empty();
        $("#modal-id").empty();
        $("#modal-email").empty();
        $("#modal-nome").append(" <b>" + $(this).attr('id') + "</b>");
        $("#modal-id").append($(this).attr('value'));
        $('#atraso-escondido').trigger("click");
    });

    // Função para enviar os dados do registro do atraso para a inserção no banco de dados
    $("#main").on("click", "#confirmar-atraso ", function () {
        id_aluno = $("#modal-id").text();
        email = $("#servidor-email").text();

        $.ajax({
            type: "POST",
            data: {
                id_aluno: id_aluno,
                email: email
            },
            url: "insert/insert_aluno_atrasado.php",
            success: function (resposta) {
                var data = JSON.parse(resposta);
                if (data.status === 0) {
                    // Mensagem de erro
                    alert(data.mensagem);
                    location.reload();
                } else {
                    // Mensagem de sucesso
                    let snackbar = new SnackBar();
                    snackbar.make("menssage",
                        [
                            data.mensagem,
                            null,
                            "bottom",
                            "right"], 4000);
                }
            }
        });
    });

    function loadValidarSaida() {
        $.ajax({
            url: 'read/read_alunos_liberados.php',
            type: 'GET',
            success: function (data) {
                if (data == 0) {
                    location.reload();
                } else {
                    data = JSON.parse(data);
                    console.log(data);
                    // Limpando o seção principal
                    $("#main > *:not('.modal')").remove();
                    $("#main").css('visibility', 'hidden');
                    $('#main').prepend(`
                            <table style="width:100%;" class="tabela-saidas text-sm text-left mx-auto text-gray-500 sm:rounded-lg shadow-lg mt-4">
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
                                        <th scope="col" class="px-6 py-3 w-1/12">
                                            Liberado por
                                        </th>
                                        <th scope="col" class="text-center px-6 py-3 w-1/12">
                                            Validar saída
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tb-alunos-resp">

                                </tbody>
                            </table>`);
                    for (var i = 0; i < data.length; i++) {
                        $('#tb-alunos-resp').append(
                            '<tr class="bg-white border-b"><td id="id" scope="col" class="px-6 py-3 hidden">' +
                            data[i]['id_aluno'] +
                            '</td>' +
                            '<td id="nome_aluno" scope="row" class="px-6 py-4 font-medium text-gray-900 w-3/12">' +
                            data[i]['aluno'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-1/12">' +
                            data[i]['turma'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-1/12">' +
                            data[i]['liberador'].split("@")[0] +
                            '</td>' +
                            '<td class="active w-1/12 p-4">' +
                            '<div class="flex items-center justify-center">' +
                            '<span class="validar-saida gmail-clock" name="' + data[i]['data'] + '" id="' + data[i]['aluno'] + '" value="' + data[i]['id_aluno'] + '">' +
                            '<svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0">' +
                            '</g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Interface / Exit">' +
                            '<path id="Vector"' +
                            'd="M12 15L15 12M15 12L12 9M15 12H4M4 7.24802V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4796 4 18.9074 4.21799C19.2837 4.40973 19.5905 4.71547 19.7822 5.0918C20 5.5192 20 6.07899 20 7.19691V16.8036C20 17.9215 20 18.4805 19.7822 18.9079C19.5905 19.2842 19.2837 19.5905 18.9074 19.7822C18.48 20 17.921 20 16.8031 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2839 4.21799 18.9076C4 18.4798 4 17.9201 4 16.8V16.75"' +
                            'stroke="#016D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>' +
                            '</span>' +
                            '</div>' +
                            '</td>' +
                            '</tr>');
                    }
                    var tabela = $(".tabela-saidas").DataTable({
                        "bSort": false,
                        "deferRender": true, 
                        initComplete: function (settings, json) {
                            $("#main").css("visibility", "visible");
                        },
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                        },
                        "pageLength": 25
                    });
                }
            }
        });
    };

    $('#saidas').click(function () {
        event.preventDefault();
        history.pushState(null, null, '#saidas');
        loadValidarSaida();
    })

    if (window.location.hash === '#saidas') {
        loadValidarSaida();
        activateButton(window.location.hash);
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#saidas') {
            loadValidarSaida();
            activateButton(window.location.hash)
        }
    });

    $(".turmas").on("click", ".select-turma", function () {
        event.preventDefault();
        history.pushState(null, null, '#turma-' + $(this).attr('id'));
        selectTurma($(this).attr('id'));
    });

    if (window.location.hash.includes("turma")) {
        var turma = window.location.hash.split('-')[1];
        selectTurma(turma);
        activateButton('#' + turma);
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash.includes("turma")) {
            var turma = window.location.hash.split('-')[1];
            selectTurma(turma);
            activateButton('#' + turma);
        }
    });

    $("#main").on("click", ".validar-saida", function () {
        // alert($(this).attr('value'));
        // alert($(this).attr('id'));
        // alert($(this).attr('name'));
        $("#valida-nome").empty();
        $("#valida-id").empty();
        $("#valida-data").empty();
        $("#valida-nome").append(" <b>" + $(this).attr('id') + "</b>");
        $("#valida-id").append($(this).attr('value'));
        $("#valida-data").append($(this).attr('name').slice(0, 10));
        $('#valida-escondido').trigger("click");
    });

    // Função para enviar os dados da validação da saída para a inserção no banco de dados
    $("#main").on("click", "#valida-saida", function () {

        id_aluno = $("#valida-id").text();
        date = $("#valida-data").text();
        // alert(id_aluno);
        // alert(date);

        $.ajax({
            type: "POST",
            data: {
                id_aluno: id_aluno,
                date: date
            },
            url: "update/update_libera_alunos.php",
            success: function (data) {
                if (data == 0) {
                    location.reload();
                }
            }
        });

        // Notificar que a operação foi realizada com sucesso
        let snackbar = new SnackBar();
        snackbar.make("message",
            [
                "Saída Validada!",
                null,
                "bottom",
                "right"
            ], 4000);

        $("#saidas").trigger("click");
        // location.reload();
    });
});