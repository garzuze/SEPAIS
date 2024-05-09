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

// Função para os checkbox serem selecionados todos de uma vez
$(document).ready(function () {
    //esconde o botão liberar ao carregar o documento
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

    $.ajax({
        url: 'read/read_motivos.php',
        type: 'GET',
        success: function (motivo) {
            if(motivo==0){
                location.reload();
            } else{
                motivo = JSON.parse(motivo)
                console.log(motivo);
                for (var i = 0; i < motivo.length; i++) {
                    $('.select-motivo').append(
                        '<option value="' + motivo[i]["id"] + '">' + motivo[i]["motivo"] + '</option>'
                    )
                }
            }
        }
    })
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
    $('.select-destaque').click(function () {
        $(".subclasse-historico").removeClass("border-[#00bf63] border-l-2");
        $('.select-destaque').removeClass('bg-gray-100');
        $(this).addClass('bg-gray-100');
    });

    // Função para selecionar alunos por turma
    $('.select-turma').click(function () {
        var turma = $(this).attr('id');
        //mostra o botão liberar
        $('.btn-liberar').show()
        $.ajax({
            url: 'read/read_alunos_turma.php',
            data: 'turma=' + turma,
            type: 'GET',
            success: function (data) {
                if(data==0){
                    location.reload();
                } else{
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
                        var aluno_check = "aluno"+i;
                        $('#tb-alunos-resp').append(
                            '<tr class="bg-white border-b">' +
                            '<td class="active w-4 p-4">' +
                            '<div class="flex items-center">' +
                            '<input type="checkbox" class="select-item gmail-checkbox checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" name="select-alunos[]" id="'+aluno_check+'" value="' + data[i]['id_aluno'] + '">' +
                            '<label for="'+aluno_check+'" class="sr-only">checkbox</label>' +
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
    })

    // Função para enviar dados para o registro das liberações
    $("#main").on("click", ".confirmar-liberar ", function () {

        id_aluno = [];
        motivo = $(".select-motivo").children("option:selected").val();
        $("input.select-item:checked").each(function () {
            id_aluno.push(this.value);
        });
        // console.log(id_aluno);
        // console.log(motivo);
        // console.log(username);
        $.ajax({
            type: "POST",
            data: {
                id_aluno: id_aluno,
                motivo: motivo,
                username: username
            },
            url: "insert/insert_sepae_libera.php",
            success: function (data) {
                if(data==0){
                    location.reload();
                }
            }
        });
        location.reload();
    });

    // Função para visualizar histórico 
    $('#historico').click(function () {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main").css('visibility', 'hidden');
        $.ajax({
            url: 'read/read_historico_liberado_sepae.php',
            type: 'GET',
            success: function (data) {
                if(data==0){
                    location.reload();
                } else{
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
                            data[i]['Servidor'] +
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
                                title: 'Histórico de liberação'
                            },
                            {
                                extend: 'excel',
                                title: 'Histórico de liberação'
                            },
                            {
                                extend: 'pdf',
                                title: 'Histórico de liberação',
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
    })

    // Função para escrever recado.
    $('#escrever-recado').click(function () {
        //esconde o botão liberar
        $('.btn-liberar').hide();
        $("#main > *:not('.modal')").remove();
        $('#main').prepend(`
                <div id="recado" class="mx-auto w-3/4 mt-4">
                    <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Escrever recado</h2>
                    <form id="form_valida" action="insert/insert_recado.php" method="post">
                        <div>
                            <input type="hidden" id="username" name="username" value="`+username+`">
                            <label for="titulo" class="block my-2 text-sm font-medium text-gray-900">Título</label>
                            <input type="text" name="titulo" id="titulo" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="O campus Pinhais é bom demais..." required>
                        </div>
                        <div>
                            <p class="block my-2 text-sm font-medium text-gray-900">Recado</p>
                            <textarea id="recado" name="recado" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Tem cachorro, tem coruja e muitos outros animais!" required></textarea>
                        </div>
                        <div>
                            <label for="validade" class="block my-2 text-sm font-medium text-gray-900">Validade</label>
                            <input type="date" name="validade" id="validade" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5">
                            <p class="text-gray-600"><small>*Deixe vazio caso o recado não tenha validade</small></p>
                        </div>
                `)
        $('#form_valida').append(`
                        <input type="submit" name="submit" class="bg-gradient-to-r from-[#00BF63] to-[#016D39] mt-6 bg-[#016D39] shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]"
                        value="Enviar recado">
                        </form>
                </div>`)
    })

    $('.select-motivo').change(function () {
        $(".confirmar-liberar").prop("disabled", false);
    });

    $(".clique-desliza").click(function () {
        $(this).next().children().slideToggle("slow");
    })
    
    $(".subclasse-historico").click(function () {
        $(".subclasse-historico").removeClass("border-[#00bf63] border-l-2");
        $(this).addClass("border-[#00bf63] border-l-2");
    })    

});
