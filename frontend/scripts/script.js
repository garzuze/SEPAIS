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

    var time = hours + ":" + minutes
    $('#time').html(time)
}
setInterval(updateTime, 1000)

$(document).ready(function () {

    $(document).on("keydown", ":input:not(textarea)", function (event) {
        if (event.key == "Enter") {
            event.preventDefault();
        }
    });

    $("#main").on("click", "input.select-all", function () {
        // Coluna checkbox que seleciona ou deseleciona todos
        var checked = this.checked;
        $("input.select-item").each(function (index, item) {
            item.checked = checked;
        });

        // Não deixa o usuário apertar o botão liberar se nenhum checkbox foi marcado
        var len = $("input.select-item:checked:checked").length;
        $(".btn-liberar").prop("disabled", len === 0);
    });

    function loadTurmas() {
        $.ajax({
            url: 'read/read_turmas.php',
            type: 'GET',
            success: function (turma) {
                if (turma == 0) {
                    location.reload();
                } else {
                    $('#ul-turma').empty();
                    $('#tb-turmas').empty();
                    turma = JSON.parse(turma);
                    console.log(turma);
                    for (var i = 0; i < turma.length; i++) {
                        $('#ul-turma').append(`
                            <li>
                                <a id="`+ turma[i]["turma"] + `" class="select-turma select-destaque target flex justify-center items-center cursor-pointer p-2 text-gray-900 rounded-lg active:hover:bg-gray-100 group">
                                    <span>`+ turma[i]["turma"] + `</span>
                                </a>
                            </li>
                        `);
                        $('#tb-turmas').append(
                            '<tr class="bg-white border-b">' +
                            '<td id="' + turma[i]['turma'] + '" scope="col" class="px-6 py-4 font-medium text-gray-900">' +
                            turma[i]['turma'] +
                            '</td>'
                        );
                    }
                }
            }
        })

    }

    loadTurmas();

    function loadMotivos() {
        $.ajax({
            url: 'read/read_motivos.php',
            type: 'GET',
            success: function (motivo) {
                if (motivo == 0) {
                    location.reload();
                } else {
                    $('.select-motivo').empty();
                    $('#tb-motivos').empty();
                    motivo = JSON.parse(motivo);
                    console.log(motivo);
                    for (var i = 0; i < motivo.length; i++) {
                        $('.select-motivo').append(
                            '<option value="' + motivo[i]["id"] + '">' + motivo[i]["motivo"] + '</option>'
                        )
                        $('#tb-motivos').append(
                            '<tr class="bg-white border-b">' +
                            '<td id="' + motivo[i]['id'] + '" scope="col" class="px-6 py-4 font-medium text-gray-900">' +
                            motivo[i]['motivo'] +
                            '</td>'
                        )
                    }
                }
            }
        })
    }

    // Marca os checkbox clicados 
    $("#main").on("click", "input.select-item", function () {
        var checked = this.checked;
        var all = $("input.select-all")[0];
        var total = $("input.select-item").length;
        var len = $("input.select-item:checked:checked").length;

        // Não deixa o usuário apertar o botão liberar se nenhum checkbox foi marcado
        all.checked = len === total;
        $(".btn-liberar").prop("disabled", len === 0);
    });

    // Função para botões ficarem em destaque quando ativos
    function activateButton(element) {
        $(".subclasse-historico").removeClass("border-[#00bf63] border-l-2 bg-gray-100");
        $(".subclasse-cadastrar").removeClass("border-[#00bf63] border-l-2 bg-gray-100");
        $('.select-destaque').removeClass('bg-gray-100');
        if (String(element).includes("historico") || String(element).includes("cadastrar")) {
            $(element).addClass("border-[#00bf63] border-l-2");
        } else {
            $(element).addClass('bg-gray-100');
        }
    }

    $("body").on("click", ".select-destaque", function () {
        activateButton(this);
    });


    // Função para selecionar alunos por turma
    function selectTurma(turma) {
        //mostra o botão liberar
        $('.btn-liberar').show()
        loadMotivos();
        $.ajax({
            url: 'read/read_alunos_turma.php',
            data: 'turma=' + turma,
            type: 'GET',
            success: function (data) {
                if (data == 0) {
                    location.reload();
                } else {
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
                                                <input type="checkbox" class="select-all gmail-checkbox checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" id="select-all" name="select-all">
                                                <label for="select-all" class="sr-only">checkbox</label>
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
                                </tbody>`)
                    for (var i = 0; i < data.length; i++) {
                        var aluno_check = "aluno" + i;
                        $('#tb-alunos-resp').append(
                            '<tr class="bg-white border-b">' +
                            '<td class="active w-4 p-4">' +
                            '<div class="flex items-center">' +
                            '<input type="checkbox" class="select-item gmail-checkbox checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" name="select-alunos[]" id="' + aluno_check + '" value="' + data[i]['id_aluno'] + '">' +
                            '<label for="' + aluno_check + '" class="sr-only">checkbox</label>' +
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
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        })
    };

    if (window.location.hash.includes("turma") && !window.location.hash.includes("cadastrar")) {
        var turma = window.location.hash.split('-')[1];
        selectTurma(turma);
        activateButton('#' + turma);
    }

    $(".turmas").on("click", ".select-turma", function () {
        event.preventDefault();
        history.pushState(null, null, '#turma-' + $(this).attr('id'));
        selectTurma($(this).attr('id'));
    });

    window.addEventListener('popstate', function () {
        if (window.location.hash.includes("turma") && !window.location.hash.includes("cadastrar")) {
            var turma = window.location.hash.split('-')[1];
            selectTurma(turma);
            activateButton('#' + turma);
        }
    });

    let hoverTimeout;

    $('.confirmar-liberar').hover(
        function () {
            hoverTimeout = setTimeout(function () {
                if ($("#category").val() == null) {
                    let snackbar = new SnackBar();
                    snackbar.make("message", [
                        "Nenhum motivo selecionado!",
                        null,
                        "top",
                        "right"
                    ], 4000);
                }
            }, 500);
        },
        function () {
            clearTimeout(hoverTimeout);
        }
    );

    $('.btn-liberar').hover(
        function () {
            var len = $("input.select-item:checked:checked").length;
            if (len === 0) {
                hoverTimeout = setTimeout(function () {
                    let snackbar = new SnackBar();
                    snackbar.make("message", [
                        "Nenhum aluno selecionado!",
                        null,
                        "top",
                        "right"
                    ], 4000);
                }, 500);
            }
        },
        function () {
            clearTimeout(hoverTimeout);
        }
    );

    // Função para enviar dados para o registro das liberações
    $("#main").on("click", ".confirmar-liberar ", function () {
        email = $("#sepae_email").text()
        id_aluno = [];
        motivo = $(".select-motivo").children("option:selected").val();
        $("input.select-item:checked").each(function () {
            id_aluno.push(this.value);
        });

        $('.gmail-checkbox').prop('checked', false);
        $(".btn-liberar").prop("disabled", true);
        $("#category").val("regular").change();
        $(".confirmar-liberar").prop("disabled", true);

        let snackbar = new SnackBar();
        snackbar.make("message", [
            "Liberações registradas!",
            null,
            "top",
            "right"
        ], 4000);

        // console.log(id_aluno);
        // console.log(motivo);
        // console.log(username);
        $.ajax({
            type: "POST",
            data: {
                id_aluno: id_aluno,
                motivo: motivo,
                email: email
            },
            url: "insert/insert_sepae_libera.php",
            success: function (data) {
                if (data == 0) {
                    location.reload();
                }
            }
        });
    });

    // Função para visualizar histórico de liberações pela SEPAE
    function loadHistoricoSepae() {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main").css('visibility', 'hidden');
        $.ajax({
            url: 'read/read_historico_liberado_sepae.php',
            type: 'GET',
            success: function (data) {
                if (data == 0) {
                    location.reload();
                } else {
                    data = JSON.parse(data)
                    console.log(data);
                    // Limpando o seção principal
                    $("#main > *:not('.modal')").remove();
                    $('#main').prepend(`
                            <table style="display:none; width:100%;" class="tabela-historico text-sm text-left mx-auto text-gray-500 sm:rounded-lg shadow-lg mt-4">
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
                            </table>`);
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['saida'] == null) {
                            data[i]['saida'] = "Não saiu";
                        }
                        else {
                            data[i]['saida'] = data[i]['saida'].slice(11, 19);
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
                            data[i]['data'].slice(0, 10) +
                            '</td>' +
                            '<td class="px-6 py-4 w-2/12">' +
                            data[i]['saida'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-1/12">' +
                            data[i]['servidor'].split("@")[0] +
                            '</td>' +
                            '<td class="px-6 py-4 w-3/12">' +
                            data[i]['motivo'] +
                            '</td>' +
                            '</tr>');
                    }
                    var tabela = $(".tabela-historico").DataTable({
                        "bSort": false,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                        },
                        dom: '<"row"lBf>rtip',
                        buttons: [
                            'copy',
                            {
                                extend: 'csv',
                                title: 'Histórico de liberação por SEPAE'
                            },
                            {
                                extend: 'excel',
                                title: 'Histórico de liberação por SEPAE'
                            },
                            {
                                extend: 'pdf',
                                title: 'Histórico de liberação por SEPAE',
                                customize: function (doc) {
                                    doc.content[1].margin = [30, 0, 30, 0] //left, top, right, bottom
                                }
                            }
                        ]
                    });
                    setTimeout(function () {
                        $(".tabela-historico").show();
                        $("#main").css('visibility', 'visible');
                    }, 10);
                }
            }
        })
    }

    $('#historico-sepae').click(function () {
        event.preventDefault();
        history.pushState(null, null, '#historico-sepae');
        loadHistoricoSepae();
    })

    if (window.location.hash === '#historico-sepae') {
        $("#historico").next().children().slideDown("slow");
        activateButton(window.location.hash)
        loadHistoricoSepae();
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#historico-sepae') {
            $("#historico").next().children().slideDown("slow");
            activateButton(window.location.hash)
            loadHistoricoSepae();
        }
    });
    // Função para visualizar histórico de liberações pelos responsáveis
    function loadHistoricoResponsavel() {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main").css('visibility', 'hidden');
        $.ajax({
            url: 'read/read_historico_liberado_responsaveis.php',
            type: 'GET',
            success: function (data) {
                if (data == 0) {
                    location.reload();
                } else {
                    data = JSON.parse(data)
                    console.log(data);
                    // Limpando o seção principal
                    $("#main > *:not('.modal')").remove();
                    $('#main').prepend(`
                            <table style="display:none; width:100%;" class="tabela-historico text-sm text-left mx-auto text-gray-500 sm:rounded-lg shadow-lg mt-4">
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
                                            Responsável
                                        </th>
                                        <th scope="col" class="px-6 py-3 w-2/12">
                                            Motivo
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tb-alunos-resp">

                                </tbody>
                            </table>`);
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['saida'] == null) {
                            data[i]['saida'] = "Não saiu";
                        }
                        else {
                            data[i]['saida'] = data[i]['saida'].slice(11, 19);
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
                            data[i]['data'].slice(0, 10) +
                            '</td>' +
                            '<td class="px-6 py-4 w-2/12">' +
                            data[i]['saida'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-1/12">' +
                            data[i]['responsavel'].split("@")[0] +
                            '</td>' +
                            '<td class="px-6 py-4 w-3/12">' +
                            data[i]['motivo'] +
                            '</td>' +
                            '</tr>');
                    }
                    var tabela = $(".tabela-historico").DataTable({
                        "bSort": false,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                        },
                        dom: '<"row"lBf>rtip',
                        buttons: [
                            'copy',
                            {
                                extend: 'csv',
                                title: 'Histórico de liberação por responsáveis'
                            },
                            {
                                extend: 'excel',
                                title: 'Histórico de liberação por responsáveis'
                            },
                            {
                                extend: 'pdf',
                                title: 'Histórico de liberação por responsáveis',
                                customize: function (doc) {
                                    doc.content[1].margin = [30, 0, 30, 0] //left, top, right, bottom
                                }
                            }
                        ]
                    });
                    setTimeout(function () {
                        $(".tabela-historico").show();
                        $("#main").css('visibility', 'visible');
                    }, 10);
                }
            }
        })
    }

    $('#historico-responsavel').click(function () {
        event.preventDefault();
        history.pushState(null, null, '#historico-responsavel');
        loadHistoricoResponsavel();
    })

    if (window.location.hash === '#historico-responsavel') {
        loadHistoricoResponsavel();
        $("#historico").next().children().slideDown("slow");
        activateButton(window.location.hash)
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#historico-responsavel') {
            loadHistoricoResponsavel();
            $("#historico").next().children().slideDown("slow");
            activateButton(window.location.hash)
        }
    });

    // Função para visualizar histórico de atrasos
    function loadHistoricoAtrasos() {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main").css('visibility', 'hidden');
        $.ajax({
            url: 'read/read_historico_atrasos.php',
            type: 'GET',
            success: function (data) {
                if (data == 0) {
                    location.reload();
                } else {
                    data = JSON.parse(data)
                    console.log(data);
                    // Limpando o seção principal
                    $("#main > *:not('.modal')").remove();
                    $('#main').prepend(`
                                <table style="display:none; width:100%;" class="tabela-historico text-sm text-left mx-auto text-gray-500 sm:rounded-lg shadow-lg mt-4">
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
                            data[i]['nome_aluno'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-1/12">' +
                            data[i]['turma'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-2/12">' +
                            data[i]['data'] +
                            '</td>' +
                            +'</tr>');
                    }
                    var tabela = $(".tabela-historico").DataTable({
                        "bSort": false,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                        },
                        dom: '<"row"lBf>rtip',
                        buttons: [
                            'copy',
                            {
                                extend: 'csv',
                                title: 'Histórico de atrasos'
                            },
                            {
                                extend: 'excel',
                                title: 'Histórico de atrasos'
                            },
                            {
                                extend: 'pdf',
                                title: 'Histórico de atrasos',
                                customize: function (doc) {
                                    doc.content[1].margin = [30, 0, 30, 0] //left, top, right, bottom
                                }
                            }
                        ]
                    });
                    setTimeout(function () {
                        $(".tabela-historico").show();
                        $("#main").css('visibility', 'visible');
                    }, 10);
                }
            }
        })
    }

    $('#historico-atrasos').click(function () {
        event.preventDefault();
        history.pushState(null, null, '#historico-atrasos');
        loadHistoricoAtrasos();
    })

    if (window.location.hash === '#historico-atrasos') {
        loadHistoricoAtrasos();
        $("#historico").next().children().slideDown("slow");
        activateButton(window.location.hash)
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#historico-atrasos') {
            loadHistoricoAtrasos();
            $("#historico").next().children().slideDown("slow");
            activateButton(window.location.hash)
        }
    });

    // Função para visualizar histórico de recados
    function loadHistoricoRecados() {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main").css('visibility', 'hidden');
        $.ajax({
            url: 'read/read_recados.php',
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
                        <table style="display:none; width:100%;" class="tabela-historico text-sm text-left mx-auto text-gray-500 sm:rounded-lg shadow-lg mt-4">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <th scope="col" class="px-6 py-3 hidden">
                                        id
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-3/12">
                                        Título
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/12">
                                        Recado
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-2/12">
                                        Validade
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-2/12">
                                        Servidor
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-2/12">
                                        Editar
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tb-recados">

                            </tbody>
                        </table>`);
                    for (var i = 0; i < data.length; i++) {
                        if (data[i]['validade'] == null) {
                            data[i]['validade'] = "Indefinida";
                        }
                        $('#tb-recados').append(
                            '<tr class="bg-white border-b">' +
                            '<td id="id" scope="col" class="px-6 py-3 hidden">' +
                            data[i]['id'] +
                            '</td>' +
                            '<td id="titulo" scope="row" class="px-6 py-4 font-medium text-gray-900 w-3/12">' +
                            data[i]['titulo'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-1/12">' +
                            data[i]['recado'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-2/12">' +
                            data[i]['validade'] +
                            '</td>' +
                            '<td class="px-6 py-4 w-2/12">' +
                            data[i]['sepae_email'].split("@")[0] +
                            '</td>' +
                            '<td class="px-6 py-4 w-2/12">' +
                            '<a class="editar-recado underline cursor-pointer" id="' + data[i]["titulo"] + '" name="' + data[i]["recado"] + '" value="' + data[i]['validade'] + '" >Editar<a/>' +
                            '</td>' +
                            +'</tr>');
                    }
                    var tabela = $(".tabela-historico").DataTable({
                        "bSort": false,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                        },
                        dom: '<"row"lBf>rtip',
                        buttons: [
                            'copy',
                            {
                                extend: 'csv',
                                title: 'Histórico de recados'
                            },
                            {
                                extend: 'excel',
                                title: 'Histórico de recados'
                            },
                            {
                                extend: 'pdf',
                                title: 'Histórico de recados',
                                customize: function (doc) {
                                    doc.content[1].margin = [30, 0, 30, 0] //left, top, right, bottom
                                }
                            }
                        ]
                    });
                    setTimeout(function () {
                        $(".tabela-historico").show();
                        $("#main").css('visibility', 'visible');
                    }, 10);
                }
            }
        })
    }

    $("#historico-recados").click(function () {
        event.preventDefault();
        history.pushState(null, null, '#historico-recados');
        loadHistoricoRecados();
    })

    if (window.location.hash === '#historico-recados') {
        loadHistoricoRecados();
        $("#historico").next().children().slideDown("slow");
        activateButton(window.location.hash)
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#historico-recados') {
            loadHistoricoRecados();
            $("#historico").next().children().slideDown("slow");
            activateButton(window.location.hash)
        }
    });

    // Função para escrever recado.
    function loadEscreverRecado() {
        email = $("#sepae_email").text();
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main > *:not('.modal')").remove();
        $('#main').prepend(`
                <div id="recado1" class="mx-auto w-3/4 mt-4">
                    <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Escrever recado</h2>
                    <form id="form_valida">
                        <div>
                            <input type="hidden" id="email" name="email" value="`+ email + `">
                            <label for="titulo" class="block my-2 text-sm font-medium text-gray-900">Título</label>
                            <input type="text" name="titulo" id="titulo" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="O campus Pinhais é bom demais..." required>
                        </div>
                        <div>
                            <p class="block my-2 text-sm font-medium text-gray-900">Recado</p>
                            <textarea id="recado" name="recado" rows="6" class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Tem cachorro, tem coruja e muitos outros animais!" required></textarea>
                        </div>
                        <div>
                            <label for="validade" class="block my-2 text-sm font-medium text-gray-900">Validade</label>
                            <input type="date" name="validade" id="validade" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5">
                            <p class="text-gray-600"><small>*Deixe vazio caso o recado não tenha validade</small></p>
                        </div>
                `)
        $('#form_valida').append(`
                        <input type="button" id="enviar-recado" class="bg-gradient-to-r from-[#00BF63] to-[#016D39] mt-6 bg-[#016D39] shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]"
                        value="Enviar recado">
                        </form>
                </div>`);
        if (!$("#editar-recado-titulo").text() == '') {
            $("#titulo").val("[ERRATA] " + $("#editar-recado-titulo").text());
            $("#recado").val($("#editar-recado-recado").text());
            $("#validade").val($("#editar-recado-validade").text());
            $("#titulo").prop("disabled", true);

            $("#editar-recado-titulo").text("");
            $("#editar-recado-recado").text("");
            $("#editar-recado-validade").text("");
        }

    }

    $('#escrever-recado').click(function () {
        event.preventDefault();
        history.pushState(null, null, '#escrever-recado');
        loadEscreverRecado();
    })

    if (window.location.hash === '#escrever-recado') {
        loadEscreverRecado();
        activateButton(window.location.hash);
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#escrever-recado') {
            loadEscreverRecado();
            activateButton(window.location.hash)
        }
    });

    function loadCadastrarMotivo() {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main > *:not('.modal')").remove();
        $('#main').prepend(`
                <div class="w-3/4 mt-4 mx-auto grid grid-cols-4 gap-4 grid-rows-4">
            <div class="col-span-2 row-span-4 content-center">
                <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl">Cadastrar novo motivo</h2>
                <form id="form_motivo">
                    <label for="motivo" class="block my-2 text-sm font-medium text-gray-900">Digite o motivo:</label>
                    <input type="text" name="motivo" id="motivo" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="O professor morreu de amor..." required>
                </form>
            </div>
            <table class="text-sm text-left text-gray-500 sm:rounded-lg shadow-lg col-span-2 row-span-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            motivos
                        </th>
                    </tr>
                </thead>
                <tbody id="tb-motivos">
                </tbody>
            </table>
        </div>`)
        $('#form_motivo').append(`
                        <input type="button" id="btn-cadastrar-motivo" class="bg-gradient-to-r from-[#00BF63] to-[#016D39] mt-6 bg-[#016D39] shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]"
                        value="Cadastrar motivo">`);
    }

    $('#cadastrar-motivo').click(function () {
        event.preventDefault();
        history.pushState(null, null, '#cadastrar-motivo');
        loadMotivos();
        loadCadastrarMotivo();
    })

    if (window.location.hash === '#cadastrar-motivo') {
        $("#cadastrar").next().children().slideDown("slow");
        loadMotivos();
        loadCadastrarMotivo();
        activateButton(window.location.hash);
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#cadastrar-motivo') {
            $("#cadastrar").next().children().slideDown("slow");
            loadMotivos();
            loadCadastrarMotivo();
            activateButton(window.location.hash)
        }
    });


    $("#main").on("click", "#btn-cadastrar-motivo", function (event) {

        let motivo = $("#motivo").val().trim();

        if (!motivo) {
            let snackbar = new SnackBar();
            snackbar.make("message", [
                "Preencha os campos necessários!",
                null,
                "top",
                "right"
            ], 4000);
            return;
        } else {
            let snackbar = new SnackBar();
            snackbar.make("message", [
                "Motivo enviado!",
                null,
                "top",
                "right"
            ], 4000);
        }

        $.ajax({
            type: "POST",
            data: {
                motivo: motivo
            },
            url: "insert/insert_motivo.php",
            success: function (data) {
                if (data == 0) {
                    location.reload();
                }
            }
        });

        $("#motivo").val("");
        loadMotivos();
    });

    function loadCadastrarTurma() {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main > *:not('.modal')").remove();
        $('#main').prepend(`
                <div class="w-3/4 mt-4 mx-auto grid grid-cols-4 gap-4 grid-rows-4">
            <div class="col-span-2 row-span-4 content-center">
                <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl">Cadastrar nova turma</h2>
                <form id="form_turma">
                    <label for="turma" class="block my-2 text-sm font-medium text-gray-900">Digite a turma:</label>
                    <input type="text" name="turma" id="turma" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="Técnico em Crochet" required>
                </form>
            </div>
            <table class="text-sm text-left text-gray-500 sm:rounded-lg shadow-lg col-span-2 row-span-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            turmas
                        </th>
                    </tr>
                </thead>
                <tbody id="tb-turmas">
                </tbody>
            </table>
        </div>`)
        $('#form_turma').append(`
                        <input type="button" id="btn-cadastrar-turma" class="bg-gradient-to-r from-[#00BF63] to-[#016D39] mt-6 bg-[#016D39] shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]"
                        value="Cadastrar turma">`);
    }

    $('#cadastrar-turma').click(function () {
        event.preventDefault();
        history.pushState(null, null, '#cadastrar-turma');
        loadTurmas();
        loadCadastrarTurma();
    })

    if (window.location.hash === '#cadastrar-turma') {
        $("#cadastrar").next().children().slideDown("slow");
        activateButton(window.location.hash);
        loadTurmas();
        loadCadastrarTurma();
    }

    window.addEventListener('popstate', function () {
        if (window.location.hash === '#cadastrar-turma') {
            $("#cadastrar").next().children().slideDown("slow");
            activateButton(window.location.hash)
            loadTurmas();
            loadCadastrarTurma();
        }
    });


    $("#main").on("click", "#btn-cadastrar-turma", function (event) {

        let turma = $("#turma").val().trim();

        if (!turma) {
            let snackbar = new SnackBar();
            snackbar.make("message", [
                "Preencha os campos necessários!",
                null,
                "top",
                "right"
            ], 4000);
            return;
        } else {
            let snackbar = new SnackBar();
            snackbar.make("message", [
                "Turma criada!",
                null,
                "top",
                "right"
            ], 4000);
        }

        $.ajax({
            type: "POST",
            data: {
                turma: turma
            },
            url: "insert/insert_turma.php",
            success: function (data) {
                if (data == 0) {
                    location.reload();
                }
            }
        });

        $("#turma").val("");
        loadTurmas();
    });

    $('.select-motivo').change(function () {
        $(".confirmar-liberar").prop("disabled", false);
    });

    $(".clique-desliza").click(function () {
        $(this).next().children().slideToggle("slow");
    })

    $(".subclasse-historico").click(function () {
        activateButton(this);
    })

    $(".subclasse-cadastrar").click(function () {
        activateButton(this);
    })


    $("#main").on("click", ".editar-recado", function () {
        $("#editar-recado-titulo").append($(this).attr('id'));
        $("#editar-recado-recado").append($(this).attr('name'));
        $("#editar-recado-validade").append($(this).attr('value'));
        $('#escrever-recado').trigger("click");
    });

    $("#main").on("click", "#enviar-recado", function (event) {

        let email = $("#email").val().trim();
        let recado = $("#recado").val().trim();
        let validade = $("#validade").val().trim();
        let titulo = $("#titulo").val().trim();

        if (!recado || !titulo || !email) {
            let snackbar = new SnackBar();
            snackbar.make("message", [
                "Preencha os campos necessários!",
                null,
                "top",
                "right"
            ], 4000);
            return;
        }

        $.ajax({
            type: "POST",
            data: {
                titulo: titulo,
                recado: recado,
                validade: validade,
                email: email
            },
            url: "insert/insert_recado.php",
            success: function (data) {
                if (data == 0) {
                    location.reload();
                }
            }
        });

        $("#recado").val("");
        $("#validade").val("");
        $("#titulo").val("");

        let snackbar = new SnackBar();
        snackbar.make("message", [
            "Recado enviado!",
            null,
            "bottom",
            "right"
        ], 4000);
    });
});
